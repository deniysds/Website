<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Issues\Models\Issue;
use Modules\Journals\Models\Journal;
use Modules\Website\Models\WebsiteNews;
use Modules\Website\Models\WebsiteProgram;
use Modules\Website\Models\WebsiteSetting;

class WebsiteController extends Controller
{
    /**
     * Displays the main public landing page according to exact design parameters.
     */
    public function home(): View
    {
        $settings = WebsiteSetting::pluck('value', 'key')->all();

        $programs = WebsiteProgram::where('is_active', true)
            ->orderBy('order_no', 'asc')
            ->get();

        $journals = Journal::where('is_active', true)
            ->withCount(['editorialBoards'])
            ->latest()
            ->take(6)
            ->get();

        $latestIssues = Issue::where('is_published', true)
            ->with('journal')
            ->latest('published_at')
            ->take(4)
            ->get();

        $news = WebsiteNews::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $mainPartners = \Modules\Website\Models\WebsitePartner::active()
            ->main()
            ->orderBy('order_no', 'asc')
            ->get();

        $supportingPartners = \Modules\Website\Models\WebsitePartner::active()
            ->supporting()
            ->orderBy('order_no', 'asc')
            ->get();

        return view('website::public.home', compact('settings', 'programs', 'journals', 'latestIssues', 'news', 'mainPartners', 'supportingPartners'));
    }

    /**
     * Admin view for managing Landing Page Settings
     */
    public function adminSettings(): View
    {
        $settings = WebsiteSetting::pluck('value', 'key')->all();
        return view('website::admin.settings', compact('settings'));
    }

