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

        return view('website::public.home', compact('settings', 'programs', 'journals', 'latestIssues', 'news'));
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
     * Displays the public list of active journals.
     */
    public function journals(): View
    {
        $journals = Journal::where('is_active', true)
            ->withCount(['editorialBoards'])
            ->latest()
            ->paginate(9);

        return view('website::public.journals', compact('journals'));
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

        return view('website::public.issue-detail', compact('journal', 'issue'));
    }

    /**
     * Displays the public archive of issues.
     */
    public function issueArchive(): View
    {
        $issues = Issue::where('is_published', true)
            ->with('journal')
            ->latest('published_at')
            ->paginate(10);

        return view('website::public.issue-archive', compact('issues'));
    }

    /**
     * Displays single issue detail page.
     */
    public function issueDetail(int $id): View
    {
        $issue = Issue::where('is_published', true)
            ->with('journal')
            ->findOrFail($id);

        return view('website::public.issue-detail', ['journal' => $issue->journal, 'issue' => $issue]);
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
}
