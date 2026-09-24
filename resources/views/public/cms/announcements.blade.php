@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header -->
    <section class="bg-slate-900 text-white py-14 border-b border-slate-800 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 flex-wrap">
                <a href="{{ route('website.home') }}" class="hover:text-white transition">Beranda</a>
                <span>/</span>
                <span class="text-slate-200">Pengumuman &amp; Call for Papers</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-megaphone text-sm"></i> Warta Publikasi &amp; Agenda Ilmiah
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Pengumuman &amp; Call for Papers
            </h1>
            <p class="text-slate-400 text-sm max-w-3xl mt-3 leading-relaxed">
                Informasi resmi dewan redaksi, ajakan penyerahan naskah riset (*Call for Papers*), edisi khusus terbitan (*Special Issues*), dan pengumuman sistem portal jurnal IGNITE.
            </p>
        </div>
    </section>

    <!-- Main Content & Filters -->
    <section class="py-10 bg-slate-50 min-h-[70vh]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Filter Bar -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs">
                <form action="{{ route('website.announcements') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('website.announcements') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ empty($type) ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Semua
                        </a>
                        <a href="{{ route('website.announcements', ['type' => 'call_for_papers', 'journal_id' => $journalId]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $type === 'call_for_papers' ? 'bg-purple-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Call for Papers
                        </a>
                        <a href="{{ route('website.announcements', ['type' => 'announcement', 'journal_id' => $journalId]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $type === 'announcement' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            Warta Redaksi
                        </a>
                    </div>

                    <div class="w-full sm:w-64">
                        <select name="journal_id" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 bg-white focus:ring-2 focus:ring-red-500 outline-hidden">
                            <option value="">-- Semua Jurnal --</option>
                            @foreach($journals as $j)
                                <option value="{{ $j->id }}" {{ $journalId == $j->id ? 'selected' : '' }}>
                                    {{ $j->short_name ?: $j->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($type)
                            <input type="hidden" name="type" value="{{ $type }}">
                        @endif
                    </div>
                </form>
            </div>

            <!-- Announcements List -->
            <div class="space-y-6">
                @forelse($announcements as $announcement)
                    <article class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4 relative overflow-hidden transition hover:shadow-md {{ $announcement->is_pinned ? 'ring-2 ring-amber-400/50' : '' }}">
                        @if($announcement->is_pinned)
                            <div class="absolute top-0 right-0">
                                <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-bold rounded-bl-xl uppercase tracking-wider inline-flex items-center gap-1 shadow-xs">
                                    <i class="ki-filled ki-pin text-[10px]"></i> Disematkan
                                </span>
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-2">
                            @if($announcement->type === 'call_for_papers')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                    <i class="ki-filled ki-document"></i> Call for Papers
                                </span>
                            @elseif($announcement->type === 'event')
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                    <i class="ki-filled ki-calendar"></i> Agenda
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-700 border border-red-100">
                                    <i class="ki-filled ki-notification-status"></i> Pengumuman
                                </span>
                            @endif

                            @if($announcement->journal)
                                <span class="text-xs text-slate-500 font-semibold">
                                    Jurnal: {{ $announcement->journal->short_name ?: $announcement->journal->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-500 font-semibold">
                                    Pengumuman Portal IGNITE
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $announcement->title }}
                        </h2>

                        <div class="flex items-center gap-4 text-xs text-slate-400 font-mono">
                            <span>Dipublikasikan: {{ $announcement->published_at ? $announcement->published_at->format('d F Y') : $announcement->created_at->format('d F Y') }}</span>
                            @if($announcement->deadline)
                                <span>•</span>
                                <span class="{{ $announcement->isDeadlinePassed() ? 'text-red-500 font-bold' : 'text-purple-700 font-bold' }}">
                                    Batas Pengiriman: {{ $announcement->deadline->format('d F Y') }}
                                </span>
                            @endif
                        </div>

                        @if($announcement->summary)
                            <p class="text-sm font-semibold text-slate-700 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                                {{ $announcement->summary }}
                            </p>
                        @endif

                        <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line text-justify">
                            {{ $announcement->content }}
                        </div>

                        <!-- Action Bar -->
                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                @if($announcement->attachment_file)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($announcement->attachment_file) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center gap-1.5">
                                        <i class="ki-filled ki-file-down text-red-600"></i> Unduh Panduan / Lampiran
                                    </a>
                                @endif
                            </div>

                            @if($announcement->type === 'call_for_papers')
                                <a href="{{ route('submissions.create.step1') }}" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center gap-2">
                                    <i class="ki-filled ki-send"></i> Kirim Naskah Sekarang &rarr;
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-2xl p-16 text-center border border-slate-200 space-y-3">
                        <i class="ki-filled ki-megaphone text-5xl text-slate-300"></i>
                        <h3 class="text-base font-bold text-slate-800">Tidak ada pengumuman saat ini</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            Belum ada pengumuman atau ajakan Call for Papers untuk kategori atau jurnal yang dipilih.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($announcements->hasPages())
                <div class="pt-4">
                    {{ $announcements->links() }}
                </div>
            @endif

        </div>
    </section>
@endsection