    /**
     * Store/Update Landing Page Settings
     */
    public function updateAdminSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            WebsiteSetting::setByKey($key, $value, 'cms');
        }

        \Illuminate\Support\Facades\Cache::forget('website_settings_all');

        return redirect()->route('website.settings')->with('success', 'Pengaturan Website & CMS berhasil diperbarui.');
    }

    /**
     * Displays the public list of active journals with search filter.
     */
    public function journals(Request $request): View
    {
        $query = Journal::where('is_active', true)->withCount(['editorialBoards']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('short_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('issn_p', 'like', '%' . $search . '%')
                  ->orWhere('issn_e', 'like', '%' . $search . '%');
            });
        }

        $journals = $query->latest()->paginate(9)->withQueryString();

        return view('website::public.journals', compact('journals', 'search'));
    }

    /**
     * Displays the detail page of a specific journal (Description, Focus & Scope, Editorial Board).
     */
    public function journalDetail(string $slug): View
    {
        $journal = Journal::where('slug', $slug)
            ->where('is_active', true)
            ->with(['editorialBoards' => function ($q) {
                $q->orderBy('order_no', 'asc');
            }])
            ->firstOrFail();

        $currentIssue = Issue::where('journal_id', $journal->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->first();

        $archives = Issue::where('journal_id', $journal->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('website::public.journal-detail', compact('journal', 'currentIssue', 'archives'));
    }

    /**
     * Displays the current issue for a specific journal.
     */
    public function currentIssue(string $slug): View
    {
        $journal = Journal::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $issue = Issue::where('journal_id', $journal->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->firstOrFail();

        $articles = \Modules\Issues\Models\Article::with(['submission.authors', 'submission.files'])
            ->where('issue_id', $issue->id)
            ->latest('published_at')
            ->get();

        $publishedSubmissions = $articles->isNotEmpty()
            ? $articles
            : \Modules\Submissions\Models\Submission::with(['authors', 'files'])
                ->where('journal_id', $journal->id)
                ->whereIn('status', ['accepted', 'published'])
                ->latest()
                ->get();

        return view('website::public.issue-detail', compact('journal', 'issue', 'publishedSubmissions', 'articles'));
    }

    /**
     * Displays the public archive of issues with search & journal filter.
     */
    public function issueArchive(Request $request): View
    {
        $query = Issue::where('is_published', true)->with('journal');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('volume', 'like', '%' . $search . '%')
                  ->orWhere('number', 'like', '%' . $search . '%')
                  ->orWhere('publication_year', 'like', '%' . $search . '%');
            });
        }

        if ($journalId = $request->get('journal_id')) {
            $query->where('journal_id', $journalId);
        }

        $issues = $query->latest('published_at')->paginate(10)->withQueryString();
        $journals = Journal::where('is_active', true)->get();

        return view('website::public.issue-archive', compact('issues', 'journals', 'search', 'journalId'));
    }

    /**
     * Displays the detail page of a specific issue.
     */
    public function issueDetail(int $id): View
    {
        $issue = Issue::where('is_published', true)->with('journal')->findOrFail($id);
        $journal = $issue->journal;

        $articles = \Modules\Issues\Models\Article::with(['submission.authors', 'submission.files'])
            ->where('issue_id', $issue->id)
            ->latest('published_at')
            ->get();

        $publishedSubmissions = $articles->isNotEmpty()
            ? $articles
            : \Modules\Submissions\Models\Submission::with(['authors', 'files'])
                ->where('journal_id', $journal->id)
                ->whereIn('status', ['accepted', 'published'])
                ->latest()
                ->get();

        return view('website::public.issue-detail', compact('journal', 'issue', 'publishedSubmissions', 'articles'));
    }

    /**
     * Displays the detail page of a published article.
     */
    public function articleDetail(string $slug): View
    {
        $article = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
            'submission.files',
        ])->where('slug', $slug)->firstOrFail();

        $article->increment('views_count');

        $issue = $article->issue;
        $journal = $issue->journal;
        $authors = $article->submission?->authors ?? collect();
        $pdfFile = $article->submission?->files->where('file_role', 'naskah_utama')->first();

        return view('website::public.article-detail', compact('article', 'issue', 'journal', 'authors', 'pdfFile'));
    }

    /**
     * Downloads the published article PDF file.
     */
    public function downloadArticle(string $slug)
    {
        $article = \Modules\Issues\Models\Article::with('submission.files')->where('slug', $slug)->firstOrFail();
        $article->increment('downloads_count');

        $pdfFile = $article->submission?->files->where('file_role', 'naskah_utama')->first();
        if ($pdfFile) {
            $disk = $pdfFile->disk ?: 'public';
            if (\Illuminate\Support\Facades\Storage::disk($disk)->exists($pdfFile->path)) {
                return \Illuminate\Support\Facades\Storage::disk($disk)->download($pdfFile->path, $pdfFile->original_name);
            }
        }

        abort(404, 'File naskah tidak ditemukan.');
    }

    /**
     * Streams the published article PDF file in-browser for interactive reading.
     */
    public function viewPdf(string $slug)
    {
        $article = \Modules\Issues\Models\Article::with('submission.files')->where('slug', $slug)->firstOrFail();
        $article->increment('views_count');

        $pdfFile = $article->submission?->files->where('file_role', 'naskah_utama')->first();
        if ($pdfFile) {
            $disk = $pdfFile->disk ?: 'public';
            if (\Illuminate\Support\Facades\Storage::disk($disk)->exists($pdfFile->path)) {
                return \Illuminate\Support\Facades\Storage::disk($disk)->response(
                    $pdfFile->path,
                    $pdfFile->original_name,
                    ['Content-Type' => 'application/pdf'],
                    'inline'
                );
            }
        }

        abort(404, 'File naskah PDF tidak ditemukan.');
    }

    /**
     * Public Articles Catalog & Global Search Engine with Multi-Criteria & Sorting.
     */
    public function articles(Request $request): View
    {
        $search = $request->get('search');
        $journalId = $request->get('journal_id');
        $year = $request->get('year');
        $sort = $request->get('sort', 'latest');

        $query = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
            'submission.files',
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('abstract', 'like', '%' . $search . '%')
                  ->orWhere('doi', 'like', '%' . $search . '%')
                  ->orWhereHas('submission.authors', function ($authorQ) use ($search) {
                      $authorQ->where('name', 'like', '%' . $search . '%')
                              ->orWhere('affiliation', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($journalId) {
            $query->whereHas('issue', function ($issueQ) use ($journalId) {
                $issueQ->where('journal_id', $journalId);
            });
        }

        if ($year) {
            $query->whereHas('issue', function ($issueQ) use ($year) {
                $issueQ->where('publication_year', $year);
            });
        }

        match ($sort) {
            'popular'   => $query->orderByDesc('views_count')->orderByDesc('id'),
            'downloads' => $query->orderByDesc('downloads_count')->orderByDesc('id'),
            'title'     => $query->orderBy('title', 'asc'),
            default     => $query->latest('published_at')->latest('id'),
        };

        $articles = $query->paginate(10)->withQueryString();
        $journals = Journal::where('is_active', true)->get();
        $availableYears = Issue::where('is_published', true)
            ->distinct()
            ->orderBy('publication_year', 'desc')
            ->pluck('publication_year');

        return view('website::public.articles', compact('articles', 'journals', 'search', 'journalId', 'year', 'availableYears', 'sort'));
    }

    /**
     * Export Article Citation to RIS format (.ris).
     */
    public function exportRis(string $slug)
    {
        $article = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
        ])->where('slug', $slug)->firstOrFail();

        $journal = $article->issue?->journal;
        $issue = $article->issue;
        $authors = $article->submission?->authors ?? collect();

        $ris = [];
        $ris[] = "TY  - JOUR";
        $ris[] = "TI  - " . $article->title;
        foreach ($authors as $author) {
            $ris[] = "AU  - " . $author->name;
        }
        if ($journal) {
            $ris[] = "T2  - " . $journal->name;
            if ($journal->short_name) {
                $ris[] = "J2  - " . $journal->short_name;
            }
            if ($journal->issn_e) {
                $ris[] = "SN  - " . $journal->issn_e;
            }
        }
        if ($issue) {
            $ris[] = "VL  - " . $issue->volume;
            $ris[] = "IS  - " . $issue->number;
            $ris[] = "PY  - " . ($issue->publication_year ?: date('Y'));
        }
        if ($article->pages) {
            $pages = explode('-', $article->pages);
            $ris[] = "SP  - " . trim($pages[0]);
            if (isset($pages[1])) {
                $ris[] = "EP  - " . trim($pages[1]);
            }
        }
        if ($article->doi) {
            $ris[] = "DO  - " . $article->doi;
        }
        if ($article->abstract) {
            $ris[] = "AB  - " . preg_replace("/\r|\n/", " ", $article->abstract);
        }
        if (is_array($article->keywords)) {
            foreach ($article->keywords as $kw) {
                $ris[] = "KW  - " . trim($kw);
            }
        }
        $ris[] = "UR  - " . route('website.articles.show', $article->slug);
        $ris[] = "ER  - \n";

        $content = implode("\r\n", $ris);

        return response($content, 200, [
            'Content-Type'        => 'application/x-research-info-systems; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $article->slug . '.ris"',
        ]);
    }

    /**
     * Export Article Citation to BibTeX format (.bib).
     */
    public function exportBibtex(string $slug)
    {
        $article = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
        ])->where('slug', $slug)->firstOrFail();

        $journal = $article->issue?->journal;
        $issue = $article->issue;
        $authors = $article->submission?->authors ?? collect();

        $authorNames = $authors->pluck('name')->implode(' and ');
        $citeKey = Str::slug($authors->first()?->name ?? 'ignite') . ($issue?->publication_year ?? date('Y')) . Str::slug(Str::words($article->title, 2, ''));

        $bib = [];
        $bib[] = "@article{" . $citeKey . ",";
        $bib[] = '  title = {' . addslashes($article->title) . '},';
        if ($authorNames) {
            $bib[] = '  author = {' . $authorNames . '},';
        }
        if ($journal) {
            $bib[] = '  journal = {' . $journal->name . '},';
        }
        if ($issue) {
            $bib[] = '  volume = {' . $issue->volume . '},';
            $bib[] = '  number = {' . $issue->number . '},';
            $bib[] = '  year = {' . ($issue->publication_year ?: date('Y')) . '},';
        }
        if ($article->pages) {
            $bib[] = '  pages = {' . $article->pages . '},';
        }
        if ($article->doi) {
            $bib[] = '  doi = {' . $article->doi . '},';
        }
        $bib[] = '  url = {' . route('website.articles.show', $article->slug) . '}';
        $bib[] = "}\n";

        $content = implode("\n", $bib);

        return response($content, 200, [
            'Content-Type'        => 'application/x-bibtex; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $article->slug . '.bib"',
        ]);
    }

    /**
     * Public CMS Page: Publication Ethics
     */
    public function publicationEthics(): View
    {
        return view('website::public.cms.ethics');
    }

    /**
     * Public CMS Page: Indexing Info
     */
    public function indexingInfo(): View
    {
        return view('website::public.cms.indexing');
    }

    /**
     * Public CMS Page: About Us
     */
    public function about(): View
    {
        return view('website::public.cms.about');
    }

    /**
     * Public Page: Organizational Structure & Officers (Dewan Pengurus & Redaksi)
     */
    public function officers(): View
    {
        $officers = \Modules\Website\Models\WebsiteOfficer::active()
            ->orderBy('hierarchy_level', 'asc')
            ->orderBy('order_no', 'asc')
            ->get();

        $officersByHierarchy = $officers->groupBy('hierarchy_level');

        return view('website::public.officers', compact('officers', 'officersByHierarchy'));
    }

    /**
     * Public CMS Page: Contact
     */
    public function contact(): View
    {
        return view('website::public.cms.contact');
    }

    /**
     * Public CMS Page: Author Guidelines
     */
    public function guidelines(): View
    {
        return view('website::public.cms.guidelines');
    }

    /**
     * Public CMS Page: Announcements & Call for Papers
     */
    public function announcements(Request $request): View
    {
        $query = \Modules\Journals\Models\JournalAnnouncement::published()->with('journal');

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($journalId = $request->get('journal_id')) {
            $query->where('journal_id', $journalId);
        }

        $announcements = $query->orderBy('is_pinned', 'desc')
            ->latest('published_at')
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        $journals = Journal::where('is_active', true)->get();

        return view('website::public.cms.announcements', compact('announcements', 'journals', 'type', 'journalId'));
    }

    /**
     * Handles submission of the public inquiry / contact form.
     */
    public function submitContactForm(Request $request)
    {
        // Anti-spam Honeypot trap: bots fill hidden field website_hp
        if ($request->filled('website_hp')) {
            return redirect()->back()->with('success', 'Terima kasih! Pertanyaan Anda telah berhasil dikirimkan. Tim kami akan segera menghubungi Anda.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'phone'      => 'required|string|max:30',
            'email'      => 'required|email|max:150',
            'message'    => 'required|string|max:3000',
        ]);

        // Sanitasi input teks untuk mencegah XSS injection
        $firstName = strip_tags(trim($validated['first_name']));
        $lastName  = !empty($validated['last_name']) ? strip_tags(trim($validated['last_name'])) : null;
        $phone     = strip_tags(trim($validated['phone']));
        $email     = filter_var(trim($validated['email']), FILTER_SANITIZE_EMAIL);
        $message   = strip_tags(trim($validated['message']));

        $contact = \Modules\Website\Models\WebsiteContact::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'phone'      => $phone,
            'email'      => $email,
            'message'    => $message,
            'status'     => 'unread',
        ]);

        // Kirim salinan pesan ke email admin / pengelola portal via background queue
        try {
            $adminEmail = config('mail.from.address', 'admin@satriabudi.org');
            \Illuminate\Support\Facades\Mail::to($adminEmail)
                ->send(new \Modules\Website\Mail\ContactInquiryMail($contact));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim salinan email pesan kontak: ' . $e->getMessage(), [
                'contact_id' => $contact->id,
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih! Pertanyaan Anda telah berhasil dikirimkan. Tim kami akan segera menghubungi Anda.');
    }

    /**
     * Public Page: Collaboration & Equipment Handover
     */
    public function collaborations(Request $request): View
    {
        $query = \Modules\Website\Models\WebsiteCollaboration::active()->with(['items' => function ($q) {
            $q->orderBy('order_no', 'asc')->orderBy('id', 'asc');
        }]);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('items', function ($itemQ) use ($search) {
                      $itemQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $collaborations = $query->orderBy('order_no', 'asc')->orderBy('handover_date', 'desc')->get();
        $totalInstitutions = $collaborations->count();
        $totalEquipmentUnits = (int) $collaborations->sum(fn($c) => $c->items->sum('quantity'));
        $totalEquipmentTypes = (int) $collaborations->sum(fn($c) => $c->items->count());

        $categories = \Modules\Website\Models\WebsiteCollaboration::active()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        return view('website::public.collaborations', compact(
            'collaborations',
            'categories',
            'totalInstitutions',
            'totalEquipmentUnits',
            'totalEquipmentTypes',
            'search',
            'category'
        ));
    }

    /**
     * XML RSS 2.0 Feed of Published Articles with Dublin Core Metadata.
     */
    public function rssFeed(Request $request)
    {
        $articles = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
        ])
        ->whereHas('issue', function ($q) {
            $q->where('is_published', true);
        })
        ->latest('published_at')
        ->take(50)
        ->get();

        $xml = view('website::public.feed-rss', compact('articles'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8',
        ]);
    }

    /**
     * OAI-PMH 2.0 Metadata Harvesting Endpoint (Garuda, Moraref, Google Scholar).
     */
    public function oaiFeed(Request $request)
    {
        $verb = $request->get('verb', 'Identify');
        $metadataPrefix = $request->get('metadataPrefix', 'oai_dc');
        $identifier = $request->get('identifier');

        $query = \Modules\Issues\Models\Article::with([
            'issue.journal',
            'submission.authors',
            'submission.files',
        ])
        ->whereHas('issue', function ($q) {
            $q->where('is_published', true);
        });

        if ($identifier) {
            $id = Str::afterLast($identifier, '/');
            $query->where(function ($q) use ($id, $identifier) {
                $q->where('id', $id)->orWhere('slug', $id)->orWhere('doi', $identifier);
            });
        }

        $articles = $query->latest('published_at')->take(100)->get();

        $xml = view('website::public.oai-pmh', compact('verb', 'metadataPrefix', 'identifier', 'articles'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}

