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
    <section class="bg-[#F5F5F5] rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8 min-w-0 max-w-full">
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
                <div class="relative bg-white rounded-tl-4xl rounded-tr-xl rounded-bl-xl rounded-br-4xl p-6 pt-9 border border-slate-200/80 shadow-xs hover:shadow-xl transition duration-300 flex flex-col justify-between space-y-6">
                    <!-- Red Icon Badge protruding top-left -->
                    <div class="absolute -top-5 left-6 w-11 h-11 rounded-xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/30">
                        @if($prog->icon === 'dna')
                            <!-- Logo IGNITE (Master Vector CorelDRAW) -->
                            <svg class="w-6 h-6 text-white" viewBox="0 0 513.89 512.41" fill="currentColor">
                                <path fill="currentColor" fill-rule="nonzero" d="M115.82 496.61c16.08,-21.9 23.85,-41.68 27.08,-62.84 2.24,-14.62 2.4,-30.2 1.65,-47.69l8.78 0.45 0 -0.05c5.71,0.41 11.56,0.59 17.29,0.88l0.53 0.02c0.7,18.07 0.42,34.48 -2.02,50.43 -3.88,25.36 -13.04,48.86 -31.93,74.59l-21.38 -15.79zm-46.9 -123.72l59.4 59.4 -5.01 23.84 -76.66 -76.66c-10.51,4.1 -20.72,9.65 -30.56,17.11l-16.09 -21.08c49.36,-37.43 102.43,-34.69 155.59,-31.95 6,0.31 12,0.62 16.82,0.83 21.05,0.9 41.94,1.07 61.99,-2.26l-52.97 -52.97 5 -23.85 71.12 71.11c14.12,-4.75 27.91,-11.99 41.25,-22.85l-99.68 -99.67c-17.99,19.58 -26.37,41.02 -29.83,63.81 -2.41,15.85 -2.49,32.61 -1.73,49.96l-10.21 -0.52c-0.58,-0.06 -1.16,-0.09 -1.76,-0.09 -4.88,-0.25 -9.75,-0.5 -14.63,-0.72 -0.72,-17.93 -0.51,-35.48 2.1,-52.67 4.3,-28.35 15.02,-55.1 38.41,-79.69 24.96,-26.25 51.67,-39.99 79.32,-46.87 21.97,-5.47 44.11,-6.51 66.29,-6.09 0.31,5.24 0.67,10.62 1.06,16.17 0.25,3.49 0.49,6.96 0.72,10.42 -16.87,-0.4 -33.55,0.02 -49.68,2.74l54.11 54.11 -5.01 23.84 -72.21 -72.21c-14.44,4.9 -28.55,12.41 -42.17,23.74l99.82 99.82c18.71,-19.89 27.35,-41.71 30.88,-64.93 3.72,-24.46 1.9,-51.11 -0.04,-78.72 -2.19,-31.17 -3.56,-56.83 0.2,-81.4 3.88,-25.35 13.04,-48.86 31.93,-74.59l21.37 15.8c-16.07,21.9 -23.84,41.68 -27.08,62.83 -3.35,21.93 -2.04,46.04 0.02,75.45 2.05,29.19 3.97,57.37 -0.17,84.67 -4.31,28.35 -15.02,55.09 -38.41,79.69 -24.96,26.25 -51.67,39.99 -79.32,46.87 -27.09,6.74 -54.43,6.76 -81.79,5.59 -6.48,-0.28 -11.8,-0.55 -17.11,-0.83 -28.93,-1.49 -57.83,-2.98 -85.28,2.82zm373.73 -232.9l-57.36 -57.36 5.01 -23.84 74.92 74.92c11.21,-4.17 22.11,-9.95 32.58,-17.89l16.09 21.09c-39.99,30.31 -82.39,34.28 -125.31,33.23 -0.36,-5.72 -0.76,-11.46 -1.16,-17.25 -0.23,-3.19 -0.44,-6.31 -0.64,-9.38 18.96,0.52 37.72,0.04 55.87,-3.52z"/>
                            </svg>
                        @elseif($prog->icon === 'leaf' || $prog->icon === 'feather')
                            <!-- Logo Pendidikan (Feather / Pena Bulu Presisi Lampiran) -->
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6.5 16.2V10.8L12.5 4.8a4.2 4.2 0 0 1 6 6l-5.7 5.7H6.5z"/>
                                <path d="M4.5 18.2L15.5 7.2"/>
                                <path d="M9.5 13.2V7.8"/>
                                <path d="M11.5 11.2H17.0"/>
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
                        <p class="text-base sm:text-[14px] text-slate-600 font-light leading-relaxed">{{ __($prog->description) }}</p>
                    </div>

                    <div class="pt-2">
                        <a href="{{ $prog->link_url ?? '/catalog-journals' }}" class="text-base font-normal text-slate-900 hover:text-red-600 transition inline-block">
                            {{ __('Selengkapnya') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Section Metode / Alur Kerja (Pendekatan Terarah - Presisi Mockup Baru) -->
    <section class="relative rounded-3xl p-8 sm:p-12 lg:p-14 text-white overflow-hidden shadow-2xl min-w-0 max-w-full bg-[#050102]"
             style="background-image: url('{{ asset('assets/media/banners/workflow-bg-ysds.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch relative z-10">
            <!-- Left Column: Title at Top, Description at Bottom -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-10 lg:space-y-0 py-2">
                <div class="space-y-3 sm:space-y-4">
                    <span class="text-xs sm:text-sm font-semibold text-white tracking-wide uppercase">{{ __($settings['method_tag'] ?? 'Alur Kerja') }}</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight">
                        {{ __($settings['method_title'] ?? 'Pendekatan terarah untuk mencapai hasil yang berdampak') }}
                    </h2>
                </div>

                <div class="pt-6 lg:pt-0">
                    <p class="text-xs sm:text-[13px] text-slate-300 font-light leading-relaxed max-w-md">
                        {{ __($settings['method_desc'] ?? 'Kami mengembangkan setiap program melalui proses yang terarah, kolaboratif, dan berbasis kebutuhan. Setiap tahapan dirancang untuk memastikan program berjalan tepat sasaran dan memberikan manfaat yang nyata.') }}
                    </p>
                </div>
            </div>

            <!-- Right Column: 3 Step Cards with Vertical Dividers -->
            <div class="lg:col-span-6 flex flex-col justify-center space-y-4 sm:space-y-5">
                <!-- Card 1 (Red Active Step) -->
                <div class="p-5 sm:p-6 rounded-2xl bg-[#d80504] text-white shadow-xl flex items-center gap-5 sm:gap-6 border border-red-500/30 transition duration-300 hover:brightness-105">
                    <div class="w-12 sm:w-14 shrink-0 flex items-center justify-center">
                        <span class="text-3xl sm:text-4xl font-extrabold text-white">1</span>
                    </div>
                    <div class="w-[1.5px] self-stretch bg-white/25 shrink-0"></div>
                    <div class="space-y-1 grow min-w-0">
                        <h4 class="font-bold text-sm sm:text-base text-white leading-snug">{{ __($settings['method_step_1_title'] ?? 'Mengidentifikasi Kebutuhan yang Berdampak') }}</h4>
                        <p class="text-xs sm:text-[13px] font-medium text-white/95 leading-normal">{{ __($settings['method_step_1_subtitle'] ?? 'Memahami tantangan, kebutuhan, dan potensi') }}</p>
                        <p class="text-[11px] sm:text-xs text-red-100 font-light leading-relaxed pt-0.5">{{ __($settings['method_step_1_desc'] ?? 'Kami mempelajari kebutuhan, permasalahan, serta potensi melalui riset, pengumpulan data, dan komunikasi dengan pihak terkait.') }}</p>
                    </div>
                </div>

                <!-- Card 2 (Dark Slate Gray Step) -->
                <div class="p-5 sm:p-6 rounded-2xl bg-[#2f3035] text-white shadow-lg flex items-center gap-5 sm:gap-6 border border-slate-700/40 transition duration-300 hover:brightness-105">
                    <div class="w-12 sm:w-14 shrink-0 flex items-center justify-center">
                        <span class="text-3xl sm:text-4xl font-extrabold text-white">2</span>
                    </div>
                    <div class="w-[1.5px] self-stretch bg-white/15 shrink-0"></div>
                    <div class="space-y-1 grow min-w-0">
                        <h4 class="font-bold text-sm sm:text-base text-white leading-snug">{{ __($settings['method_step_2_title'] ?? 'Merancang dan Menjalankan Program') }}</h4>
                        <p class="text-xs sm:text-[13px] font-medium text-white/95 leading-normal">{{ __($settings['method_step_2_subtitle'] ?? 'Mewujudkan solusi yang tepat sasaran') }}</p>
                        <p class="text-[11px] sm:text-xs text-slate-300 font-light leading-relaxed pt-0.5">{{ __($settings['method_step_2_desc'] ?? 'Berdasarkan identifikasi, kami menyusun strategi dan melaksanakan program bersama mitra, ahli, komunitas, serta pemangku kepentingan.') }}</p>
                    </div>
                </div>

                <!-- Card 3 (Medium Slate Gray Step) -->
                <div class="p-5 sm:p-6 rounded-2xl bg-[#484a52] text-white shadow-lg flex items-center gap-5 sm:gap-6 border border-slate-600/40 transition duration-300 hover:brightness-105">
                    <div class="w-12 sm:w-14 shrink-0 flex items-center justify-center">
                        <span class="text-3xl sm:text-4xl font-extrabold text-white">3</span>
                    </div>
                    <div class="w-[1.5px] self-stretch bg-white/15 shrink-0"></div>
                    <div class="space-y-1 grow min-w-0">
                        <h4 class="font-bold text-sm sm:text-base text-white leading-snug">{{ __($settings['method_step_3_title'] ?? 'Mengevaluasi dan Mengembangkan') }}</h4>
                        <p class="text-xs sm:text-[13px] font-medium text-white/95 leading-normal">{{ __($settings['method_step_3_subtitle'] ?? 'Mengukur hasil untuk perbaikan berkelanjutan') }}</p>
                        <p class="text-[11px] sm:text-xs text-slate-200 font-light leading-relaxed pt-0.5">{{ __($settings['method_step_3_desc'] ?? 'Kami memantau pelaksanaan, mengukur hasil, dan mengevaluasi program sebagai dasar untuk meningkatkan kualitas serta efektivitasnya.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Section Publikasi Jurnal Terbaru (Carousel Sesuai Lampiran Kedua) -->
    <section class="bg-white py-10 px-4 sm:px-8 space-y-8 min-w-0 max-w-full overflow-hidden"
             x-data="{
                active: 0,
                total: {{ count($journals) > 0 ? count($journals) : 1 }},
                touchStartX: 0,
                next() {
                    this.active = (this.active + 1) % this.total;
                },
                prev() {
                    this.active = (this.active - 1 + this.total) % this.total;
                },
                goTo(index) {
                    this.active = index;
                },
                getDiff(index) {
                    let diff = index - this.active;
                    if (diff < -Math.floor(this.total / 2)) diff += this.total;
                    if (diff > Math.floor((this.total - 1) / 2)) diff -= this.total;
                    return diff;
                }
             }"
             @touchstart="touchStartX = $event.changedTouches[0].screenX"
             @touchend="if ($event.changedTouches[0].screenX - touchStartX < -40) next(); if ($event.changedTouches[0].screenX - touchStartX > 40) prev();"
    >
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Jurnal') }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">{{ __('Publikasi Jurnal Terbaru') }}</h2>
            </div>
            <a href="{{ route('website.journals.index') }}" class="px-5 py-2.5 rounded-xl border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                <span>{{ __('Jurnal Lainnya') }}</span>
                <span class="text-sm">↗</span>
            </a>
        </div>

        @if(count($journals) > 0)
            <!-- Carousel Container with Arrows -->
            <div class="relative w-full flex items-center justify-between gap-2 sm:gap-4 py-2">
                <!-- Tombol Navigasi Kiri -->
                <button type="button" @click="prev()" aria-label="Jurnal Sebelumnya" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-100/90 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-xs z-30 shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <!-- Stage Kartu Carousel 3D / Coverflow -->
                <div class="relative grow h-[360px] sm:h-[320px] flex items-center justify-center overflow-hidden">
                    @foreach($journals as $index => $journal)
                        <div class="absolute w-[92%] sm:w-[480px] md:w-[540px] max-w-[560px] bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 transition-all duration-500 ease-out flex flex-col justify-between"
                             :style="(() => {
                                 const diff = getDiff({{ $index }});
                                 if (diff === 0) {
                                     return 'transform: translateX(0%) scale(1.04); z-index: 20; opacity: 1; pointer-events: auto;';
                                 } else if (diff === -1) {
                                     return 'transform: translateX(-56%) scale(0.9); z-index: 10; opacity: 0.55; cursor: pointer;';
                                 } else if (diff === 1) {
                                     return 'transform: translateX(56%) scale(0.9); z-index: 10; opacity: 0.55; cursor: pointer;';
                                 } else {
                                     return 'transform: translateX(' + (diff * 80) + '%) scale(0.7); z-index: 0; opacity: 0; pointer-events: none;';
                                 }
                             })()"
                             :class="getDiff({{ $index }}) === 0 ? 'shadow-2xl' : 'shadow-md'"
                             @click="if (getDiff({{ $index }}) !== 0) goTo({{ $index }})"
                        >
                            <!-- Header Kartu -->
                            <div class="flex items-center justify-between text-xs font-bold">
                                <div class="flex items-center gap-1.5 text-red-600">
                                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-bold text-red-600 text-xs tracking-wide uppercase">{{ $journal->short_name ?: 'Jurnal' }}</span>
                                </div>
                                <span class="text-xs font-bold text-red-600">{{ $journal->created_at ? $journal->created_at->format('Y') : date('Y') }}</span>
                            </div>

                            <!-- Konten Judul & Ringkasan -->
                            <div class="space-y-2 py-3 grow flex flex-col justify-center">
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-snug line-clamp-2 hover:text-red-600 transition">
                                    <a href="{{ route('website.journals.show', $journal->slug) }}">{{ $journal->name }}</a>
                                </h3>
                                <p class="text-xs italic text-red-600 line-clamp-2 leading-relaxed font-normal">
                                    {{ $journal->description ?? 'Publikasi riset inovasi genomik dan kesehatan presisi terstandarisasi.' }}
                                </p>
                            </div>

                            <!-- Footer Badges & Selengkapnya -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-red-600 text-white uppercase tracking-wider">
                                        {{ __('Kategori') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-900 text-white uppercase tracking-wider">
                                        {{ $journal->short_name ?: __('Riset') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border border-slate-300 text-slate-700 bg-white">
                                        {{ $journal->issn_e ? 'ISSN: ' . $journal->issn_e : 'DOI' }}
                                    </span>
                                </div>
                                <a href="{{ route('website.journals.show', $journal->slug) }}" class="font-bold text-slate-800 hover:text-red-600 transition inline-flex items-center gap-1">
                                    <span>{{ __('Selengkapnya') }}</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Navigasi Kanan -->
                <button type="button" @click="next()" aria-label="Jurnal Selanjutnya" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-100/90 hover:bg-slate-200 text-slate-700 flex items-center justify-center transition shadow-xs z-30 shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <!-- Indikator Dots -->
            <div class="flex items-center justify-center gap-2 pt-2">
                @for($i = 0; $i < count($journals); $i++)
                    <button type="button"
                            @click="goTo({{ $i }})"
                            :class="active === {{ $i }} ? 'w-5 h-1.5 bg-red-600 rounded-full' : 'w-1.5 h-1.5 bg-black rounded-full hover:bg-slate-700'"
                            class="transition-all duration-300 cursor-pointer"
                            aria-label="Slide {{ $i + 1 }}"></button>
                @endfor
            </div>
        @else
            <div class="bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                <p class="text-slate-500 text-sm">{{ __('Belum ada jurnal aktif yang dipublikasikan.') }}</p>
            </div>
        @endif
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
        <!-- 8. Section Mitra Kami (Flat Tanpa Rounded & Tanpa Border Sesuai Lampiran) -->
        <section class="bg-black text-white px-4 py-10 sm:px-8 sm:py-14 space-y-8 sm:space-y-10 overflow-hidden relative min-w-0 max-w-full">
            <style>
                @keyframes marquee-scroll-left {
                    0% { transform: translateX(0%); }
                    100% { transform: translateX(-50%); }
                }
                @keyframes marquee-scroll-right {
                    0% { transform: translateX(-50%); }
                    100% { transform: translateX(0%); }
                }
                .marquee-stream {
                    width: 100%;
                    max-width: 100%;
                    overflow: hidden;
                    position: relative;
                }
                .marquee-stream-track-l {
                    display: flex;
                    width: max-content;
                    animation: marquee-scroll-left 45s linear infinite;
                    will-change: transform;
                }
                .marquee-stream-track-r {
                    display: flex;
                    width: max-content;
                    animation: marquee-scroll-right 48s linear infinite;
                    will-change: transform;
                }
                .marquee-stream:hover .marquee-stream-track-l,
                .marquee-stream:hover .marquee-stream-track-r {
                    animation-play-state: paused;
                }
            </style>

            <!-- Header Section Mitra Kami -->
            <div class="text-center space-y-2.5 max-w-3xl mx-auto">
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __($settings['partners_tag'] ?? 'Mitra Kami') }}</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight">
                    {{ __($settings['partners_title'] ?? 'Kami Percaya Setiap Mitra Adalah Bagian Berharga dalam Perjalanan Jangka Panjang') }}
                </h2>
            </div>

            <!-- 1. Mitra Platform Utama (Tepat 1 Baris Horizontal) -->
            <div class="max-w-4xl mx-auto w-full pt-1">
                <div class="grid grid-cols-5 items-center justify-items-center gap-3 sm:gap-6 md:gap-8 w-full">
                    @forelse($mainPartners as $partner)
                        <div class="flex items-center justify-center w-full transition-transform hover:scale-105 duration-200" title="{{ $partner->name }}">
                            <span class="sr-only">{{ $partner->name }}</span>
                            @if($partner->website_url)
                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-full" title="{{ $partner->name }}">
                            @endif
                            @if($partner->logo_path)
                                <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-6 sm:max-h-7 md:max-h-8 max-w-[95%] sm:max-w-[130px] md:max-w-[160px] object-contain filter brightness-95 hover:brightness-100 transition" />
                            @else
                                <span class="font-bold text-white text-xs sm:text-sm tracking-tight text-center truncate">{{ $partner->name }}</span>
                            @endif
                            @if($partner->website_url)
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-5 text-center text-slate-500 text-xs">Belum ada data mitra utama.</div>
                    @endforelse
                </div>
            </div>

            @php
                // Helper duplikasi track agar animasi infinite loop 100% mulus tanpa terputus
                $prepareTrack = function ($collection, $minItems = 16) {
                    if (! $collection || $collection->isEmpty()) return collect();
                    $list = $collection;
                    while ($list->count() < $minItems) {
                        $list = $list->concat($collection);
                    }
                    return $list->concat($list);
                };

                // 2. Perguruan Tinggi: Dibagi tepat 3 baris bergerak
                $uList = $universityPartners ?? collect();
                $uTotal = $uList->count();
                $uChunk = (int) ceil($uTotal / 3);
                $univRow1 = $prepareTrack($uList->slice(0, $uChunk));
                $univRow2 = $prepareTrack($uList->slice($uChunk, $uChunk));
                $univRow3 = $prepareTrack($uList->slice($uChunk * 2));

                // 3. Perusahaan & Lainnya: Maksimal 2 baris, bergerak jika > 10
                $oList = $otherPartners ?? collect();
                $oTotal = $oList->count();
                $isOtherMoving = $oTotal > 10;
                $oChunk = (int) ceil($oTotal / 2);
                $otherRow1 = $isOtherMoving ? $prepareTrack($oList->slice(0, $oChunk)) : $oList->slice(0, $oChunk);
                $otherRow2 = $isOtherMoving ? $prepareTrack($oList->slice($oChunk)) : $oList->slice($oChunk);
            @endphp

            <!-- 2. Perguruan Tinggi (3 Baris Bergerak Mulus) -->
            @if($uList->isNotEmpty())
                <div class="space-y-2.5 max-w-6xl mx-auto pt-2">
                    <!-- Row 1: Bergerak ke Kiri -->
                    <div class="marquee-stream py-1 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
                        <div class="marquee-stream-track-l flex gap-3.5 sm:gap-4.5 items-center" style="animation-duration: 48s;">
                            @foreach($univRow1 as $partner)
                                <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 flex items-center justify-center shrink-0 rounded-full hover:scale-120 transition-transform duration-200 group relative" title="{{ $partner->name }}">
                                    <span class="sr-only">{{ $partner->name }}</span>
                                    @if($partner->website_url)
                                        <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
                                    @endif
                                    @if($partner->logo_path)
                                        <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain filter brightness-95 group-hover:brightness-110 transition drop-shadow-xs" loading="lazy" />
                                    @else
                                        <div class="w-full h-full rounded-full bg-slate-900 border border-slate-800 text-[9px] font-bold text-slate-300 flex items-center justify-center">
                                            {{ substr($partner->name, 0, 2) }}
                                        </div>
                                    @endif
                                    @if($partner->website_url)
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Row 2: Bergerak ke Kanan (Arah Berlawanan) -->
                    @if($univRow2->isNotEmpty())
                        <div class="marquee-stream py-1 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
                            <div class="marquee-stream-track-r flex gap-3.5 sm:gap-4.5 items-center" style="animation-duration: 52s;">
                                @foreach($univRow2 as $partner)
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 flex items-center justify-center shrink-0 rounded-full hover:scale-120 transition-transform duration-200 group relative" title="{{ $partner->name }}">
                                        <span class="sr-only">{{ $partner->name }}</span>
                                        @if($partner->website_url)
                                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
                                        @endif
                                        @if($partner->logo_path)
                                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain filter brightness-95 group-hover:brightness-110 transition drop-shadow-xs" loading="lazy" />
                                        @else
                                            <div class="w-full h-full rounded-full bg-slate-900 border border-slate-800 text-[9px] font-bold text-slate-300 flex items-center justify-center">
                                                {{ substr($partner->name, 0, 2) }}
                                            </div>
                                        @endif
                                        @if($partner->website_url)
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Row 3: Bergerak ke Kiri -->
                    @if($univRow3->isNotEmpty())
                        <div class="marquee-stream py-1 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
                            <div class="marquee-stream-track-l flex gap-3.5 sm:gap-4.5 items-center" style="animation-duration: 46s;">
                                @foreach($univRow3 as $partner)
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 flex items-center justify-center shrink-0 rounded-full hover:scale-120 transition-transform duration-200 group relative" title="{{ $partner->name }}">
                                        <span class="sr-only">{{ $partner->name }}</span>
                                        @if($partner->website_url)
                                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="w-full h-full flex items-center justify-center">
                                        @endif
                                        @if($partner->logo_path)
                                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain filter brightness-95 group-hover:brightness-110 transition drop-shadow-xs" loading="lazy" />
                                        @else
                                            <div class="w-full h-full rounded-full bg-slate-900 border border-slate-800 text-[9px] font-bold text-slate-300 flex items-center justify-center">
                                                {{ substr($partner->name, 0, 2) }}
                                            </div>
                                        @endif
                                        @if($partner->website_url)
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- 3. Perusahaan & Lainnya (Maksimal 2 Baris, Bergerak jika > 10) -->
            @if($oList->isNotEmpty())
                <div class="space-y-3 max-w-6xl mx-auto pt-2">
                    @if($isOtherMoving)
                        <!-- Row 1: Bergerak ke Kiri -->
                        <div class="marquee-stream py-1 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
                            <div class="marquee-stream-track-l flex gap-6 sm:gap-8 md:gap-10 items-center" style="animation-duration: 44s;">
                                @foreach($otherRow1 as $partner)
                                    <div class="flex items-center justify-center shrink-0 h-9 sm:h-10 px-2 hover:scale-105 transition-transform duration-200 group" title="{{ $partner->name }}">
                                        <span class="sr-only">{{ $partner->name }}</span>
                                        @if($partner->website_url)
                                            <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center">
                                        @endif
                                        @if($partner->logo_path)
                                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-6 sm:max-h-7 md:max-h-8 max-w-[100px] sm:max-w-[120px] object-contain filter brightness-95 group-hover:brightness-100 transition" loading="lazy" />
                                        @else
                                            <span class="text-xs font-semibold text-slate-300 whitespace-nowrap">{{ $partner->name }}</span>
                                        @endif
                                        @if($partner->website_url)
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Row 2: Bergerak ke Kanan (Arah Berlawanan) -->
                        @if($otherRow2->isNotEmpty())
                            <div class="marquee-stream py-1 [mask-image:linear-gradient(to_right,transparent,black_6%,black_94%,transparent)]">
                                <div class="marquee-stream-track-r flex gap-6 sm:gap-8 md:gap-10 items-center" style="animation-duration: 48s;">
                                    @foreach($otherRow2 as $partner)
                                        <div class="flex items-center justify-center shrink-0 h-9 sm:h-10 px-2 hover:scale-105 transition-transform duration-200 group" title="{{ $partner->name }}">
                                            <span class="sr-only">{{ $partner->name }}</span>
                                            @if($partner->website_url)
                                                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center">
                                            @endif
                                            @if($partner->logo_path)
                                                <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-6 sm:max-h-7 md:max-h-8 max-w-[100px] sm:max-w-[120px] object-contain filter brightness-95 group-hover:brightness-100 transition" loading="lazy" />
                                            @else
                                                <span class="text-xs font-semibold text-slate-300 whitespace-nowrap">{{ $partner->name }}</span>
                                            @endif
                                            @if($partner->website_url)
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Tampilan Statis Maksimal 2 Baris jika Jumlah <= 10 -->
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8">
                                @foreach($otherRow1 as $partner)
                                    <div class="flex items-center justify-center h-9 sm:h-10 px-2" title="{{ $partner->name }}">
                                        <span class="sr-only">{{ $partner->name }}</span>
                                        @if($partner->logo_path)
                                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-7 max-w-[110px] object-contain" />
                                        @else
                                            <span class="text-xs font-semibold text-slate-300">{{ $partner->name }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($otherRow2->isNotEmpty())
                                <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8">
                                    @foreach($otherRow2 as $partner)
                                        <div class="flex items-center justify-center h-9 sm:h-10 px-2" title="{{ $partner->name }}">
                                            <span class="sr-only">{{ $partner->name }}</span>
                                            @if($partner->logo_path)
                                                <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-7 max-w-[110px] object-contain" />
                                            @else
                                                <span class="text-xs font-semibold text-slate-300">{{ $partner->name }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
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
