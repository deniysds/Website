@extends('website::layouts.public')

@section('public_content')
    <!-- 1. Hero Section Banner Presisi (Sesuai Desain Gambar 2) -->
    <div class="relative min-w-0 max-w-full pb-10 sm:pb-16">
        <!-- Hero Dark Card -->
        <section class="relative bg-[#070102] text-white rounded-3xl sm:rounded-[36px] overflow-hidden pt-16 sm:pt-24 lg:pt-28 pb-24 sm:pb-32 lg:pb-36 shadow-2xl border border-red-950/30 min-w-0 max-w-full min-h-[460px] sm:min-h-[520px] flex flex-col justify-center"
                 style="background-color: #070102;">
            <!-- Dynamic Background Asset Sesuai Gambar 2 (Gelombang & Halftone Merah) -->
            <div class="absolute inset-0 z-0 bg-cover bg-center pointer-events-none"
                 style="background-image: url('{{ asset('assets/media/banners/hero-banner-ysds.png') }}'); background-color: #070102; background-size: cover; background-position: center;"></div>

            <!-- Content Centered -->
            <div class="max-w-4xl mx-auto px-6 relative z-10 text-center space-y-4 sm:space-y-6">
                <!-- Title: 2 Baris Presisi Gambar 2 -->
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-semibold tracking-tight text-white leading-tight mx-auto">
                    @if(($settings['hero_title'] ?? 'Yayasan Satriabudi Dharma Setia') === 'Yayasan Satriabudi Dharma Setia')
                        <span class="block">Yayasan Satriabudi</span>
                        <span class="block">Dharma Setia</span>
                    @else
                        {{ __($settings['hero_title'] ?? 'Yayasan Satriabudi Dharma Setia') }}
                    @endif
                </h1>

                <!-- Subtitle: Presisi Gambar 2 -->
                <p class="text-sm sm:text-lg lg:text-xl text-white/90 font-light sm:font-normal max-w-xl mx-auto leading-relaxed">
                    @if(($settings['hero_subtitle'] ?? 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.') === 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.')
                        <span class="block sm:inline">{{ __('Membangun Akses Kesehatan dan') }}</span>
                        <span class="block sm:inline">{{ __('Pendidikan untuk Indonesia.') }}</span>
                    @else
                        {{ __($settings['hero_subtitle'] ?? 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.') }}
                    @endif
                </p>

                <!-- Tombol Donasi Presisi Gambar 2 -->
                <div class="pt-2 sm:pt-3">
                    <a href="{{ $settings['hero_button_url'] ?? route('website.donation.public') }}"
                       class="inline-flex items-center justify-center px-8 py-3 rounded-md bg-red-600 hover:bg-red-700 text-white font-bold text-sm shadow-xl shadow-red-600/40 transition duration-200"
                       style="background-color: #dc2626;">
                        {{ __($settings['hero_button_text'] ?? 'Donasi') }} &nearr;
                    </a>
                </div>
            </div>
        </section>

        <!-- Floating Red Stat Counter Overlay Presisi Desain Gambar 2 -->
        <div class="relative -mt-14 sm:-mt-16 z-20 max-w-4xl 2xl:max-w-5xl mx-auto px-4 sm:px-6">
            <div class="rounded-2xl sm:rounded-3xl p-5 sm:py-6 sm:px-8 shadow-2xl border border-red-500/40 grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-0 text-center divide-y sm:divide-y-0 sm:divide-x divide-white/30"
                 style="background: linear-gradient(135deg, #ba0a0a 0%, #ba0a0a 100%); background-color: #ba0a0a;">
                <div class="pt-2 sm:pt-0 sm:px-4 flex flex-col items-center justify-center">
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_1_number'] ?? '150+' }}</div>
                    <div class="text-xs sm:text-sm font-semibold text-white mt-1">{{ __($settings['stat_1_label'] ?? 'Kerjasama Sukses') }}</div>
                </div>
                <div class="pt-4 sm:pt-0 sm:px-4 flex flex-col items-center justify-center">
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_2_number'] ?? '125 T' }}</div>
                    <div class="text-xs sm:text-sm font-semibold text-white mt-1">{{ __($settings['stat_2_label'] ?? 'Dana Terkumpul') }}</div>
                </div>
                <div class="pt-4 sm:pt-0 sm:px-4 flex flex-col items-center justify-center">
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_3_number'] ?? '79+' }}</div>
                    <div class="text-xs sm:text-sm font-semibold text-white mt-1">{{ __($settings['stat_3_label'] ?? 'Mitra Jejaring') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Section Profil (Menciptakan generasi muda unggul...) -->
    <section id="profil" class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8 min-w-0 max-w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
            <div class="space-y-6">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __($settings['profile_tag'] ?? 'Profil') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ __($settings['profile_title'] ?? 'Menciptakan generasi muda unggul melalui pendidikan bermutu, kesehatan prima, dan lingkungan hidup yang terpelihara.') }}
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ __($settings['profile_desc'] ?? 'Berkontribusi bagi kemajuan bangsa dengan membangun masa depan yang lebih cerah bagi generasi muda Indonesia melalui program pendidikan, kesehatan, dan lingkungan yang berdampak serta berkelanjutan.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('website.about') }}" class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold text-sm transition shadow-2xs">
                        {{ __($settings['profile_button_text'] ?? 'Selengkapnya') }} &nearr;
                    </a>
                </div>
            </div>

            <!-- 3 Box Sisi Kanan (Pendidikan, Kesehatan, Lingkungan) -->
            <div class="space-y-4">
                <div class="p-6 sm:p-7 rounded-2xl bg-[#F5F5F5] border border-gray-200/80 hover:bg-white hover:border-red-200 hover:shadow-md transition duration-200 flex items-center gap-5 sm:gap-6">
                    <div class="shrink-0 flex items-center justify-center text-red-600">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/>
                            <path d="M22 10v6"/>
                            <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">{{ __($settings['profile_box_1_title'] ?? 'Pendidikan yang Berkualitas') }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ __($settings['profile_box_1_desc'] ?? 'Penguatan kapabilitas SDM riset dan beasiswa tingkat tinggi secara berkesinambungan.') }}</p>
                    </div>
                </div>

                <div class="p-6 sm:p-7 rounded-2xl bg-[#F5F5F5] border border-gray-200/80 hover:bg-white hover:border-red-200 hover:shadow-md transition duration-200 flex items-center gap-5 sm:gap-6">
                    <div class="shrink-0 flex items-center justify-center text-red-600">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">{{ __($settings['profile_box_2_title'] ?? 'Kesehatan yang Prima') }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ __($settings['profile_box_2_desc'] ?? 'Dukungan fasilitas kesehatan, diagnostik molekuler, dan pencegahan penyakit tropis.') }}</p>
                    </div>
                </div>

                <div class="p-6 sm:p-7 rounded-2xl bg-[#F5F5F5] border border-gray-200/80 hover:bg-white hover:border-red-200 hover:shadow-md transition duration-200 flex items-center gap-5 sm:gap-6">
                    <div class="shrink-0 flex items-center justify-center text-red-600">
                        <svg class="w-10 h-10 sm:w-11 sm:h-11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base sm:text-lg leading-snug">{{ __($settings['profile_box_3_title'] ?? 'Lingkungan Hidup yang Terpelihara') }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ __($settings['profile_box_3_desc'] ?? 'Pelestarian keanekaragaman hayati dan penerapan riset sains ramah lingkungan.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Section Program (Kami Membangun Program untuk Dampak Nyata - 5 Kategori Cards) -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8 min-w-0 max-w-full">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Program') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">{{ __('Kami Membangun Program untuk Dampak Nyata') }}</h2>
            </div>
            <a href="{{ route('website.about') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1 self-start sm:self-auto">
                {{ __('Hubungi kami') }} &nearr;
            </a>
        </div>

        <!-- 5 Kategori Cards (IGNITE, Pendidikan, ISA Kuliah, Katalis, DASH) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 pt-6">
            @foreach($programs as $prog)
                <div class="relative bg-white rounded-2xl p-6 pt-9 border border-slate-200/80 shadow-xs hover:shadow-xl transition duration-300 flex flex-col justify-between space-y-6">
                    <!-- Red Icon Badge protruding top-left -->
                    <div class="absolute -top-5 left-6 w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/30">
                        @if($prog->icon === 'dna')
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m8 8 8 8"/>
                                <path d="m9 2 7 7"/>
                                <path d="m15 15 7 7"/>
                                <path d="m2 9 7 7"/>
                                <path d="m15 2-7 7"/>
                                <path d="M2 15c6.667-6 13.333 0 20-6"/>
                                <path d="M2 9c6.667 6 13.333 0 20 6"/>
                            </svg>
                        @elseif($prog->icon === 'leaf')
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                            </svg>
                        @elseif($prog->icon === 'graduation-cap')
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/>
                                <path d="M22 10v6"/>
                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
                            </svg>
                        @elseif($prog->icon === 'cross')
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                            </svg>
                        @elseif($prog->icon === 'globe')
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                                <path d="M2 12h20"/>
                            </svg>
                        @else
                            <i class="{{ $prog->icon }} text-lg"></i>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-medium text-slate-900 tracking-tight">{{ __($prog->title) }}</h3>
                        <p class="text-xs sm:text-[13px] text-slate-600 font-light leading-relaxed">{{ __($prog->description) }}</p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ $prog->link_url ?? '/catalog-journals' }}" class="text-xs font-normal text-slate-900 hover:text-red-600 transition inline-block">
                            {{ __('Selengkapnya') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Section Metode / Pendekatan Terarah (Dark Banner Card 1, 2, 3 Steps) -->
    <section class="bg-slate-950 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-xl relative overflow-hidden min-w-0 max-w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left Title & Description -->
            <div class="space-y-6">
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __($settings['method_tag'] ?? 'Metode') }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                    {{ __($settings['method_title'] ?? 'Pendekatan terarah untuk mencapai hasil yang optimal') }}
                </h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    {{ __($settings['method_desc'] ?? 'Kami menerjemahkan komitmen menjadi dampak berkesinambungan melalui aliansi strategis bersama mitra riset terpercaya di seluruh Indonesia.') }}
                </p>
            </div>

            <!-- Right 3 Steps List (Red Active Box 1, Dark Gray 2 & 3) -->
            <div class="space-y-4">
                <div class="p-6 rounded-2xl bg-red-600 text-white shadow-xl flex items-start gap-5 border border-red-500">
                    <span class="text-2xl font-black text-white shrink-0">1</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ __($settings['method_step_1_title'] ?? 'Mengkaji Riset & Kebutuhan') }}</h4>
                        <p class="text-xs text-red-100 leading-relaxed">{{ __($settings['method_step_1_desc'] ?? 'Pemetaan isu strategis sains & kesehatan berbasis fakta ilmiah untuk pemangku kepentingan nasional.') }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 text-white flex items-start gap-5 hover:border-slate-700 transition">
                    <span class="text-2xl font-black text-slate-400 shrink-0">2</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ __($settings['method_step_2_title'] ?? 'Merancang dan Menjalankan Program') }}</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">{{ __($settings['method_step_2_desc'] ?? 'Eksekusi program publikasi & fasilitas riset secara transparan dengan standar akuntabilitas tinggi.') }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 text-white flex items-start gap-5 hover:border-slate-700 transition">
                    <span class="text-2xl font-black text-slate-400 shrink-0">3</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ __($settings['method_step_3_title'] ?? 'Menevaluasi dan Mengembangkan') }}</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">{{ __($settings['method_step_3_desc'] ?? 'Pemeriksaan berkala untuk memastikan efektivitas dampak program ilmiah yang kontinyu bagi masyarakat.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Section Publikasi Jurnal Terbaru -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8 min-w-0 max-w-full">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Jurnal') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">{{ __('Publikasi Jurnal Terbaru') }}</h2>
            </div>
            <a href="{{ route('website.journals.index') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1 self-start sm:self-auto">
                {{ __('Lihat Semua Jurnal') }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($journals as $journal)
                <div class="bg-slate-50/70 rounded-2xl p-6 border border-slate-200/80 hover:bg-white hover:shadow-xl transition duration-300 flex flex-col justify-between space-y-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-red-600 uppercase font-mono"><i class="ki-filled ki-document mr-1"></i> {{ $journal->short_name ?? $journal->slug }}</span>
                            <span class="text-slate-400 font-mono">e-ISSN: {{ $journal->issn_e ?? '-' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 hover:text-red-600 transition">
                            <a href="{{ route('website.journals.show', $journal->slug) }}">{{ $journal->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $journal->description ?? 'Jurnal ilmiah berkala yang mempublikasikan hasil penelitian berkualitas.' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-medium"><i class="ki-filled ki-profile-user mr-1 text-slate-400"></i> {{ $journal->editorial_boards_count }} {{ __('Redaksi') }}</span>
                        <a href="{{ route('website.journals.show', $journal->slug) }}" class="font-bold text-slate-900 hover:text-red-600 flex items-center gap-1 transition">
                            <span>{{ __('Selengkapnya') }}</span> &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                    <p class="text-slate-500 text-sm">{{ __('Belum ada jurnal aktif yang dipublikasikan.') }}</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. Section Kegiatan Terbaru (Presisi Mockup) -->
    <section class="bg-[#F5F5F5] rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs min-w-0 max-w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <!-- Kolom Kiri: Metadata & Judul Kegiatan -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-widest">
                        {{ $featuredEvent->tag ?? ($settings['project_tag'] ?? 'Kegiatan Terbaru') }}
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight mt-2">
                        @if(isset($featuredEvent) && $featuredEvent)
                            <a href="{{ route('website.events.show', $featuredEvent->slug) }}" class="hover:text-red-600 transition">
                                {{ $featuredEvent->title }}
                            </a>
                        @else
                            {{ $settings['project_title'] ?? 'BioAI and Genomics Symposium - Indonesia' }}
                        @endif
                    </h2>
                </div>

                <!-- Tabel Baris Metadata Sesuai Mockup -->
                <div class="space-y-3 pt-2 text-xs sm:text-sm">
                    <div class="flex items-center justify-between sm:justify-start gap-4 border-b border-slate-200/80 pb-3">
                        <span class="text-slate-500 font-medium w-44">{{ __('Tahun Pelaksanaan') }}</span>
                        <span class="font-bold text-slate-900">: {{ $featuredEvent->year ?? ($settings['project_year'] ?? '2026') }}</span>
                    </div>
                    <div class="flex items-center justify-between sm:justify-start gap-4 border-b border-slate-200/80 pb-3">
                        <span class="text-slate-500 font-medium w-44">{{ __('Mitra') }}</span>
                        <span class="font-bold text-slate-900">: {{ $featuredEvent->partner_name ?? ($settings['project_partner'] ?? 'Ultima Genomic') }}</span>
                    </div>
                    <div class="flex items-center justify-between sm:justify-start gap-4 pb-1">
                        <span class="text-slate-500 font-medium w-44">{{ __('Sponsor') }}</span>
                        <span class="font-bold text-slate-900">: {{ $featuredEvent->sponsor_name ?? ($settings['project_sponsor'] ?? 'Panin Bank') }}</span>
                    </div>
                </div>

                @if(isset($featuredEvent) && $featuredEvent->summary)
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-light sm:font-normal">
                        {{ $featuredEvent->summary }}
                    </p>
                @endif

                <!-- Aksi Kegiatan -->
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    @if(isset($featuredEvent) && $featuredEvent)
                        <a href="{{ route('website.events.show', $featuredEvent->slug) }}" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-2">
                            <span>{{ __('Lihat Detail Kegiatan') }}</span>
                            <i class="ki-filled ki-arrow-right text-xs"></i>
                        </a>
                    @else
                        <a href="{{ route('website.events.public') }}" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-2">
                            <span>{{ __('Lihat Detail Kegiatan') }}</span>
                            <i class="ki-filled ki-arrow-right text-xs"></i>
                        </a>
                    @endif
                    <a href="{{ route('website.events.public') }}" class="px-5 py-3 rounded-xl border border-slate-300 hover:border-red-600 text-slate-700 hover:text-red-600 font-semibold text-xs bg-white transition inline-flex items-center gap-1.5">
                        <span>{{ __('Semua Kegiatan') }}</span> &rarr;
                    </a>
                </div>
            </div>

            <!-- Kolom Kanan: Media Card / Banner Box Sesuai Mockup -->
            <div class="lg:col-span-5 w-full">
                <div class="w-full rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-red-950 border border-slate-700/80 p-6 sm:p-8 shadow-xl relative overflow-hidden group min-h-[300px] flex flex-col justify-between">
                    @if(isset($featuredEvent) && $featuredEvent->banner_url)
                        <img src="{{ $featuredEvent->banner_url }}" alt="{{ $featuredEvent->title }}" class="absolute inset-0 w-full h-full object-cover rounded-2xl opacity-75 group-hover:scale-105 transition duration-500" />
                    @endif
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-red-600/20 rounded-full blur-3xl group-hover:bg-red-600/30 transition duration-700"></div>
                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-red-600 text-white shadow-xs">
                                {{ $featuredEvent->year ?? '2026' }}
                            </span>
                            <span class="text-xs font-mono text-slate-300">YSDS Genomic Hub</span>
                        </div>
                        <h4 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                            {{ $featuredEvent->title ?? 'BioAI and Genomics Symposium - Indonesia' }}
                        </h4>
                        <p class="text-xs text-slate-200 leading-relaxed line-clamp-3 font-light">
                            {{ $featuredEvent->summary ?? __('Menghubungkan lebih dari 150+ peneliti, institusi laboratorium, dan praktisi genomik nasional dalam forum ilmiah terstandarisasi.') }}
                        </p>
                    </div>
                    <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                        <span class="flex items-center gap-1"><i class="ki-filled ki-calendar text-red-400"></i> {{ $featuredEvent->event_date ?? 'Kamis, 15 Mei 2026' }}</span>
                        <span class="flex items-center gap-1"><i class="ki-filled ki-geolocation text-red-400"></i> {{ $featuredEvent->location ?? 'Jakarta' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Section Berita Terbaru (Background Putih Tanpa Border & Tanpa Rounded Sesuai Instruksi) -->
    <section class="bg-white p-6 sm:p-12 space-y-8 min-w-0 max-w-full">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Berita Terbaru') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">{{ __('Temukan informasi, kegiatan, dan pembaruan terbaru dari kami.') }}</h2>
            </div>
            <a href="{{ route('website.news.index') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                <span>{{ __('Artikel Lainnya') }}</span>
                <span class="text-sm">↗</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($news as $item)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between group">
                    <!-- Foto Berita Atas dengan sudut membulat -->
                    <div class="w-full h-48 sm:h-52 bg-gradient-to-tr from-slate-900 via-slate-800 to-red-950 relative overflow-hidden text-white border-b border-slate-100">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500 rounded-t-2xl" />
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-900/60 p-6 text-center">
                                <span class="text-xs font-mono text-slate-300">{{ $item->category }}</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 z-10">
                            <span class="text-[10px] font-black uppercase tracking-wider text-red-100 bg-red-600/90 backdrop-blur-xs px-2.5 py-0.5 rounded-full">
                                {{ $item->category }}
                            </span>
                        </div>
                    </div>

                    <!-- Isi Kartu Berita -->
                    <div class="p-6 space-y-3 grow">
                        <!-- Tanggal dengan icon kalender sesuai mockup -->
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                            <i class="ki-filled ki-calendar text-red-500 text-xs"></i>
                            <span>{{ $item->published_at ? $item->published_at->format('d F Y') : '-' }}</span>
                        </div>

                        <h4 class="font-bold text-slate-900 text-base leading-snug group-hover:text-red-600 transition line-clamp-2">
                            <a href="{{ route('website.news.show', $item->slug ?: $item->id) }}">{{ $item->title }}</a>
                        </h4>

                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 font-light sm:font-normal">{{ $item->summary }}</p>
                    </div>

                    <!-- Garis Pemisah Tipis -->
                    <hr class="border-slate-100 mx-6">

                    <!-- Footer Kartu: Penulis & Selengkapnya -->
                    <div class="p-6 pt-3 flex items-center justify-between text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-[10px] font-bold">
                                {{ strtoupper(substr($item->author_name ?: 'Y', 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-700 truncate max-w-[130px]">{{ $item->author_name ?: 'Tim Redaksi YSDS' }}</span>
                        </div>
                        <a href="{{ route('website.news.show', $item->slug ?: $item->id) }}" class="font-bold text-slate-900 hover:text-red-600 flex items-center gap-1">
                            <span>{{ __('Selengkapnya') }}</span>
                            <span class="text-sm">&rarr;</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                    <p class="text-slate-500 text-sm">{{ __('Belum ada berita terbaru.') }}</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Blok Bawah Terpadu: Mitra Kami, Kolaborasi & Kontak (Tanpa Rounded & Tanpa Border Sesuai Lampiran) -->
    <div class="space-y-0 overflow-hidden">
        <!-- 8. Section Mitra Kami (Flat Tanpa Rounded & Tanpa Border) -->
        <section class="bg-black text-white p-8 sm:p-14 space-y-12 overflow-hidden relative min-w-0 max-w-full">
            <style>
                @keyframes marquee-scroll {
                    0% { transform: translateX(0%); }
                    100% { transform: translateX(-50%); }
                }
                @keyframes marquee-scroll-reverse {
                    0% { transform: translateX(-50%); }
                    100% { transform: translateX(0%); }
                }
                .marquee-container {
                    width: 100%;
                    max-width: 100%;
                    min-width: 0;
                    overflow: hidden;
                }
                .marquee-track {
                    display: flex;
                    width: max-content;
                    animation: marquee-scroll 40s linear infinite;
                }
                .marquee-track-reverse {
                    display: flex;
                    width: max-content;
                    animation: marquee-scroll-reverse 45s linear infinite;
                }
                .marquee-container:hover .marquee-track,
                .marquee-container:hover .marquee-track-reverse {
                    animation-play-state: paused;
                }
            </style>

            <!-- Header Section Mitra Kami -->
            <div class="text-center space-y-3 max-w-3xl mx-auto">
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __($settings['partners_tag'] ?? 'Mitra Kami') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">
                    {{ __($settings['partners_title'] ?? 'Kami Percaya Setiap Mitra Adalah Bagian Berharga dalam Perjalanan Jangka Panjang') }}
                </h2>
            </div>

            <!-- 1. Mitra Utama (Platinum Partners: PaninBank, Ultima Genomics, PacBio, MGI, Oxford Nanopore) -->
            <div class="pt-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 items-center justify-center">
                    @forelse($mainPartners as $partner)
                        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800 hover:border-slate-600 hover:bg-slate-900 transition flex items-center justify-center h-24 group relative" title="{{ $partner->name }}">
                            <span class="sr-only">{{ $partner->name }}</span>
                            @if($partner->logo_path)
                                <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-12 max-w-full object-contain filter brightness-90 group-hover:brightness-100 transition" />
                            @else
                                <!-- Brand Text-based Logo for Demo / Main Partners matching screenshot -->
                                @if(str_contains(strtolower($partner->name), 'panin'))
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-sm bg-blue-600 flex items-center justify-center text-white font-bold text-xs shadow-xs">P</div>
                                        <span class="font-black text-lg tracking-tight text-white"><span class="text-red-500">Panin</span>Bank</span>
                                    </div>
                                @elseif(str_contains(strtolower($partner->name), 'ultima'))
                                    <div class="text-center">
                                        <div class="font-black text-base text-white tracking-widest uppercase">ULTIMA</div>
                                        <div class="text-[9px] font-bold text-slate-400 tracking-widest uppercase">GENOMICS</div>
                                    </div>
                                @elseif(str_contains(strtolower($partner->name), 'pacbio'))
                                    <div class="font-black text-xl tracking-tight text-pink-500">Pac<span class="text-white">Bio</span></div>
                                @elseif(str_contains(strtolower($partner->name), 'mgi'))
                                    <div class="flex items-center gap-1">
                                        <div class="text-cyan-400 font-mono font-black text-2xl tracking-tighter">MGI</div>
                                        <div class="text-[9px] text-cyan-200 font-bold uppercase tracking-wider">Tech</div>
                                    </div>
                                @elseif(str_contains(strtolower($partner->name), 'nanopore'))
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full border-2 border-cyan-400 flex items-center justify-center"><div class="w-2 h-2 rounded-full bg-cyan-400"></div></div>
                                        <div class="text-left leading-none">
                                            <div class="text-[9px] text-slate-400 uppercase font-mono">Oxford</div>
                                            <div class="text-xs font-black text-white uppercase tracking-wider">NANOPORE</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="font-bold text-white text-sm tracking-tight text-center">{{ $partner->name }}</span>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="col-span-5 text-center text-slate-500 text-xs">Belum ada data mitra utama.</div>
                    @endforelse
                </div>
            </div>

            <!-- 2. Mitra Pendukung (Running Marquee Carousel - Logo Berjalan Halus) -->
            <div class="space-y-4 pt-4 border-t border-slate-900/80">
                <div class="text-center">
                    <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">{{ __('Mitra Perguruan Tinggi & Institusi Riset Akademik') }}</span>
                </div>

                <!-- Carousel Row 1 (Kiri ke Kanan) -->
                <div class="marquee-container overflow-hidden relative w-full py-2 [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                    <div class="marquee-track flex gap-4 items-center">
                        @php
                            // Gandakan list untuk infinite loop yang mulus
                            $marqueeList = $supportingPartners->concat($supportingPartners);
                        @endphp
                        @foreach($marqueeList as $partner)
                            <div class="flex items-center gap-3 px-4 py-2.5 rounded-full bg-slate-900/90 border border-slate-800 hover:border-red-500/50 hover:bg-slate-800 transition shrink-0 group">
                                @if($partner->logo_path)
                                    <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="w-7 h-7 object-contain rounded-full bg-white/10 p-0.5" />
                                @else
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-red-600 via-slate-800 to-blue-600 text-white font-black flex items-center justify-center text-[10px] shrink-0 shadow-xs border border-white/20">
                                        {{ substr($partner->name, 0, 2) }}
                                    </div>
                                @endif
                                <span class="text-xs font-semibold text-slate-300 group-hover:text-white transition whitespace-nowrap">{{ $partner->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Carousel Row 2 (Kanan ke Kiri) -->
                @if($supportingPartners->count() > 6)
                    <div class="marquee-container overflow-hidden relative w-full py-2 [mask-image:linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                        <div class="marquee-track-reverse flex gap-4 items-center">
                            @php
                                $reverseList = $supportingPartners->reverse()->concat($supportingPartners->reverse());
                            @endphp
                            @foreach($reverseList as $partner)
                                <div class="flex items-center gap-3 px-4 py-2.5 rounded-full bg-slate-900/90 border border-slate-800 hover:border-red-500/50 hover:bg-slate-800 transition shrink-0 group">
                                    @if($partner->logo_path)
                                        <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="w-7 h-7 object-contain rounded-full bg-white/10 p-0.5" />
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-blue-600 via-slate-800 to-amber-500 text-white font-black flex items-center justify-center text-[10px] shrink-0 shadow-xs border border-white/20">
                                            {{ substr($partner->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-semibold text-slate-300 group-hover:text-white transition whitespace-nowrap">{{ $partner->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- 9. Section Kolaborasi (Presisi Mockup Gambar Lampiran: Background Putih Tanpa Border & Tanpa Rounded) -->
        <section class="bg-white py-16 px-6 sm:px-12 text-center space-y-6 min-w-0 max-w-full">
            <div class="space-y-3 max-w-4xl mx-auto">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Kolaborasi') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ __('Bangun Kolaborasi Bersama Kami untuk') }}<br class="hidden sm:inline">
                    {{ __('Menciptakan Inovasi dan Peluang yang Lebih Besar') }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl mx-auto pt-1 font-light sm:font-normal">
                    {{ __('Mari jelajahi peluang untuk bekerja sama dalam mendukung pengembangan genomik dan sequencing. Hubungi kami untuk mendiskusikan peluang kolaborasi, kemitraan, maupun solusi yang dapat disesuaikan dengan kebutuhan Anda.') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-3.5 pt-2">
                <a href="{{ route('website.assistance.public') }}" class="px-6 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-1.5">
                    <span>{{ __('Formulir Riset') }}</span>
                    <span class="text-sm font-normal">↗</span>
                </a>
                <a href="{{ route('website.contact') }}" class="px-6 py-2.5 rounded-lg border border-red-500 text-red-600 hover:bg-red-50 font-bold text-xs transition inline-flex items-center gap-1.5 bg-white">
                    <span>{{ __('Hubungi Kami') }}</span>
                    <span class="text-sm font-normal">↗</span>
                </a>
            </div>
        </section>

        <!-- 10. Section Butuh Informasi Lebih Lanjut? (Flat Edge Menyesuaikan Alur) -->
        <section class="overflow-hidden bg-gradient-to-r from-red-950 via-red-800 to-red-600 text-white p-8 sm:p-14 min-w-0 max-w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Kolom Kiri: Headline & Deskripsi -->
                <div class="space-y-6">
                    <div class="space-y-3">
                        <h2 class="text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                            {{ __('Butuh Informasi Lebih Lanjut?') }}<br>
                            {{ __('Sampaikan Pertanyaan Anda kepada Kami') }}
                        </h2>
                    </div>
                    <p class="text-sm sm:text-base text-red-100/90 leading-relaxed font-light sm:font-normal max-w-lg">
                        {{ __('Sampaikan pertanyaan, kebutuhan, atau informasi yang ingin Anda ketahui melalui formulir di samping. Tim kami akan menghubungi Anda untuk memberikan informasi dan solusi yang sesuai dengan kebutuhan Anda.') }}
                    </p>

                    @if(session('success'))
                        <div class="p-4 rounded-xl bg-white/20 backdrop-blur-md border border-white/40 text-white text-xs font-bold flex items-center gap-2">
                            <i class="ki-filled ki-check-circle text-white text-lg"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Kolom Kanan: Card Formulir Putih Modern -->
                <div class="w-full">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 text-slate-900 shadow-2xl border border-white/80">
                        <form action="{{ route('website.contact.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            {{-- Honeypot bot protection field --}}
                            <div class="hidden" style="display:none !important;" aria-hidden="true">
                                <input type="text" name="website_hp" value="" tabindex="-1" autocomplete="off" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('FIRST NAME') }} <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="first_name" required placeholder="{{ __('FIRST NAME') }}" value="{{ old('first_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-600 focus:ring-2 focus:ring-red-500/20 text-xs font-medium focus:outline-none transition" />
                                @error('first_name')
                                    <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('PHONE') }} <span class="text-red-600">*</span>
                                </label>
                                <input type="text" name="phone" required placeholder="{{ __('PHONE') }}" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-600 focus:ring-2 focus:ring-red-500/20 text-xs font-medium focus:outline-none transition" />
                                @error('phone')
                                    <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('EMAIL') }} <span class="text-red-600">*</span>
                                </label>
                                <input type="email" name="email" required placeholder="{{ __('EMAIL') }}" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-600 focus:ring-2 focus:ring-red-500/20 text-xs font-medium focus:outline-none transition" />
                                @error('email')
                                    <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-700 mb-1">
                                    {{ __('MESSAGE') }} <span class="text-red-600">*</span>
                                </label>
                                <textarea name="message" rows="3" required placeholder="{{ __('MESSAGE') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-red-600 focus:ring-2 focus:ring-red-500/20 text-xs font-medium focus:outline-none transition">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-[10px] text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-auto px-8 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs tracking-wide transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2 cursor-pointer">
                                    <span>{{ __('Kirim') }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
