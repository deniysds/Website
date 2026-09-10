<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\Models\WebsiteOfficer;

class AdminOfficerController extends Controller
{
    /**
     * Display listing of officers for admin CMS.
     */
    public function index(Request $request): View
    {
        $query = WebsiteOfficer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('affiliation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('hierarchy_level')) {
            $query->where('hierarchy_level', $request->hierarchy_level);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $officers = $query->orderBy('hierarchy_level', 'asc')
            ->orderBy('order_no', 'asc')
            ->paginate(20)
            ->withQueryString();

        $countLevel1 = WebsiteOfficer::byHierarchy(1)->count();
        $countLevel2 = WebsiteOfficer::byHierarchy(2)->count();
        $countLevel3 = WebsiteOfficer::byHierarchy(3)->count();
        $countLevel4 = WebsiteOfficer::byHierarchy(4)->count();

        return view('website::admin.officers.index', compact(
            'officers',
            'countLevel1',
            'countLevel2',
            'countLevel3',
            'countLevel4'
        ));
    }

    /**
     * Store newly created officer in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'title_prefix'    => 'nullable|string|max:50',
            'title_suffix'    => 'nullable|string|max:50',
            'position'        => 'required|string|max:255',
            'category'        => 'required|in:pembina,pengawas,pengurus_harian,dewan_redaksi,tim_ahli',
            'hierarchy_level' => 'required|integer|in:1,2,3,4',
            'affiliation'     => 'nullable|string|max:255',
            'bio'             => 'nullable|string',
            'email'           => 'nullable|email|max:255',
            'linkedin_url'    => 'nullable|url|max:255',
            'order_no'        => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('officers', 'public');
        }

        WebsiteOfficer::create([
            'name'            => $validated['name'],
            'title_prefix'    => $validated['title_prefix'] ?? null,
            'title_suffix'    => $validated['title_suffix'] ?? null,
            'position'        => $validated['position'],
            'category'        => $validated['category'],
            'hierarchy_level' => $validated['hierarchy_level'],
            'affiliation'     => $validated['affiliation'] ?? null,
            'bio'             => $validated['bio'] ?? null,
            'email'           => $validated['email'] ?? null,
            'linkedin_url'    => $validated['linkedin_url'] ?? null,
            'order_no'        => $validated['order_no'] ?? 0,
            'is_active'       => $request->boolean('is_active', true),
            'photo_path'      => $photoPath,
        ]);

        return redirect()->route('website.officers.index')
            ->with('success', 'Data pengurus baru berhasil ditambahkan.');
    }

    /**
     * Update specified officer in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $officer = WebsiteOfficer::findOrFail($id);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'title_prefix'    => 'nullable|string|max:50',
            'title_suffix'    => 'nullable|string|max:50',
            'position'        => 'required|string|max:255',
            'category'        => 'required|in:pembina,pengawas,pengurus_harian,dewan_redaksi,tim_ahli',
            'hierarchy_level' => 'required|integer|in:1,2,3,4',
            'affiliation'     => 'nullable|string|max:255',
            'bio'             => 'nullable|string',
            'email'           => 'nullable|email|max:255',
            'linkedin_url'    => 'nullable|url|max:255',
            'order_no'        => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photoPath = $officer->photo_path;
        if ($request->hasFile('photo')) {
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('officers', 'public');
        }

        $officer->update([
            'name'            => $validated['name'],
            'title_prefix'    => $validated['title_prefix'] ?? null,
            'title_suffix'    => $validated['title_suffix'] ?? null,
            'position'        => $validated['position'],
            'category'        => $validated['category'],
            'hierarchy_level' => $validated['hierarchy_level'],
            'affiliation'     => $validated['affiliation'] ?? null,
            'bio'             => $validated['bio'] ?? null,
            'email'           => $validated['email'] ?? null,
            'linkedin_url'    => $validated['linkedin_url'] ?? null,
            'order_no'        => $validated['order_no'] ?? 0,
            'is_active'       => $request->boolean('is_active', true),
            'photo_path'      => $photoPath,
        ]);

        return redirect()->route('website.officers.index')
            ->with('success', 'Data profil dan jabatan pengurus berhasil diperbarui.');
    }

    /**
     * Remove specified officer from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $officer = WebsiteOfficer::findOrFail($id);

        if ($officer->photo_path && Storage::disk('public')->exists($officer->photo_path)) {
            Storage::disk('public')->delete($officer->photo_path);
        }

        $officer->delete();

        return redirect()->route('website.officers.index')
            ->with('success', 'Pengurus berhasil dihapus dari sistem.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $officer = WebsiteOfficer::findOrFail($id);
        $officer->is_active = !$officer->is_active;
        $officer->save();

        $statusLabel = $officer->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Status pengurus {$officer->full_name_with_title} berhasil {$statusLabel}.");
    }
}
