<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Website\Models\WebsiteAssistanceRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminAssistanceRequestController extends Controller
{
    /**
     * Display a listing of assistance requests from hospitals & health facilities.
     */
    public function index(Request $request): View
    {
        $query = WebsiteAssistanceRequest::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('pic_email', 'like', "%{$search}%")
                  ->orWhere('pic_phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('equipment_needed', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('institution_type')) {
            $query->where('institution_type', $request->institution_type);
        }

        $requests = $query->latest()->paginate(15)->withQueryString();

        $countPending = WebsiteAssistanceRequest::where('status', 'pending')->count();
        $countReviewed = WebsiteAssistanceRequest::where('status', 'reviewed')->count();
        $countApproved = WebsiteAssistanceRequest::where('status', 'approved')->count();
        $countDistributed = WebsiteAssistanceRequest::where('status', 'distributed')->count();
        $countRejected = WebsiteAssistanceRequest::where('status', 'rejected')->count();

        return view('website::admin.assistance_requests.index', compact(
            'requests',
            'countPending',
            'countReviewed',
            'countApproved',
            'countDistributed',
            'countRejected'
        ));
    }

    /**
     * Display the specified assistance request details.
     */
    public function show(int $id): View
    {
        $assistanceRequest = WebsiteAssistanceRequest::findOrFail($id);

        if ($assistanceRequest->status === 'pending') {
            $assistanceRequest->update([
                'status'      => 'reviewed',
                'reviewed_at' => now(),
            ]);
        }

        return view('website::admin.assistance_requests.show', compact('assistanceRequest'));
    }

    /**
     * Update assistance request status and verification notes.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $assistanceRequest = WebsiteAssistanceRequest::findOrFail($id);

        $validated = $request->validate([
            'status'      => 'required|in:pending,reviewed,approved,rejected,distributed',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $updates = [
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $assistanceRequest->admin_notes,
        ];

        if ($validated['status'] === 'reviewed' && !$assistanceRequest->reviewed_at) {
            $updates['reviewed_at'] = now();
        } elseif ($validated['status'] === 'approved' && !$assistanceRequest->approved_at) {
            $updates['approved_at'] = now();
        } elseif ($validated['status'] === 'distributed' && !$assistanceRequest->distributed_at) {
            $updates['distributed_at'] = now();
        }

        $assistanceRequest->update($updates);

        return redirect()->route('website.assistance.show', $assistanceRequest->id)
            ->with('success', "Status permohonan bantuan dari '{$assistanceRequest->institution_name}' berhasil diperbarui menjadi '{$assistanceRequest->status_label}'.");
    }

    /**
     * Delete an assistance request.
     */
    public function destroy(int $id): RedirectResponse
    {
        $assistanceRequest = WebsiteAssistanceRequest::findOrFail($id);
        $name = $assistanceRequest->institution_name;
        $assistanceRequest->delete();

        return redirect()->route('website.assistance.index')
            ->with('success', "Permohonan bantuan dari instansi '{$name}' berhasil dihapus.");
    }

    /**
     * Export all assistance requests to CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'rekap_permohonan_bantuan_ysds_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // BOM untuk UTF-8 Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header baris CSV
            fputcsv($handle, [
                'ID',
                'Nama Instansi / Faskes',
                'Jenis Instansi',
                'Nama PIC',
                'Jabatan PIC',
                'No. Telepon / WA',
                'Email PIC',
                'Provinsi',
                'Kota / Kabupaten',
                'Alamat Lengkap',
                'Jenis Bantuan',
                'Rincian Alat Dibutuhkan',
                'Alasan Kebutuhan / Urgensi',
                'Status Permohonan',
                'Catatan Admin',
                'Tanggal Diajukan',
            ]);

            WebsiteAssistanceRequest::query()->latest()->chunk(100, function ($records) use ($handle) {
                foreach ($records as $item) {
                    fputcsv($handle, [
                        $item->id,
                        $item->institution_name,
                        $item->institution_type,
                        $item->pic_name,
                        $item->pic_position,
                        $item->pic_phone,
                        $item->pic_email,
                        $item->province,
                        $item->city,
                        $item->address,
                        $item->assistance_type,
                        $item->equipment_needed,
                        $item->urgency_reason,
                        $item->status_label,
                        $item->admin_notes,
                        $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '-',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}
