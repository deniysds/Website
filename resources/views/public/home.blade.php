@extends('website::layouts.public')

@section('public_content')
    <!-- 1. Hero Section Banner Presisi Gambar 2 (Kartu Melengkung Terpusat dengan Banner Merah Overlay) -->
    <section class="relative bg-slate-900 text-white rounded-3xl overflow-hidden py-16 sm:py-24 shadow-xl border border-slate-800">
        <!-- Overlay Background Pattern & Gradient Gedung Satriabudi -->
        <div class="absolute inset-0 z-0 bg-cover bg-center opacity-30 mix-blend-luminosity filter brightness-75" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center space-y-6">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                {{ $settings['hero_title'] ?? 'Yayasan Satriabudi Dharma Setia' }}
            </h1>
            <p class="text-base sm:text-xl text-slate-200 font-light max-w-2xl mx-auto leading-relaxed">
                {{ $settings['hero_subtitle'] ?? 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.' }}
            </p>
            <div class="pt-2">
                <a href="{{ $settings['hero_button_url'] ?? '#profil' }}" class="inline-flex items-center justify-center px-7 py-3 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold text-sm shadow-xl shadow-red-600/40 transition duration-200">
                    {{ $settings['hero_button_text'] ?? 'Donasi' }} &nearr;
                </a>
            </div>

            <!-- Floating Red Stat Counter Overlay Presisi Desain Gambar 2 -->
            <div class="pt-10 max-w-3xl mx-auto">
                <div class="bg-gradient-to-r from-red-700 via-red-600 to-red-700 rounded-2xl p-6 sm:p-8 shadow-2xl border border-red-500/40 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center divide-y sm:divide-y-0 sm:divide-x divide-red-500/40">
                    <div class="pt-4 sm:pt-0">
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_1_number'] ?? '150+' }}</div>
                        <div class="text-xs font-semibold text-red-100 mt-1 uppercase tracking-wider">{{ $settings['stat_1_label'] ?? 'Kerjasama Sukses' }}</div>
                    </div>
                    <div class="pt-4 sm:pt-0 sm:pl-6">
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_2_number'] ?? '125 T' }}</div>
                        <div class="text-xs font-semibold text-red-100 mt-1 uppercase tracking-wider">{{ $settings['stat_2_label'] ?? 'Dana Terkumpul' }}</div>
                    </div>
                    <div class="pt-4 sm:pt-0 sm:pl-6">
                        <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">{{ $settings['stat_3_number'] ?? '79+' }}</div>
                        <div class="text-xs font-semibold text-red-100 mt-1 uppercase tracking-wider">{{ $settings['stat_3_label'] ?? 'Mitra Jejaring' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Section Profil (Menciptakan generasi muda unggul...) -->
    <section id="profil" class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ $settings['profile_tag'] ?? 'Profil' }}</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ $settings['profile_title'] ?? 'Menciptakan generasi muda unggul melalui pendidikan bermutu, kesehatan prima, dan lingkungan hidup yang terpelihara.' }}
                </h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    {{ $settings['profile_desc'] ?? 'Melalui aliansi strategis dengan institusi nasional dan internasional, kami menghadirkan program berbasis bukti riset ilmiah yang transparan dan akuntabel.' }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('website.about') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 border-b-2 border-red-600 pb-1 transition">
                        {{ $settings['profile_button_text'] ?? 'Selengkapnya tentang kami' }} &rarr;
                    </a>
                </div>
            </div>

            <!-- 3 Box Sisi Kanan (Pendidikan, Kesehatan, Lingkungan) -->
            <div class="lg:col-span-6 space-y-4">
                <div class="p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:shadow-md transition flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold shrink-0">
                        <i class="ki-filled ki-teacher text-lg"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base">{{ $settings['profile_box_1_title'] ?? 'Pendidikan' }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $settings['profile_box_1_desc'] ?? 'Penguatan kapabilitas SDM riset dan beasiswa tingkat tinggi secara berkesinambungan.' }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:shadow-md transition flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold shrink-0">
                        <i class="ki-filled ki-heart text-lg"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base">{{ $settings['profile_box_2_title'] ?? 'Kesehatan' }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $settings['profile_box_2_desc'] ?? 'Dukungan fasilitas kesehatan, diagnostik molekuler, dan pencegahan penyakit tropis.' }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50/80 border border-slate-200/80 hover:bg-white hover:shadow-md transition flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold shrink-0">
                        <i class="ki-filled ki-element-11 text-lg"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-base">{{ $settings['profile_box_3_title'] ?? 'Lingkungan' }}</h4>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $settings['profile_box_3_desc'] ?? 'Pelestarian keanekaragaman hayati dan penerapan riset sains ramah lingkungan.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Section Program (Kami Membangun Program untuk Dampak Nyata - 5 Kategori Cards) -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">Program</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Kami Membangun Program untuk Dampak Nyata</h2>
            </div>
            <a href="{{ route('website.about') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1 self-start sm:self-auto">
                Hubungi kami &nearr;
            </a>
        </div>

        <!-- 5 Kategori Cards (IGNITE, Pendidikan, EJA Kuliah, Kelola, DASH) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach($programs as $prog)
                <div class="bg-slate-50/70 rounded-2xl p-6 border border-slate-200/80 hover:bg-white hover:shadow-xl transition duration-300 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold shadow-md">
                            <i class="{{ $prog->icon ?? 'ki-filled ki-rocket' }} text-lg"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">{{ $prog->title }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $prog->description }}</p>
                    </div>
                    <div class="pt-2 border-t border-slate-200/60">
                        <a href="{{ $prog->link_url ?? '/catalog-journals' }}" class="text-xs font-bold text-slate-900 hover:text-red-600 flex items-center justify-between transition">
                            <span>Selengkapnya</span>
                            <span>&nearr;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Section Metode / Pendekatan Terarah (Dark Banner Card 1, 2, 3 Steps) -->
    <section class="bg-slate-950 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-xl relative overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Title & Description -->
            <div class="lg:col-span-5 space-y-6">
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ $settings['method_tag'] ?? 'Metode' }}</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                    {{ $settings['method_title'] ?? 'Pendekatan terarah untuk mencapai hasil yang optimal' }}
                </h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    {{ $settings['method_desc'] ?? 'Kami menerjemahkan komitmen menjadi dampak berkesinambungan melalui aliansi strategis bersama mitra riset terpercaya di seluruh Indonesia.' }}
                </p>
            </div>

            <!-- Right 3 Steps List (Red Active Box 1, Dark Gray 2 & 3) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="p-6 rounded-2xl bg-red-600 text-white shadow-xl flex items-start gap-5 border border-red-500">
                    <span class="text-2xl font-black text-white shrink-0">1</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ $settings['method_step_1_title'] ?? 'Mengkaji Riset & Kebutuhan' }}</h4>
                        <p class="text-xs text-red-100 leading-relaxed">{{ $settings['method_step_1_desc'] ?? 'Pemetaan isu strategis sains & kesehatan berbasis fakta ilmiah untuk pemangku kepentingan nasional.' }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 text-white flex items-start gap-5 hover:border-slate-700 transition">
                    <span class="text-2xl font-black text-slate-400 shrink-0">2</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ $settings['method_step_2_title'] ?? 'Merancang dan Menjalankan Program' }}</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">{{ $settings['method_step_2_desc'] ?? 'Eksekusi program publikasi & fasilitas riset secara transparan dengan standar akuntabilitas tinggi.' }}</p>
                    </div>
                </div>

                <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 text-white flex items-start gap-5 hover:border-slate-700 transition">
                    <span class="text-2xl font-black text-slate-400 shrink-0">3</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-base text-white">{{ $settings['method_step_3_title'] ?? 'Menevaluasi dan Mengembangkan' }}</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">{{ $settings['method_step_3_desc'] ?? 'Pemeriksaan berkala untuk memastikan efektivitas dampak program ilmiah yang kontinyu bagi masyarakat.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Section Publikasi Jurnal Terbaru -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">Jurnal</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Publikasi Jurnal Terbaru</h2>
            </div>
            <a href="{{ route('website.journals.index') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1 self-start sm:self-auto">
                Lihat Semua Jurnal &rarr;
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
                        <span class="text-slate-500 font-medium"><i class="ki-filled ki-profile-user mr-1 text-slate-400"></i> {{ $journal->editorial_boards_count }} Redaksi</span>
                        <a href="{{ route('website.journals.show', $journal->slug) }}" class="font-bold text-slate-900 hover:text-red-600 flex items-center gap-1 transition">
                            <span>Selengkapnya</span> &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                    <p class="text-slate-500 text-sm">Belum ada jurnal aktif yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. Section Proyek Terbaru / Simposium -->
    <section class="bg-slate-900 text-white rounded-3xl p-8 sm:p-12 border border-slate-800 shadow-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ $settings['project_tag'] ?? 'Proyek Terbaru' }}</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white">
                    {{ $settings['project_title'] ?? 'GenAI and Genomics Symposium - Indonesia' }}
                </h3>
                <div class="space-y-2 text-xs sm:text-sm text-slate-300 font-medium pt-2">
                    <p class="flex items-center gap-2"><i class="ki-filled ki-time text-red-500"></i> {{ $settings['project_time'] ?? '10.00 - 16.00 WIB' }}</p>
                    <p class="flex items-center gap-2"><i class="ki-filled ki-calendar text-red-500"></i> {{ $settings['project_date'] ?? 'Kamis, 15 Mei 2026' }}</p>
                    <p class="flex items-center gap-2"><i class="ki-filled ki-geolocation text-red-500"></i> {{ $settings['project_location'] ?? 'Jakarta, Indonesia' }}</p>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="w-full h-56 sm:h-64 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 font-bold text-sm">
                    <div class="text-center p-6 space-y-2">
                        <i class="ki-filled ki-picture text-4xl text-slate-500"></i>
                        <p>Banner Simposium / Proyek Utama</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Section Berita Terbaru -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest">Berita Terbaru</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900">Temukan informasi dan kegiatan terbaru dari kami.</h2>
            </div>
            <a href="{{ route('website.announcements') }}" class="px-5 py-2.5 rounded-full border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs transition inline-flex items-center gap-1 self-start sm:self-auto">
                Lihat Semua Berita &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($news as $item)
                <div class="bg-slate-50/70 rounded-2xl border border-slate-200/80 hover:bg-white hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between">
                    <div class="w-full h-40 bg-slate-200 border-b border-slate-200/60 flex items-center justify-center text-slate-400">
                        <i class="ki-filled ki-picture text-3xl"></i>
                    </div>
                    <div class="p-6 space-y-3 grow">
                        <span class="text-[10px] font-bold uppercase text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100">{{ $item->category }}</span>
                        <h4 class="font-bold text-slate-900 text-base leading-snug hover:text-red-600 transition">
                            <a href="{{ route('website.announcements') }}">{{ $item->title }}</a>
                        </h4>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $item->summary }}</p>
                    </div>
                    <div class="p-6 pt-0 flex items-center justify-between text-xs text-slate-500 border-t border-slate-200/60 mt-2">
                        <span>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</span>
                        <a href="{{ route('website.announcements') }}" class="font-bold text-slate-900 hover:text-red-600 flex items-center gap-1">
                            <span>Selengkapnya</span> &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                    <p class="text-slate-500 text-sm">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
