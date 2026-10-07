@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Manajemen Donasi & Penggalangan Dana</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Statistics -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Donasi & Penggalangan Dana</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola konfirmasi transfer donasi, verifikasi mutasi bank, dan penerbitan bukti penerimaan resmi YSDS.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.donations.export', request()->query()) }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-file-down text-white mr-1"></i> Ekspor CSV
                </a>
                <a href="{{ route('website.visitations.admin.index') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-routing mr-1"></i> Visitasi Lapangan
                </a>
                <a href="{{ route('website.assistance.index') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-shield-tick mr-1"></i> Permohonan Bantuan
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
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-wallet"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">Rp {{ number_format($totalVerifiedAmount, 0, ',', '.') }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Terverifikasi</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-time"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-amber-600">{{ $pendingCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Menunggu Verifikasi</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-blue-600">{{ $verifiedCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Donasi Disetujui</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-cross-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-red-600">{{ $rejectedCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ditolak / Invalid</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-6">
            <form action="{{ route('website.donations.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-5">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode donasi, nama donatur, email, atau telepon..." class="kt-input w-full text-xs">
                </div>
                <div class="md:col-span-3">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <select name="program_target" class="kt-select w-full text-xs">
                        <option value="">-- Semua Program --</option>
                        <option value="alkes_pcr_3t" {{ request('program_target') === 'alkes_pcr_3t' ? 'selected' : '' }}>Bantuan Alkes & PCR Faskes 3T</option>
                        <option value="beasiswa_smk_fensensius" {{ request('program_target') === 'beasiswa_smk_fensensius' ? 'selected' : '' }}>Beasiswa SMK Fensensius</option>
                        <option value="rumah_baca_halmahera" {{ request('program_target') === 'rumah_baca_halmahera' ? 'selected' : '' }}>Rumah Baca Halmahera</option>
                        <option value="umum" {{ request('program_target') === 'umum' ? 'selected' : '' }}>Dana Kemanusiaan YSDS</option>
                    </select>
                </div>
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit" class="kt-btn kt-btn-primary w-full text-xs px-3">
                        <i class="ki-filled ki-magnifier"></i>
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'program_target']))
                        <a href="{{ route('website.donations.index') }}" class="kt-btn kt-btn-outline text-xs px-3" title="Reset Filter">
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
                            <th class="py-4 px-6">Kode Donasi</th>
                            <th class="py-4 px-6">Donatur</th>
                            <th class="py-4 px-6">Program Tujuan</th>
                            <th class="py-4 px-6 text-right">Nominal (IDR)</th>
                            <th class="py-4 px-6">Bank / Tanggal</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Bukti</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @forelse($donations as $donation)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-red-600">
                                    <a href="{{ route('website.donations.show', $donation->id) }}" class="hover:underline">
                                        {{ $donation->donation_code }}
                                    </a>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                        {{ $donation->donor_name }}
                                        @if($donation->is_anonymous)
                                            <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded font-normal" title="Publik Anonim">Anonim</span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-0.5">{{ $donation->email }} &bull; {{ $donation->phone }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-medium bg-slate-100 text-slate-800">
                                        {{ $donation->program_target_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-extrabold text-gray-900">
                                    {{ $donation->formatted_amount }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-gray-800">{{ $donation->bank_name ?? 'Transfer Bank' }}</div>
                                    <div class="text-[11px] text-gray-500">{{ $donation->transfer_date ? $donation->transfer_date->format('d M Y') : '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $donation->status_badge_class }}">
                                        {{ $donation->status_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($donation->proof_path)
                                        <a href="{{ asset('storage/' . $donation->proof_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Lihat Bukti Transfer">
                                            <i class="ki-filled ki-picture text-base"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-300 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('website.donations.show', $donation->id) }}" class="kt-btn kt-btn-sm kt-btn-outline text-xs px-3 py-1.5" title="Verifikasi Donasi">
                                            <i class="ki-filled ki-eye mr-1"></i> Detail
                                        </a>
                                        <form action="{{ route('website.donations.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data donasi {{ $donation->donation_code }} ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-sm kt-btn-outline text-red-600 hover:bg-red-50 text-xs p-1.5" title="Hapus">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-400">
                                    <i class="ki-filled ki-information-2 text-3xl mb-2 block"></i>
                                    <span>Belum ada data konfirmasi donasi yang sesuai dengan kriteria filter.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($donations->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
