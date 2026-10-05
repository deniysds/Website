@extends('website::layouts.public')

@section('public_content')
    <!-- Header Banner Permohonan Bantuan -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-red-950/40 via-slate-900/90 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-heart text-sm"></i> {{ __('Program Bantuan Medis & Faskes') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Permohonan Bantuan Fasilitas Kesehatan & Alkes') }}
            </h1>
            <p class="text-slate-300 text-sm mt-3 leading-relaxed">
                {{ __('Yayasan Satriabudi Dharma Setia (YSDS) membuka permohonan dukungan peralatan diagnostik, instrumen laboratorium molekuler/PCR, dan fasilitas medis bagi Rumah Sakit, Puskesmas, Klinik, serta Laboratorium di seluruh Indonesia.') }}
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-6xl mx-auto pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Panduan & Informasi Layanan Bantuan (4 Kolom) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Panduan Alur -->
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-xs space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold shrink-0">
                            <i class="ki-filled ki-shield-tick text-xl"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base">{{ __('Alur Penyaluran Bantuan') }}</h3>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600">
                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-red-600 text-white font-black flex items-center justify-center text-[11px] shrink-0">1</span>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ __('Pengajuan Permohonan') }}</h4>
                                <p class="text-slate-500 mt-0.5">{{ __('Faskes mengisi formulir online dan melampirkan surat permohonan resmi instansi.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-slate-800 text-white font-black flex items-center justify-center text-[11px] shrink-0">2</span>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ __('Verifikasi Saintifik & Kebutuhan') }}</h4>
                                <p class="text-slate-500 mt-0.5">{{ __('Tim medis dan operasional YSDS menelaah kelayakan fasilitas dan urgensi kebutuhan.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-slate-800 text-white font-black flex items-center justify-center text-[11px] shrink-0">3</span>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ __('Penyaluran & Penandatanganan BAST') }}</h4>
                                <p class="text-slate-500 mt-0.5">{{ __('Pengiriman peralatan atau bahan lab disertai Berita Acara Serah Terima (BAST) resmi.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Kategori Bantuan Tersedia -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-3">
                    <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider">{{ __('Fokus Dukungan YSDS') }}</h4>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-center gap-2">
                            <i class="ki-filled ki-check text-emerald-600"></i>
                            <span>Mesin Real-Time PCR & Bio-safety Cabinet</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ki-filled ki-check text-emerald-600"></i>
                            <span>Ultra-Low Temperature Freezer (-86°C)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ki-filled ki-check text-emerald-600"></i>
                            <span>Sentrifus, Mikropipet & Kit Diagnostik</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="ki-filled ki-check text-emerald-600"></i>
                            <span>Reagen Ekstraksi & Bahan Habis Pakai</span>
                        </li>
                    </ul>
                </div>

                <!-- Card Kontak Layanan Faskes -->
                <div class="bg-slate-900 text-white rounded-2xl p-6 border border-slate-800 shadow-sm space-y-3">
                    <h4 class="font-bold text-xs uppercase tracking-wider text-red-400">{{ __('Pusat Bantuan & Konfirmasi') }}</h4>
                    <p class="text-[11px] text-slate-300 leading-relaxed">
                        {{ __('Jika instansi Anda membutuhkan konsultasi kebutuhan sebelum mengajukan proposal resmi, silakan hubungi tim sekretariat yayasan:') }}
                    </p>
                    <div class="pt-2 space-y-2 text-xs">
                        <p class="flex items-center gap-2 text-slate-200">
                            <i class="ki-filled ki-sms text-red-400"></i>
                            <a href="mailto:admin@dharma.or.id" class="hover:underline">admin@dharma.or.id</a>
                        </p>
                        <p class="flex items-center gap-2 text-slate-200">
                            <i class="ki-filled ki-phone text-red-400"></i>
                            <span>(021) 5020-8805</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Pendaftaran Permohonan Bantuan (8 Kolom) -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl p-8 sm:p-10 border border-slate-200 shadow-xs space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Formulir Resmi') }}</span>
                            <h2 class="text-2xl font-black text-slate-900 mt-1">{{ __('Pengajuan Bantuan Instansi') }}</h2>
                            <p class="text-xs text-slate-500 mt-1">{{ __('Isi seluruh informasi di bawah ini secara lengkap. Kolom bertanda bintang (*) wajib diisi.') }}</p>
                        </div>
                        <a href="{{ route('website.assistance.track') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold shrink-0 transition">
                            <i class="ki-filled ki-magnifier text-red-600"></i> {{ __('Lacak Permohonan') }} &rarr;
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium space-y-3">
                            <div class="flex items-center gap-2 font-bold text-sm text-emerald-900">
                                <i class="ki-filled ki-check-circle text-emerald-600 text-lg"></i>
                                <span>{{ __('Permohonan Berhasil Dikirim!') }}</span>
                            </div>
                            <p>{{ session('success') }}</p>

                            @if(session('ticket_code'))
                                <div class="p-4 rounded-xl bg-white border border-emerald-300 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-emerald-700 tracking-wider block">{{ __('Nomor Registrasi / Kode Tiket Anda:') }}</span>
                                        <span class="text-lg font-mono font-black text-slate-900 tracking-wider">{{ session('ticket_code') }}</span>
                                    </div>
                                    <a href="{{ route('website.assistance.track', ['ticket' => session('ticket_code')]) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition text-center shadow-xs">
                                        {{ __('Lacak Status Sekarang') }} &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                            <div class="font-bold flex items-center gap-1.5 text-red-800">
                                <i class="ki-filled ki-information text-base"></i>
                                <span>{{ __('Periksa kembali isian formulir:') }}</span>
                            </div>
                            <ul class="list-disc pl-5 space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('website.assistance.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
                        @csrf
                        {{-- Honeypot bot protection field --}}
                        <div class="hidden" style="display:none !important;" aria-hidden="true">
                            <input type="text" name="website_hp" value="" tabindex="-1" autocomplete="off" />
                        </div>

                        <!-- 1. Identitas Instansi / Faskes -->
                        <div class="space-y-4">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider text-red-600">{{ __('1. Data Instansi & Fasilitas Kesehatan') }}</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Nama Instansi / Rumah Sakit / Lab') }} <span class="text-red-600">*</span></label>
                                    <input type="text" name="institution_name" required value="{{ old('institution_name') }}" placeholder="Contoh: RSUD Dr. Soedono / Labkesda Prov..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>

                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Jenis Instansi') }} <span class="text-red-600">*</span></label>
                                    <select name="institution_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition bg-white">
                                        <option value="Rumah Sakit Umum Daerah (RSUD)" {{ old('institution_type') == 'Rumah Sakit Umum Daerah (RSUD)' ? 'selected' : '' }}>Rumah Sakit Umum Daerah (RSUD)</option>
                                        <option value="Rumah Sakit Vertikal / Rujukan Nasional" {{ old('institution_type') == 'Rumah Sakit Vertikal / Rujukan Nasional' ? 'selected' : '' }}>Rumah Sakit Vertikal / Rujukan Nasional</option>
                                        <option value="Rumah Sakit Swasta / Yayasan" {{ old('institution_type') == 'Rumah Sakit Swasta / Yayasan' ? 'selected' : '' }}>Rumah Sakit Swasta / Yayasan</option>
                                        <option value="Laboratorium Kesehatan Daerah (Labkesda)" {{ old('institution_type') == 'Laboratorium Kesehatan Daerah (Labkesda)' ? 'selected' : '' }}>Laboratorium Kesehatan Daerah (Labkesda)</option>
                                        <option value="Laboratorium Fakultas / Universitas" {{ old('institution_type') == 'Laboratorium Fakultas / Universitas' ? 'selected' : '' }}>Laboratorium Fakultas / Universitas</option>
                                        <option value="Puskesmas / Klinik" {{ old('institution_type') == 'Puskesmas / Klinik' ? 'selected' : '' }}>Puskesmas / Klinik</option>
                                        <option value="Dinas Kesehatan" {{ old('institution_type') == 'Dinas Kesehatan' ? 'selected' : '' }}>Dinas Kesehatan</option>
                                        <option value="Lainnya" {{ old('institution_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Provinsi') }}</label>
                                    <input type="text" name="province" value="{{ old('province') }}" placeholder="Contoh: Nusa Tenggara Timur / Jawa Barat" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Kota / Kabupaten') }}</label>
                                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Contoh: Kab. Sabu Raijua / Kota Bandung" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">{{ __('Alamat Lengkap Faskes') }}</label>
                                <textarea name="address" rows="2" placeholder="Alamat jalan, nomor, kecamatan, kode pos..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <!-- 2. Data Penanggung Jawab (PIC) -->
                        <div class="space-y-4 pt-2">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider text-red-600">{{ __('2. Kontak Penanggung Jawab (PIC)') }}</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Nama Lengkap PIC') }} <span class="text-red-600">*</span></label>
                                    <input type="text" name="pic_name" required value="{{ old('pic_name') }}" placeholder="Nama penanggung jawab permohonan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Jabatan PIC') }}</label>
                                    <input type="text" name="pic_position" value="{{ old('pic_position') }}" placeholder="Contoh: Kepala Lab / Direktur / Yanmed" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('No. Telepon / WhatsApp Aktif') }} <span class="text-red-600">*</span></label>
                                    <input type="text" name="pic_phone" required value="{{ old('pic_phone') }}" placeholder="Contoh: 0812xxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">{{ __('Email Resmi PIC / Faskes') }} <span class="text-red-600">*</span></label>
                                    <input type="email" name="pic_email" required value="{{ old('pic_email') }}" placeholder="email@faskes.go.id / pic@gmail.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition" />
                                </div>
                            </div>
                        </div>

                        <!-- 3. Rincian Kebutuhan Bantuan -->
                        <div class="space-y-4 pt-2">
                            <div class="border-b border-slate-100 pb-2">
                                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider text-red-600">{{ __('3. Rincian Permohonan Bantuan') }}</h3>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">{{ __('Kategori Bantuan') }} <span class="text-red-600">*</span></label>
                                <select name="assistance_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition bg-white">
                                    <option value="Alat Kesehatan / Lab PCR Diagnostik" {{ old('assistance_type') == 'Alat Kesehatan / Lab PCR Diagnostik' ? 'selected' : '' }}>Alat Kesehatan / Lab PCR Diagnostik</option>
                                    <option value="Reagen & Bahan Medis Habis Pakai (BMHP)" {{ old('assistance_type') == 'Reagen & Bahan Medis Habis Pakai (BMHP)' ? 'selected' : '' }}>Reagen & Bahan Medis Habis Pakai (BMHP)</option>
                                    <option value="Freezer Penyimpanan Biobank / Sampel Medis" {{ old('assistance_type') == 'Freezer Penyimpanan Biobank / Sampel Medis' ? 'selected' : '' }}>Freezer Penyimpanan Biobank / Sampel Medis</option>
                                    <option value="Alat Perlindungan Diri (APD) & Sterilisasi" {{ old('assistance_type') == 'Alat Perlindungan Diri (APD) & Sterilisasi' ? 'selected' : '' }}>Alat Perlindungan Diri (APD) & Sterilisasi</option>
                                    <option value="Pelatihan SDM & Supervisi Laboratorium" {{ old('assistance_type') == 'Pelatihan SDM & Supervisi Laboratorium' ? 'selected' : '' }}>Pelatihan SDM & Supervisi Laboratorium</option>
                                    <option value="Dukungan Riset Genomik / Penyakit Tropis" {{ old('assistance_type') == 'Dukungan Riset Genomik / Penyakit Tropis' ? 'selected' : '' }}>Dukungan Riset Genomik / Penyakit Tropis</option>
                                    <option value="Lain-lain" {{ old('assistance_type') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">{{ __('Rincian Peralatan / Kebutuhan yang Diajukan') }} <span class="text-red-600">*</span></label>
                                <textarea name="equipment_needed" rows="3" required placeholder="Sebutkan jenis alat, estimasi kuantitas (unit/set), atau spesifikasi yang sangat dibutuhkan..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition">{{ old('equipment_needed') }}</textarea>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">{{ __('Urgensi & Latar Belakang Kebutuhan') }}</label>
                                <textarea name="urgency_reason" rows="3" placeholder="Jelaskan kondisi faskes saat ini, cakupan pasien/masyarakat yang dilayani, atau urgensi ketiadaan alat..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition">{{ old('urgency_reason') }}</textarea>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">{{ __('Unggah Surat Permohonan Resmi / Dokumen Pendukung (Opsional)') }}</label>
                                <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none transition text-xs file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" />
                                <p class="text-[11px] text-slate-400 mt-1">{{ __('Format file yang didukung: PDF, DOC, DOCX, JPG, PNG. Ukuran maksimal 10 MB.') }}</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <p class="text-[11px] text-slate-500">
                                {{ __('Dengan mengirimkan formulir ini, PIC menyatakan data yang diberikan adalah benar dan resmi atas nama instansi terkait.') }}
                            </p>
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2 shrink-0 cursor-pointer">
                                <i class="ki-filled ki-send text-white"></i>
                                <span>{{ __('Kirim Permohonan Bantuan') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
