@extends('website::layouts.public')

@section('public_content')
    <!-- Header Archive Banner -->
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Koleksi Terbitan</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Arsip Terbitan (Issue Archives)</h1>
            <p class="text-slate-400 text-sm mt-2 max-w-2xl">Arsip edisi jurnal berkala yang telah diterbitkan oleh seluruh jurnal di bawah naugan IGNITE.</p>
        </div>
    </section>

    <!-- Archive List -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($issues as $issue)
                    <div class="p-6 rounded-2xl border border-slate-200 bg-white hover:shadow-md transition flex items-start gap-4">
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
                            <div class="text-xs text-slate-500 flex items-center justify-between pt-2">
                                <span><i class="ki-filled ki-calendar mr-1"></i> Terbit: {{ $issue->published_at ? $issue->published_at->format('d M Y') : '-' }}</span>
                                <a href="{{ route('website.issues.show', $issue->id) }}" class="font-semibold text-red-600 hover:underline">Lihat Artikel &rarr;</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 bg-white p-12 text-center rounded-2xl border border-slate-200">
                        <p class="text-slate-500">Belum ada arsip terbitan publik.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $issues->links() }}
            </div>
        </div>
    </section>
@endsection
