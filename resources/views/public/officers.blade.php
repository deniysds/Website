@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header Halaman Pengurus -->
    <section class="bg-slate-900 text-white py-14 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/20 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-people text-sm"></i> {{ __('Struktur Organisasi') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Dewan Pengurus & Redaksi Jurnal') }}
            </h1>
            <p class="text-slate-400 text-sm max-w-2xl mt-3 leading-relaxed">
                {{ __('Struktur kepengurusan resmi Yayasan Satriabudi Dharma Setia dan dewan redaksi jurnal ilmiah IGNITE yang berdedikasi mewujudkan kemajuan riset kesehatan serta publikasi ilmiah terpercaya.') }}
            </p>
        </div>
    </section>

    <!-- Konten Utama Struktur Organisasi Berjenjang (Hierarki) -->
    <section class="py-14 bg-slate-50 min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            <!-- TINGKAT 1: DEWAN PEMBINA & DEWAN PENGAWAS -->
            @if(isset($officersByHierarchy[1]) && $officersByHierarchy[1]->isNotEmpty())
                <div class="space-y-6">
                    <div class="text-center max-w-xl mx-auto">
                        <span class="text-xs font-extrabold text-amber-600 uppercase tracking-widest block">{{ __('Tingkat Puncak') }}</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">{{ __('Dewan Pembina & Pengawas Yayasan') }}</h2>
                        <div class="w-16 h-1 bg-amber-500 mx-auto mt-3 rounded-full"></div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach($officersByHierarchy[1] as $officer)
                            <div class="w-full sm:w-80 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition p-6 flex flex-col items-center text-center group">
                                <div class="relative mb-4">
                                    @if($officer->photo_path)
                                        <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-amber-100 shadow-xs group-hover:scale-105 transition" />
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center font-black text-2xl border-4 border-amber-100 shadow-xs">
                                            {{ strtoupper(substr($officer->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <span class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs shadow">
                                        <i class="ki-filled ki-crown text-xs"></i>
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-slate-900">{{ $officer->full_name_with_title }}</h3>
                                <div class="text-xs font-semibold text-red-600 mt-1 uppercase tracking-wider">{{ $officer->position }}</div>
                                
                                @if($officer->affiliation)
                                    <p class="text-[11px] text-slate-500 mt-2">{{ $officer->affiliation }}</p>
                                @endif

                                @if($officer->bio)
                                    <p class="text-xs text-slate-600 mt-3 pt-3 border-t border-slate-100 line-clamp-3 leading-relaxed">
                                        {{ $officer->bio }}
                                    </p>
                                @endif

                                @if($officer->email || $officer->linkedin_url)
                                    <div class="flex items-center gap-3 mt-4 pt-3 border-t border-slate-100">
                                        @if($officer->email)
                                            <a href="mailto:{{ $officer->email }}" class="text-slate-400 hover:text-red-600 transition text-sm" title="Kirim Email">
                                                <i class="ki-filled ki-sms"></i>
                                            </a>
                                        @endif
                                        @if($officer->linkedin_url)
                                            <a href="{{ $officer->linkedin_url }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition text-sm" title="LinkedIn Profile">
                                                <i class="ki-filled ki-element-11"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- GARIS HIERARKI PENGHUBUNG -->
            <div class="relative flex items-center justify-center">
                <div class="w-full border-t border-slate-200"></div>
                <div class="absolute bg-slate-50 px-4 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <i class="ki-filled ki-down text-slate-400"></i>
                </div>
            </div>

            <!-- TINGKAT 2: PIMPINAN HARIAN & KETUA YAYASAN -->
            @if(isset($officersByHierarchy[2]) && $officersByHierarchy[2]->isNotEmpty())
                <div class="space-y-6">
                    <div class="text-center max-w-xl mx-auto">
                        <span class="text-xs font-extrabold text-red-600 uppercase tracking-widest block">{{ __('Pimpinan Eksekutif') }}</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-1">{{ __('Ketua & Pimpinan Harian Yayasan') }}</h2>
                        <div class="w-16 h-1 bg-red-600 mx-auto mt-3 rounded-full"></div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach($officersByHierarchy[2] as $officer)
                            <div class="w-full sm:w-80 bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition p-6 flex flex-col items-center text-center group">
                                <div class="relative mb-4">
                                    @if($officer->photo_path)
                                        <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-red-100 shadow-xs group-hover:scale-105 transition" />
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-red-50 text-red-600 flex items-center justify-center font-black text-2xl border-4 border-red-100 shadow-xs">
                                            {{ strtoupper(substr($officer->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <span class="absolute bottom-0 right-0 w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center text-xs shadow">
                                        <i class="ki-filled ki-profile-user text-xs"></i>
                                    </span>
                                </div>

                                <h3 class="text-base font-bold text-slate-900">{{ $officer->full_name_with_title }}</h3>
                                <div class="text-xs font-semibold text-red-600 mt-1 uppercase tracking-wider">{{ $officer->position }}</div>
                                
                                @if($officer->affiliation)
                                    <p class="text-[11px] text-slate-500 mt-2">{{ $officer->affiliation }}</p>
                                @endif

                                @if($officer->bio)
                                    <p class="text-xs text-slate-600 mt-3 pt-3 border-t border-slate-100 line-clamp-3 leading-relaxed">
                                        {{ $officer->bio }}
                                    </p>
                                @endif

                                @if($officer->email || $officer->linkedin_url)
                                    <div class="flex items-center gap-3 mt-4 pt-3 border-t border-slate-100">
                                        @if($officer->email)
                                            <a href="mailto:{{ $officer->email }}" class="text-slate-400 hover:text-red-600 transition text-sm" title="Kirim Email">
                                                <i class="ki-filled ki-sms"></i>
                                            </a>
                                        @endif
                                        @if($officer->linkedin_url)
                                            <a href="{{ $officer->linkedin_url }}" target="_blank" class="text-slate-400 hover:text-blue-600 transition text-sm" title="LinkedIn Profile">
                                                <i class="ki-filled ki-element-11"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- TINGKAT 3: SEKRETARIS & PENGELOLA OPERASIONAL -->
            @if(isset($officersByHierarchy[3]) && $officersByHierarchy[3]->isNotEmpty())
                <div class="space-y-6">
                    <div class="text-center max-w-xl mx-auto">
                        <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest block">{{ __('Manajemen Pelaksana') }}</span>
                        <h2 class="text-xl font-bold text-slate-900 mt-1">{{ __('Sekretaris, Bendahara & Manajemen Program') }}</h2>
                        <div class="w-12 h-1 bg-blue-600 mx-auto mt-2 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($officersByHierarchy[3] as $officer)
                            <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs transition p-5 flex items-start gap-4">
                                @if($officer->photo_path)
                                    <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0" />
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-base border border-blue-100 shrink-0">
                                        {{ strtoupper(substr($officer->name, 0, 2)) }}
                                    </div>
                                @endif

                                <div class="grow min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $officer->full_name_with_title }}</h4>
                                    <div class="text-xs font-semibold text-blue-600 mt-0.5">{{ $officer->position }}</div>
                                    @if($officer->affiliation)
                                        <div class="text-[11px] text-slate-500 mt-1 truncate">{{ $officer->affiliation }}</div>
                                    @endif
                                    @if($officer->email)
                                        <a href="mailto:{{ $officer->email }}" class="text-[11px] text-slate-400 hover:text-red-600 mt-1 inline-block truncate">
                                            {{ $officer->email }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- TINGKAT 4: DEWAN REDAKSI JURNAL & KOMITE ILMIAH IGNITE -->
            @if(isset($officersByHierarchy[4]) && $officersByHierarchy[4]->isNotEmpty())
                <div class="space-y-6">
                    <div class="text-center max-w-xl mx-auto">
                        <span class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest block">{{ __('Publikasi Ilmiah') }}</span>
                        <h2 class="text-xl font-bold text-slate-900 mt-1">{{ __('Dewan Redaksi Jurnal & Komite Ilmiah IGNITE') }}</h2>
                        <div class="w-12 h-1 bg-emerald-600 mx-auto mt-2 rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($officersByHierarchy[4] as $officer)
                            <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs transition p-5 flex items-start gap-4">
                                @if($officer->photo_path)
                                    <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 shrink-0" />
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-base border border-emerald-100 shrink-0">
                                        {{ strtoupper(substr($officer->name, 0, 2)) }}
                                    </div>
                                @endif

                                <div class="grow min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $officer->full_name_with_title }}</h4>
                                    <div class="text-xs font-semibold text-emerald-600 mt-0.5">{{ $officer->position }}</div>
                                    @if($officer->affiliation)
                                        <div class="text-[11px] text-slate-500 mt-1 truncate">{{ $officer->affiliation }}</div>
                                    @endif
                                    @if($officer->email)
                                        <a href="mailto:{{ $officer->email }}" class="text-[11px] text-slate-400 hover:text-red-600 mt-1 inline-block truncate">
                                            {{ $officer->email }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Back to Home / Contact Box -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-base font-bold text-slate-900">{{ __('Ingin Bergabung atau Berkolaborasi?') }}</h4>
                    <p class="text-xs text-slate-500 mt-1">{{ __('Kami membuka ruang kemitraan riset, editor sejawat, dan kontributor ilmiah di seluruh Indonesia.') }}</p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('website.about') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                        {{ __('Tentang Kami') }}
                    </a>
                    <a href="{{ route('website.contact') }}" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow transition">
                        {{ __('Hubungi Pengurus') }} &rarr;
                    </a>
                </div>
            </div>

        </div>
    </section>
@endsection
