@extends('website::layouts.public')

@section('public_content')
    <!-- Header Page Banner -->
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Katalog Ilmiah</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Daftar Jurnal Publikasi IGNITE</h1>
            <p class="text-slate-400 text-sm mt-2 max-w-2xl">Jelajahi seluruh jurnal aktif yang dikelola oleh Yayasan Satriabudi Dharma Setia beserta dewan redaksi independen.</p>
        </div>
    </section>

    <!-- Main Listing Content -->
    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($journals as $journal)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition duration-200 flex flex-col justify-between overflow-hidden">
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                    {{ $journal->short_name ?? $journal->slug }}
                                </span>
                                <div class="text-xs text-slate-400 font-mono space-y-0.5 text-right">
                                    <div>p-ISSN: {{ $journal->issn_p ?? '-' }}</div>
                                    <div>e-ISSN: {{ $journal->issn_e ?? '-' }}</div>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 hover:text-red-600 transition">
                                <a href="{{ route('website.journals.show', $journal->slug) }}">{{ $journal->name }}</a>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-4 leading-relaxed">
                                {{ $journal->description ?? 'Jurnal ilmiah berkala yang mempublikasikan hasil penelitian berkualitas.' }}
                            </p>
                        </div>
                        <div class="p-6 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span><i class="ki-filled ki-profile-user mr-1 text-slate-400"></i> {{ $journal->editorial_boards_count }} Anggota Redaksi</span>
                            <a href="{{ route('website.journals.show', $journal->slug) }}" class="font-bold text-red-600 hover:underline">Lihat Detail Jurnal &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200">
                        <p class="text-slate-500">Belum ada jurnal publikasi yang terdaftar saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $journals->links() }}
            </div>
        </div>
    </section>
@endsection
