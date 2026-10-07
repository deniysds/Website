<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\Models\WebsiteDonation;

class AdminDonationController extends Controller
{
    /**
     * Display a listing of donations and financial contributions.
     */
    public function index(Request $request): View
    {
        $query = WebsiteDonation::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donation_code', 'like', "%{$search}%")
                  ->orWhere('donor_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('program_target')) {
            $query->where('program_target', $request->program_target);
        }

        $donations = $query->latest('transfer_date')->latest('created_at')->paginate(15)->withQueryString();

        $totalVerifiedAmount = WebsiteDonation::verified()->sum('amount');
        $pendingCount = WebsiteDonation::pending()->count();
        $verifiedCount = WebsiteDonation::verified()->count();
        $rejectedCount = WebsiteDonation::where('status', 'rejected')->count();

        return view('website::admin.donations.index', compact(
            'donations',
            'totalVerifiedAmount',
            'pendingCount',
            'verifiedCount',
            'rejectedCount'
        ));
    }

    /**
     * Display the specified donation confirmation detail.
     */
    public function show(int $id): View
    {
        $donation = WebsiteDonation::findOrFail($id);

        return view('website::admin.donations.show', compact('donation'));
    }

    /**
     * Update donation verification status and admin notes.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $donation = WebsiteDonation::findOrFail($id);

        $validated = $request->validate([
            'status'      => 'required|in:pending,verified,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $updates = [
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $donation->admin_notes,
        ];

        if ($validated['status'] === 'verified' && ! $donation->verified_at) {
            $updates['verified_at'] = now();
        } elseif ($validated['status'] !== 'verified') {
            $updates['verified_at'] = null;
        }

        $donation->update($updates);

        return redirect()->route('website.donations.show', $donation->id)
            ->with('success', "Status donasi {$donation->donation_code} berhasil diperbarui menjadi " . $donation->status_label . '.');
    }

    /**
     * Delete donation record and uploaded proof of transfer.
     */
    public function destroy(int $id): RedirectResponse
    {
        $donation = WebsiteDonation::findOrFail($id);
        $code = $donation->donation_code;

        if ($donation->proof_path && Storage::disk('public')->exists($donation->proof_path)) {
            Storage::disk('public')->delete($donation->proof_path);
        }

        $donation->delete();

        return redirect()->route('website.donations.index')
            ->with('success', "Data donasi '{$code}' berhasil dihapus.");
    }

    /**
     * Export donations to CSV format.
     */
    public function exportCsv(Request $request)
    {
        $query = WebsiteDonation::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('donation_code', 'like', "%{$search}%")
                  ->orWhere('donor_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('program_target')) {
            $query->where('program_target', $request->program_target);
        }

        $donations = $query->latest('transfer_date')->latest('created_at')->get();

        $fileName = 'donations_export_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, [
                'Kode Donasi',
                'Nama Donatur',
                'Anonim?',
                'Tipe Donatur',
                'Email',
                'Nomor Telepon',
                'Program Tujuan',
                'Nominal (IDR)',
                'Tanggal Transfer',
                'Metode Pembayaran',
                'Bank Pengirim',
                'Status',
                'Tanggal Verifikasi',
                'Catatan Admin',
                'Pesan / Doa',
                'Tanggal Submit',
            ]);

            foreach ($donations as $d) {
                fputcsv($file, [
                    $d->donation_code,
                    $d->donor_name,
                    $d->is_anonymous ? 'YA' : 'TIDAK',
                    $d->donor_type === 'institution' ? 'Lembaga / Korporasi' : 'Individu',
                    $d->email,
                    $d->phone,
                    $d->program_target_label,
                    $d->amount,
                    $d->transfer_date ? $d->transfer_date->format('Y-m-d') : '-',
                    $d->payment_method ?? 'Transfer Bank',
                    $d->bank_name ?? '-',
                    strtoupper($d->status),
                    $d->verified_at ? $d->verified_at->format('Y-m-d H:i:s') : '-',
                    $d->admin_notes ?? '-',
                    $d->message ?? '-',
                    $d->created_at ? $d->created_at->format('Y-m-d H:i:s') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
