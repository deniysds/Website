@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Dokumentasi Visitasi Lapangan</span>
    </div>
@endsection

@section('content')
<div class="container-fixed py-6 space-y-6">

    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dokumentasi Visitasi Lapangan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola publikasi laporan kunjungan langsung tim YSDS, penyerahan mesin PCR, dan supervisi faskes.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('website.visitations.public') }}" target="_blank" class="kt-btn kt-btn-outline text-gray-700 hover:bg-gray-100 text-xs px-3.5 py-2">
                <i class="ki-filled ki-eye mr-1"></i> Lihat Halaman Publik
            </a>
            <a href="{{ route('website.visitations.admin.create') }}" class="kt-btn bg-red-600 hover:bg-red-700 text-white text-xs px-3.5 py-2">
                <i class="ki-filled ki-plus mr-1"></i> Tambah Laporan Visitasi
            </a>
        </div>
    </div>

    <!-- Statistik Counter Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="kt-card p-5 border-l-4 border-l-red-600 space-y-1">
            <span class="text-gray-500 text-xs font-semibold">Total Laporan Visitasi</span>
            <div class="text-2xl font-black text-gray-900">{{ $visitations->total() }}</div>
            <p class="text-[11px] text-gray-400">Seluruh agenda kunjungan yang tercatat</p>
        </div>
        <div class="kt-card p-5 border-l-4 border-l-emerald-600 space-y-1">
            <span class="text-gray-500 text-xs font-semibold">Dipublikasikan (Live)</span>
            <div class="text-2xl font-black text-emerald-600">{{ $countPublished }}</div>
            <p class="text-[11px] text-gray-400">Tampil di portal publik dharma.or.id</p>
        </div>
        <div class="kt-card p-5 border-l-4 border-l-amber-500 space-y-1">
            <span class="text-gray-500 text-xs font-semibold">Draft / Arsip Internal</span>
            <div class="text-2xl font-black text-amber-600">{{ $countDraft }}</div>
            <p class="text-[11px] text-gray-400">Menunggu persetujuan publikasi</p>
        </div>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
            <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Tabel Data & Filter -->
    <div class="kt-card overflow-hidden">
        
        <!-- Filter Toolbar -->
        <div class="p-5 border-b border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="{{ route('website.visitations.admin.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-3">
                <div class="relative grow w-full">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari judul visitasi, nama instansi, atau kota..."
                           class="kt-input w-full pl-9 text-xs" />
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <i class="ki-filled ki-magnifier text-xs"></i>
                    </span>
                </div>

                @if($provinces->isNotEmpty())
                <div class="w-full sm:w-56">
                    <select name="province" onchange="this.form.submit()" class="kt-select w-full text-xs">
                        <option value="">Semua Provinsi</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <button type="submit" class="kt-btn bg-gray-900 text-white text-xs px-4 py-2">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'province']))
                <a href="{{ route('website.visitations.admin.index') }}" class="kt-btn kt-btn-outline text-gray-600 text-xs px-3 py-2">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-gray-50/80 text-gray-500 font-bold uppercase tracking-wider text-[11px] border-b border-gray-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Laporan &amp; Instansi Faskes</th>
                        <th class="py-3.5 px-4">Lokasi Wilayah</th>
                        <th class="py-3.5 px-4">Tanggal Kunjungan</th>
                        <th class="py-3.5 px-4">Delegasi YSDS</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($visitations as $index => $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="py-3.5 px-4 text-center text-gray-400 font-mono">
                                {{ $visitations->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-gray-900 text-sm line-clamp-1">{{ $item->title }}</div>
                                <div class="text-[11px] text-red-600 font-semibold mt-0.5">{{ $item->institution_name }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-gray-800">{{ $item->city ?: '-' }}</div>
                                <div class="text-[11px] text-gray-400">{{ $item->province ?: '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-600 font-medium">
                                {{ $item->visit_date ? $item->visit_date->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-gray-600 max-w-xs truncate">
                                {{ $item->delegation_team ?: '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('website.visitations.admin.toggle', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase transition {{ $item->is_published ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                        {{ $item->is_published ? 'Publik' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('website.visitations.admin.edit', $item->id) }}" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Edit Laporan">
                                        <i class="ki-filled ki-notepad-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('website.visitations.admin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan visitasi ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus Data">
                                            <i class="ki-filled ki-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-400">
                                <i class="ki-filled ki-information text-2xl block mb-2 text-gray-300"></i>
                                Belum ada laporan visitasi lapangan. Klik tombol <strong>Tambah Laporan Visitasi</strong> untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($visitations->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $visitations->links() }}
        </div>
        @endif

    </div>

</div>
@endsection
