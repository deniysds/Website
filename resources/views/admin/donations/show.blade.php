@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.donations.index') }}" class="hover:text-red-600">Manajemen Donasi</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">{{ $donation->donation_code }}</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('website.donations.index') }}" class="kt-btn kt-btn-outline text-xs px-3 py-2">
                    <i class="ki-filled ki-arrow-left mr-1"></i> Kembali
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $donation->donation_code }}</h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $donation->status_badge_class }}">
                            {{ $donation->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Konfirmasi donasi diterima pada {{ $donation->created_at ? $donation->created_at->format('d M Y, H:i') : '-' }} WIB</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('website.donations.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data donasi ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="kt-btn kt-btn-outline text-red-600 hover:bg-red-50 text-xs">
                        <i class="ki-filled ki-trash mr-1"></i> Hapus Donasi
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Kolom Kiri: Rincian Donasi & Bukti Transfer (7 Kolom) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- Info Donatur -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-user text-red-600"></i> Informasi Donatur
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 block mb-0.5">Nama Lengkap / Instansi:</span>
                            <span class="font-bold text-gray-900 text-sm">{{ $donation->donor_name }}</span>
                            @if($donation->is_anonymous)
                                <span class="inline-block mt-1 text-[10px] bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-medium">
                                    Anonim di Tampilan Publik
                                </span>
                            @endif
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Tipe Donatur:</span>
                            <span class="font-semibold text-gray-800">
                                {{ $donation->donor_type === 'institution' ? 'Instansi / Korporasi' : 'Individu / Perorangan' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Email:</span>
                            <a href="mailto:{{ $donation->email }}" class="font-semibold text-blue-600 hover:underline">
                                {{ $donation->email }}
                            </a>
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Nomor Telepon / WA:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $donation->phone) }}" target="_blank" class="font-semibold text-emerald-600 hover:underline flex items-center gap-1">
                                <i class="ki-filled ki-whatsapp"></i> {{ $donation->phone }}
                            </a>
                        </div>
                    </div>

                    @if($donation->message)
                        <div class="mt-4 pt-4 border-t border-gray-100 text-xs">
                            <span class="text-gray-400 block mb-1">Pesan / Harapan / Doa Donatur:</span>
                            <div class="p-3 bg-gray-50 rounded-xl text-gray-700 italic border border-gray-100">
                                "{{ $donation->message }}"
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Info Pembayaran -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-credit-cart text-red-600"></i> Rincian Dana & Penyaluran
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 block mb-0.5">Program Sasaran:</span>
                            <span class="font-bold text-red-600">{{ $donation->program_target_label }}</span>
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Nominal Transfer:</span>
                            <span class="font-black text-gray-900 text-base text-emerald-600">{{ $donation->formatted_amount }}</span>
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Tanggal Transfer:</span>
                            <span class="font-semibold text-gray-800">{{ $donation->transfer_date ? $donation->transfer_date->format('d F Y') : '-' }}</span>
                        </div>

                        <div>
                            <span class="text-gray-400 block mb-0.5">Rekening Bank YSDS:</span>
                            <span class="font-semibold text-gray-800">{{ $donation->bank_name ?? 'BCA' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Bukti Transfer -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-picture text-red-600"></i> Bukti Transfer / Resi
                    </h3>

                    @if($donation->proof_path)
                        @php
                            $isPdf = str_ends_with(strtolower($donation->proof_path), '.pdf');
                        @endphp

                        @if($isPdf)
                            <div class="p-6 bg-slate-50 border border-slate-200 rounded-xl text-center space-y-3">
                                <i class="ki-filled ki-document text-4xl text-red-600"></i>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Dokumen Bukti Transfer (PDF)</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ basename($donation->proof_path) }}</p>
                                </div>
                                <div>
                                    <a href="{{ asset('storage/' . $donation->proof_path) }}" target="_blank" class="kt-btn kt-btn-primary text-xs px-4 py-2 inline-flex items-center gap-1.5">
                                        <i class="ki-filled ki-eye"></i> Buka File PDF
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="space-y-3">
                                <div class="max-w-md mx-auto rounded-xl overflow-hidden border border-gray-200 shadow-xs bg-black/5 p-2">
                                    <a href="{{ asset('storage/' . $donation->proof_path) }}" target="_blank" title="Klik untuk memperbesar">
                                        <img src="{{ asset('storage/' . $donation->proof_path) }}" alt="Bukti Transfer {{ $donation->donation_code }}" class="w-full h-auto rounded-lg object-contain max-h-96">
                                    </a>
                                </div>
                                <div class="text-center">
                                    <a href="{{ asset('storage/' . $donation->proof_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1">
                                        <i class="ki-filled ki-arrow-up-right"></i> Buka Gambar Ukuran Asli
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-8 text-center text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200 text-xs">
                            <i class="ki-filled ki-picture text-3xl mb-1 block"></i>
                            <span>Donatur tidak melampirkan berkas bukti transfer saat mengisi formulir.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan: Verifikasi Status & Aksi Admin (5 Kolom) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Panel Verifikasi -->
                <div class="kt-card p-6 space-y-5">
                    <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-shield-tick text-red-600"></i> Verifikasi Mutasi Bank
                    </h3>

                    <form action="{{ route('website.donations.status', $donation->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status Donasi</label>
                            <select name="status" class="kt-select w-full text-xs" required>
                                <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                                <option value="verified" {{ $donation->status === 'verified' ? 'selected' : '' }}>Terverifikasi & Diterima (Verified)</option>
                                <option value="rejected" {{ $donation->status === 'rejected' ? 'selected' : '' }}>Ditolak / Mutasi Tidak Ditemukan (Rejected)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Catatan Internal Admin / Rekonsiliasi</label>
                            <textarea name="admin_notes" rows="4" placeholder="Misal: Mutasi telah dicocokkan dengan rekening koran BCA tanggal 06/10/2026. Ref mutasi #128912." class="kt-textarea w-full text-xs">{{ old('admin_notes', $donation->admin_notes) }}</textarea>
                            <span class="text-[11px] text-gray-400 mt-1 block">Catatan ini hanya terlihat oleh pengurus yayasan.</span>
                        </div>

                        @if($donation->verified_at)
                            <div class="p-3 bg-emerald-50 text-emerald-800 rounded-xl text-xs flex items-center gap-2 border border-emerald-200">
                                <i class="ki-filled ki-check-circle text-base"></i>
                                <span>Diverifikasi pada: {{ $donation->verified_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                        @endif

                        <button type="submit" class="kt-btn kt-btn-primary w-full text-xs font-bold py-2.5">
                            <i class="ki-filled ki-check text-white mr-1"></i> Simpan Status Verifikasi
                        </button>
                    </form>
                </div>

                <!-- Kontak Cepat Donatur -->
                <div class="kt-card p-6 space-y-3">
                    <h4 class="font-bold text-gray-900 text-xs uppercase tracking-wider">Komunikasi Donatur</h4>
                    <p class="text-xs text-gray-500">Kirim pesan apresiasi atau permintaan konfirmasi lanjutan kepada donatur:</p>

                    <div class="space-y-2 pt-1">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $donation->phone) }}?text=Halo%20{{ urlencode($donation->donor_name) }},%20kami%20dari%20Yayasan%20Satriabudi%20Dharma%20Setia%20(YSDS)%20mengonfirmasi%20penerimaan%20donasi%20Anda%20dengan%20kode%20{{ $donation->donation_code }}." 
                           target="_blank" 
                           class="kt-btn kt-btn-outline w-full text-xs text-emerald-700 hover:bg-emerald-50 flex items-center justify-center gap-2">
                            <i class="ki-filled ki-whatsapp text-emerald-600"></i> Hubungi via WhatsApp
                        </a>

                        <a href="mailto:{{ $donation->email }}?subject=Konfirmasi%20Donasi%20YSDS%20-%20{{ $donation->donation_code }}" 
                           class="kt-btn kt-btn-outline w-full text-xs text-blue-700 hover:bg-blue-50 flex items-center justify-center gap-2">
                            <i class="ki-filled ki-sms text-blue-600"></i> Kirim Email Konfirmasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
