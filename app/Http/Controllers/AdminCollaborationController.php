<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\Models\WebsiteCollaboration;
use Modules\Website\Models\WebsiteCollaborationItem;

class AdminCollaborationController extends Controller
{
    /**
     * Display a listing of collaborations & institutions.
     */
    public function index(Request $request): View
    {
        $query = WebsiteCollaboration::with(['items'])->withCount('items');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhereHas('items', function ($itemQ) use ($search) {
                      $itemQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $collaborations = $query->orderBy('order_no', 'asc')
            ->orderBy('handover_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalInstitutions = WebsiteCollaboration::count();
        $totalActiveInstitutions = WebsiteCollaboration::where('is_active', true)->count();
        $totalItemsCount = WebsiteCollaborationItem::count();
        $totalUnitsSum = (int) WebsiteCollaborationItem::sum('quantity');

        $categories = WebsiteCollaboration::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        return view('website::admin.collaborations.index', compact(
            'collaborations',
            'totalInstitutions',
            'totalActiveInstitutions',
            'totalItemsCount',
            'totalUnitsSum',
            'categories'
        ));
    }

    /**
     * Store a newly created collaboration institution.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'category'         => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'handover_date'    => 'nullable|date',
            'pic_name'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'order_no'         => 'nullable|integer|min:0',
            'is_active'        => 'nullable|boolean',
            'institution_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('institution_logo')) {
            $logoPath = $request->file('institution_logo')->store('collaborations', 'public');
        }

        $collaboration = WebsiteCollaboration::create([
            'institution_name' => $validated['institution_name'],
            'category'         => $validated['category'] ?? null,
            'location'         => $validated['location'] ?? null,
            'handover_date'    => $validated['handover_date'] ?? null,
            'pic_name'         => $validated['pic_name'] ?? null,
            'description'      => $validated['description'] ?? null,
            'order_no'         => $validated['order_no'] ?? 0,
            'is_active'        => $request->boolean('is_active', true),
            'institution_logo' => $logoPath,
        ]);

        return redirect()->route('website.collaborations.show', $collaboration->id)
            ->with('success', "Instansi '{$collaboration->institution_name}' berhasil ditambahkan. Silakan kelola rincian peralatan yang diserahkan.");
    }

    /**
     * Display the specified collaboration details and equipment list.
     */
    public function show(int $id): View
    {
        $collaboration = WebsiteCollaboration::with(['items' => function ($q) {
            $q->orderBy('order_no', 'asc')->orderBy('id', 'asc');
        }])->findOrFail($id);

        return view('website::admin.collaborations.show', compact('collaboration'));
    }

    /**
     * Update the specified collaboration institution in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);

        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'category'         => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'handover_date'    => 'nullable|date',
            'pic_name'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'order_no'         => 'nullable|integer|min:0',
            'is_active'        => 'nullable|boolean',
            'institution_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $logoPath = $collaboration->institution_logo;
        if ($request->hasFile('institution_logo')) {
            if ($collaboration->institution_logo && Storage::disk('public')->exists($collaboration->institution_logo)) {
                Storage::disk('public')->delete($collaboration->institution_logo);
            }
            $logoPath = $request->file('institution_logo')->store('collaborations', 'public');
        }

        $collaboration->update([
            'institution_name' => $validated['institution_name'],
            'category'         => $validated['category'] ?? null,
            'location'         => $validated['location'] ?? null,
            'handover_date'    => $validated['handover_date'] ?? null,
            'pic_name'         => $validated['pic_name'] ?? null,
            'description'      => $validated['description'] ?? null,
            'order_no'         => $validated['order_no'] ?? 0,
            'is_active'        => $request->boolean('is_active', true),
            'institution_logo' => $logoPath,
        ]);

        return redirect()->back()
            ->with('success', "Data instansi '{$collaboration->institution_name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified collaboration institution from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);

        if ($collaboration->institution_logo && Storage::disk('public')->exists($collaboration->institution_logo)) {
            Storage::disk('public')->delete($collaboration->institution_logo);
        }

        $name = $collaboration->institution_name;
        $collaboration->delete();

        return redirect()->route('website.collaborations.index')
            ->with('success', "Data instansi '{$name}' dan riwayat peralatan berhasil dihapus.");
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);
        $collaboration->update(['is_active' => !$collaboration->is_active]);

        $statusText = $collaboration->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Status instansi '{$collaboration->institution_name}' berhasil {$statusText}.");
    }

    /**
     * Store a newly created equipment item for the collaboration.
     */
    public function storeItem(Request $request, int $id): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);

        $validated = $request->validate([
            'item_number'    => 'required|string|max:50',
            'name'           => 'required|string|max:255',
            'unit'           => 'required|string|max:50',
            'quantity'       => 'required|integer|min:1',
            'specifications' => 'nullable|string',
            'order_no'       => 'nullable|integer|min:0',
        ]);

        $collaboration->items()->create([
            'item_number'    => $validated['item_number'],
            'name'           => $validated['name'],
            'unit'           => $validated['unit'],
            'quantity'       => $validated['quantity'],
            'specifications' => $validated['specifications'] ?? null,
            'order_no'       => $validated['order_no'] ?? 0,
        ]);

        return redirect()->route('website.collaborations.show', $collaboration->id)
            ->with('success', "Peralatan '{$validated['name']}' berhasil ditambahkan ke instansi {$collaboration->institution_name}.");
    }

    /**
     * Update the specified equipment item.
     */
    public function updateItem(Request $request, int $id, int $itemId): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);
        $item = $collaboration->items()->findOrFail($itemId);

        $validated = $request->validate([
            'item_number'    => 'required|string|max:50',
            'name'           => 'required|string|max:255',
            'unit'           => 'required|string|max:50',
            'quantity'       => 'required|integer|min:1',
            'specifications' => 'nullable|string',
            'order_no'       => 'nullable|integer|min:0',
        ]);

        $item->update([
            'item_number'    => $validated['item_number'],
            'name'           => $validated['name'],
            'unit'           => $validated['unit'],
            'quantity'       => $validated['quantity'],
            'specifications' => $validated['specifications'] ?? null,
            'order_no'       => $validated['order_no'] ?? 0,
        ]);

        return redirect()->route('website.collaborations.show', $collaboration->id)
            ->with('success', "Data peralatan '{$item->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified equipment item.
     */
    public function destroyItem(int $id, int $itemId): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);
        $item = $collaboration->items()->findOrFail($itemId);

        $name = $item->name;
        $item->delete();

        return redirect()->route('website.collaborations.show', $collaboration->id)
            ->with('success', "Peralatan '{$name}' berhasil dihapus dari daftar serah terima.");
    }
}
