@extends('website::layouts.public')

@section('public_content')
    <!-- Hero Banner Section -->
    <section class="relative bg-slate-900 overflow-hidden py-20 lg:py-28 text-white">
        <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(#e11d48_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-8 space-y-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-600/20 text-red-400 border border-red-500/30">
                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></span> Yayasan Satriabudi Dharma Setia
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.
                    </h1>
                    <p class="text-lg text-slate-300 max-w-2xl leading-relaxed">
                        IGNITE Publishing Portal menyediakan platform publikasi ilmiah terpercaya, berbasis peer-review independen untuk mendukung riset genomic, kesehatan masyarakat, dan sains terapan.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('website.journals.index') }}" class="px-6 py-3.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-lg shadow-red-600/30 transition flex items-center gap-2">
                            Eksplorasi Jurnal <i class="ki-filled ki-arrow-right"></i>
                        </a>
                        <a href="{{ route('website.guidelines') }}" class="px-6 py-3.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-sm border border-slate-700 transition">
                            Panduan Penulis
                        </a>
                    </div>
                </div>

                <!-- Stats Counter Overlay -->
                <div class="lg:col-span-4 grid grid-cols-1 gap-4">
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-2xl">
                        <div class="text-3xl font-extrabold text-red-500">{{ $stats['total_journals'] }}+</div>
                        <div class="text-sm font-medium text-slate-300 mt-1">Jurnal Ilmiah Aktif</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-2xl">
                        <div class="text-3xl font-extrabold text-white">{{ $stats['total_issues'] }}+</div>
                        <div class="text-sm font-medium text-slate-300 mt-1">Terbitan (Issues) Dipublikasikan</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-2xl">
                        <div class="text-3xl font-extrabold text-rose-400">{{ $stats['total_articles'] }}+</div>
                        <div class="text-sm font-medium text-slate-300 mt-1">Artikel & Naskah Terindeks</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Program / Nilai Utama Section -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Komitmen Kami</span>
                <h2 class="text-3xl font-bold text-slate-900">Menciptakan Generasi Muda Unggul Berbasis Sains</h2>
                <p class="text-slate-600 text-sm">Portal IGNITE dirancang untuk menjamin transparansi, aksesibilitas penuh, dan integritas tinggi bagi peneliti dan praktisi di seluruh Indonesia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xl">
                        <i class="ki-filled ki-shield-check"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Kualitas Peer-Review</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Proses penelaahan independen oleh dewan redaksi & pakar di bidangnya untuk menjaga standar akademik tinggi.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xl">
                        <i class="ki-filled ki-eye"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Akses Terbuka (Open Access)</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Mendukung aksesibilitas bebas bagi publik, mahasiswa, dan peneliti untuk meningkatkan sitasi riset nasional.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:shadow-md transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xl">
                        <i class="ki-filled ki-document"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Standar Pengindeksan</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Pengelolaan metadata terstruktur dengan p-ISSN, e-ISSN, dan kesiapan integrasi ke DOI & SINTA.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Jurnal Terbaru Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Publikasi Jurnal Terbaru</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-1">Jurnal Ilmiah Terdaftar</h2>
                </div>
                <a href="{{ route('website.journals.index') }}" class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
                    Lihat Semua Jurnal <i class="ki-filled ki-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($journals as $journal)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition duration-200 flex flex-col justify-between overflow-hidden">
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                    {{ $journal->short_name ?? $journal->slug }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono">
                                    e-ISSN: {{ $journal->issn_e ?? '-' }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 hover:text-red-600 transition">
                                <a href="{{ route('website.journals.show', $journal->slug) }}">{{ $journal->name }}</a>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $journal->description ?? 'Jurnal ilmiah berkala yang mempublikasikan hasil penelitian berkualitas.' }}
                            </p>
                        </div>
                        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span><i class="ki-filled ki-profile-user mr-1 text-slate-400"></i> {{ $journal->editorial_boards_count }} Anggota Redaksi</span>
                            <a href="{{ route('website.journals.show', $journal->slug) }}" class="font-bold text-red-600 hover:underline">Detail Jurnal &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                        <p class="text-slate-500">Belum ada jurnal aktif yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Edisi Terbitan Terkini (Issues) Section -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Terbitan Terbaru</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-1">Edisi Jurnal yang Baru Rilis</h2>
                </div>
                <a href="{{ route('website.issues.archive') }}" class="text-sm font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
                    Arsip Terbitan Lengkap <i class="ki-filled ki-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($latestIssues as $issue)
                    <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:shadow-md transition flex items-start gap-4">
                        <div class="w-16 h-20 rounded-lg bg-slate-900 text-white flex flex-col items-center justify-center shrink-0 shadow-md">
                            <span class="text-xs font-bold uppercase text-red-400">VOL. {{ $issue->volume }}</span>
                            <span class="text-lg font-black">NO. {{ $issue->number }}</span>
                            <span class="text-[10px] text-slate-400">{{ $issue->publication_year }}</span>
                        </div>
                        <div class="space-y-2 grow">
                            <div class="text-xs font-bold text-red-600 uppercase">{{ $issue->journal?->name }}</div>
                            <h4 class="font-bold text-slate-900 text-base leading-snug hover:text-red-600 transition">
                                <a href="{{ route('website.issues.show', $issue->id) }}">{{ $issue->title }}</a>
                            </h4>
                            <div class="text-xs text-slate-500 flex items-center gap-4 pt-1">
                                <span><i class="ki-filled ki-calendar mr-1"></i> {{ $issue->published_at ? $issue->published_at->format('d M Y') : '-' }}</span>
                                <a href="{{ route('website.issues.show', $issue->id) }}" class="font-semibold text-red-600 hover:underline">Lihat Isi Terbitan &rarr;</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-slate-50 p-8 text-center rounded-2xl border border-slate-200">
                        <p class="text-slate-500">Belum ada terbitan publik yang rilis.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
