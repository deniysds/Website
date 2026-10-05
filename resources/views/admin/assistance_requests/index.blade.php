@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Permohonan Bantuan Faskes & Alkes</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Permohonan Bantuan Faskes & Alkes</h1>
                <p class="text-xs text-gray-500 mt-1">Daftar permohonan alat kesehatan, reagen, dan fasilitas medis yang diajukan oleh Rumah Sakit, Puskesmas, dan Laboratorium.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.assistance.export', request()->query()) }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-file-down text-white mr-1"></i> Ekspor CSV
                </a>
                <a href="{{ route('website.collaborations.index') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-briefcase mr-1"></i> Penyerahan Alat & BAST
                </a>
                <a href="{{ route('website.assistance.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Form Publik Faskes
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-time"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-amber-600">{{ $countPending }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Menunggu Verifikasi</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-eye"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-blue-600">{{ $countReviewed }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Sedang Ditinjau</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-emerald-600">{{ $countApproved }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Disetujui</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-delivery"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-purple-600">{{ $countDistributed }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Disalurkan</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-cross-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-red-600">{{ $countRejected }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Ditolak</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.assistance.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama faskes, PIC, kontak, kota, provinsi, atau alat yang dibutuhkan..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-48">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Sedang Ditinjau</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="distributed" {{ request('status') === 'distributed' ? 'selected' : '' }}>Disalurkan</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                    <i class="ki-filled ki-filter text-xs mr-1"></i> Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'institution_type']))
                    <a href="{{ route('website.assistance.index') }}" class="kt-btn kt-btn-outline text-xs px-3">Reset</a>
                @endif
            </form>
        </div>

        <!-- Table Permohonan Bantuan -->
        <div class="kt-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="kt-table w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-200 uppercase font-semibold text-[11px]">
                        <tr>
                            <th class="py-3.5 px-4">Instansi & Lokasi</th>
                            <th class="py-3.5 px-4">Penanggung Jawab (PIC)</th>
                            <th class="py-3.5 px-4">Kebutuhan Bantuan</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Masuk</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($requests as $item)
                            <tr class="hover:bg-gray-50/80 transition {{ $item->status === 'pending' ? 'bg-amber-50/20 font-medium' : '' }}">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-gray-900 text-sm">{{ $item->institution_name }}</span>
                                        <span class="px-1.5 py-0.5 rounded bg-gray-900 text-white font-mono text-[10px] font-bold">{{ $item->ticket_code }}</span>
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-0.5">
                                        <span class="inline-block px-1.5 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold mr-1">{{ $item->institution_type }}</span>
                                        {{ $item->city ? $item->city . ', ' : '' }}{{ $item->province ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-gray-900">{{ $item->pic_name }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $item->pic_position ?: 'PIC Instansi' }}</div>
                                    <div class="text-[11px] text-gray-500 mt-1 flex items-center gap-2">
                                        <a href="tel:{{ $item->pic_phone }}" class="hover:text-red-600 flex items-center gap-1"><i class="ki-filled ki-phone text-[10px]"></i> {{ $item->pic_phone }}</a>
                                        <a href="mailto:{{ $item->pic_email }}" class="hover:text-red-600 flex items-center gap-1"><i class="ki-filled ki-sms text-[10px]"></i> {{ $item->pic_email }}</a>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-red-50 text-red-700 border border-red-200">
                                        {{ $item->assistance_type }}
                                    </span>
                                    <p class="text-gray-600 text-xs mt-1 line-clamp-2 leading-relaxed">
                                        {{ $item->equipment_needed }}
                                    </p>
                                    @if($item->attachment_path)
                                        <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1 mt-1">
                                            <i class="ki-filled ki-paper-clip"></i> Lampiran Surat Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $item->status_badge_class }}">
                                        {{ $item->status_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-gray-500 whitespace-nowrap">
                                    <div>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('website.assistance.show', $item->id) }}" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Lihat Detail Permohonan">
                                            <i class="ki-filled ki-eye text-sm"></i>
                                        </a>
                                        <form action="{{ route('website.assistance.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus Data">
                                                <i class="ki-filled ki-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-gray-400">
                                    <i class="ki-filled ki-information text-3xl mb-2 text-gray-300"></i>
                                    <p>Belum ada permohonan bantuan fasilitas kesehatan yang masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($requests->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
