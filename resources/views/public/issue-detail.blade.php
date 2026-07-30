@extends('website::layouts.public')

@section('public_content')
    <!-- Header Issue Banner -->
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ $journal->name ?? 'Jurnal Publikasi' }}</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">{{ $issue->title }}</h1>
            <div class="flex items-center gap-4 text-xs text-slate-400 font-mono mt-3">
                <span>Vol. {{ $issue->volume }} No. {{ $issue->number }}</span>
                <span>•</span>
                <span>Tahun {{ $issue->publication_year }}</span>
                <span>•</span>
                <span>Tanggal Terbit: {{ $issue->published_at ? $issue->published_at->format('d M Y') : '-' }}</span>
            </div>
        </div>
    </section>

    <!-- Issue Articles Content -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-8">
                
                @if($issue->description)
                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Redaksi / Editorial Note</h4>
                        <p class="text-slate-700 text-sm leading-relaxed">{{ $issue->description }}</p>
                    </div>
                @endif

                <!-- Article Table of Contents Placeholder -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200 pb-4 flex items-center gap-2">
                        <i class="ki-filled ki-document text-red-600"></i> Daftar Naskah / Artikel Terbit
                    </h3>

                    <div class="divide-y divide-slate-100">
                        <!-- Sample Mock Published Articles for Public Layout Demonstration -->
                        <div class="py-6 space-y-2">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">Original Research</span>
                            <h4 class="text-lg font-bold text-slate-900 hover:text-red-600 transition cursor-pointer">
                                Analisis Sekuensing Genomik Populasi Indonesia untuk Identifikasi Varian Penyakit Langka
                            </h4>
                            <p class="text-xs text-slate-500 font-medium">Penulis: Ahmad Subroto, Maria Santos, Hendra Wijaya</p>
                            <div class="flex items-center justify-between pt-2 text-xs">
                                <span class="text-slate-400 font-mono">Halaman: 1 - 14 | DOI: 10.1234/ignite.v{{ $issue->volume }}i{{ $issue->number }}.101</span>
                                <a href="#" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-semibold transition border border-red-100 flex items-center gap-1">
                                    <i class="ki-filled ki-file-down"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="py-6 space-y-2">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">Review Article</span>
                            <h4 class="text-lg font-bold text-slate-900 hover:text-red-600 transition cursor-pointer">
                                Penerapan Pembelajaran Mesin dalam Sistem Pendukung Keputusan Medis Rumah Sakit
                            </h4>
                            <p class="text-xs text-slate-500 font-medium">Penulis: Budi Santoso, Rina Fitriani</p>
                            <div class="flex items-center justify-between pt-2 text-xs">
                                <span class="text-slate-400 font-mono">Halaman: 15 - 28 | DOI: 10.1234/ignite.v{{ $issue->volume }}i{{ $issue->number }}.102</span>
                                <a href="#" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-semibold transition border border-red-100 flex items-center gap-1">
                                    <i class="ki-filled ki-file-down"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
