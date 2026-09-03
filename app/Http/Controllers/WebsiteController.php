<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
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
            WebsiteSetting::setByKey($key, $value, 'landing');
        }

        return redirect()->back()->with('success', 'Pengaturan Landing Page Publik berhasil diperbarui.');
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

        $publishedSubmissions = \Modules\Submissions\Models\Submission::with(['authors', 'files'])
            ->where('journal_id', $journal->id)
            ->whereIn('status', ['accepted', 'published'])
            ->latest()
            ->get();

        return view('website::public.issue-detail', compact('journal', 'issue', 'publishedSubmissions'));
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

        $publishedSubmissions = \Modules\Submissions\Models\Submission::with(['authors', 'files'])
            ->where('journal_id', $journal->id)
            ->whereIn('status', ['accepted', 'published'])
            ->latest()
            ->get();

        return view('website::public.issue-detail', compact('journal', 'issue', 'publishedSubmissions'));
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
     * Public CMS Page: Announcements
     */
    public function announcements(): View
    {
        return view('website::public.cms.announcements');
    }

    /**
     * Handles submission of the public inquiry / contact form.
     */
    public function submitContactForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'phone'      => 'required|string|max:30',
            'email'      => 'required|email|max:150',
            'message'    => 'required|string|max:3000',
        ]);

        $contact = \Modules\Website\Models\WebsiteContact::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'] ?? null,
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'message'    => $validated['message'],
            'status'     => 'unread',
        ]);

        // Kirim salinan pesan ke email admin / pengelola portal
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
}
