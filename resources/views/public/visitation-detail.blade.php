@extends('website::layouts.public')

@section('title', $visitation->title . ' - Yayasan Satriabudi Dharma Setia')

@section('public_content')
<div class="space-y-8 py-6 max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('website.home') }}" class="hover:text-red-600 transition">{{ __('Beranda') }}</a>
        <span>/</span>
        <a href="{{ route('website.visitations.public') }}" class="hover:text-red-600 transition">{{ __('Visitasi') }}</a>
        <span>/</span>
        <span class="text-slate-900 font-semibold truncate max-w-md">{{ $visitation->institution_name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

        <!-- Kolom Utama: Laporan Visitasi (2 Kolom) -->
        <article class="lg:col-span-2 space-y-8 bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-xs">
            
            <!-- Header Artikel -->
            <div class="space-y-4 border-b border-slate-100 pb-6">
                <div class="flex items-center gap-2 flex-wrap text-xs">
                    <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 font-bold uppercase tracking-wider text-[11px] border border-red-200">
                        {{ $visitation->institution_name }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-slate-500 font-medium">
                        <i class="ki-filled ki-geolocation text-xs text-red-500"></i> {{ $visitation->location_label }}
                    </span>
                    @if($visitation->visit_date)
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-500 font-medium">
                        {{ $visitation->visit_date->translatedFormat('d F Y') }}
                    </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-snug">
                    {{ $visitation->title }}
                </h1>

                @if($visitation->summary)
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed italic border-l-4 border-red-600 pl-4 py-1">
                    {{ $visitation->summary }}
                </p>
                @endif
            </div>

            <!-- Cover Image -->
            <div class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xs max-h-[500px]">
                <img src="{{ $visitation->cover_image_url }}"
                     alt="{{ $visitation->title }}"
                     class="w-full h-full object-cover" />
            </div>

            <!-- Narasi Deskripsi Laporan -->
            <div class="prose prose-slate max-w-none text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                {{ $visitation->description }}
            </div>

            <!-- Galeri Foto Dokumentasi Lapangan (Jika ada) -->
            @if(!empty($visitation->gallery_images))
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="ki-filled ki-picture text-red-600"></i>
                    <span>{{ __('Galeri Foto Dokumentasi Lapangan') }}</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($visitation->gallery_images as $imgPath)
                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath))
                        <div class="rounded-xl overflow-hidden bg-slate-100 border border-slate-200 aspect-4/3 group cursor-pointer">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($imgPath) }}"
                                 alt="Dokumentasi {{ $visitation->institution_name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Video Dokumentasi (Jika ada) -->
            @if($visitation->video_url)
            <div class="pt-6 border-t border-slate-100 space-y-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="ki-filled ki-video text-red-600"></i>
                    <span>{{ __('Video Dokumentasi Kunjungan') }}</span>
                </h3>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                    <a href="{{ $visitation->video_url }}" target="_blank" rel="noopener" class="text-red-600 font-bold hover:underline flex items-center gap-1.5">
                        <i class="ki-filled ki-arrow-up-right"></i> {{ __('Tonton Video Liputan Lapangan di') }} {{ $visitation->video_url }}
                    </a>
                </div>
            </div>
            @endif

            <!-- Footer Kembali -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('website.visitations.public') }}" class="font-bold text-slate-700 hover:text-red-600 transition flex items-center gap-1">
                    &larr; {{ __('Kembali ke Semua Laporan Visitasi') }}
                </a>
                <a href="{{ route('website.assistance.public') }}" class="font-bold text-red-600 hover:underline">
                    {{ __('Ajukan Bantuan Faskes') }} &rarr;
                </a>
            </div>

        </article>

        <!-- Sidebar Kanan: Info Instansi & Laporan Lainnya (1 Kolom) -->
        <aside class="space-y-6">

            <!-- Card Metadata Kunjungan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4 text-xs">
                <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] border-b border-slate-100 pb-2">
                    {{ __('Detail Kunjungan Lapangan') }}
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-slate-400 block">{{ __('Instansi Tujuan:') }}</span>
                        <span class="font-bold text-slate-900">{{ $visitation->institution_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">{{ __('Wilayah:') }}</span>
                        <span class="font-medium text-slate-800">{{ $visitation->location_label }}</span>
                    </div>
                    @if($visitation->visit_date)
                    <div>
                        <span class="text-slate-400 block">{{ __('Tanggal Kunjungan:') }}</span>
                        <span class="font-medium text-slate-800">{{ $visitation->visit_date->translatedFormat('d F Y') }}</span>
                    </div>
                    @endif
                    @if($visitation->delegation_team)
                    <div>
                        <span class="text-slate-400 block">{{ __('Delegasi Tim YSDS:') }}</span>
                        <span class="font-bold text-slate-900">{{ $visitation->delegation_team }}</span>
                    </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <a href="{{ route('website.collaborations.public') }}" class="block text-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                        {{ __('Lihat BAST & Alkes') }} &rarr;
                    </a>
                </div>
            </div>

            <!-- Card Laporan Visitasi Lainnya -->
            @if($recentVisitations->isNotEmpty())
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] border-b border-slate-100 pb-2">
                    {{ __('Laporan Visitasi Lainnya') }}
                </h3>
                <div class="space-y-3">
                    @foreach($recentVisitations as $recent)
                    <a href="{{ route('website.visitations.show', $recent->slug) }}" class="block group space-y-1">
                        <span class="text-[10px] uppercase font-bold text-red-600 block">{{ $recent->institution_name }}</span>
                        <h4 class="text-xs font-semibold text-slate-900 group-hover:text-red-600 transition line-clamp-2">
                            {{ $recent->title }}
                        </h4>
                        <span class="text-[10px] text-slate-400 block">{{ $recent->location_label }}</span>
                    </a>
                    @if(!$loop->last)
                    <div class="border-b border-slate-100"></div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

        </aside>

    </div>

</div>
@endsection
