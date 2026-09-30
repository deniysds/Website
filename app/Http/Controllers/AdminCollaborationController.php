<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Website\Imports\CollaborationItemsImport;
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

    /**
     * Export all collaborations recap and equipments summary to CSV (Excel compatible).
     */
    public function exportCsv(Request $request)
    {
        $query = WebsiteCollaboration::with(['items' => function ($q) {
            $q->orderBy('order_no', 'asc')->orderBy('id', 'asc');
        }]);

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
            ->get();

        $fileName = 'rekap_kolaborasi_penyerahan_alat_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($collaborations) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Microsoft Excel compatibility

            fputcsv($file, [
                'ID',
                'Nama Instansi Mitra',
                'Kategori Instansi',
                'Lokasi / Wilayah',
                'Penanggung Jawab (PIC)',
                'Tanggal Serah Terima',
                'Status Publikasi',
                'Jumlah Jenis Alat',
                'Total Unit Diserahkan',
                'Daftar Rincian Peralatan',
                'Deskripsi / Catatan BAST',
            ]);

            foreach ($collaborations as $c) {
                $equipmentList = $c->items->map(function ($item) {
                    $spec = $item->specifications ? " [{$item->specifications}]" : '';
                    return "{$item->item_number}. {$item->name} ({$item->quantity} {$item->unit}){$spec}";
                })->implode('; ');

                fputcsv($file, [
                    $c->id,
                    $c->institution_name,
                    $c->category ?? '-',
                    $c->location ?? '-',
                    $c->pic_name ?? '-',
                    $c->handover_date ? $c->handover_date->format('Y-m-d') : '-',
                    $c->is_active ? 'Publik / Aktif' : 'Draft / Non-Aktif',
                    $c->items->count(),
                    $c->items->sum('quantity'),
                    $equipmentList ?: '-',
                    $c->description ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export equipment list of a specific collaboration to CSV (Excel compatible).
     */
    public function exportItemsCsv(int $id)
    {
        $collaboration = WebsiteCollaboration::with(['items' => function ($q) {
            $q->orderBy('order_no', 'asc')->orderBy('id', 'asc');
        }])->findOrFail($id);

        $safeName = \Illuminate\Support\Str::slug($collaboration->institution_name, '_');
        $fileName = "peralatan_diserahkan_{$safeName}_" . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($collaboration) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Microsoft Excel compatibility

            fputcsv($file, [
                'Nomor Urut / Inventaris',
                'Nama Peralatan',
                'Satuan',
                'Jumlah Unit',
                'Spesifikasi / Merk / Catatan Kondisi',
                'Instansi Penerima',
                'Kategori Instansi',
                'Lokasi Instansi',
                'Penanggung Jawab (PIC)',
                'Tanggal Serah Terima',
            ]);

            foreach ($collaboration->items as $item) {
                fputcsv($file, [
                    $item->item_number,
                    $item->name,
                    $item->unit,
                    $item->quantity,
                    $item->specifications ?? '-',
                    $collaboration->institution_name,
                    $collaboration->category ?? '-',
                    $collaboration->location ?? '-',
                    $collaboration->pic_name ?? '-',
                    $collaboration->handover_date ? $collaboration->handover_date->format('Y-m-d') : '-',
                ]);
            }

            // Tambahkan baris pemisah dan total akumulasi peralatan
            fputcsv($file, []);
            fputcsv($file, [
                'TOTAL',
                $collaboration->items->count() . ' Jenis Peralatan',
                '',
                $collaboration->items->sum('quantity') . ' Unit',
                'Tercatat dalam Berita Acara Serah Terima (BAST)',
                $collaboration->institution_name,
                '',
                '',
                '',
                '',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display printable Berita Acara Serah Terima (BAST) view for collaboration equipment.
     */
    public function printBast(int $id): View
    {
        $collaboration = WebsiteCollaboration::with(['items' => function ($q) {
            $q->orderBy('order_no', 'asc')->orderBy('id', 'asc');
        }])->findOrFail($id);

        $settings = \Modules\Website\Models\WebsiteSetting::pluck('value', 'key')->all();

        return view('website::admin.collaborations.print-bast', compact('collaboration', 'settings'));
    }

    /**
     * Download sample Excel/CSV template for importing equipments.
     */
    public function downloadImportTemplate(int $id)
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);
        $fileName = 'template_import_peralatan_' . \Illuminate\Support\Str::slug($collaboration->institution_name, '_') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Microsoft Excel

            // Header kolom
            fputcsv($file, [
                'Nomor',
                'Nama Peralatan',
                'Satuan',
                'Jumlah',
                'Spesifikasi / Merk / Catatan',
            ]);

            // Baris contoh 1
            fputcsv($file, [
                '1',
                'Real-Time PCR Detection System',
                'Unit',
                '1',
                'Bio-Rad CFX96 Touch, 96-well fast real-time PCR detection system',
            ]);

            // Baris contoh 2
            fputcsv($file, [
                '2',
                'Biosafety Cabinet (BSC) Class II Type A2',
                'Unit',
                '1',
                'HEPA filter 99.995% dengan microprocessor airflow control',
            ]);

            // Baris contoh 3
            fputcsv($file, [
                '3',
                'Refrigerated High-Speed Microcentrifuge',
                'Unit',
                '2',
                'Rotor 24 x 1.5/2.0 mL, kecepatan maksimum 15,000 RPM',
            ]);

            // Baris contoh 4
            fputcsv($file, [
                '4',
                'Set Adjustable Micropipette (0.5 - 1000 uL)',
                'Set',
                '10',
                'Autoclavable ergonomic micropipette 4 ukuran dengan tip box',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import equipments from uploaded Excel or CSV file.
     */
    public function importItems(Request $request, int $id): RedirectResponse
    {
        $collaboration = WebsiteCollaboration::findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:5120',
            'mode' => 'required|in:append,replace',
        ], [
            'file.required' => 'Silakan pilih berkas Excel atau CSV yang ingin diimpor.',
            'file.mimes'    => 'Format berkas harus berupa .xlsx, .xls, atau .csv.',
            'file.max'      => 'Ukuran berkas tidak boleh melebihi 5MB.',
            'mode.required' => 'Silakan pilih mode import (Tambahkan atau Ganti Total).',
        ]);

        try {
            $import = new CollaborationItemsImport($collaboration, $request->input('mode', 'append'));
            Excel::import($import, $request->file('file'));

            $count = $import->getImportedCount();
            $units = $import->getTotalUnits();

            if ($count === 0) {
                return redirect()->back()
                    ->withErrors(['import_error' => 'Tidak ditemukan data peralatan yang valid dalam berkas. Pastikan menggunakan format template yang disediakan.']);
            }

            $modeText = $request->input('mode') === 'replace' ? 'diganti dengan' : 'berhasil ditambahkan sebanyak';
            return redirect()->route('website.collaborations.show', $collaboration->id)
                ->with('success', "Data peralatan instansi '{$collaboration->institution_name}' {$modeText} {$count} jenis peralatan (total {$units} unit).");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['import_error' => 'Terjadi kesalahan saat memproses berkas: ' . $e->getMessage()]);
        }
    }
}
