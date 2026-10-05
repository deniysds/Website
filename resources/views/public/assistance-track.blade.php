@extends('website::layouts.public')

@section('title', __('Lacak Status Permohonan Bantuan Faskes') . ' - Yayasan Satriabudi Dharma Setia')

@section('public_content')
<div class="space-y-10 py-6 max-w-5xl mx-auto px-4 sm:px-6">

    <!-- Header Section -->
    <div class="text-center space-y-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wider">
            <i class="ki-filled ki-magnifier text-xs"></i> {{ __('Pelacakan Mandiri') }}
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
            {{ __('Lacak Status Permohonan Bantuan') }}
        </h1>
        <p class="text-slate-600 text-sm max-w-2xl mx-auto leading-relaxed">
            {{ __('Pantau progres verifikasi, telaah kelayakan medis, hingga alokasi penyaluran alat kesehatan untuk fasilitas kesehatan Anda secara transparan.') }}
        </p>
    </div>

    <!-- Search / Track Form Box -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs max-w-2xl mx-auto">
        <form action="{{ route('website.assistance.track') }}" method="GET" class="space-y-4">
            <div>
                <label for="ticket" class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1.5">
                    {{ __('Nomor Registrasi / Kode Tiket Permohonan') }} <span class="text-red-600">*</span>
                </label>
                <div class="relative">
                    <input type="text"
                           id="ticket"
                           name="ticket"
                           required
                           value="{{ old('ticket', $ticket) }}"
                           placeholder="Contoh: REQ-2610-A9B2C"
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none uppercase font-mono font-bold tracking-wider text-slate-900 text-sm transition" />
                    <span class="absolute right-3.5 top-3.5 text-slate-400">
                        <i class="ki-filled ki-barcode text-lg"></i>
                    </span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">
                    {{ __('Masukkan kode registrasi yang didapatkan saat selesai mengisi formulir atau pada email konfirmasi.') }}
                </p>
            </div>

            <div>
                <label for="contact" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    {{ __('Email PIC atau No. WhatsApp (Opsional Verifikasi)') }}
                </label>
                <input type="text"
                       id="contact"
                       name="contact"
                       value="{{ old('contact', $contact) }}"
                       placeholder="Contoh: dokter@rsud.go.id atau 08123456789"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none text-slate-900 text-xs transition" />
            </div>

            <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                <button type="submit" class="w-full sm:w-auto grow px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                    <i class="ki-filled ki-magnifier"></i>
                    {{ __('Cek Status Permohonan') }}
                </button>
                <a href="{{ route('website.assistance.public') }}" class="w-full sm:w-auto px-4 py-3 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs text-center transition">
                    {{ __('Formulir Baru') }} &rarr;
                </a>
            </div>
        </form>
    </div>

    @if($searched)
        @if($assistanceRequest)
            <!-- Hasil Pencarian: Detail & Timeline Permohonan -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden space-y-6">

                <!-- Header Permohonan -->
                <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 rounded-lg bg-red-600 text-white font-mono font-black text-xs tracking-wider">
                                {{ $assistanceRequest->ticket_code }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold border {{ $assistanceRequest->status_badge_class }}">
                                {{ $assistanceRequest->status_label }}
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-white">
                            {{ $assistanceRequest->institution_name }}
                        </h2>
                        <p class="text-xs text-slate-300">
                            {{ $assistanceRequest->institution_type }} &bull; {{ $assistanceRequest->city ?: '-' }}, {{ $assistanceRequest->province ?: '-' }}
                        </p>
                    </div>

                    <div class="text-left md:text-right text-xs text-slate-400 space-y-1">
                        <div>{{ __('Tanggal Pengajuan:') }}</div>
                        <div class="font-bold text-white">{{ $assistanceRequest->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                <!-- Stepper Progress Tracker -->
                <div class="px-6 sm:px-8 py-4">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-6 text-center sm:text-left">
                        {{ __('Tahapan & Progres Verifikasi YSDS') }}
                    </h3>

                    @if($assistanceRequest->status === 'rejected')
                        <!-- Banner Ditolak -->
                        <div class="p-5 rounded-2xl bg-red-50 border border-red-200 text-red-900 space-y-2">
                            <div class="flex items-center gap-2 font-bold text-sm text-red-700">
                                <i class="ki-filled ki-cross-circle text-lg"></i>
                                <span>{{ __('Permohonan Bantuan Belum Dapat Disetujui') }}</span>
                            </div>
                            <p class="text-xs text-red-800 leading-relaxed">
                                {{ $assistanceRequest->admin_notes ?: __('Berdasarkan telaah tim verifikasi medik, permohonan belum memenuhi kriteria ketersediaan kuota alkes atau prioritas penanganan saat ini.') }}
                            </p>
                        </div>
                    @else
                        <!-- 4-Step Progress Flow -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
                            <!-- Step 1: Diajukan -->
                            <div class="p-4 rounded-xl border {{ $assistanceRequest->created_at ? 'bg-emerald-50/60 border-emerald-300' : 'bg-slate-50 border-slate-200' }} space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                                    <span class="text-xs font-bold text-emerald-900">{{ __('Terkirim') }}</span>
                                </div>
                                <p class="text-[11px] text-slate-600 leading-tight">
                                    {{ __('Formulir berhasil terdaftar di sistem YSDS.') }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-medium block">
                                    {{ $assistanceRequest->created_at->format('d/m/Y') }}
                                </span>
                            </div>

                            <!-- Step 2: Telaah & Review -->
                            @php
                                $isReviewed = in_array($assistanceRequest->status, ['reviewed', 'approved', 'distributed']);
                            @endphp
                            <div class="p-4 rounded-xl border {{ $isReviewed ? 'bg-emerald-50/60 border-emerald-300' : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full {{ $isReviewed ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center text-xs font-bold">2</span>
                                    <span class="text-xs font-bold {{ $isReviewed ? 'text-emerald-900' : 'text-slate-600' }}">{{ __('Telaah Medis') }}</span>
                                </div>
                                <p class="text-[11px] {{ $isReviewed ? 'text-slate-600' : 'text-slate-400' }} leading-tight">
                                    {{ __('Verifikasi dokumen dan kesiapan faskes.') }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-medium block">
                                    {{ $assistanceRequest->reviewed_at ? $assistanceRequest->reviewed_at->format('d/m/Y') : ($assistanceRequest->status === 'reviewed' ? 'Sedang berlangsung' : '-') }}
                                </span>
                            </div>

                            <!-- Step 3: Disetujui -->
                            @php
                                $isApproved = in_array($assistanceRequest->status, ['approved', 'distributed']);
                            @endphp
                            <div class="p-4 rounded-xl border {{ $isApproved ? 'bg-emerald-50/60 border-emerald-300' : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full {{ $isApproved ? 'bg-emerald-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center text-xs font-bold">3</span>
                                    <span class="text-xs font-bold {{ $isApproved ? 'text-emerald-900' : 'text-slate-600' }}">{{ __('Persetujuan') }}</span>
                                </div>
                                <p class="text-[11px] {{ $isApproved ? 'text-slate-600' : 'text-slate-400' }} leading-tight">
                                    {{ __('Alokasi peralatan disetujui pengurus.') }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-medium block">
                                    {{ $assistanceRequest->approved_at ? $assistanceRequest->approved_at->format('d/m/Y') : '-' }}
                                </span>
                            </div>

                            <!-- Step 4: Disalurkan -->
                            @php
                                $isDistributed = $assistanceRequest->status === 'distributed';
                            @endphp
                            <div class="p-4 rounded-xl border {{ $isDistributed ? 'bg-purple-50/60 border-purple-300' : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full {{ $isDistributed ? 'bg-purple-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center text-xs font-bold">4</span>
                                    <span class="text-xs font-bold {{ $isDistributed ? 'text-purple-900' : 'text-slate-600' }}">{{ __('Penyaluran') }}</span>
                                </div>
                                <p class="text-[11px] {{ $isDistributed ? 'text-slate-600' : 'text-slate-400' }} leading-tight">
                                    {{ __('Penyerahan alkes & BAST resmi.') }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-medium block">
                                    {{ $assistanceRequest->distributed_at ? $assistanceRequest->distributed_at->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Rincian Data Permohonan -->
                <div class="px-6 sm:px-8 pb-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                        <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                            <h4 class="font-bold text-slate-900 uppercase tracking-wider text-[11px]">{{ __('Informasi Penanggung Jawab (PIC)') }}</h4>
                            <div class="space-y-1.5 text-slate-700">
                                <div><span class="text-slate-400">{{ __('Nama PIC:') }}</span> <span class="font-bold text-slate-900">{{ $assistanceRequest->pic_name }}</span></div>
                                <div><span class="text-slate-400">{{ __('Jabatan:') }}</span> {{ $assistanceRequest->pic_position ?: '-' }}</div>
                                <div><span class="text-slate-400">{{ __('No. HP / WA:') }}</span> {{ Str::mask($assistanceRequest->pic_phone, '*', 4, -3) }}</div>
                                <div><span class="text-slate-400">{{ __('Email:') }}</span> {{ Str::mask($assistanceRequest->pic_email, '*', 3, Str::length(Str::before($assistanceRequest->pic_email, '@')) - 4) }}</div>
                            </div>
                        </div>

                        <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                            <h4 class="font-bold text-slate-900 uppercase tracking-wider text-[11px]">{{ __('Detail Bantuan yang Dimohonkan') }}</h4>
                            <div class="space-y-1.5 text-slate-700">
                                <div><span class="text-slate-400">{{ __('Kategori:') }}</span> <span class="font-bold text-slate-900">{{ $assistanceRequest->assistance_type }}</span></div>
                                <div><span class="text-slate-400">{{ __('Wilayah:') }}</span> {{ $assistanceRequest->city ?: '-' }}, {{ $assistanceRequest->province ?: '-' }}</div>
                                <div><span class="text-slate-400">{{ __('Proposal:') }}</span> {{ $assistanceRequest->attachment_path ? 'Dokumen Terlampir' : 'Tidak ada lampiran' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kotak Rincian Alat -->
                    <div class="p-5 rounded-xl bg-red-50/50 border border-red-100 space-y-2 text-xs">
                        <h4 class="font-bold text-red-900 uppercase tracking-wider text-[11px]">{{ __('Rincian Peralatan / Reagen Medis yang Dibutuhkan:') }}</h4>
                        <p class="text-slate-800 leading-relaxed font-medium">
                            {{ $assistanceRequest->equipment_needed }}
                        </p>
                    </div>

                    @if($assistanceRequest->admin_notes && $assistanceRequest->status !== 'rejected')
                        <!-- Catatan Tindak Lanjut dari YSDS -->
                        <div class="p-5 rounded-xl bg-blue-50/60 border border-blue-200 space-y-2 text-xs">
                            <div class="flex items-center gap-1.5 font-bold text-blue-900">
                                <i class="ki-filled ki-information text-sm"></i>
                                <span>{{ __('Catatan Tim Verifikasi YSDS:') }}</span>
                            </div>
                            <p class="text-blue-950 leading-relaxed">
                                {{ $assistanceRequest->admin_notes }}
                            </p>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                        <p>
                            {{ __('Pertanyaan terkait permohonan ini? Hubungi kami di') }}
                            <a href="mailto:admin@dharma.or.id" class="text-red-600 font-bold hover:underline">admin@dharma.or.id</a>
                        </p>
                        <a href="{{ route('website.assistance.track') }}" class="font-bold text-slate-700 hover:text-red-600 transition">
                            &larr; {{ __('Lacak Nomor Tiket Lain') }}
                        </a>
                    </div>
                </div>

            </div>
        @else
            <!-- Tidak Ditemukan -->
            <div class="p-8 rounded-2xl bg-amber-50 border border-amber-200 text-center max-w-2xl mx-auto space-y-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto text-xl font-bold">
                    <i class="ki-filled ki-information"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-amber-900">{{ __('Nomor Tiket Tidak Ditemukan') }}</h3>
                    <p class="text-xs text-amber-800 max-w-md mx-auto leading-relaxed">
                        {{ __('Nomor registrasi') }} <strong class="font-mono">{{ $ticket }}</strong> {{ __('tidak ditemukan dalam basis data kami. Periksa kembali penulisan kode tiket (contoh: REQ-2610-XXXXX) atau hubungi administrator YSDS.') }}
                    </p>
                </div>
                <a href="{{ route('website.assistance.track') }}" class="inline-block px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition">
                    {{ __('Coba Lagi') }}
                </a>
            </div>
        @endif
    @endif

</div>
@endsection
