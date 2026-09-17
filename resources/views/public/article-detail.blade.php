@extends('website::layouts.public')

@section('public_content')
    <!-- Header Article Banner -->
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 flex-wrap">
                <a href="{{ route('website.home') }}" class="hover:text-white transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('website.journals.index') }}" class="hover:text-white transition">Katalog Jurnal</a>
                <span>/</span>
                <a href="{{ route('website.journals.show', $journal->slug) }}" class="hover:text-white transition">{{ $journal->short_name ?: $journal->name }}</a>
                <span>/</span>
                <a href="{{ route('website.issues.show', $issue->id) }}" class="hover:text-white transition">Vol. {{ $issue->volume }} No. {{ $issue->number }} ({{ $issue->publication_year }})</a>
            </nav>

            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-500/10 text-red-400 border border-red-500/20 mb-3">
                <i class="ki-filled ki-document"></i> Naskah Terbit / Published Article
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight mt-1 max-w-5xl">
                {{ $article->title }}
            </h1>

            <!-- Authors list -->
            <div class="mt-4 flex flex-wrap items-center gap-y-2 gap-x-4 text-sm text-slate-300 font-medium">
                @forelse($authors as $author)
                    <div class="flex items-center gap-1.5">
                        <span class="text-white font-semibold">{{ $author->name }}</span>
                        @if($author->affiliation)
                            <span class="text-xs text-slate-400">({{ $author->affiliation }})</span>
                        @endif
                        @if($author->is_corresponding_author)
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-mono" title="Penulis Korespondensi">Koresponden</span>
                        @endif
                    </div>
                @empty
                    <span class="text-slate-400">{{ $article->submission?->author?->name ?? 'Tim Peneliti Ignite' }}</span>
                @endforelse
            </div>

            <!-- Meta statistics -->
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400 font-mono mt-4 pt-4 border-t border-slate-800/80">
                @if($article->doi)
                    <span class="flex items-center gap-1">
                        <strong class="text-slate-300 font-semibold">DOI:</strong>
                        <a href="https://doi.org/{{ $article->doi }}" target="_blank" class="text-red-400 hover:underline">https://doi.org/{{ $article->doi }}</a>
                    </span>
                    <span>•</span>
                @endif
                <span>Terbit: {{ $article->published_at ? $article->published_at->format('d F Y') : ($issue->published_at ? $issue->published_at->format('d F Y') : '-') }}</span>
                <span>•</span>
                <span>Halaman: {{ $article->pages ?: '1-10' }}</span>
                <span>•</span>
                <span><i class="ki-filled ki-eye text-slate-400"></i> {{ number_format($article->views_count) }} Kali Dilihat</span>
                <span>•</span>
                <span><i class="ki-filled ki-file-down text-slate-400"></i> {{ number_format($article->downloads_count) }} Kali Diunduh</span>
            </div>
        </div>
    </section>

    <!-- Main Content & Sidebar -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left 2 Cols: Abstract, Keywords, Citation -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Abstract Card -->
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
                        <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-text-align-left text-red-600"></i> Abstrak / Abstract
                        </h2>
                        <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line text-justify">
                            {{ $article->abstract ?: 'Abstrak tidak tersedia untuk naskah ini.' }}
                        </div>

                        <!-- Keywords -->
                        @if(!empty($article->keywords) && is_array($article->keywords))
                            <div class="pt-4 border-t border-slate-100">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Kata Kunci / Keywords:</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($article->keywords as $keyword)
                                        <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 text-slate-700 font-medium border border-slate-200">
                                            #{{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Citation Tool Widget -->
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4" x-data="{ format: 'apa', copied: false }">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i class="ki-filled ki-quote-up text-red-600"></i> Sitasi Naskah Ini (How to Cite)
                            </h3>
                            <div class="flex items-center gap-1 text-xs">
                                <button type="button" @click="format = 'apa'" :class="format === 'apa' ? 'bg-red-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-2.5 py-1 rounded-md transition">APA</button>
                                <button type="button" @click="format = 'ieee'" :class="format === 'ieee' ? 'bg-red-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-2.5 py-1 rounded-md transition">IEEE</button>
                                <button type="button" @click="format = 'harvard'" :class="format === 'harvard' ? 'bg-red-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-2.5 py-1 rounded-md transition">Harvard</button>
                            </div>
                        </div>

                        <!-- APA Format -->
                        <div x-show="format === 'apa'" class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-mono leading-relaxed" id="cite-apa">
                            {{ $authors->pluck('name')->implode(', ') ?: 'Ignite Author' }} ({{ $issue->publication_year }}). {{ $article->title }}. <em>{{ $journal->name }}</em>, {{ $issue->volume }}({{ $issue->number }}), {{ $article->pages ?: '1-10' }}.
                        </div>

                        <!-- IEEE Format -->
                        <div x-show="format === 'ieee'" class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-mono leading-relaxed" id="cite-ieee" style="display: none;">
                            {{ $authors->pluck('name')->implode(', ') ?: 'Ignite Author' }}, "{{ $article->title }}," <em>{{ $journal->short_name ?: $journal->name }}</em>, vol. {{ $issue->volume }}, no. {{ $issue->number }}, pp. {{ $article->pages ?: '1-10' }}, {{ $issue->publication_year }}.
                        </div>

                        <!-- Harvard Format -->
                        <div x-show="format === 'harvard'" class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-mono leading-relaxed" id="cite-harvard" style="display: none;">
                            {{ $authors->pluck('name')->implode(', ') ?: 'Ignite Author' }}, {{ $issue->publication_year }}. {{ $article->title }}. {{ $journal->name }}, {{ $issue->volume }}({{ $issue->number }}), pp.{{ $article->pages ?: '1-10' }}.
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="button" 
                                @click="
                                    let text = document.getElementById('cite-' + format).innerText;
                                    navigator.clipboard.writeText(text);
                                    copied = true;
                                    setTimeout(() => copied = false, 2000);
                                " 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                <i class="ki-filled" :class="copied ? 'ki-check text-green-600' : 'ki-copy'"></i>
                                <span x-text="copied ? 'Disalin ke Clipboard!' : 'Salin Sitasi'"></span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Right 1 Col: Download Action, Journal & Issue Metadata -->
                <div class="space-y-6">
                    
                    <!-- PDF Download Action Box -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Berkas Naskah / Full Text</h3>
                        
                        @if($pdfFile)
                            <a href="{{ route('website.articles.download', $article->slug) }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-sm shadow-md transition">
                                <i class="ki-filled ki-file-down text-lg"></i> Unduh PDF Resmi
                            </a>
                            <p class="text-[11px] text-slate-500 text-center">
                                Format: PDF • Berkas: {{ $pdfFile->original_name }}
                            </p>
                        @else
                            <div class="p-4 rounded-xl bg-slate-50 text-center text-xs text-slate-500">
                                Berkas digital naskah sedang dalam proses digitalisasi arsip.
                            </div>
                        @endif
                    </div>

                    <!-- Issue Details Card -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Informasi Terbitan</h3>
                        <div class="space-y-3 text-xs text-slate-600">
                            <div class="flex justify-between border-b border-slate-100 pb-2">
                                <span class="text-slate-400">Jurnal</span>
                                <span class="font-semibold text-slate-800 text-right">{{ $journal->name }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 pb-2">
                                <span class="text-slate-400">Volume / No</span>
                                <span class="font-semibold text-slate-800">Vol. {{ $issue->volume }} No. {{ $issue->number }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 pb-2">
                                <span class="text-slate-400">Tahun</span>
                                <span class="font-semibold text-slate-800">{{ $issue->publication_year }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 pb-2">
                                <span class="text-slate-400">ISSN (Cetak / Online)</span>
                                <span class="font-semibold text-slate-800 font-mono">{{ $journal->issn_p ?: '-' }} / {{ $journal->issn_e ?: '-' }}</span>
                            </div>
                        </div>

                        <a href="{{ route('website.issues.show', $issue->id) }}" class="block text-center py-2 px-3 rounded-lg bg-slate-50 hover:bg-slate-100 text-red-600 font-semibold text-xs transition border border-slate-200">
                            Lihat Semua Artikel di Edisi Ini →
                        </a>
                    </div>

                    <!-- Copyright & Licensing Card -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-2">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Lisensi & Hak Cipta</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Artikel ini dilisensikan di bawah lisensi Creative Commons Attribution 4.0 International (CC BY 4.0). Penulis memegang hak cipta penuh atas isi naskah.
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
