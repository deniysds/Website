<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Website\Models\WebsiteNews;

class AdminArticleController extends Controller
{
    /**
     * Default article categories.
     */
    protected array $defaultCategories = [
        'Berita Utama',
        'Edukasi Kesehatan',
        'Riset Populer',
        'Kegiatan Yayasan',
        'Opini & Kolom',
        'Siaran Pers',
        'Pengumuman',
    ];

    /**
     * Display a listing of non-journal articles / news.
     */
    public function index(Request $request): View
    {
        $query = WebsiteNews::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('summary_en', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        $articles = $query->latest('published_at')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $totalArticles = WebsiteNews::count();
        $publishedCount = WebsiteNews::where('is_published', true)->count();
        $draftCount = WebsiteNews::where('is_published', false)->count();
        $totalViews = (int) WebsiteNews::sum('views_count');

        $categories = WebsiteNews::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $categories = array_unique(array_merge($this->defaultCategories, $categories));

        return view('website::admin.articles.index', compact(
            'articles',
            'totalArticles',
            'publishedCount',
            'draftCount',
            'totalViews',
            'categories'
        ));
    }

    /**
     * Show form for creating a new article.
     */
    public function create(): View
    {
        $categories = $this->defaultCategories;
        return view('website::admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'title_en'     => 'nullable|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:website_news,slug',
            'category'     => 'required|string|max:100',
            'author_name'  => 'nullable|string|max:255',
            'summary'      => 'nullable|string|max:1000',
            'summary_en'   => 'nullable|string|max:1000',
            'content'      => 'required|string',
            'content_en'   => 'nullable|string',
            'tags'         => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'is_featured'  => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : WebsiteNews::generateUniqueSlug($validated['title']);

        $article = WebsiteNews::create([
            'title'        => $validated['title'],
            'title_en'     => $validated['title_en'] ?? null,
            'slug'         => $slug,
            'category'     => $validated['category'],
            'author_name'  => $validated['author_name'] ?: 'Tim Redaksi YSDS',
            'summary'      => $validated['summary'] ?? null,
            'summary_en'   => $validated['summary_en'] ?? null,
            'content'      => $validated['content'],
            'content_en'   => $validated['content_en'] ?? null,
            'tags'         => $validated['tags'] ?? null,
            'image'        => $imagePath,
            'published_at' => $validated['published_at'] ?? now()->toDateString(),
            'is_published' => $request->boolean('is_published'),
            'is_featured'  => $request->boolean('is_featured'),
            'views_count'  => 0,
        ]);

        return redirect()->route('website.articles.admin.index')
            ->with('success', "Artikel non-jurnal '{$article->title}' berhasil dipublikasikan / disimpan.");
    }

    /**
     * Show form for editing the specified article.
     */
    public function edit(int $id): View
    {
        $article = WebsiteNews::findOrFail($id);
        $categories = $this->defaultCategories;

        return view('website::admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $article = WebsiteNews::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'title_en'     => 'nullable|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:website_news,slug,' . $id,
            'category'     => 'required|string|max:100',
            'author_name'  => 'nullable|string|max:255',
            'summary'      => 'nullable|string|max:1000',
            'summary_en'   => 'nullable|string|max:1000',
            'content'      => 'required|string',
            'content_en'   => 'nullable|string',
            'tags'         => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'is_featured'  => 'nullable|boolean',
        ]);

        $imagePath = $article->image;
        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
        }

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : ($article->slug ?: WebsiteNews::generateUniqueSlug($validated['title'], $article->id));

        $article->update([
            'title'        => $validated['title'],
            'title_en'     => $validated['title_en'] ?? null,
            'slug'         => $slug,
            'category'     => $validated['category'],
            'author_name'  => $validated['author_name'] ?: 'Tim Redaksi YSDS',
            'summary'      => $validated['summary'] ?? null,
            'summary_en'   => $validated['summary_en'] ?? null,
            'content'      => $validated['content'],
            'content_en'   => $validated['content_en'] ?? null,
            'tags'         => $validated['tags'] ?? null,
            'image'        => $imagePath,
            'published_at' => $validated['published_at'] ?? $article->published_at,
            'is_published' => $request->boolean('is_published'),
            'is_featured'  => $request->boolean('is_featured'),
        ]);

        return redirect()->route('website.articles.admin.index')
            ->with('success', "Artikel '{$article->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $article = WebsiteNews::findOrFail($id);

        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $title = $article->title;
        $article->delete();

        return redirect()->route('website.articles.admin.index')
            ->with('success', "Artikel '{$title}' berhasil dihapus.");
    }

    /**
     * Toggle published status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $article = WebsiteNews::findOrFail($id);
        $article->update(['is_published' => !$article->is_published]);

        $statusText = $article->is_published ? 'dipublikasikan' : 'diarsipkan ke draft';
        return redirect()->back()
            ->with('success', "Status artikel '{$article->title}' berhasil {$statusText}.");
    }
}
