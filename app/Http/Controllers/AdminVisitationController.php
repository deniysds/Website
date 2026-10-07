<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Website\Models\WebsiteVisitation;

class AdminVisitationController extends Controller
{
    /**
     * Display a listing of field visitations.
     */
    public function index(Request $request): View
    {
        $query = WebsiteVisitation::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('institution_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('delegation_team', 'like', "%{$search}%");
            });
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        $visitations = $query->orderBy('order_no', 'asc')->latest('visit_date')->paginate(12)->withQueryString();
        $countPublished = WebsiteVisitation::where('is_published', true)->count();
        $countDraft = WebsiteVisitation::where('is_published', false)->count();
        $provinces = WebsiteVisitation::whereNotNull('province')->distinct()->pluck('province');

        return view('website::admin.visitations.index', compact(
            'visitations',
            'countPublished',
            'countDraft',
            'provinces'
        ));
    }

    /**
     * Show form for creating a new visitation record.
     */
    public function create(): View
    {
        return view('website::admin.visitations.create');
    }

    /**
     * Store a newly created visitation record.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'city'             => 'nullable|string|max:100',
            'province'         => 'nullable|string|max:100',
            'visit_date'       => 'nullable|date',
            'delegation_team'  => 'nullable|string|max:255',
            'summary'          => 'nullable|string|max:1000',
            'description'      => 'nullable|string',
            'video_url'        => 'nullable|url|max:255',
            'order_no'         => 'nullable|integer|min:0',
            'is_published'     => 'nullable|boolean',
            'cover_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('visitations/covers', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('visitations/gallery', 'public');
            }
        }

        WebsiteVisitation::create([
            'title'            => $validated['title'],
            'institution_name' => $validated['institution_name'],
            'city'             => $validated['city'] ?? null,
            'province'         => $validated['province'] ?? null,
            'visit_date'       => $validated['visit_date'] ?? null,
            'delegation_team'  => $validated['delegation_team'] ?? null,
            'summary'          => $validated['summary'] ?? null,
            'description'      => $validated['description'] ?? null,
            'video_url'        => $validated['video_url'] ?? null,
            'order_no'         => $validated['order_no'] ?? 0,
            'is_published'     => $request->has('is_published'),
            'cover_image'      => $coverPath,
            'gallery_images'   => !empty($galleryPaths) ? $galleryPaths : null,
        ]);

        return redirect()->route('website.visitations.admin.index')
            ->with('success', 'Dokumentasi visitasi lapangan berhasil ditambahkan.');
    }

    /**
     * Show form for editing an existing visitation record.
     */
    public function edit(int $id): View
    {
        $visitation = WebsiteVisitation::findOrFail($id);
        return view('website::admin.visitations.edit', compact('visitation'));
    }

    /**
     * Update an existing visitation record.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $visitation = WebsiteVisitation::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'city'             => 'nullable|string|max:100',
            'province'         => 'nullable|string|max:100',
            'visit_date'       => 'nullable|date',
            'delegation_team'  => 'nullable|string|max:255',
            'summary'          => 'nullable|string|max:1000',
            'description'      => 'nullable|string',
            'video_url'        => 'nullable|url|max:255',
            'order_no'         => 'nullable|integer|min:0',
            'is_published'     => 'nullable|boolean',
            'cover_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $coverPath = $visitation->cover_image;
        if ($request->hasFile('cover_image')) {
            if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }
            $coverPath = $request->file('cover_image')->store('visitations/covers', 'public');
        }

        $galleryPaths = $visitation->gallery_images ?? [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('visitations/gallery', 'public');
            }
        }

        $visitation->update([
            'title'            => $validated['title'],
            'institution_name' => $validated['institution_name'],
            'city'             => $validated['city'] ?? null,
            'province'         => $validated['province'] ?? null,
            'visit_date'       => $validated['visit_date'] ?? null,
            'delegation_team'  => $validated['delegation_team'] ?? null,
            'summary'          => $validated['summary'] ?? null,
            'description'      => $validated['description'] ?? null,
            'video_url'        => $validated['video_url'] ?? null,
            'order_no'         => $validated['order_no'] ?? 0,
            'is_published'     => $request->has('is_published'),
            'cover_image'      => $coverPath,
            'gallery_images'   => !empty($galleryPaths) ? $galleryPaths : null,
        ]);

        return redirect()->route('website.visitations.admin.index')
            ->with('success', 'Dokumentasi visitasi berhasil diperbarui.');
    }

    /**
     * Toggle published status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $visitation = WebsiteVisitation::findOrFail($id);
        $visitation->update(['is_published' => !$visitation->is_published]);

        $statusStr = $visitation->is_published ? 'dipublikasikan' : 'disimpan sebagai draft';
        return redirect()->route('website.visitations.admin.index')
            ->with('success', "Dokumentasi visitasi '{$visitation->title}' sekarang {$statusStr}.");
    }

    /**
     * Delete a visitation record.
     */
    public function destroy(int $id): RedirectResponse
    {
        $visitation = WebsiteVisitation::findOrFail($id);

        if ($visitation->cover_image && Storage::disk('public')->exists($visitation->cover_image)) {
            Storage::disk('public')->delete($visitation->cover_image);
        }

        if (!empty($visitation->gallery_images)) {
            foreach ($visitation->gallery_images as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $visitation->delete();

        return redirect()->route('website.visitations.admin.index')
            ->with('success', 'Dokumentasi visitasi berhasil dihapus.');
    }
}
