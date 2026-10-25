@extends('website::layouts.public')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-container {
            font-family: inherit;
            background-color: #0b1329 !important;
            outline: none;
        }
        .custom-pulse-marker {
            background: transparent !important;
            border: none !important;
        }
        .ysds-map-tooltip {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            font-family: inherit !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
            padding: 6px 10px !important;
        }
        .ysds-map-tooltip::before {
            border-top-color: #0f172a !important;
        }
        .leaflet-popup-content-wrapper {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-radius: 12px !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
        }
        .leaflet-popup-tip {
            background-color: #0f172a !important;
        }
    </style>
@endpush

@section('public_content')
    <!-- Banner Header Halaman Kolaborasi -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-briefcase text-sm"></i> {{ __('Kemitraan & Penyerahan Bantuan') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Kolaborasi & Penyerahan Peralatan') }}
            </h1>
            <p class="text-slate-400 text-sm max-w-3xl mt-3 leading-relaxed">
                {{ __('Dukungan konkret Yayasan Satriabudi Dharma Setia dalam memperkuat kapabilitas fasilitas kesehatan, laboratorium diagnostik molekuler, dan pusat riset genomik melalui hibah serta serah terima peralatan ke berbagai instansi di Indonesia.') }}
            </p>

            <!-- Stat Counters Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-8 pt-8 border-t border-slate-800/80 max-w-2xl">
                <div>
                    <div class="text-3xl font-black text-white">{{ $totalInstitutions }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Instansi Penerima') }}</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-red-500">{{ number_format($totalEquipmentUnits) }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Total Unit Peralatan') }}</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-emerald-400">{{ $totalEquipmentTypes }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Jenis Alat & Instrumen') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peta Interaktif Sebaran Bantuan Alkes Indonesia (Impact Map) -->
    <div x-data="impactMapComponent()" class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-10 mb-8 shadow-2xl text-white relative overflow-hidden">
        
        <!-- Header Peta -->
        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold uppercase tracking-widest mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span> {{ __('Peta Interaktif Sebaran Alkes & Visitasi') }}
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    {{ __('Jangkauan Dukungan Laboratorium di Pelosok Negeri') }}
                </h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-2 leading-relaxed">
                    {{ __('Klik pada titik-titik lokasi di peta untuk melihat fasilitas kesehatan, jenis instrumen medis/PCR yang diserahterimakan, serta dokumentasi visitasi lapangan yayasan.') }}
                </p>
            </div>

            <!-- Region Filter Pills -->
            <div class="flex flex-wrap gap-2 shrink-0">
                <button type="button" 
                        @click="filterRegion('all')" 
                        :class="selectedRegion === 'all' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                    {{ __('Semua Titik (9)') }}
                </button>
                <button type="button" 
                        @click="filterRegion('nusa_tenggara')" 
                        :class="selectedRegion === 'nusa_tenggara' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> {{ __('Nusa Tenggara & Flores (Fokus 3T)') }}
                </button>
                <button type="button" 
                        @click="filterRegion('jawa')" 
                        :class="selectedRegion === 'jawa' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                    {{ __('Jawa & Pusat Rujukan') }}
                </button>
                <button type="button" 
                        @click="filterRegion('maluku_papua')" 
                        :class="selectedRegion === 'maluku_papua' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all">
                    {{ __('Maluku & Halmahera') }}
                </button>
            </div>
        </div>

        <!-- Interactive Google Maps Container -->
        <div class="relative bg-slate-950 rounded-2xl border border-slate-800 p-2 sm:p-2.5 mb-6 overflow-hidden shadow-2xl">
            <!-- Leaflet Canvas -->
            <div id="ysds-impact-map" class="w-full h-[380px] sm:h-[460px] lg:h-[500px] rounded-xl overflow-hidden relative z-0"></div>

            <!-- Floating Map Type & Reset Controls -->
            <div class="absolute top-4 right-4 z-10 flex items-center gap-1 bg-slate-900/90 backdrop-blur-md border border-slate-700/80 p-1.5 rounded-xl shadow-2xl">
                <button type="button"
                        @click="setMapType('roadmap')"
                        :class="activeMapType === 'roadmap' ? 'bg-red-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800'"
                        class="px-2.5 py-1 rounded-lg text-[11px] transition flex items-center gap-1.5 cursor-pointer">
                    <i class="ki-filled ki-map text-xs"></i>
                    <span>{{ __('Google Peta') }}</span>
                </button>
                <button type="button"
                        @click="setMapType('satellite')"
                        :class="activeMapType === 'satellite' ? 'bg-red-600 text-white font-bold' : 'text-slate-300 hover:text-white hover:bg-slate-800'"
                        class="px-2.5 py-1 rounded-lg text-[11px] transition flex items-center gap-1.5 cursor-pointer">
                    <i class="ki-filled ki-picture text-xs"></i>
                    <span>{{ __('Google Satelit') }}</span>
                </button>
                <div class="h-4 w-px bg-slate-700 mx-0.5"></div>
                <button type="button"
                        @click="resetView()"
                        title="{{ __('Reset Tampilan Seluruh Indonesia') }}"
                        class="p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition cursor-pointer">
                    <i class="ki-filled ki-arrows-circle text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Detail Drawer / Card Informasi Faskes Terpilih -->
        <div x-show="activePin" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-slate-950 border border-red-500/40 rounded-2xl p-6 sm:p-7 relative shadow-2xl">
            
            <button type="button" @click="activePin = null" class="absolute top-4 right-4 text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
                <i class="ki-filled ki-cross text-lg"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <div class="md:col-span-8 space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-red-500/20 text-red-400 border border-red-500/30" x-text="activePin?.type"></span>
                        <span class="text-xs text-slate-400 flex items-center gap-1">
                            <i class="ki-filled ki-geolocation text-red-500 text-xs"></i>
                            <span x-text="activePin?.province"></span>
                        </span>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-black text-white" x-text="activePin?.name"></h3>

                    <div class="space-y-1 text-xs text-slate-300 pt-1">
                        <p class="text-slate-400">
                            <strong class="text-white">Alat / Dukungan Terpasang:</strong> 
                            <span x-text="activePin?.alats" class="text-red-200 font-semibold"></span>
                        </p>
                        <p class="text-slate-400">
                            <strong class="text-white">Status Operasional:</strong> 
                            <span x-text="activePin?.status" class="text-emerald-400 font-bold"></span>
                            <span class="text-slate-500 mx-1">&bull;</span>
                            <span class="text-slate-400">Tanggal: <span x-text="activePin?.date"></span></span>
                        </p>
                    </div>
                </div>

                <div class="md:col-span-4 flex flex-col sm:flex-row md:flex-col gap-2.5 justify-center md:items-end">
                    <a :href="activePin?.link" 
                       class="w-full text-center px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs shadow-lg shadow-red-600/30 transition flex items-center justify-center gap-2">
                        <i class="ki-filled ki-eye text-sm"></i>
                        <span x-text="activePin?.linkText"></span>
                    </a>
                    <a href="{{ route('website.assistance.public') }}" 
                       class="w-full text-center px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-xs border border-slate-700 transition flex items-center justify-center gap-1.5">
                        <i class="ki-filled ki-heart text-xs text-red-400"></i>
                        {{ __('Ajukan Bantuan Faskes') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Highlight Key Metrics Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 mt-6 border-t border-slate-800/80 text-xs text-slate-400">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center shrink-0">
                    <i class="ki-filled ki-shield-tick text-base"></i>
                </div>
                <span><strong>100% Bebas Biaya</strong> bagi fasilitas kesehatan dan lab di wilayah 3T.</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0">
                    <i class="ki-filled ki-verify text-base"></i>
                </div>
                <span>Disertai <strong>Pelatihan Operasional & Biosafety</strong> intensif oleh dokter spesialis.</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                    <i class="ki-filled ki-document text-base"></i>
                </div>
                <span>Berita Acara Serah Terima <strong>(BAST) Resmi</strong> tersertifikasi dan terverifikasi.</span>
            </div>
        </div>
    </div>

    <!-- Konten Utama: Filter & Daftar Instansi Kolaborasi -->
    <div class="w-full space-y-8 pb-12">

            <!-- Filter & Pencarian -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
                <form action="{{ route('website.collaborations.public') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="grow relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Cari nama instansi, kota, atau jenis peralatan...') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden transition" />
                        <i class="ki-filled ki-magnifier absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                    </div>

                    @if($categories->isNotEmpty())
                        <div class="w-full sm:w-64">
                            <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-hidden bg-white text-slate-700 font-medium transition">
                                <option value="">{{ __('-- Semua Kategori Instansi --') }}</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition shrink-0">
                        {{ __('Cari') }}
                    </button>

                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('website.collaborations.public') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold text-xs text-center transition shrink-0">
                            {{ __('Reset') }}
                        </a>
                    @endif
                </form>
            </div>

            <!-- Daftar Instansi & Peralatan -->
            <div class="space-y-8">
                @forelse($collaborations as $collab)
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition overflow-hidden">
                        <!-- Instansi Header -->
                        <div class="p-6 sm:p-7 border-b border-slate-100 bg-gradient-to-b from-slate-50/50 to-white">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                                <div class="flex items-start sm:items-center gap-4">
                                    @if($collab->institution_logo)
                                        <img src="{{ Storage::url($collab->institution_logo) }}" alt="{{ $collab->institution_name }}" class="w-16 h-16 object-contain rounded-xl bg-white p-2 border border-slate-200 shadow-2xs shrink-0" />
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-slate-900 text-white font-black flex items-center justify-center text-xl uppercase shadow-xs shrink-0">
                                            {{ strtoupper(substr($collab->institution_name, 0, 2)) }}
                                        </div>
                                    @endif

                                    <div class="space-y-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h2 class="text-xl font-bold text-slate-900 tracking-tight">{{ $collab->institution_name }}</h2>
                                            @if($collab->category)
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100">
                                                    {{ $collab->category }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                            @if($collab->location)
                                                <div class="flex items-center gap-1">
                                                    <i class="ki-filled ki-geolocation text-red-600 text-xs"></i>
                                                    <span>{{ $collab->location }}</span>
                                                </div>
                                            @endif

                                            @if($collab->handover_date)
                                                <div class="flex items-center gap-1 font-mono text-[11px]">
                                                    <i class="ki-filled ki-calendar text-slate-400 text-xs"></i>
                                                    <span>{{ __('Serah Terima') }}: {{ $collab->handover_date->translatedFormat('d F Y') }}</span>
                                                </div>
                                            @endif

                                            @if($collab->pic_name)
                                                <div class="flex items-center gap-1 text-[11px]">
                                                    <i class="ki-filled ki-user text-slate-400 text-xs"></i>
                                                    <span>{{ __('Penerima') }}: <strong class="text-slate-700">{{ $collab->pic_name }}</strong></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="self-start md:self-center shrink-0">
                                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-red-50 text-red-700 border border-red-100 font-bold text-xs">
                                        <i class="ki-filled ki-cube-2 text-sm text-red-600"></i>
                                        <span>{{ (int) $collab->items->sum('quantity') }} {{ __('Unit') }} ({{ $collab->items->count() }} {{ __('Jenis') }})</span>
                                    </div>
                                </div>
                            </div>

                            @if($collab->description)
                                <p class="text-xs text-slate-600 mt-4 pt-3 border-t border-slate-100 leading-relaxed max-w-4xl">
                                    {{ $collab->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Tabel Peralatan yang Telah Diserahkan (nomor, nama, satuan, jumlah) -->
                        <div class="p-6 sm:p-7">
                            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                {{ __('Peralatan yang Telah Diserahkan') }}
                            </h3>

                            @if($collab->items->isNotEmpty())
                                <div class="overflow-x-auto rounded-xl border border-slate-200">
                                    <table class="w-full text-xs text-left">
                                        <thead class="bg-slate-100/80 text-slate-700 uppercase font-bold text-[11px] border-b border-slate-200">
                                            <tr>
                                                <th class="px-4 py-3 w-20 text-center">{{ __('Nomor') }}</th>
                                                <th class="px-4 py-3">{{ __('Nama Peralatan') }}</th>
                                                <th class="px-4 py-3 text-center w-28">{{ __('Satuan') }}</th>
                                                <th class="px-4 py-3 text-center w-28">{{ __('Jumlah') }}</th>
                                                <th class="px-4 py-3 hidden md:table-cell">{{ __('Spesifikasi / Keterangan') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-150 bg-white">
                                            @foreach($collab->items as $item)
                                                <tr class="hover:bg-slate-50/80 transition">
                                                    <td class="px-4 py-3 text-center font-mono font-bold text-slate-700 bg-slate-50/50">
                                                        {{ $item->item_number }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="font-bold text-slate-900">{{ $item->name }}</div>
                                                        @if($item->specifications)
                                                            <div class="text-[11px] text-slate-500 mt-0.5 md:hidden">
                                                                {{ $item->specifications }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="px-2.5 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[10px] uppercase border border-slate-200">
                                                            {{ $item->unit }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="font-mono font-extrabold text-slate-900 text-sm">
                                                            {{ number_format($item->quantity) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-slate-500 hidden md:table-cell">
                                                        {{ $item->specifications ?: '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-slate-50 text-slate-700 font-bold border-t border-slate-200 text-xs">
                                            <tr>
                                                <td colspan="2" class="px-4 py-2.5 text-right uppercase tracking-wider text-[10px] text-slate-500">
                                                    {{ __('Total Unit untuk Instansi Ini:') }}
                                                </td>
                                                <td class="px-4 py-2.5 text-center text-slate-600 font-mono text-[11px]">
                                                    {{ $collab->items->count() }} {{ __('Jenis') }}
                                                </td>
                                                <td class="px-4 py-2.5 text-center text-red-600 font-mono font-black text-sm">
                                                    {{ number_format($collab->items->sum('quantity')) }}
                                                </td>
                                                <td class="px-4 py-2.5 hidden md:table-cell text-[10px] text-slate-400">
                                                    {{ __('Terverifikasi dalam Dokumen Serah Terima Resmi Yayasan') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                <div class="p-6 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center text-xs text-slate-500">
                                    {{ __('Rincian peralatan sedang dalam proses digitalisasi berita acara.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center space-y-4">
                        <div class="w-16 h-16 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto text-2xl">
                            <i class="ki-filled ki-magnifier"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ __('Tidak ada data instansi yang sesuai') }}</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">
                            {{ __('Silakan coba gunakan kata kunci pencarian yang berbeda atau reset filter kategori instansi.') }}
                        </p>
                        <a href="{{ route('website.collaborations.public') }}" class="inline-block px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition">
                            {{ __('Lihat Semua Kolaborasi') }}
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Ajakan Kerjasama / Call to Action -->
            <div class="rounded-2xl bg-gradient-to-r from-slate-950 via-slate-900 to-red-950 text-white p-8 sm:p-10 border border-slate-800 shadow-md">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-white">{{ __('Berminat Menjalin Kemitraan Bersama Kami?') }}</h3>
                        <p class="text-xs text-slate-400 max-w-xl leading-relaxed">
                            {{ __('Yayasan Satriabudi Dharma Setia membuka peluang kolaborasi seluas-luasnya bagi institusi akademik, rumah sakit rujukan, dan laboratorium penelitian dalam memajukan riset kesehatan di tanah air.') }}
                        </p>
                    </div>
                    <a href="{{ route('website.contact') }}" class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-lg transition shrink-0 flex items-center gap-2">
                        <span>{{ __('Hubungi Tim Yayasan') }}</span>
                        <i class="ki-filled ki-arrow-up-right text-xs"></i>
                    </a>
                </div>
            </div>

    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function impactMapComponent() {
            return {
                selectedRegion: 'all',
                activePin: null,
                activeMapType: 'roadmap',
                map: null,
                markers: {},
                tileLayers: {},
                pins: [
                    {
                        id: 'maumere',
                        name: 'RSUD Dr. T.C. Hillers Maumere',
                        region: 'nusa_tenggara',
                        province: 'Nusa Tenggara Timur (Kab. Sikka)',
                        alats: '1 Unit Real-Time PCR 96-Well, 1 Unit Biosafety Cabinet Class II, Reagen Deteksi Molekuler',
                        date: '18 Oktober 2023',
                        type: 'RSUD Kabupaten 3T',
                        status: 'Laboratorium Molekuler Mandiri Beroperasi',
                        link: '{{ route('website.visitations.show', 'visitasi-penyerahan-mesin-pcr-rsud-tc-hillers-maumere') }}',
                        linkText: 'Buka Dokumentasi Visitasi & Pelatihan',
                        lat: -8.6253,
                        lng: 122.2155
                    },
                    {
                        id: 'ruteng',
                        name: 'RSUD Dr. Ben Mboi Ruteng',
                        region: 'nusa_tenggara',
                        province: 'Nusa Tenggara Timur (Kab. Manggarai)',
                        alats: 'Thermal Cycler Gradient, Ruang PCR Tekanan Negatif, Reagensia Deteksi Penyakit Tropis',
                        date: '05 November 2023',
                        type: 'RSUD Dataran Tinggi Flores',
                        status: 'Kesiapsiagaan Deteksi Dini Penyakit Menular',
                        link: '{{ route('website.visitations.show', 'supervisi-fasilitas-diagnostik-rsud-ben-mboi-ruteng') }}',
                        linkText: 'Buka Laporan Supervisi Lab',
                        lat: -8.6133,
                        lng: 120.4639
                    },
                    {
                        id: 'labuan_bajo',
                        name: 'RSUD Komodo Labuan Bajo',
                        region: 'nusa_tenggara',
                        province: 'Nusa Tenggara Timur (Manggarai Barat)',
                        alats: 'Instrumen Ekstraksi Otomatis DNA/RNA, Real-Time PCR Multi-Channel Modern',
                        date: '22 Mei 2024',
                        type: 'RSUD Destinasi Wisata Super Prioritas',
                        status: 'Standar Diagnostik Internasional',
                        link: '{{ route('website.visitations.show', 'visitasi-kesiapan-lab-genomik-rsud-komodo-labuan-bajo') }}',
                        linkText: 'Buka Dokumentasi Kesiapan Lab',
                        lat: -8.5134,
                        lng: 119.8974
                    },
                    {
                        id: 'sabu',
                        name: 'Dinas Kesehatan & Labkesda Sabu Raijua',
                        region: 'nusa_tenggara',
                        province: 'Nusa Tenggara Timur (Pulau Sabu)',
                        alats: 'Freezer Rantai Dingin Spesimen Medis, Digitalisasi Sekolah POP Savu Smart Island',
                        date: '14 Februari 2024',
                        type: 'Kepulauan Terluar 3T',
                        status: 'Program Savu Smart Island & Cold Chain Medis',
                        link: '{{ route('website.visitations.show', 'visitasi-program-savu-smart-island-sabu-raijua') }}',
                        linkText: 'Buka Laporan Program Savu Smart Island',
                        lat: -10.4950,
                        lng: 121.8410
                    },
                    {
                        id: 'alor',
                        name: 'RSUD Kalabahi Alor',
                        region: 'nusa_tenggara',
                        province: 'Nusa Tenggara Timur (Kepulauan Alor)',
                        alats: 'Ultra-Low Freezer -86°C Biobank, High-Speed Refrigerated Centrifuge, Micropipette Set',
                        date: '30 Agustus 2024',
                        type: 'RSUD Wilayah Kepulauan Perbatasan',
                        status: 'Diagnostik Akurat Tanpa Rujukan ke Kupang',
                        link: '{{ route('website.visitations.show', 'visitasi-penyerahan-alat-supervisi-rsud-kalabahi-alor') }}',
                        linkText: 'Buka Dokumentasi Visitasi Alor',
                        lat: -8.2192,
                        lng: 124.5165
                    },
                    {
                        id: 'sardjito',
                        name: 'RSUP Dr. Sardjito Yogyakarta',
                        region: 'jawa',
                        province: 'D.I. Yogyakarta (Sleman)',
                        alats: 'Real-Time PCR System (2 Unit), BSC Class II Type A2 (2 Unit), Ultra-Low Freezer 728 Liter',
                        date: '15 Agustus 2024',
                        type: 'Rumah Sakit Rujukan Nasional',
                        status: 'Hibah Berita Acara Serah Terima (BAST) Resmi',
                        link: '#',
                        linkText: 'Lihat Detail Item Kolaborasi BAST',
                        lat: -7.7686,
                        lng: 110.3736
                    },
                    {
                        id: 'fkui',
                        name: 'Lab Mikrobiologi FKUI / RSCM Salemba',
                        region: 'jawa',
                        province: 'DKI Jakarta (Salemba)',
                        alats: 'Next-Generation Sequencing Library Prep Automation, Thermal Cycler (3 Unit), Fluorometer Qubit 4',
                        date: '20 November 2024',
                        type: 'Pusat Riset Genomik & RS Pendidikan',
                        status: 'Riset Translasi Long-Read PacBio & ONT',
                        link: '{{ route('website.visitations.show', 'kunjungan-kemitraan-riset-genomik-lab-mikrobiologi-fkui') }}',
                        linkText: 'Buka Laporan Kemitraan Akademik',
                        lat: -6.1963,
                        lng: 106.8480
                    },
                    {
                        id: 'rshs',
                        name: 'RSUP Dr. Hasan Sadikin Bandung',
                        region: 'jawa',
                        province: 'Jawa Barat (Bandung)',
                        alats: 'Automated Extraction System 32-Channel, Microvolume Spectrophotometer NanoDrop, Medical Refrigerator',
                        date: '10 Februari 2025',
                        type: 'Rumah Sakit Rujukan Jawa Barat',
                        status: 'Laboratorium Sentral Diagnostik Cepat',
                        link: '#',
                        linkText: 'Lihat Detail Item Kolaborasi BAST',
                        lat: -6.8956,
                        lng: 107.5985
                    },
                    {
                        id: 'halmahera',
                        name: 'Rumah Baca & Pendidikan Halmahera',
                        region: 'maluku_papua',
                        province: 'Maluku Utara (Halmahera)',
                        alats: 'Penyediaan Sarana Literasi Anak, Perpustakaan Mini, Modul Sains & Nutrisi Generasi Muda',
                        date: '2024 - Berkelanjutan',
                        type: 'Pendidikan Vokasi & Literasi Anak',
                        status: 'Dukungan Program Berkelanjutan YSDS',
                        link: '{{ route('website.donation.public') }}',
                        linkText: 'Dukung Program via Donasi Resmi',
                        lat: 1.7283,
                        lng: 128.0094
                    }
                ],

                init() {
                    this.$nextTick(() => {
                        const checkLeaflet = () => {
                            if (typeof L !== 'undefined') {
                                this.initMap();
                            } else {
                                setTimeout(checkLeaflet, 80);
                            }
                        };
                        checkLeaflet();
                    });
                },

                initMap() {
                    const mapEl = document.getElementById('ysds-impact-map');
                    if (!mapEl || this.map) return;

                    // Inisialisasi Leaflet
                    this.map = L.map('ysds-impact-map', {
                        center: [-2.5, 118.0],
                        zoom: 5,
                        minZoom: 4,
                        maxZoom: 18,
                        zoomControl: false,
                        scrollWheelZoom: false
                    });

                    // Aktifkan scroll wheel zoom saat peta difokuskan / diklik
                    this.map.on('focus', () => {
                        this.map.scrollWheelZoom.enable();
                    });

                    // Zoom control di pojok kanan bawah
                    L.control.zoom({ position: 'bottomright' }).addTo(this.map);

                    // Tile Layer Google Maps (Roadmap & Hybrid/Satellite)
                    this.tileLayers.roadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        attribution: '&copy; <a href="https://maps.google.com" target="_blank" rel="noopener">Google Maps</a>'
                    });

                    this.tileLayers.satellite = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                        attribution: '&copy; <a href="https://maps.google.com" target="_blank" rel="noopener">Google Maps</a>'
                    });

                    // Default ke Roadmap
                    this.tileLayers.roadmap.addTo(this.map);

                    // Buat Marker untuk setiap fasilitas
                    this.pins.forEach(pin => {
                        const icon = L.divIcon({
                            className: 'custom-pulse-marker',
                            html: `
                                <div class="relative flex items-center justify-center -translate-x-1/2 -translate-y-1/2 cursor-pointer group">
                                    <span class="absolute w-8 h-8 rounded-full bg-red-500/50 animate-ping pointer-events-none"></span>
                                    <div class="relative w-7 h-7 rounded-full bg-red-600 text-white flex items-center justify-center shadow-xl ring-2 ring-white/90 group-hover:scale-125 transition-transform duration-200">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                    </div>
                                </div>
                            `,
                            iconSize: [28, 28],
                            iconAnchor: [14, 14]
                        });

                        const marker = L.marker([pin.lat, pin.lng], { icon: icon }).addTo(this.map);

                        marker.bindTooltip(`
                            <div class="font-bold text-white text-xs">${pin.name}</div>
                            <div class="text-[10px] text-slate-400">${pin.province}</div>
                        `, {
                            direction: 'top',
                            offset: [0, -14],
                            className: 'ysds-map-tooltip'
                        });

                        marker.on('click', () => {
                            this.selectPin(pin);
                        });

                        this.markers[pin.id] = marker;
                    });

                    // Auto-fit ke seluruh titik
                    this.fitAllMarkers();
                },

                fitAllMarkers() {
                    if (!this.map) return;
                    const allCoords = this.pins.map(p => [p.lat, p.lng]);
                    this.map.fitBounds(L.latLngBounds(allCoords), {
                        padding: [50, 50],
                        maxZoom: 6
                    });
                },

                setMapType(type) {
                    if (this.activeMapType === type || !this.map) return;
                    this.map.removeLayer(this.tileLayers[this.activeMapType]);
                    this.tileLayers[type].addTo(this.map);
                    this.activeMapType = type;
                },

                selectPin(pin) {
                    this.activePin = pin;
                    if (this.map) {
                        this.map.flyTo([pin.lat, pin.lng], 13, {
                            duration: 1.2
                        });
                    }
                },

                filterRegion(region) {
                    this.selectedRegion = region;
                    if (!this.map) return;

                    this.pins.forEach(pin => {
                        const marker = this.markers[pin.id];
                        if (!marker) return;
                        const matches = this.selectedRegion === 'all' || this.selectedRegion === pin.region;
                        if (matches) {
                            if (!this.map.hasLayer(marker)) {
                                this.map.addLayer(marker);
                            }
                        } else {
                            if (this.map.hasLayer(marker)) {
                                this.map.removeLayer(marker);
                            }
                        }
                    });

                    if (region === 'all') {
                        this.fitAllMarkers();
                    } else {
                        const filtered = this.pins.filter(p => p.region === region);
                        if (filtered.length === 1) {
                            this.map.flyTo([filtered[0].lat, filtered[0].lng], 8, {
                                duration: 1.2
                            });
                        } else if (filtered.length > 1) {
                            const coords = filtered.map(p => [p.lat, p.lng]);
                            this.map.flyToBounds(L.latLngBounds(coords), {
                                padding: [50, 50],
                                duration: 1.2,
                                maxZoom: 8
                            });
                        }
                    }
                },

                resetView() {
                    this.activePin = null;
                    this.filterRegion('all');
                }
            };
        }
    </script>
@endpush
