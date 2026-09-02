<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\Models\WebsitePartner;

class AdminPartnerController extends Controller
{
    /**
     * Display a listing of the partners (Main & Supporting).
     */
    public function index(Request $request): View
    {
        $query = WebsitePartner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $partners = $query->orderBy('type', 'asc')
            ->orderBy('order_no', 'asc')
            ->paginate(20)
            ->withQueryString();

        $mainCount = WebsitePartner::main()->count();
        $supportingCount = WebsitePartner::supporting()->count();

        return view('website::admin.partners.index', compact('partners', 'mainCount', 'supportingCount'));
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:main,supporting',
            'website_url' => 'nullable|url|max:255',
            'order_no'    => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        WebsitePartner::create([
            'name'        => $validated['name'],
            'type'        => $validated['type'],
            'website_url' => $validated['website_url'] ?? null,
            'order_no'    => $validated['order_no'] ?? 0,
            'is_active'   => $request->boolean('is_active', true),
            'logo_path'   => $logoPath,
        ]);

        return redirect()->route('website.partners.index')
            ->with('success', 'Logo Mitra baru berhasil ditambahkan ke dalam sistem.');
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $partner = WebsitePartner::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:main,supporting',
            'website_url' => 'nullable|url|max:255',
            'order_no'    => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = $partner->logo_path;
        if ($request->hasFile('logo')) {
            if ($partner->logo_path && Storage::disk('public')->exists($partner->logo_path)) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        $partner->update([
            'name'        => $validated['name'],
            'type'        => $validated['type'],
            'website_url' => $validated['website_url'] ?? null,
            'order_no'    => $validated['order_no'] ?? 0,
            'is_active'   => $request->boolean('is_active', true),
            'logo_path'   => $logoPath,
        ]);

        return redirect()->route('website.partners.index')
            ->with('success', "Data mitra '{$partner->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $partner = WebsitePartner::findOrFail($id);

        if ($partner->logo_path && Storage::disk('public')->exists($partner->logo_path)) {
            Storage::disk('public')->delete($partner->logo_path);
        }

        $name = $partner->name;
        $partner->delete();

        return redirect()->route('website.partners.index')
            ->with('success', "Mitra '{$name}' berhasil dihapus dari sistem.");
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $partner = WebsitePartner::findOrFail($id);
        $partner->update(['is_active' => !$partner->is_active]);

        $statusText = $partner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('website.partners.index')
            ->with('success', "Status mitra '{$partner->name}' berhasil {$statusText}.");
    }
}
