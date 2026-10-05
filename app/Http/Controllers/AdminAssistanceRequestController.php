<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Website\Mail\AssistanceRequestStatusUpdatedMail;
use Modules\Website\Models\WebsiteAssistanceRequest;
use Modules\Website\Models\WebsiteCollaboration;
use Modules\Website\Models\WebsiteSetting;
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
                $q->where('ticket_code', 'like', "%{$search}%")
                  ->orWhere('institution_name', 'like', "%{$search}%")
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

        $oldStatus = $assistanceRequest->status;
        $assistanceRequest->update($updates);

        // Kirim email pembaruan status ke PIC pemohon bila status menjadi approved, distributed, atau rejected
        if ($oldStatus !== $validated['status'] && in_array($validated['status'], ['approved', 'distributed', 'rejected'])) {
            try {
                Mail::to($assistanceRequest->pic_email)->send(new AssistanceRequestStatusUpdatedMail($assistanceRequest));
            } catch (\Throwable $e) {
                Log::warning('Gagal mengirim email status update ke PIC: ' . $e->getMessage());
            }
        }

        return redirect()->route('website.assistance.show', $assistanceRequest->id)
            ->with('success', "Status permohonan bantuan dari '{$assistanceRequest->institution_name}' berhasil diperbarui menjadi '{$assistanceRequest->status_label}'.");
    }

    /**
     * Display printable disposition and review sheet for medical board review.
     */
    public function printDisposisi(int $id): View
    {
        $assistanceRequest = WebsiteAssistanceRequest::findOrFail($id);
        $settings = WebsiteSetting::pluck('value', 'key')->all();

        return view('website::admin.assistance_requests.print', compact('assistanceRequest', 'settings'));
    }

    /**
     * Convert approved assistance request to official collaboration & equipment handover entry.
     */
    public function convertToCollaboration(int $id): RedirectResponse
    {
        $assistanceRequest = WebsiteAssistanceRequest::findOrFail($id);

        $location = trim(($assistanceRequest->city ? $assistanceRequest->city . ', ' : '') . ($assistanceRequest->province ?: 'Indonesia'));

        $collaboration = WebsiteCollaboration::create([
            'institution_name' => $assistanceRequest->institution_name,
            'category'         => $assistanceRequest->institution_type,
            'location'         => $location ?: 'Indonesia',
            'pic_name'         => $assistanceRequest->pic_name,
            'description'      => "Realisasi permohonan bantuan kesehatan (Tiket: {$assistanceRequest->ticket_code}). Rincian: {$assistanceRequest->equipment_needed}",
            'handover_date'    => now()->toDateString(),
            'is_active'        => true,
            'order_no'         => 0,
        ]);

        // Catat referensi konversi di catatan permohonan bantuan
        $conversionNote = "Dikonversi ke Kerjasama & Penyerahan Alat ID #{$collaboration->id} pada " . now()->format('d/m/Y H:i');
        $newNotes = $assistanceRequest->admin_notes ? $assistanceRequest->admin_notes . "\n" . $conversionNote : $conversionNote;

        $updateData = ['admin_notes' => $newNotes];
        if ($assistanceRequest->status === 'pending' || $assistanceRequest->status === 'reviewed') {
            $updateData['status'] = 'approved';
            $updateData['approved_at'] = $assistanceRequest->approved_at ?: now();
        }
        $assistanceRequest->update($updateData);

        return redirect()->route('website.collaborations.show', $collaboration->id)
            ->with('success', "Permohonan bantuan dari '{$assistanceRequest->institution_name}' berhasil dikonversi menjadi data Kerjasama & Penyerahan Alat (#{$collaboration->id}). Anda sekarang dapat melengkapi rincian unit alat atau mencetak BAST.");
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
                'No. Registrasi / Tiket',
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
                        $item->ticket_code,
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
