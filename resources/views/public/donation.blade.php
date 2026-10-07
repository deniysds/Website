@extends('website::layouts.public')

@section('public_content')
    <!-- Header Banner Donasi -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-red-950/40 via-slate-900/90 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-heart text-sm"></i> {{ __('Program Donasi & Kemanusiaan YSDS') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Mari Bergotong-Royong Wujudkan Pemerataan Kesehatan & Pendidikan') }}
            </h1>
            <p class="text-slate-300 text-sm mt-3 leading-relaxed">
                {{ __('Setiap kontribusi Anda disalurkan secara transparan dan akuntabel langsung kepada masyarakat di pelosok 3T Indonesia—mulai dari penyediaan mesin PCR laboratorium, beasiswa vokasi kesehatan, hingga sarana literasi.') }}
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Alert / Notifikasi Success -->
    @if(session('success'))
        <div class="max-w-6xl mx-auto mb-8 bg-emerald-50 border border-emerald-200 rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                <i class="ki-filled ki-check-circle text-2xl"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-extrabold text-emerald-900 text-base">{{ __('Konfirmasi Donasi Berhasil Diterima!') }}</h4>
                <p class="text-emerald-700 text-sm mt-1">{{ session('success') }}</p>
                @if(session('donation_code'))
                    <div class="mt-2 text-xs font-mono font-bold text-emerald-800 bg-emerald-100/60 px-3 py-1 rounded-md inline-block">
                        {{ __('Kode Registrasi: ') }} <span class="tracking-wide">{{ session('donation_code') }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Main Grid Content -->
    <div class="max-w-6xl mx-auto pb-16">
        
        <!-- 3 Pilar Program Donasi -->
        <div class="mb-12">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ __('Pilar Program Utama Penggalangan Dana') }}</h2>
                <p class="text-slate-600 text-sm mt-2">{{ __('Pilih program yang ingin Anda dukung secara spesifik atau salurkan melalui dana umum kemanusiaan YSDS.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pilar 1 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-red-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-4">
                            <i class="ki-filled ki-flask text-2xl"></i>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-700 mb-2">Faskes & Lab 3T</span>
                        <h3 class="font-extrabold text-slate-900 text-base mb-2">Bantuan Alkes & PCR Faskes 3T</h3>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Penyediaan mesin Real-Time PCR, Biosafety Cabinet, Ultra-Low Freezer, dan reagen diagnostik bagi RSUD dan puskesmas kepulauan terpencil (Sabu Raijua, Alor, Maumere, Ruteng, dll).
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-red-600">
                        <span>Fasilitas Diagnostik Mandiri</span>
                        <i class="ki-filled ki-arrow-right"></i>
                    </div>
                </div>

                <!-- Pilar 2 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-emerald-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                            <i class="ki-filled ki-teacher text-2xl"></i>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 mb-2">Pendidikan Vokasi</span>
                        <h3 class="font-extrabold text-slate-900 text-base mb-2">Beasiswa SMK Fensensius</h3>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Bantuan biaya pendidikan, asrama, dan peralatan praktikum bagi putra-putri daerah yang menempuh studi keperawatan dan teknologi laboratorium medik di SMK Fensensius.
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-emerald-600">
                        <span>Mencetak Tenaga Medis Masa Depan</span>
                        <i class="ki-filled ki-arrow-right"></i>
                    </div>
                </div>

                <!-- Pilar 3 -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs hover:border-sky-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center mb-4">
                            <i class="ki-filled ki-book-open text-2xl"></i>
                        </div>
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-700 mb-2">Literasi & Anak</span>
                        <h3 class="font-extrabold text-slate-900 text-base mb-2">Rumah Baca & Pendidikan Halmahera</h3>
                        <p class="text-slate-600 text-xs leading-relaxed">
                            Penyediaan buku ensiklopedia, sarana belajar digital, dan pelatihan guru di wilayah pelosok Halmahera guna mengatasi kesenjangan literasi anak Indonesia timur.
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-sky-600">
                        <span>Akses Pengetahuan Tanpa Batas</span>
                        <i class="ki-filled ki-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Rekening Bank Resmi & Informasi Transparansi (5 Kolom) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Notice Rekening Resmi -->
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-start gap-3">
                        <i class="ki-filled ki-information-2 text-amber-600 text-xl shrink-0 mt-0.5"></i>
                        <div class="text-xs text-amber-900 space-y-1">
                            <p class="font-black text-amber-950 uppercase tracking-wide">Pemberitahuan Rekening Resmi</p>
                            <p class="leading-relaxed">
                                Seluruh rekening penerimaan donasi resmi Yayasan Satriabudi Dharma Setia <strong>HANYA</strong> terdaftar atas nama: <br>
                                <span class="font-extrabold text-slate-900 underline">YAYASAN SATRIABUDI DHARMA SETIA</span>.
                            </p>
                            <p class="text-[11px] text-amber-800">Mohon berhati-hati terhadap segala modus rekening perorangan yang mengatasnamakan YSDS.</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Rekening BCA -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-lg tracking-wider text-blue-200">BANK BCA</span>
                            </div>
                            <span class="text-[11px] font-semibold uppercase tracking-widest text-blue-300 bg-white/10 px-2 py-0.5 rounded-md">Transfer Antar-Bank / VA</span>
                        </div>

                        <div>
                            <span class="text-xs text-blue-300 block mb-1">Nomor Rekening:</span>
                            <div class="flex items-center justify-between bg-black/20 rounded-xl px-4 py-2.5 border border-white/10">
                                <span id="bca-account" class="font-mono text-xl sm:text-2xl font-black tracking-widest text-white">873-098-8805</span>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('8730988805'); alert('Nomor Rekening BCA (8730988805) berhasil disalin!');" 
                                        class="text-xs font-bold text-blue-200 hover:text-white bg-blue-600/40 hover:bg-blue-600 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                                    <i class="ki-filled ki-copy text-sm"></i> Salin
                                </button>
                            </div>
                        </div>

                        <div class="text-xs space-y-0.5 border-t border-white/10 pt-3">
                            <p class="text-blue-300">Atas Nama:</p>
                            <p class="font-bold text-white tracking-wide text-sm">YAYASAN SATRIABUDI DHARMA SETIA</p>
                            <p class="text-[11px] text-blue-300">KCU Sudirman - Jakarta</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Rekening Mandiri -->
                <div class="bg-gradient-to-br from-slate-900 to-amber-950 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-lg tracking-wider text-amber-300">BANK MANDIRI</span>
                            </div>
                            <span class="text-[11px] font-semibold uppercase tracking-widest text-amber-300 bg-white/10 px-2 py-0.5 rounded-md">Transfer Antar-Bank / VA</span>
                        </div>

                        <div>
                            <span class="text-xs text-amber-300 block mb-1">Nomor Rekening:</span>
                            <div class="flex items-center justify-between bg-black/20 rounded-xl px-4 py-2.5 border border-white/10">
                                <span id="mandiri-account" class="font-mono text-xl sm:text-2xl font-black tracking-widest text-white">127-00-1122880-5</span>
                                <button type="button" 
                                        onclick="navigator.clipboard.writeText('1270011228805'); alert('Nomor Rekening Mandiri (1270011228805) berhasil disalin!');" 
                                        class="text-xs font-bold text-amber-200 hover:text-white bg-amber-600/40 hover:bg-amber-600 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                                    <i class="ki-filled ki-copy text-sm"></i> Salin
                                </button>
                            </div>
                        </div>

                        <div class="text-xs space-y-0.5 border-t border-white/10 pt-3">
                            <p class="text-amber-300">Atas Nama:</p>
                            <p class="font-bold text-white tracking-wide text-sm">YAYASAN SATRIABUDI DHARMA SETIA</p>
                            <p class="text-[11px] text-amber-300">KC Jakarta Thamrin</p>
                        </div>
                    </div>
                </div>

                <!-- Card Transparansi & Akuntabilitas -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h4 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                        <i class="ki-filled ki-shield-check text-emerald-600 text-lg"></i>
                        {{ __('Komitmen Akuntabilitas YSDS') }}
                    </h4>
                    <ul class="text-xs text-slate-600 space-y-2.5">
                        <li class="flex items-start gap-2">
                            <i class="ki-filled ki-check text-emerald-600 shrink-0 mt-0.5"></i>
                            <span>Seluruh donasi yang masuk diverifikasi oleh tim keuangan yayasan dalam waktu 1x24 jam kerja.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ki-filled ki-check text-emerald-600 shrink-0 mt-0.5"></i>
                            <span>Bukti tanda terima donasi resmi (e-Receipt) diterbitkan langsung ke alamat email donatur.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ki-filled ki-check text-emerald-600 shrink-0 mt-0.5"></i>
                            <span>Laporan penggunaan dana dan dokumentasi penyaluran alkes dipublikasikan secara berkala di portal visitasi kami.</span>
                        </li>
                    </ul>
                </div>

                <!-- Donatur Terkini Feed -->
                @if(isset($recentDonations) && $recentDonations->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">{{ __('Donasi Terverifikasi Terkini') }}</h4>
                            <span class="text-[11px] text-slate-500">{{ $totalDonors ?? 0 }} Donatur</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($recentDonations as $rd)
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-3 text-xs">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $rd->display_name }}</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">{{ $rd->program_target_label }}</div>
                                        @if($rd->message)
                                            <p class="text-[11px] italic text-slate-600 mt-1">"{{ Str::limit($rd->message, 70) }}"</p>
                                        @endif
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="font-extrabold text-emerald-600 block">{{ $rd->formatted_amount }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $rd->transfer_date ? $rd->transfer_date->format('d M Y') : '' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan: Formulir Konfirmasi Transfer Donasi (7 Kolom) -->
            <div class="lg:col-span-7 bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs">
                <div class="mb-6">
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wider">{{ __('Langkah 2: Konfirmasi Pembayaran') }}</span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1">
                        {{ __('Formulir Konfirmasi Donasi') }}
                    </h2>
                    <p class="text-slate-500 text-xs mt-1">
                        {{ __('Silakan isi konfirmasi ini setelah Anda melakukan transfer agar tim bendahara YSDS dapat segera memverifikasi dan mengirimkan bukti tanda terima donasi.') }}
                    </p>
                </div>

                <form action="{{ route('website.donation.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Anti-spam Honeypot Trap -->
                    <input type="text" name="website_hp" value="" class="hidden" style="display:none;" tabindex="-1" autocomplete="off">

                    <!-- Tipe Donatur -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Tipe Donatur') }}
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:border-red-500 has-[:checked]:border-red-600 has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="donor_type" value="individual" class="text-red-600 focus:ring-red-500" {{ old('donor_type', 'individual') === 'individual' ? 'checked' : '' }}>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ __('Individu / Perorangan') }}</span>
                                    <span class="block text-[11px] text-slate-500">{{ __('Donasi atas nama pribadi') }}</span>
                                </div>
                            </label>
                            <label class="cursor-pointer border border-slate-200 rounded-xl p-3 flex items-center gap-3 hover:border-red-500 has-[:checked]:border-red-600 has-[:checked]:bg-red-50/30 transition-all">
                                <input type="radio" name="donor_type" value="institution" class="text-red-600 focus:ring-red-500" {{ old('donor_type') === 'institution' ? 'checked' : '' }}>
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ __('Instansi / Korporasi') }}</span>
                                    <span class="block text-[11px] text-slate-500">{{ __('Perusahaan, Yayasan, Komunitas') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Nama Donatur -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Nama Lengkap / Instansi') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="donor_name" value="{{ old('donor_name') }}" required
                               placeholder="Contoh: Bpk. Hendra Gunawan / PT Sehat Bersama"
                               class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                        @error('donor_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilihan Anonim -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                               class="rounded border-slate-300 text-red-600 focus:ring-red-500 h-4 w-4">
                        <label for="is_anonymous" class="text-xs text-slate-600 cursor-pointer">
                            {{ __('Sembunyikan nama saya pada daftar donatur publik (Tampilkan sebagai Hamba Allah / Anonim)') }}
                        </label>
                    </div>

                    <!-- Kontak Donatur -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Alamat Email') }} <span class="text-red-600">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com"
                                   class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                            <span class="text-[11px] text-slate-400 mt-1 block">Tanda terima resmi akan dikirim ke email ini.</span>
                            @error('email')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Nomor WhatsApp / Telp') }} <span class="text-red-600">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   placeholder="08123456789"
                                   class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                            @error('phone')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Program Target -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Pilihan Program Penyaluran') }} <span class="text-red-600">*</span>
                        </label>
                        <select name="program_target" required
                                class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 bg-white">
                            <option value="">-- Pilih Program Donasi --</option>
                            <option value="alkes_pcr_3t" {{ old('program_target') === 'alkes_pcr_3t' ? 'selected' : '' }}>Bantuan Alkes & PCR Faskes 3T</option>
                            <option value="beasiswa_smk_fensensius" {{ old('program_target') === 'beasiswa_smk_fensensius' ? 'selected' : '' }}>Beasiswa Siswa SMK Fensensius</option>
                            <option value="rumah_baca_halmahera" {{ old('program_target') === 'rumah_baca_halmahera' ? 'selected' : '' }}>Rumah Baca & Pendidikan Halmahera</option>
                            <option value="umum" {{ old('program_target') === 'umum' ? 'selected' : '' }}>Dana Kemanusiaan & Operasional YSDS (Bebas Alokasi)</option>
                        </select>
                        @error('program_target')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominal Donasi & Quick Buttons -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Nominal Donasi (IDR)') }} <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-400 font-bold text-sm">Rp</span>
                            <input type="number" id="amount_input" name="amount" value="{{ old('amount') }}" required min="10000" step="1000"
                                   placeholder="100.000"
                                   class="w-full pl-12 pr-4 text-sm font-bold text-slate-900 rounded-xl border border-slate-200 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20">
                        </div>
                        
                        <!-- Quick Nominal Buttons -->
                        <div class="flex flex-wrap gap-2 mt-2">
                            <button type="button" onclick="document.getElementById('amount_input').value = '100000'" class="px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 transition-colors">Rp 100.000</button>
                            <button type="button" onclick="document.getElementById('amount_input').value = '250000'" class="px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 transition-colors">Rp 250.000</button>
                            <button type="button" onclick="document.getElementById('amount_input').value = '500000'" class="px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 transition-colors">Rp 500.000</button>
                            <button type="button" onclick="document.getElementById('amount_input').value = '1000000'" class="px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 transition-colors">Rp 1.000.000</button>
                            <button type="button" onclick="document.getElementById('amount_input').value = '5000000'" class="px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-700 transition-colors">Rp 5.000.000</button>
                        </div>
                        @error('amount')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Transfer & Bank Tujuan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Tanggal Transfer') }} <span class="text-red-600">*</span>
                            </label>
                            <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" required
                                   class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 bg-white">
                            @error('transfer_date')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                {{ __('Bank YSDS Tujuan') }} <span class="text-red-600">*</span>
                            </label>
                            <select name="bank_name" required
                                    class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 bg-white">
                                <option value="BCA" {{ old('bank_name') === 'BCA' ? 'selected' : '' }}>BCA - 873-098-8805</option>
                                <option value="Bank Mandiri" {{ old('bank_name') === 'Bank Mandiri' ? 'selected' : '' }}>Mandiri - 127-00-1122880-5</option>
                            </select>
                            @error('bank_name')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Upload Bukti Transfer -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Unggah Bukti Transfer / Resi') }}
                        </label>
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-red-300 transition-colors">
                            <input type="file" name="proof" accept="image/jpeg,image/png,image/jpg,application/pdf"
                                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                            <p class="text-[11px] text-slate-400 mt-1">Format gambar (JPG, PNG) atau PDF (Maksimal 5MB).</p>
                        </div>
                        @error('proof')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pesan / Harapan / Doa -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            {{ __('Pesan / Doa Donatur (Opsional)') }}
                        </label>
                        <textarea name="message" rows="3"
                                  placeholder="Tuliskan doa, harapan, atau catatan khusus untuk penerima manfaat..."
                                  class="w-full text-sm rounded-xl border border-slate-200 px-4 py-3 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-extrabold text-sm py-3.5 px-6 rounded-xl shadow-lg shadow-red-600/25 transition-all flex items-center justify-center gap-2">
                            <i class="ki-filled ki-send text-base"></i>
                            <span>{{ __('Kirim Konfirmasi Donasi') }}</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-400 text-center leading-normal">
                        Dengan menekan tombol di atas, Anda menyatakan bahwa data transfer yang Anda masukkan adalah benar dan valid.
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
