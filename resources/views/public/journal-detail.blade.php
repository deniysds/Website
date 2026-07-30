@extends('website::layouts.public')

@section('public_content')
    <!-- Header Journal Banner -->
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-600/20 text-red-400 border border-red-500/30">
                        {{ $journal->short_name ?? $journal->slug }}
                    </span>
                    <h1 class="text-3xl font-extrabold text-white">{{ $journal->name }}</h1>
                    <div class="flex flex-wrap gap-4 text-xs text-slate-400 font-mono pt-1">
                        <span>p-ISSN: {{ $journal->issn_p ?? '-' }}</span>
                        <span>•</span>
                        <span>e-ISSN: {{ $journal->issn_e ?? '-' }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition">
                            Kirim Naskah Baru
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition">
                            Login Penulis
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections: Description, Focus & Scope, Editorial Board, Current Issue -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Main Content Left (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Deskripsi & Scope -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <i class="ki-filled ki-document text-red-600"></i> Deskripsi Jurnal
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                {{ $journal->description ?? 'Jurnal ini merupakan media ilmiah terpercaya yang didedikasikan untuk pengembangan ilmu pengetahuan dan sains.' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <i class="ki-filled ki-eye text-red-600"></i> Focus & Scope
                            </h3>
                            <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                                {{ $journal->scope ?? 'Ruang lingkup jurnal mencakup penelitian teoritis, pemodelan eksperimental, dan kajian studi kasus independen.' }}
                            </div>
                        </div>

                        @if($journal->publication_ethics)
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                    <i class="ki-filled ki-shield-check text-red-600"></i> Etika Publikasi
                                </h3>
                                <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $journal->publication_ethics }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Dewan Redaksi / Editorial Board -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6">
                        <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-profile-user text-red-600"></i> Dewan Redaksi (Editorial Team)
                        </h3>

                        <div class="divide-y divide-slate-100">
                            @forelse($journal->editorialBoards as $member)
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-base">{{ $member->display_name }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $member->affiliation ?? 'Institusi / Universitas' }}</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                            {{ $member->role }}
                                        </span>
                                        <p class="text-xs text-slate-400 mt-1 font-mono">{{ $member->display_email }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm py-4">Belum ada data tim redaksi yang ditampilkan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar Right (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Terbitan Terkini (Current Issue Sidebar) -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-copy text-red-600"></i> Terbitan Terkini (Current Issue)
                        </h3>

                        @if($currentIssue)
                            <div class="space-y-3">
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                    <span class="text-xs font-bold text-red-600 uppercase">VOL. {{ $currentIssue->volume }} NO. {{ $currentIssue->number }} ({{ $currentIssue->publication_year }})</span>
                                    <h4 class="font-bold text-slate-900 text-sm mt-1 leading-snug">
                                        <a href="{{ route('website.issues.show', $currentIssue->id) }}" class="hover:text-red-600 transition">{{ $currentIssue->title }}</a>
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-2">Terbit: {{ $currentIssue->published_at ? $currentIssue->published_at->format('d M Y') : '-' }}</p>
                                </div>
                                <a href="{{ route('website.issues.show', $currentIssue->id) }}" class="block text-center w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-xs transition">
                                    Lihat Daftar Artikel Terbit &rarr;
                                </a>
                            </div>
                        @else
                            <p class="text-xs text-slate-500">Belum ada terbitan resmi yang dirilis untuk jurnal ini.</p>
                        @endif
                    </div>

                    <!-- Sidebar Arsip Terbitan -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
                        <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-calendar text-red-600"></i> Arsip Terbitan
                        </h3>

                        <ul class="space-y-2 text-xs">
                            @forelse($archives as $arc)
                                <li>
                                    <a href="{{ route('website.issues.show', $arc->id) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-slate-50 text-slate-700 hover:text-red-600 transition border border-transparent hover:border-slate-200">
                                        <span>Vol. {{ $arc->volume }} No. {{ $arc->number }} ({{ $arc->publication_year }})</span>
                                        <i class="ki-filled ki-arrow-right text-slate-400"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="text-slate-500">Belum ada arsip terbitan.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
