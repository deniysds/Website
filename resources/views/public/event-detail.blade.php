@extends('website::layouts.public')

@section('public_content')
    <div class="max-w-4xl mx-auto space-y-8 pb-16">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
            <a href="{{ route('website.home') }}" class="hover:text-red-600 transition">{{ __('Beranda') }}</a>
            <span>/</span>
            <a href="{{ route('website.events.public') }}" class="hover:text-red-600 transition">{{ __('Kegiatan & Simposium') }}</a>
            <span>/</span>
            <a href="{{ route('website.events.public', ['year' => $event->year]) }}" class="hover:text-red-600 transition">{{ $event->year }}</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $event->title }}</span>
        </nav>

        <!-- Header Kegiatan -->
        <header class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-red-50 text-red-600 border border-red-200">
                    {{ $event->tag ?: 'Kegiatan Terbaru' }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-900 text-white">
                    {{ __('Tahun') }} {{ $event->year }}
                </span>
                @if($event->is_featured)
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                        {{ __('Sorotan Utama') }}
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight tracking-tight">
                {{ $event->title }}
            </h1>
        </header>

        <!-- Summary / Lead Box -->
        @if($event->summary)
            <div class="p-5 sm:p-6 rounded-2xl bg-[#F5F5F5] border-l-4 border-red-600 shadow-xs">
                <p class="text-sm sm:text-base text-slate-700 leading-relaxed font-medium">
                    {{ $event->summary }}
                </p>
            </div>
        @endif

        <!-- Card Informasi & Metadata Pelaksanaan (Presisi Mockup) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Informasi & Detail Pelaksanaan') }}</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                        <i class="ki-filled ki-calendar text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('Tahun Pelaksanaan') }}</div>
                        <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $event->year }}</div>
                    </div>
                </div>

                @if($event->partner_name)
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-briefcase text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('Mitra Kolaborasi') }}</div>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $event->partner_name }}</div>
                        </div>
                    </div>
                @endif

                @if($event->sponsor_name)
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-shield-tick text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('Sponsor') }}</div>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $event->sponsor_name }}</div>
                        </div>
                    </div>
                @endif

                @if($event->event_date)
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-time text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('Jadwal & Waktu') }}</div>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">
                                {{ $event->event_date }}
                                @if($event->event_time)
                                    <span class="block text-xs font-normal text-slate-600 mt-0.5">{{ $event->event_time }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($event->location)
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 sm:col-span-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                            <i class="ki-filled ki-geolocation text-sm"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('Tempat / Lokasi') }}</div>
                            <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $event->location }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex flex-wrap items-center gap-3">
                @if($event->registration_url)
                    <a href="{{ $event->registration_url }}" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-2">
                        <i class="ki-filled ki-calendar text-xs"></i>
                        <span>{{ __('Registrasi Partisipan') }}</span>
                    </a>
                @endif
                <a href="{{ route('website.contact') }}" class="px-5 py-3 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-xs transition inline-flex items-center gap-1.5">
                    <i class="ki-filled ki-sms text-xs"></i>
                    <span>{{ __('Hubungi Panitia') }}</span>
                </a>
            </div>
        </div>

        <!-- Banner Image -->
        @if($event->banner_url)
            <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200/80 bg-slate-900">
                <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-full max-h-[500px] object-cover" />
            </div>
        @endif

        <!-- Deskripsi Lengkap Kegiatan -->
        @if($event->description)
            <div class="space-y-4 pt-2">
                <h3 class="text-xl font-bold text-slate-900 border-b border-slate-200/80 pb-3">{{ __('Tentang Kegiatan & Agenda') }}</h3>
                <div class="prose max-w-none text-slate-800 text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line text-justify">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>
        @endif

        <!-- Share / Bagikan -->
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i class="ki-filled ki-share text-red-600 text-base"></i>
                <span>{{ __('Bagikan Informasi Kegiatan Ini:') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($event->title . ' - ' . url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition inline-flex items-center gap-1.5 shadow-xs">
                    <span>WhatsApp</span>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs transition inline-flex items-center gap-1.5 shadow-xs">
                    <span>LinkedIn</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition inline-flex items-center gap-1.5 shadow-xs">
                    <span>X (Twitter)</span>
                </a>
            </div>
        </div>

        <!-- Kegiatan Terkait Lainnya -->
        @if($relatedEvents->isNotEmpty())
            <div class="pt-8 border-t border-slate-200/80 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">{{ __('Kegiatan & Simposium Lainnya') }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ __('Agenda ilmiah dan program riset yayasan.') }}</p>
                    </div>
                    <a href="{{ route('website.events.public') }}" class="text-xs font-bold text-red-600 hover:underline">
                        {{ __('Lihat Semua') }} &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedEvents as $rel)
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-lg transition overflow-hidden flex flex-col justify-between group">
                            <div class="p-5 space-y-2.5 grow">
                                <span class="text-[10px] font-bold uppercase text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100">
                                    {{ $rel->year }}
                                </span>
                                <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-red-600 transition">
                                    <a href="{{ route('website.events.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h4>
                                @if($rel->summary)
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $rel->summary }}</p>
                                @endif
                            </div>
                            <div class="p-5 pt-0 border-t border-slate-100 mt-2 flex items-center justify-between text-xs text-slate-500">
                                <span>{{ $rel->partner_name ?: 'YSDS' }}</span>
                                <a href="{{ route('website.events.show', $rel->slug) }}" class="font-bold text-red-600 hover:underline">
                                    {{ __('Detail') }} &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Kembali ke Katalog -->
        <div class="text-center pt-4">
            <a href="{{ route('website.events.public') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-slate-300 text-slate-700 hover:border-red-600 hover:text-red-600 font-bold text-xs transition">
                <i class="ki-filled ki-arrow-left text-xs"></i>
                <span>{{ __('Kembali ke Daftar Kegiatan') }}</span>
            </a>
        </div>
    </div>
@endsection
