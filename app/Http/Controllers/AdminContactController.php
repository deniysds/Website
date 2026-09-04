<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Website\Models\WebsiteContact;

class AdminContactController extends Controller
{
    /**
     * Display a listing of inquiries submitted through the contact form.
     */
    public function index(Request $request): View
    {
        $query = WebsiteContact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        $unreadCount = WebsiteContact::unread()->count();
        $readCount = WebsiteContact::read()->count();
        $repliedCount = WebsiteContact::replied()->count();

        return view('website::admin.contacts.index', compact('contacts', 'unreadCount', 'readCount', 'repliedCount'));
    }

    /**
     * Display the specified contact inquiry details.
     */
    public function show(int $id): View
    {
        $contact = WebsiteContact::findOrFail($id);

        if ($contact->status === 'unread') {
            $contact->update([
                'status'  => 'read',
                'read_at' => now(),
            ]);
        }

        return view('website::admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact status and admin notes.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $contact = WebsiteContact::findOrFail($id);

        $validated = $request->validate([
            'status'      => 'required|in:unread,read,replied',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $updates = [
            'status'      => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $contact->admin_notes,
        ];

        if ($validated['status'] === 'replied' && !$contact->replied_at) {
            $updates['replied_at'] = now();
        }

        $contact->update($updates);

        return redirect()->route('website.contacts.show', $contact->id)
            ->with('success', 'Status dan catatan tindak lanjut pertanyaan berhasil diperbarui.');
    }

    /**
     * Delete contact inquiry.
     */
    public function destroy(int $id): RedirectResponse
    {
        $contact = WebsiteContact::findOrFail($id);
        $name = $contact->full_name;
        $contact->delete();

        return redirect()->route('website.contacts.index')
            ->with('success', "Pesan pertanyaan dari '{$name}' berhasil dihapus.");
    }

    /**
     * Export contact inquiries to CSV format (Excel compatible).
     */
    public function exportCsv(Request $request)
    {
        $query = WebsiteContact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contacts = $query->latest()->get();

        $fileName = 'inquiries_export_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($contacts) {
            $file = fopen('php://output', 'w');
            // Tulis UTF-8 BOM untuk kompatibilitas Microsoft Excel
            fputs($file, "\xEF\xBB\xBF");

            // CSV Column Headers
            fputcsv($file, [
                'ID',
                'Nama Lengkap',
                'Nomor Telepon',
                'Email',
                'Status',
                'Tanggal Masuk',
                'Tanggal Ditindaklanjuti',
                'Catatan Admin',
                'Isi Pesan',
            ]);

            foreach ($contacts as $c) {
                fputcsv($file, [
                    $c->id,
                    $c->full_name,
                    $c->phone,
                    $c->email,
                    strtoupper($c->status),
                    $c->created_at ? $c->created_at->format('Y-m-d H:i:s') : '-',
                    $c->replied_at ? $c->replied_at->format('Y-m-d H:i:s') : '-',
                    $c->admin_notes ?? '-',
                    $c->message,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
