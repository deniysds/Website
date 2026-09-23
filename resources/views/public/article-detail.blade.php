@extends('website::layouts.public')

@push('meta')
    <!-- Google Scholar & Academic Metadata -->
    <meta name="citation_title" content="{{ $article->title }}" />
    @foreach($authors as $author)
        <meta name="citation_author" content="{{ $author->name }}" />
        @if($author->affiliation)
            <meta name="citation_author_institution" content="{{ $author->affiliation }}" />
        @endif
    @endforeach
    <meta name="citation_publication_date" content="{{ $article->published_at ? $article->published_at->format('Y/m/d') : ($issue->published_at ? $issue->published_at->format('Y/m/d') : date('Y/m/d')) }}" />
    <meta name="citation_journal_title" content="{{ $journal->name }}" />
    @if($journal->issn_e)
        <meta name="citation_issn" content="{{ $journal->issn_e }}" />
    @endif
    <meta name="citation_volume" content="{{ $issue->volume }}" />
    <meta name="citation_issue" content="{{ $issue->number }}" />
    @if($article->pages)
        @php
            $pagesArr = explode('-', $article->pages);
        @endphp
        <meta name="citation_firstpage" content="{{ trim($pagesArr[0]) }}" />
        @if(isset($pagesArr[1]))
            <meta name="citation_lastpage" content="{{ trim($pagesArr[1]) }}" />
        @endif
    @endif
    @if($article->doi)
        <meta name="citation_doi" content="{{ $article->doi }}" />
    @endif
    @if($pdfFile)
        <meta name="citation_pdf_url" content="{{ route('website.articles.download', $article->slug) }}" />
    @endif
    <meta name="citation_abstract_html_url" content="{{ route('website.articles.show', $article->slug) }}" />

    <!-- Dublin Core Metadata -->
    <meta name="DC.Title" content="{{ $article->title }}" />
    @foreach($authors as $author)
        <meta name="DC.Creator" content="{{ $author->name }}" />
    @endforeach
    <meta name="DC.Date" content="{{ $article->published_at ? $article->published_at->format('Y-m-d') : date('Y-m-d') }}" />
    <meta name="DC.Description" content="{{ $article->abstract }}" />
    <meta name="DC.Source" content="{{ $journal->name }}" />
    @if($article->doi)
        <meta name="DC.Identifier" content="doi:{{ $article->doi }}" />
    @endif
@endpush

@section('public_content')
<div x-data="{ showPdfModal: false }">
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

                        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] text-slate-500 font-semibold">Unduh Sitasi:</span>
                                <a href="{{ route('website.articles.export.ris', $article->slug) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-red-50 hover:text-red-700 text-slate-700 border border-slate-200 transition" title="Format RIS untuk Mendeley, Zotero, EndNote">
                                    <i class="ki-filled ki-file-down text-xs"></i> .RIS
                                </a>
                                <a href="{{ route('website.articles.export.bib', $article->slug) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-red-50 hover:text-red-700 text-slate-700 border border-slate-200 transition" title="Format BibTeX untuk LaTeX">
                                    <i class="ki-filled ki-file-down text-xs"></i> .BIB
                                </a>
                            </div>

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
                    
                    <!-- PDF Action Box -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Berkas Naskah / Full Text</h3>
                        
                        @if($pdfFile)
                            <div class="space-y-2.5">
                                <button type="button" 
                                        @click="showPdfModal = true" 
                                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-sm shadow-md transition cursor-pointer">
                                    <i class="ki-filled ki-eye text-lg text-red-500"></i> Baca Online (PDF Viewer)
                                </button>
                                <a href="{{ route('website.articles.download', $article->slug) }}" 
                                   class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition">
                                    <i class="ki-filled ki-file-down text-base"></i> Unduh PDF Resmi
                                </a>
                            </div>
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

    @if($pdfFile)
        <!-- PDF In-Browser Viewer Modal -->
        <div x-show="showPdfModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-2 sm:p-4" 
             style="display: none;"
             @keydown.escape.window="showPdfModal = false">
            
            <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-6xl max-h-[96vh] flex flex-col overflow-hidden"
                 @click.outside="showPdfModal = false">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-3.5 bg-slate-900 text-white border-b border-slate-800 shrink-0">
                    <div class="flex items-center gap-2 min-w-0 pr-4">
                        <span class="px-2 py-0.5 rounded bg-red-600 text-[10px] font-bold uppercase tracking-wider shrink-0">PDF Galley</span>
                        <h4 class="text-sm font-bold truncate text-slate-200" title="{{ $article->title }}">
                            {{ $article->title }}
                        </h4>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('website.articles.view_pdf', $article->slug) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold flex items-center gap-1 transition" title="Buka di Tab Baru">
                            <i class="ki-filled ki-exit-right-corner text-xs"></i> <span class="hidden sm:inline">Tab Baru</span>
                        </a>
                        <a href="{{ route('website.articles.download', $article->slug) }}" class="px-2.5 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold flex items-center gap-1 transition" title="Unduh Berkas PDF">
                            <i class="ki-filled ki-file-down text-xs"></i> <span class="hidden sm:inline">Unduh</span>
                        </a>
                        <button type="button" @click="showPdfModal = false" class="p-1.5 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white transition cursor-pointer" title="Tutup Viewer">
                            <i class="ki-filled ki-cross text-base"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal PDF Viewer Body -->
                <div class="grow bg-slate-100 relative min-h-[65vh] sm:min-h-[75vh]">
                    <iframe src="{{ route('website.articles.view_pdf', $article->slug) }}#toolbar=1&navpanes=0" 
                            class="w-full h-full min-h-[65vh] sm:min-h-[75vh] border-0" 
                            title="{{ $article->title }}"
                            loading="lazy">
                    </iframe>
                </div>

                <!-- Modal Footer -->
                <div class="px-5 py-2.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500 shrink-0">
                    <span class="text-[11px] truncate">
                        {{ $journal->name }} • Vol. {{ $issue->volume }} No. {{ $issue->number }} ({{ $issue->publication_year }})
                    </span>
                    <span class="text-[11px] text-slate-400 hidden sm:inline">
                        Gunakan tombol zoom dan layar penuh bawaan peramban untuk kenyamanan membaca.
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
