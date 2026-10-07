@extends('website::layouts.public')

@section('title', __('Dokumentasi Visitasi Lapangan') . ' - Yayasan Satriabudi Dharma Setia')

@section('public_content')
<div class="space-y-10 py-6 max-w-7xl mx-auto px-4 sm:px-6">

    <!-- Hero Header -->
    <div class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 text-white rounded-3xl p-8 sm:p-12 overflow-hidden border border-slate-800 shadow-xl">
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-600/30 border border-red-500/40 text-red-300 text-xs font-bold uppercase tracking-wider">
                <i class="ki-filled ki-geolocation text-xs"></i> {{ __('Aksi Nyata Lapangan') }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                {{ __('Dokumentasi Visitasi & Supervisi Faskes') }}
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                {{ __('Transparansi rekam jejak tim Yayasan Satriabudi Dharma Setia dalam penyerahan mesin PCR, instalasi laboratorium biomolekuler, pelatihan teknisi medis, serta program sosial pendidikan di berbagai daerah 3T Indonesia.') }}
            </p>
        </div>
        <!-- Decorative Glow -->
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('website.visitations.public') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-3">
            <div class="relative grow w-full">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="{{ __('Cari laporan visitasi, nama rumah sakit, atau kota...') }}"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none text-xs transition" />
                <span class="absolute left-3.5 top-3 text-slate-400">
                    <i class="ki-filled ki-magnifier text-sm"></i>
                </span>
            </div>

            @if($provinces->isNotEmpty())
            <div class="w-full sm:w-64">
                <select name="province" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none text-xs bg-white text-slate-700 transition">
                    <option value="">{{ __('Semua Provinsi') }}</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition">
                {{ __('Filter') }}
            </button>

            @if(request()->hasAny(['search', 'province']))
            <a href="{{ route('website.visitations.public') }}" class="w-full sm:w-auto px-3.5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-semibold text-xs text-center transition">
                {{ __('Reset') }}
            </a>
            @endif
        </form>
    </div>

    <!-- Grid Kartu Laporan Visitasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($visitations as $item)
            <article class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition overflow-hidden flex flex-col group">
                <!-- Cover Image -->
                <a href="{{ route('website.visitations.show', $item->slug) }}" class="relative block h-52 bg-slate-100 overflow-hidden shrink-0">
                    <img src="{{ $item->cover_image_url }}"
                         alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                    
                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white text-[11px] font-semibold">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-xs">
                            <i class="ki-filled ki-geolocation text-red-400"></i> {{ $item->location_label }}
                        </span>
                        @if($item->visit_date)
                        <span class="px-2.5 py-1 rounded-lg bg-red-600/90 font-mono text-[10px] uppercase font-bold tracking-wider">
                            {{ $item->visit_date->translatedFormat('d M Y') }}
                        </span>
                        @endif
                    </div>
                </a>

                <!-- Card Body -->
                <div class="p-6 flex flex-col grow space-y-4">
                    <div class="space-y-2 grow">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-red-600 block">
                            {{ $item->institution_name }}
                        </span>
                        <h2 class="text-base font-bold text-slate-900 group-hover:text-red-600 transition leading-snug line-clamp-2">
                            <a href="{{ route('website.visitations.show', $item->slug) }}">
                                {{ $item->title }}
                            </a>
                        </h2>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ $item->summary ?: Str::limit(strip_tags($item->description), 130) }}
                        </p>
                    </div>

                    @if($item->delegation_team)
                    <div class="pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex items-center gap-1.5">
                        <i class="ki-filled ki-people text-xs text-slate-400"></i>
                        <span class="line-clamp-1">{{ __('Delegasi:') }} <strong>{{ $item->delegation_team }}</strong></span>
                    </div>
                    @endif

                    <a href="{{ route('website.visitations.show', $item->slug) }}"
                       class="w-full text-center px-4 py-2.5 rounded-xl bg-slate-100 group-hover:bg-red-600 text-slate-800 group-hover:text-white font-bold text-xs transition flex items-center justify-center gap-1.5">
                        <span>{{ __('Baca Laporan Visitasi') }}</span> &rarr;
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full p-12 rounded-3xl bg-white border border-slate-200 text-center space-y-3">
                <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
                    <i class="ki-filled ki-information"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">{{ __('Belum Ada Laporan Visitasi') }}</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                    {{ __('Tidak ada dokumentasi visitasi yang sesuai dengan kriteria filter Anda.') }}
                </p>
                <a href="{{ route('website.visitations.public') }}" class="inline-block px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs">
                    {{ __('Tampilkan Semua Laporan') }}
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($visitations->hasPages())
    <div class="pt-4 flex justify-center">
        {{ $visitations->links() }}
    </div>
    @endif

</div>
@endsection
