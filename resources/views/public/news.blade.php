@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header Halaman Berita & Artikel Non-Jurnal -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 flex-wrap">
                <a href="{{ route('website.home') }}" class="hover:text-white transition">{{ __('Beranda') }}</a>
                <span>/</span>
                <span class="text-slate-200">{{ __('Warta & Artikel Non-Jurnal') }}</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-notepad-edit text-sm"></i> {{ __('Kabar & Warta Edukasi') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Warta, Berita & Artikel Populer') }}
            </h1>
            <p class="text-slate-400 text-sm max-w-3xl mt-3 leading-relaxed">
                {{ __('Informasi terkini, liputan kegiatan yayasan, edukasi sains kesehatan genomik, wawasan diagnostik molekuler, dan siaran pers resmi dari Yayasan Satriabudi Dharma Setia.') }}
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <div class="w-full space-y-8 pb-12">
        <!-- Filter Kategori & Pencarian -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-4">
            <form action="{{ route('website.news.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="{{ __('Cari judul artikel, topik, penulis, atau kata kunci...') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden transition" />
                    <i class="ki-filled ki-magnifier absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                </div>

                @if($categories->isNotEmpty())
                    <div class="w-full sm:w-64">
                        <select name="category" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                            <option value="">{{ __('-- Semua Kategori --') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $activeCategory === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-1.5 shrink-0">
                        <i class="ki-filled ki-magnifier"></i> {{ __('Cari') }}
                    </button>
                    @if($searchQuery || $activeCategory)
                        <a href="{{ route('website.news.index') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 text-xs font-semibold transition shrink-0">
                            {{ __('Reset') }}
                        </a>
                    @endif
                </div>
            </form>

            <!-- Kategori Pills / Badges -->
            @if($categories->isNotEmpty())
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                    <a href="{{ route('website.news.index', array_filter(['search' => $searchQuery])) }}" class="px-3 py-1.5 rounded-lg font-bold transition whitespace-nowrap {{ empty($activeCategory) ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ __('Semua') }}
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('website.news.index', array_filter(['category' => $cat, 'search' => $searchQuery])) }}" class="px-3 py-1.5 rounded-lg font-bold transition whitespace-nowrap {{ $activeCategory === $cat ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Featured Article Spotlight (jika ada dan tidak sedang filter) -->
        @if($featuredArticle && !$searchQuery && !$activeCategory)
            <div class="bg-gradient-to-tr from-slate-950 via-slate-900 to-red-950 rounded-3xl border border-slate-800 shadow-xl overflow-hidden text-white">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center">
                    <div class="p-8 sm:p-12 lg:col-span-7 space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-red-600 text-white shadow-xs">
                                {{ __('Sorotan Utama') }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase text-red-300 bg-red-950/80 border border-red-800/60">
                                {{ $featuredArticle->category }}
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-black leading-snug hover:text-red-400 transition">
                            <a href="{{ route('website.news.show', $featuredArticle->slug) }}">
                                {{ $featuredArticle->title }}
                            </a>
                        </h2>
                        @if($featuredArticle->summary)
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed line-clamp-3">
                                {{ $featuredArticle->summary }}
                            </p>
                        @endif
                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400 pt-2 border-t border-slate-800/80">
                            <span class="flex items-center gap-1.5"><i class="ki-filled ki-profile-user text-red-400"></i> {{ $featuredArticle->author_name ?: 'Tim Redaksi YSDS' }}</span>
                            <span>•</span>
                            <span class="flex items-center gap-1.5"><i class="ki-filled ki-calendar text-slate-400"></i> {{ $featuredArticle->published_at ? $featuredArticle->published_at->translatedFormat('d F Y') : '-' }}</span>
                            <span>•</span>
                            <span>{{ $featuredArticle->reading_time }}</span>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('website.news.show', $featuredArticle->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-md transition">
                                {{ __('Baca Selengkapnya') }} &rarr;
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-5 h-64 lg:h-full min-h-[280px] relative overflow-hidden bg-slate-800">
                        @if($featuredArticle->image_url)
                            <img src="{{ $featuredArticle->image_url }}" alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-red-900 to-slate-900 flex items-center justify-center p-8 text-center">
                                <i class="ki-filled ki-picture text-6xl text-red-500/30"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid Daftar Artikel -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-semibold text-slate-500">
                    {{ __('Menampilkan') }} <strong class="text-slate-900">{{ $news->total() }}</strong> {{ __('artikel') }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($news as $item)
                    <article class="bg-white rounded-2xl border border-slate-200/80 hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between group">
                        <!-- Card Cover -->
                        <div class="w-full h-48 bg-slate-900 relative overflow-hidden">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-slate-900 via-slate-800 to-red-950 p-5 flex flex-col justify-between relative overflow-hidden text-white">
                                    <div class="flex items-center justify-between relative z-10">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-red-400 bg-red-950/80 px-2.5 py-0.5 rounded-full border border-red-800/60">{{ $item->category }}</span>
                                        <i class="ki-filled ki-document text-slate-400 text-lg"></i>
                                    </div>
                                    <div class="relative z-10">
                                        <span class="text-[11px] font-mono text-slate-300 block">{{ __('Warta Yayasan') }}</span>
                                    </div>
                                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-red-600/20 rounded-full blur-xl"></div>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-red-600 text-white shadow-xs">
                                    {{ $item->category }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-3 grow flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                                    <span>{{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span>{{ $item->reading_time }}</span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-red-600 transition">
                                    <a href="{{ route('website.news.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h3>
                                @if($item->summary)
                                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                        {{ $item->summary }}
                                    </p>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs mt-3">
                                <span class="text-[11px] text-slate-500 font-medium truncate max-w-[150px]">
                                    <i class="ki-filled ki-profile-user text-slate-400"></i> {{ $item->author_name ?: 'Redaksi' }}
                                </span>
                                <a href="{{ route('website.news.show', $item->slug) }}" class="font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1 shrink-0">
                                    <span>{{ __('Baca') }}</span> &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200 space-y-3">
                        <i class="ki-filled ki-notepad-edit text-5xl text-slate-300"></i>
                        <h3 class="text-base font-bold text-slate-800">{{ __('Tidak Ada Artikel yang Ditemukan') }}</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            {{ __('Belum ada artikel yang cocok dengan kata kunci pencarian atau kategori yang dipilih.') }}
                        </p>
                        <a href="{{ route('website.news.index') }}" class="kt-btn kt-btn-outline text-xs mt-2 inline-flex items-center gap-1">
                            {{ __('Lihat Semua Artikel') }}
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="pt-8">
                    {{ $news->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
