@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Pusat Dokumen & Laporan Publik</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pusat Dokumen & Unduhan Publik</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola berkas publikasi laporan tahunan, laporan keuangan audit, legalitas SK yayasan, dan SOP program.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.documents.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs px-3.5 py-2">
                    <i class="ki-filled ki-eye mr-1"></i> Lihat Halaman Publik
                </a>
                <a href="{{ route('website.documents.admin.create') }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus mr-1"></i> Unggah Dokumen Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Stat Counter Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-document"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $totalDocuments }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Dokumen</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-file-down"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-emerald-600">{{ number_format($totalDownloads) }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Unduhan</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $activeCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Publik (Aktif)</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-archive"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-amber-600">{{ $inactiveCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Draft / Arsip</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-6">
            <form action="{{ route('website.documents.admin.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-5">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen, deskripsi, atau tahun..." class="kt-input w-full text-xs">
                </div>
                <div class="md:col-span-3">
                    <select name="category" class="kt-select w-full text-xs">
                        <option value="">-- Semua Kategori --</option>
                        <option value="laporan_tahunan" {{ request('category') === 'laporan_tahunan' ? 'selected' : '' }}>Laporan Tahunan (Annual Report)</option>
                        <option value="laporan_keuangan" {{ request('category') === 'laporan_keuangan' ? 'selected' : '' }}>Laporan Keuangan Teraudit</option>
                        <option value="legalitas_sk" {{ request('category') === 'legalitas_sk' ? 'selected' : '' }}>Legalitas & SK Kemenkumham</option>
                        <option value="panduan_sop" {{ request('category') === 'panduan_sop' ? 'selected' : '' }}>SOP & Panduan Program</option>
                        <option value="brosur_profil" {{ request('category') === 'brosur_profil' ? 'selected' : '' }}>Brosur & Profil Yayasan</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Publik)</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-aktif (Arsip)</option>
                    </select>
                </div>
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit" class="kt-btn kt-btn-primary w-full text-xs px-3">
                        <i class="ki-filled ki-magnifier"></i>
                    </button>
                    @if(request()->anyFilled(['search', 'category', 'status']))
                        <a href="{{ route('website.documents.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3" title="Reset Filter">
                            <i class="ki-filled ki-cross"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Data -->
        <div class="kt-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="kt-table w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                            <th class="py-4 px-6">Judul Dokumen</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6 text-center">Tahun</th>
                            <th class="py-4 px-6 text-center">Ukuran / Format</th>
                            <th class="py-4 px-6 text-center">Unduhan</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900">{{ $doc->title }}</div>
                                    @if($doc->description)
                                        <div class="text-[11px] text-gray-400 mt-0.5 max-w-sm truncate">{{ $doc->description }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $doc->category_badge_class }}">
                                        {{ $doc->category_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center font-mono font-semibold text-gray-700">
                                    {{ $doc->published_year ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="uppercase font-bold text-gray-800 text-[11px] bg-slate-100 px-1.5 py-0.5 rounded">{{ $doc->file_extension }}</span>
                                    <span class="text-gray-400 text-[11px] block mt-0.5">{{ $doc->formatted_file_size }}</span>
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-blue-600">
                                    {{ number_format($doc->download_count) }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($doc->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Aktif (Live)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                            Arsip
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('website.documents.admin.toggle', $doc->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline text-xs px-2 py-1" title="{{ $doc->is_active ? 'Arsipkan' : 'Aktifkan' }}">
                                                <i class="ki-filled {{ $doc->is_active ? 'ki-eye-slash' : 'ki-eye' }}"></i>
                                            </button>
                                        </form>

                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="kt-btn kt-btn-sm kt-btn-outline text-blue-600 text-xs px-2 py-1" title="Unduh Berkas">
                                            <i class="ki-filled ki-file-down"></i>
                                        </a>

                                        <a href="{{ route('website.documents.admin.edit', $doc->id) }}" class="kt-btn kt-btn-sm kt-btn-outline text-xs px-2 py-1" title="Edit">
                                            <i class="ki-filled ki-notepad-edit"></i>
                                        </a>

                                        <form action="{{ route('website.documents.admin.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline text-red-600 hover:bg-red-50 text-xs p-1" title="Hapus">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400">
                                    <i class="ki-filled ki-information-2 text-3xl mb-2 block"></i>
                                    <span>Belum ada data dokumen yang sesuai dengan filter.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($documents->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
