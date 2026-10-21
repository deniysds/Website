@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header Halaman Kegiatan & Simposium -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4 flex-wrap">
                <a href="{{ route('website.home') }}" class="hover:text-white transition">{{ __('Beranda') }}</a>
                <span>/</span>
                <span class="text-slate-200">{{ __('Kegiatan & Simposium') }}</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-calendar text-sm"></i> {{ __('Agenda Ilmiah & Forum Riset') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Kegiatan, Simposium & Kolaborasi') }}
            </h1>
            <p class="text-slate-400 text-sm max-w-3xl mt-3 leading-relaxed">
                {{ __('Forum ilmiah internasional, simposium BioAI dan genomik presisi, lokakarya teknologi laboratorium molekuler, serta agenda strategis Yayasan Satriabudi Dharma Setia.') }}
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <div class="w-full space-y-8 pb-12">
        <!-- Filter Tahun & Pencarian -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs space-y-4">
            <form action="{{ route('website.events.public') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ $searchQuery }}" placeholder="{{ __('Cari nama kegiatan, mitra, sponsor, atau lokasi...') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden transition" />
                    <i class="ki-filled ki-magnifier absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                </div>

                @if(!empty($availableYears))
                    <div class="w-full sm:w-48">
                        <select name="year" onchange="this.form.submit()" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                            <option value="">{{ __('-- Semua Tahun --') }}</option>
                            @foreach($availableYears as $yr)
                                <option value="{{ $yr }}" {{ $activeYear == $yr ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-1.5 shrink-0">
                        <i class="ki-filled ki-magnifier"></i> {{ __('Cari') }}
                    </button>
                    @if($searchQuery || $activeYear)
                        <a href="{{ route('website.events.public') }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 text-xs font-semibold transition shrink-0">
                            {{ __('Reset') }}
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tahun Pills -->
            @if(!empty($availableYears))
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                    <a href="{{ route('website.events.public', array_filter(['search' => $searchQuery])) }}" class="px-3 py-1.5 rounded-lg font-bold transition whitespace-nowrap {{ empty($activeYear) ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ __('Semua Tahun') }}
                    </a>
                    @foreach($availableYears as $yr)
                        <a href="{{ route('website.events.public', array_filter(['year' => $yr, 'search' => $searchQuery])) }}" class="px-3 py-1.5 rounded-lg font-bold transition whitespace-nowrap {{ $activeYear == $yr ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $yr }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Featured Event Spotlight Card -->
        @if($featuredEvent && !$searchQuery && !$activeYear)
            <div class="bg-[#F5F5F5] rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xs">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold uppercase tracking-wider mb-2">
                                <i class="ki-filled ki-star text-xs"></i> {{ $featuredEvent->tag ?: 'Kegiatan Terbaru' }}
                            </div>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                                <a href="{{ route('website.events.show', $featuredEvent->slug) }}" class="hover:text-red-600 transition">
                                    {{ $featuredEvent->title }}
                                </a>
                            </h2>
                        </div>

                        <!-- Key-Value Metadata Table matching mockup -->
                        <div class="space-y-3 pt-2 text-sm border-t border-slate-200/80">
                            <div class="flex items-center justify-between sm:justify-start gap-4 border-b border-slate-200/80 pb-2.5">
                                <span class="text-slate-500 font-medium w-40">{{ __('Tahun Pelaksanaan') }}</span>
                                <span class="font-bold text-slate-900">: {{ $featuredEvent->year }}</span>
                            </div>
                            @if($featuredEvent->partner_name)
                                <div class="flex items-center justify-between sm:justify-start gap-4 border-b border-slate-200/80 pb-2.5">
                                    <span class="text-slate-500 font-medium w-40">{{ __('Mitra') }}</span>
                                    <span class="font-bold text-slate-900">: {{ $featuredEvent->partner_name }}</span>
                                </div>
                            @endif
                            @if($featuredEvent->sponsor_name)
                                <div class="flex items-center justify-between sm:justify-start gap-4 pb-1">
                                    <span class="text-slate-500 font-medium w-40">{{ __('Sponsor') }}</span>
                                    <span class="font-bold text-slate-900">: {{ $featuredEvent->sponsor_name }}</span>
                                </div>
                            @endif
                        </div>

                        @if($featuredEvent->summary)
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                {{ $featuredEvent->summary }}
                            </p>
                        @endif

                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('website.events.show', $featuredEvent->slug) }}" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-2">
                                <span>{{ __('Lihat Detail Kegiatan') }}</span>
                                <i class="ki-filled ki-arrow-right text-xs"></i>
                            </a>
                            @if($featuredEvent->registration_url)
                                <a href="{{ $featuredEvent->registration_url }}" class="px-5 py-3 rounded-xl border border-slate-300 hover:border-red-600 text-slate-700 hover:text-red-600 font-semibold text-xs bg-white transition inline-flex items-center gap-1.5">
                                    <span>{{ __('Daftar Partisipan') }}</span> &rarr;
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right Media Box -->
                    <div class="lg:col-span-5 w-full">
                        <div class="w-full rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-red-950 border border-slate-700/80 p-6 sm:p-8 shadow-xl relative overflow-hidden group min-h-[300px] flex flex-col justify-between">
                            @if($featuredEvent->banner_url)
                                <img src="{{ $featuredEvent->banner_url }}" alt="{{ $featuredEvent->title }}" class="absolute inset-0 w-full h-full object-cover rounded-2xl opacity-75 group-hover:scale-105 transition duration-500" />
                            @endif
                            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-red-600/20 rounded-full blur-3xl group-hover:bg-red-600/30 transition duration-700"></div>
                            <div class="relative z-10 space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-red-600 text-white shadow-xs">
                                        {{ $featuredEvent->year }}
                                    </span>
                                    <span class="text-xs font-mono text-slate-300">YSDS Event</span>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                                    {{ $featuredEvent->title }}
                                </h3>
                            </div>
                            <div class="relative z-10 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                                @if($featuredEvent->event_date)
                                    <span class="flex items-center gap-1"><i class="ki-filled ki-calendar text-red-400"></i> {{ $featuredEvent->event_date }}</span>
                                @endif
                                @if($featuredEvent->location)
                                    <span class="flex items-center gap-1"><i class="ki-filled ki-geolocation text-red-400"></i> {{ $featuredEvent->location }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid of Events -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">{{ __('Daftar Kegiatan & Simposium') }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __('Menampilkan agenda ilmiah dan lokakarya riset berkala.') }}</p>
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    Total: <span class="font-bold text-slate-900">{{ $events->total() }}</span> kegiatan
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between group">
                        <!-- Card Banner Top -->
                        <div class="w-full h-48 bg-gradient-to-tr from-slate-900 via-slate-800 to-red-950 p-5 flex flex-col justify-between relative overflow-hidden text-white border-b border-slate-200/60">
                            @if($event->banner_url)
                                <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-70" />
                            @endif
                            <div class="flex items-center justify-between relative z-10">
                                <span class="text-[10px] font-black uppercase tracking-widest text-red-300 bg-red-950/80 px-2.5 py-0.5 rounded-full border border-red-800/60">
                                    {{ $event->tag ?: 'Kegiatan' }}
                                </span>
                                <span class="text-xs font-bold text-white bg-black/40 backdrop-blur-sm px-2.5 py-0.5 rounded-full">
                                    {{ $event->year }}
                                </span>
                            </div>
                            <div class="relative z-10">
                                <span class="text-[11px] font-mono text-slate-300 block">YSDS Genomic Hub</span>
                            </div>
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-red-600/20 rounded-full blur-xl"></div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-3 grow">
                            <h4 class="font-bold text-slate-900 text-base leading-snug group-hover:text-red-600 transition">
                                <a href="{{ route('website.events.show', $event->slug) }}">
                                    {{ $event->title }}
                                </a>
                            </h4>

                            <!-- Metadata row -->
                            <div class="space-y-1 text-xs text-slate-600 pt-1">
                                @if($event->partner_name)
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-slate-400 font-medium">Mitra:</span>
                                        <span class="font-semibold text-slate-800">{{ $event->partner_name }}</span>
                                    </div>
                                @endif
                                @if($event->sponsor_name)
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-slate-400 font-medium">Sponsor:</span>
                                        <span class="font-semibold text-slate-800">{{ $event->sponsor_name }}</span>
                                    </div>
                                @endif
                                @if($event->event_date)
                                    <div class="flex items-center gap-1.5 text-slate-500 pt-1">
                                        <i class="ki-filled ki-calendar text-red-500 text-xs"></i>
                                        <span>{{ $event->event_date }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($event->summary)
                                <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 pt-1">
                                    {{ $event->summary }}
                                </p>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="p-6 pt-0 flex items-center justify-between text-xs text-slate-500 border-t border-slate-100 mt-2">
                            <span class="truncate max-w-[150px]">{{ $event->location ?: 'Indonesia' }}</span>
                            <a href="{{ route('website.events.show', $event->slug) }}" class="font-bold text-slate-900 hover:text-red-600 flex items-center gap-1">
                                <span>{{ __('Selengkapnya') }}</span> &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-slate-50 p-12 text-center rounded-2xl border border-slate-200">
                        <i class="ki-filled ki-calendar text-slate-300 text-4xl mb-2 block"></i>
                        <p class="text-slate-600 text-sm font-semibold">{{ __('Tidak ada kegiatan yang sesuai dengan kriteria pencarian.') }}</p>
                        @if($searchQuery || $activeYear)
                            <a href="{{ route('website.events.public') }}" class="mt-3 inline-block px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-bold">
                                {{ __('Lihat Semua Kegiatan') }}
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($events->hasPages())
                <div class="mt-8 pt-4">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
