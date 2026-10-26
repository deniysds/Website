@extends('website::layouts.public')

@section('public_content')
    <!-- Header Issue Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-10 mb-8 shadow-xl">
        <div class="relative z-10">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ $journal->name ?? __('Jurnal Publikasi') }}</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">{{ $issue->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400 font-mono mt-3">
                <span>Vol. {{ $issue->volume }} No. {{ $issue->number }}</span>
                <span>•</span>
                <span>{{ __('Tahun') }} {{ $issue->publication_year }}</span>
                <span>•</span>
                <span>{{ __('Tanggal Terbit:') }} {{ $issue->published_at ? $issue->published_at->format('d M Y') : '-' }}</span>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Issue Articles Content -->
    <div class="w-full pb-12">
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-8">
            
            @if($issue->description)
                <div class="p-6 rounded-xl bg-slate-50 border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Catatan Redaksi / Editorial Note') }}</h4>
                    <p class="text-slate-700 text-sm leading-relaxed">{{ $issue->description }}</p>
                </div>
            @endif

            <!-- Article Table of Contents -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-4 flex items-center gap-2">
                    <i class="ki-filled ki-document text-red-600"></i> {{ __('Daftar Naskah / Artikel Terbit') }}
                </h3>

                <div class="divide-y divide-slate-100">
                    @forelse($publishedSubmissions as $submission)
                        <div class="py-6 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-red-50 text-red-700 border border-red-100">{{ __('Diterima / Terbit') }}</span>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 hover:text-red-600 transition">
                                <a href="{{ route('website.articles.show', $submission->slug) }}" class="hover:underline">
                                    {{ $submission->title_localized }}
                                </a>
                            </h4>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">{{ $submission->abstract_localized }}</p>
                            <p class="text-xs text-slate-500 font-medium pt-1">
                                {{ __('Penulis:') }} {{ $submission->authors->pluck('name')->implode(', ') ?: ($submission->author?->name ?? __('Penulis')) }}
                            </p>
                            <div class="flex items-center justify-between pt-2 text-xs flex-wrap gap-2">
                                <span class="text-slate-400 font-mono">DOI: {{ $submission->doi ?: '10.1234/ignite.v' . $issue->volume . 'i' . $issue->number . '.' . $submission->id }}</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('website.articles.show', $submission->slug) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium transition flex items-center gap-1">
                                        <i class="ki-filled ki-eye"></i> {{ __('Detail Artikel') }}
                                    </a>
                                    @if($mainFile = $submission->files->where('file_role', 'naskah_utama')->first())
                                        <a href="{{ route('website.articles.download', $submission->slug) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-semibold transition border border-red-100 flex items-center gap-1">
                                            <i class="ki-filled ki-file-down"></i> {{ __('Unduh Berkas') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-500 text-sm">
                            {{ __('Belum ada naskah ilmiah yang terbit dalam edisi terbitan ini.') }}
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
