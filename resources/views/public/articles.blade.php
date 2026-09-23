@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header Halaman Pencarian Artikel -->
    <section class="bg-slate-900 text-white py-14 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 flex-wrap">
                <a href="{{ route('website.home') }}" class="hover:text-white transition">{{ __('Beranda') }}</a>
                <span>/</span>
                <span class="text-slate-200">{{ __('Pencarian Artikel Ilmiah') }}</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-magnifier text-sm"></i> {{ __('Indeks Publikasi Terbuka') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Katalog & Pencarian Artikel') }}
            </h1>
            <p class="text-slate-400 text-sm max-w-3xl mt-3 leading-relaxed">
                {{ __('Telusuri seluruh naskah riset, laporan genomik, dan artikel ilmiah yang telah melalui proses telaah sejawat (peer-review) dan dipublikasikan oleh portal jurnal IGNITE - Yayasan Satriabudi Dharma Setia.') }}
            </p>
        </div>
    </section>

    <!-- Konten Utama: Filter & Hasil Pencarian -->
    <section class="py-10 bg-slate-50 min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Filter & Bar Pencarian -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <form action="{{ route('website.articles.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="grow relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Cari berdasarkan judul naskah, abstrak, kata kunci, DOI, atau nama penulis...') }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden transition" />
                            <i class="ki-filled ki-magnifier absolute left-3.5 top-3.5 text-slate-400 text-base"></i>
                        </div>
                        <button type="submit" class="px-8 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm shadow-md transition shrink-0 flex items-center justify-center gap-2">
                            <i class="ki-filled ki-magnifier text-xs"></i> {{ __('Cari Artikel') }}
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-2 border-t border-slate-100">
                        <!-- Filter Jurnal -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">{{ __('Filter Jurnal:') }}</label>
                            <select name="journal_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                                <option value="">{{ __('-- Semua Jurnal --') }}</option>
                                @foreach($journals as $j)
                                    <option value="{{ $j->id }}" {{ request('journal_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->short_name ?: $j->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">{{ __('Tahun Terbit:') }}</label>
                            <select name="year" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                                <option value="">{{ __('-- Semua Tahun --') }}</option>
                                @foreach($availableYears as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Urutan / Sort -->
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">{{ __('Urutkan Berdasarkan:') }}</label>
                            <select name="sort" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>{{ __('Terbaru Dipublikasi') }}</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Paling Banyak Dilihat (Populer)') }}</option>
                                <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>{{ __('Paling Banyak Diunduh') }}</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>{{ __('Judul Naskah (A - Z)') }}</option>
                            </select>
                        </div>

                        <!-- Reset Filter -->
                        <div class="flex items-end">
                            @if(request()->hasAny(['search', 'journal_id', 'year', 'sort']))
                                <a href="{{ route('website.articles.index') }}" class="w-full py-2 px-4 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold text-xs text-center transition flex items-center justify-center gap-1">
                                    <i class="ki-filled ki-cross-circle text-xs"></i> {{ __('Reset Filter') }}
                                </a>
                            @else
                                <div class="text-[11px] text-slate-400 py-2">
                                    {{ __('Menampilkan semua naskah terbit aktif.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Hasil & Daftar Artikel -->
            <div class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500 px-1">
                    <div>
                        <span>{{ __('Ditemukan') }} <strong class="text-slate-900 font-bold">{{ $articles->total() }}</strong> {{ __('artikel ilmiah') }}</span>
                        @if(request('search'))
                            <span>• {{ __('Kata kunci:') }} <strong class="text-red-600">"{{ request('search') }}"</strong></span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-medium">
                        <span class="text-slate-400">Feed Pengindeksan:</span>
                        <a href="{{ route('website.feed.rss') }}" target="_blank" class="text-amber-600 hover:text-amber-700 font-bold flex items-center gap-1" title="RSS 2.0 Feed Dublin Core">
                            <i class="ki-filled ki-technology-4"></i> RSS 2.0
                        </a>
                        <span class="text-slate-300">•</span>
                        <a href="{{ route('website.oai') }}?verb=Identify" target="_blank" class="text-blue-600 hover:text-blue-700 font-bold flex items-center gap-1" title="Open Archives Initiative Protocol for Metadata Harvesting (Garuda/Moraref/Google Scholar)">
                            <i class="ki-filled ki-data"></i> OAI-PMH 2.0
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($articles as $article)
                        @php
                            $journal = $article->issue?->journal;
                            $authors = $article->submission?->authors ?? collect();
                            $pdfFile = $article->submission?->files->where('file_role', 'naskah_utama')->first();
                        @endphp
                        <article class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200 shadow-xs hover:shadow-md transition space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($journal)
                                        <a href="{{ route('website.journals.show', $journal->slug) }}" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-100 hover:bg-red-100 transition">
                                            {{ $journal->short_name ?: $journal->name }}
                                        </a>
                                    @endif
                                    @if($article->issue)
                                        <a href="{{ route('website.issues.show', $article->issue->id) }}" class="text-[11px] text-slate-500 font-medium hover:underline">
                                            Vol. {{ $article->issue->volume }} No. {{ $article->issue->number }} ({{ $article->issue->publication_year }})
                                        </a>
                                    @endif
                                </div>
                                @if($article->doi)
                                    <span class="text-[11px] font-mono text-slate-400">
                                        DOI: <a href="https://doi.org/{{ $article->doi }}" target="_blank" class="text-slate-600 hover:text-red-600">{{ $article->doi }}</a>
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 hover:text-red-600 transition leading-snug">
                                <a href="{{ route('website.articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            <!-- Authors -->
                            <div class="text-xs text-slate-600 font-medium flex flex-wrap items-center gap-x-3 gap-y-1">
                                <i class="ki-filled ki-profile-user text-slate-400 text-xs"></i>
                                @forelse($authors as $author)
                                    <span class="text-slate-800 font-semibold">{{ $author->name }}@if(!$loop->last), @endif</span>
                                @empty
                                    <span class="text-slate-500">{{ $article->submission?->author?->name ?? 'Tim Peneliti Ignite' }}</span>
                                @endforelse
                            </div>

                            <!-- Abstract Preview -->
                            @if($article->abstract)
                                <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $article->abstract }}
                                </p>
                            @endif

                            <!-- Keywords -->
                            @if(!empty($article->keywords) && is_array($article->keywords))
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    @foreach(array_slice($article->keywords, 0, 4) as $kw)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-600 font-medium">
                                            #{{ trim($kw) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Footer Bar: Views, Download, Detail -->
                            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-4 text-slate-400 font-mono text-[11px]">
                                    <span><i class="ki-filled ki-eye"></i> {{ number_format($article->views_count) }} views</span>
                                    <span><i class="ki-filled ki-file-down"></i> {{ number_format($article->downloads_count) }} downloads</span>
                                    <span>Terbit: {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($pdfFile)
                                        <a href="{{ route('website.articles.view_pdf', $article->slug) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-black text-white font-bold transition flex items-center gap-1 text-xs" title="Pratinjau PDF di Tab Baru">
                                            <i class="ki-filled ki-eye text-red-500 text-xs"></i> Pratinjau
                                        </a>
                                        <a href="{{ route('website.articles.download', $article->slug) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition flex items-center gap-1 text-xs" title="Unduh Berkas PDF">
                                            <i class="ki-filled ki-file-down text-red-600"></i> Unduh
                                        </a>
                                    @endif
                                    <a href="{{ route('website.articles.show', $article->slug) }}" class="px-4 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition flex items-center gap-1 text-xs shadow-xs">
                                        {{ __('Baca Artikel') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 space-y-3">
                            <i class="ki-filled ki-search-list text-5xl text-slate-300"></i>
                            <h3 class="text-base font-bold text-slate-800">{{ __('Tidak Ada Artikel yang Cocok') }}</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto">
                                {{ __('Coba ubah kata kunci pencarian atau reset filter jurnal untuk melihat seluruh naskah yang tersedia.') }}
                            </p>
                            @if(request()->hasAny(['search', 'journal_id', 'year']))
                                <div class="pt-2">
                                    <a href="{{ route('website.articles.index') }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                                        {{ __('Lihat Semua Artikel') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="pt-6">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
