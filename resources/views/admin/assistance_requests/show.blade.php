@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.assistance.index') }}" class="hover:text-red-600">Permohonan Bantuan Faskes</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">{{ $assistanceRequest->institution_name }}</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('website.assistance.index') }}" class="p-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 transition" title="Kembali ke Daftar">
                    <i class="ki-filled ki-arrow-left text-base"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $assistanceRequest->institution_name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-lg bg-gray-900 text-white font-mono text-xs font-bold tracking-wider">
                            {{ $assistanceRequest->ticket_code }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $assistanceRequest->status_badge_class }}">
                            {{ $assistanceRequest->status_label }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">Diajukan pada {{ $assistanceRequest->created_at ? $assistanceRequest->created_at->format('d F Y, H:i') : '-' }} WIB</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('website.assistance.print', $assistanceRequest->id) }}" target="_blank" class="kt-btn kt-btn-outline text-gray-700 hover:bg-gray-100 text-xs px-3.5 py-2">
                    <i class="ki-filled ki-printer mr-1"></i> Cetak Disposisi
                </a>

                <form action="{{ route('website.assistance.convert_collaboration', $assistanceRequest->id) }}" method="POST" onsubmit="return confirm('Konversi permohonan ini ke data Penyerahan Alat & BAST resmi? Data instansi dan PIC akan otomatis disalin ke modul Kolaborasi.');">
                    @csrf
                    <button type="submit" class="kt-btn bg-red-600 hover:bg-red-700 text-white text-xs px-3.5 py-2">
                        <i class="ki-filled ki-plus-circle mr-1"></i> Konversi ke BAST
                    </button>
                </form>

                <form action="{{ route('website.assistance.destroy', $assistanceRequest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="kt-btn kt-btn-outline text-red-600 border-red-200 hover:bg-red-50 text-xs px-3.5 py-2">
                        <i class="ki-filled ki-trash mr-1"></i> Hapus
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Kolom Kiri: Rincian Permohonan (2 Kolom) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card Rincian Kebutuhan Bantuan -->
                <div class="kt-card p-6 space-y-5">
                    <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                            <i class="ki-filled ki-heart text-red-600 text-lg"></i>
                            <span>Rincian Bantuan yang Diajukan</span>
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase bg-red-50 text-red-700 border border-red-200">
                            {{ $assistanceRequest->assistance_type }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Peralatan / Kebutuhan yang Diajukan:</span>
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 text-xs leading-relaxed whitespace-pre-line mt-1 font-mono">
                                {{ $assistanceRequest->equipment_needed }}
                            </div>
                        </div>

                        @if($assistanceRequest->urgency_reason)
                            <div>
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Latar Belakang & Urgensi Kebutuhan:</span>
                                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 text-xs leading-relaxed whitespace-pre-line mt-1">
                                    {{ $assistanceRequest->urgency_reason }}
                                </div>
                            </div>
                        @endif

                        @if($assistanceRequest->attachment_path)
                            <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-200 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">
                                        <i class="ki-filled ki-document text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs text-gray-900">Surat Permohonan Resmi / Dokumen Pendukung</h4>
                                        <p class="text-[11px] text-gray-500">Berkas proposal atau surat resmi yang diunggah oleh faskes</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $assistanceRequest->attachment_path) }}" target="_blank" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                                    <i class="ki-filled ki-file-down"></i> Unduh Berkas
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Profil Instansi & Alamat -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-geolocation text-blue-600 text-lg"></i>
                        <span>Profil Instansi & Lokasi Faskes</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Nama Instansi:</span>
                            <span class="font-bold text-gray-900 text-sm mt-0.5 block">{{ $assistanceRequest->institution_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Kategori Instansi:</span>
                            <span class="font-bold text-gray-800 mt-0.5 block">{{ $assistanceRequest->institution_type }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Kota / Kabupaten:</span>
                            <span class="font-semibold text-gray-800 mt-0.5 block">{{ $assistanceRequest->city ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Provinsi:</span>
                            <span class="font-semibold text-gray-800 mt-0.5 block">{{ $assistanceRequest->province ?: '-' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Alamat Lengkap:</span>
                            <span class="text-gray-700 mt-0.5 block leading-relaxed">{{ $assistanceRequest->address ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status, Tindak Lanjut & PIC (1 Kolom) -->
            <div class="space-y-6">
                <!-- Card Update Status & Verifikasi -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">
                        Tindak Lanjut & Verifikasi
                    </h3>

                    <form action="{{ route('website.assistance.status', $assistanceRequest->id) }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Status Permohonan</label>
                            <select name="status" class="kt-select w-full text-xs font-semibold">
                                <option value="pending" {{ $assistanceRequest->status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="reviewed" {{ $assistanceRequest->status === 'reviewed' ? 'selected' : '' }}>Sedang Ditinjau (Reviewed)</option>
                                <option value="approved" {{ $assistanceRequest->status === 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                                <option value="distributed" {{ $assistanceRequest->status === 'distributed' ? 'selected' : '' }}>Bantuan Disalurkan (Distributed)</option>
                                <option value="rejected" {{ $assistanceRequest->status === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Catatan Tim Verifikasi / Tindak Lanjut</label>
                            <textarea name="admin_notes" rows="4" placeholder="Catatan internal tim verifikasi YSDS terkait telaah kebutuhan, rencana penyerahan alkes, atau BAST..." class="kt-input w-full text-xs p-3 leading-relaxed">{{ old('admin_notes', $assistanceRequest->admin_notes) }}</textarea>
                        </div>

                        <button type="submit" class="kt-btn kt-btn-primary w-full text-white text-xs font-bold py-2.5 shadow-sm">
                            <i class="ki-filled ki-check mr-1"></i> Perbarui Status & Catatan
                        </button>
                    </form>

                    <!-- Timeline Status Audit -->
                    <div class="pt-3 border-t border-gray-100 space-y-2 text-[11px] text-gray-500">
                        @if($assistanceRequest->reviewed_at)
                            <div class="flex items-center justify-between">
                                <span>Ditinjau Pertama:</span>
                                <span class="font-semibold text-gray-700">{{ $assistanceRequest->reviewed_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($assistanceRequest->approved_at)
                            <div class="flex items-center justify-between">
                                <span>Disetujui:</span>
                                <span class="font-semibold text-emerald-700">{{ $assistanceRequest->approved_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($assistanceRequest->distributed_at)
                            <div class="flex items-center justify-between">
                                <span>Disalurkan:</span>
                                <span class="font-semibold text-purple-700">{{ $assistanceRequest->distributed_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card PIC Kontak -->
                <div class="kt-card p-6 space-y-4">
                    <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3 flex items-center gap-2">
                        <i class="ki-filled ki-profile-user text-red-600 text-lg"></i>
                        <span>Penanggung Jawab (PIC)</span>
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-gray-400 font-bold uppercase tracking-wider block text-[10px]">Nama PIC:</span>
                            <span class="font-bold text-gray-900 text-sm mt-0.5 block">{{ $assistanceRequest->pic_name }}</span>
                            @if($assistanceRequest->pic_position)
                                <span class="text-[11px] text-gray-500">{{ $assistanceRequest->pic_position }}</span>
                            @endif
                        </div>

                        <div class="pt-2 border-t border-gray-100 space-y-2">
                            <div class="flex items-center gap-2">
                                <i class="ki-filled ki-phone text-red-600 text-sm"></i>
                                <a href="tel:{{ $assistanceRequest->pic_phone }}" class="text-gray-800 font-semibold hover:text-red-600">{{ $assistanceRequest->pic_phone }}</a>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="ki-filled ki-sms text-red-600 text-sm"></i>
                                <a href="mailto:{{ $assistanceRequest->pic_email }}" class="text-gray-800 font-semibold hover:text-red-600 break-all">{{ $assistanceRequest->pic_email }}</a>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-gray-100">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $assistanceRequest->pic_phone) }}?text=Halo%20{{ urlencode($assistanceRequest->pic_name) }},%20kami%20dari%20Yayasan%20Satriabudi%20Dharma%20Setia%20(YSDS)%20menghubungi%20terkait%20permohonan%20bantuan%20fasilitas%20kesehatan%20{{ urlencode($assistanceRequest->institution_name) }}" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2">
                                <i class="ki-filled ki-whatsapp text-sm"></i>
                                <span>Hubungi PIC via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
