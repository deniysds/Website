<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Website\Models\WebsiteDocument;

class AdminDocumentController extends Controller
{
    /**
     * Display a listing of public downloadable documents.
     */
    public function index(Request $request): View
    {
        $query = WebsiteDocument::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('published_year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $documents = $query->orderBy('order_no', 'asc')
            ->orderBy('published_year', 'desc')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalDocuments = WebsiteDocument::count();
        $totalDownloads = WebsiteDocument::sum('download_count');
        $activeCount = WebsiteDocument::where('is_active', true)->count();
        $inactiveCount = WebsiteDocument::where('is_active', false)->count();

        return view('website::admin.documents.index', compact(
            'documents',
            'totalDocuments',
            'totalDownloads',
            'activeCount',
            'inactiveCount'
        ));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create(): View
    {
        return view('website::admin.documents.create');
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|in:laporan_tahunan,laporan_keuangan,legalitas_sk,panduan_sop,brosur_profil',
            'description'    => 'nullable|string|max:1000',
            'published_year' => 'nullable|integer|min:2010|max:' . (date('Y') + 1),
            'order_no'       => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
            'file'           => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:20480', // Max 20MB
        ]);

        $file = $request->file('file');
        $filePath = $file->store('website/documents', 'public');
        $fileSize = $file->getSize();
        $fileExtension = strtolower($file->getClientOriginalExtension());

        WebsiteDocument::create([
            'title'          => strip_tags(trim($validated['title'])),
            'category'       => $validated['category'],
            'description'    => !empty($validated['description']) ? strip_tags(trim($validated['description'])) : null,
            'file_path'      => $filePath,
            'file_size'      => $fileSize,
            'file_extension' => $fileExtension,
            'published_year' => $validated['published_year'] ?? date('Y'),
            'order_no'       => $validated['order_no'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
        ]);

        return redirect()->route('website.documents.admin.index')
            ->with('success', 'Dokumen publik berhasil diunggah.');
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(int $id): View
    {
        $document = WebsiteDocument::findOrFail($id);

        return view('website::admin.documents.edit', compact('document'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $document = WebsiteDocument::findOrFail($id);

        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'required|string|in:laporan_tahunan,laporan_keuangan,legalitas_sk,panduan_sop,brosur_profil',
            'description'    => 'nullable|string|max:1000',
            'published_year' => 'nullable|integer|min:2010|max:' . (date('Y') + 1),
            'order_no'       => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
            'file'           => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:20480',
        ]);

        $updates = [
            'title'          => strip_tags(trim($validated['title'])),
            'category'       => $validated['category'],
            'description'    => !empty($validated['description']) ? strip_tags(trim($validated['description'])) : null,
            'published_year' => $validated['published_year'] ?? $document->published_year,
            'order_no'       => $validated['order_no'] ?? 0,
            'is_active'      => $request->boolean('is_active'),
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $updates['file_path'] = $file->store('website/documents', 'public');
            $updates['file_size'] = $file->getSize();
            $updates['file_extension'] = strtolower($file->getClientOriginalExtension());
        }

        $document->update($updates);

        return redirect()->route('website.documents.admin.index')
            ->with('success', "Dokumen '{$document->title}' berhasil diperbarui.");
    }

    /**
     * Toggle the active status of the document.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        $document = WebsiteDocument::findOrFail($id);
        $document->update(['is_active' => ! $document->is_active]);

        $statusStr = $document->is_active ? 'diaktifkan untuk publik' : 'dinonaktifkan (diarsipkan)';

        return redirect()->route('website.documents.admin.index')
            ->with('success', "Dokumen '{$document->title}' berhasil {$statusStr}.");
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $document = WebsiteDocument::findOrFail($id);
        $title = $document->title;

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('website.documents.admin.index')
            ->with('success', "Dokumen '{$title}' berhasil dihapus.");
    }
}
