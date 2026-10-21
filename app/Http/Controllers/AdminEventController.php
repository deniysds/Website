<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Website\Models\WebsiteEvent;

class AdminEventController extends Controller
{
    /**
     * Display a listing of events / activities in CMS.
     */
    public function index(Request $request): View
    {
        $query = WebsiteEvent::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('partner_name', 'like', "%{$search}%")
                  ->orWhere('sponsor_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        $events = $query->orderBy('order_no', 'asc')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $totalEvents = WebsiteEvent::count();
        $publishedCount = WebsiteEvent::where('is_published', true)->count();
        $draftCount = WebsiteEvent::where('is_published', false)->count();
        $featuredCount = WebsiteEvent::where('is_featured', true)->count();

        $availableYears = WebsiteEvent::whereNotNull('year')
            ->where('year', '!=', '')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        return view('website::admin.events.index', compact(
            'events',
            'totalEvents',
            'publishedCount',
            'draftCount',
            'featuredCount',
            'availableYears'
        ));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('website::admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:website_events,slug',
            'tag'              => 'nullable|string|max:100',
            'year'             => 'required|string|max:10',
            'partner_name'     => 'nullable|string|max:255',
            'sponsor_name'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'summary'          => 'nullable|string|max:1000',
            'description'      => 'nullable|string',
            'event_date'       => 'nullable|string|max:100',
            'event_time'       => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'registration_url' => 'nullable|string|max:255',
            'order_no'         => 'nullable|integer',
            'is_featured'      => 'nullable|boolean',
            'is_published'     => 'nullable|boolean',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('events', 'public');
        }

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['title']);

        $baseSlug = $slug;
        $counter = 1;
        while (WebsiteEvent::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $event = WebsiteEvent::create([
            'title'            => $validated['title'],
            'slug'             => $slug,
            'tag'              => $validated['tag'] ?? 'Kegiatan Terbaru',
            'year'             => $validated['year'],
            'partner_name'     => $validated['partner_name'] ?? null,
            'sponsor_name'     => $validated['sponsor_name'] ?? null,
            'banner_image'     => $bannerPath,
            'summary'          => $validated['summary'] ?? null,
            'description'      => $validated['description'] ?? null,
            'event_date'       => $validated['event_date'] ?? null,
            'event_time'       => $validated['event_time'] ?? null,
            'location'         => $validated['location'] ?? null,
            'registration_url' => $validated['registration_url'] ?? null,
            'order_no'         => $validated['order_no'] ?? 1,
            'is_featured'      => $request->boolean('is_featured', false),
            'is_published'     => $request->boolean('is_published', true),
        ]);

        return redirect()->route('website.events.admin.index')
            ->with('success', "Kegiatan '{$event->title}' berhasil disimpan.");
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(int $id): View
    {
        $event = WebsiteEvent::findOrFail($id);
        return view('website::admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $event = WebsiteEvent::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:website_events,slug,' . $id,
            'tag'              => 'nullable|string|max:100',
            'year'             => 'required|string|max:10',
            'partner_name'     => 'nullable|string|max:255',
            'sponsor_name'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'summary'          => 'nullable|string|max:1000',
            'description'      => 'nullable|string',
            'event_date'       => 'nullable|string|max:100',
            'event_time'       => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'registration_url' => 'nullable|string|max:255',
            'order_no'         => 'nullable|integer',
            'is_featured'      => 'nullable|boolean',
            'is_published'     => 'nullable|boolean',
        ]);

        $bannerPath = $event->banner_image;
        if ($request->hasFile('banner_image')) {
            if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $bannerPath = $request->file('banner_image')->store('events', 'public');
        }

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : ($event->slug ?: Str::slug($validated['title']));

        $event->update([
            'title'            => $validated['title'],
            'slug'             => $slug,
            'tag'              => $validated['tag'] ?? $event->tag ?? 'Kegiatan Terbaru',
            'year'             => $validated['year'],
            'partner_name'     => $validated['partner_name'] ?? null,
            'sponsor_name'     => $validated['sponsor_name'] ?? null,
            'banner_image'     => $bannerPath,
            'summary'          => $validated['summary'] ?? null,
            'description'      => $validated['description'] ?? null,
            'event_date'       => $validated['event_date'] ?? null,
            'event_time'       => $validated['event_time'] ?? null,
            'location'         => $validated['location'] ?? null,
            'registration_url' => $validated['registration_url'] ?? null,
            'order_no'         => $validated['order_no'] ?? $event->order_no,
            'is_featured'      => $request->boolean('is_featured', false),
            'is_published'     => $request->boolean('is_published', true),
        ]);

        return redirect()->route('website.events.admin.index')
            ->with('success', "Kegiatan '{$event->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $event = WebsiteEvent::findOrFail($id);

        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $title = $event->title;
        $event->delete();

        return redirect()->route('website.events.admin.index')
            ->with('success', "Kegiatan '{$title}' berhasil dihapus.");
    }

    /**
     * Toggle published status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $event = WebsiteEvent::findOrFail($id);
        $event->update(['is_published' => !$event->is_published]);

        $statusText = $event->is_published ? 'dipublikasikan' : 'diarsipkan ke draft';
        return redirect()->back()
            ->with('success', "Status kegiatan '{$event->title}' berhasil {$statusText}.");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(int $id): RedirectResponse
    {
        $event = WebsiteEvent::findOrFail($id);
        $event->update(['is_featured' => !$event->is_featured]);

        $statusText = $event->is_featured ? 'dijadikan sorotan (featured)' : 'dihapus dari sorotan';
        return redirect()->back()
            ->with('success', "Status sorotan kegiatan '{$event->title}' berhasil diperbarui ({$statusText}).");
    }
}
