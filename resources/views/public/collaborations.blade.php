@extends('website::layouts.public')

@section('public_content')
    <!-- Banner Header Halaman Kolaborasi -->
    <section class="bg-slate-900 text-white py-14 border-b border-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-900/30 via-slate-900/80 to-slate-900 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
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
    </section>

    <!-- Konten Utama: Filter & Daftar Instansi Kolaborasi -->
    <section class="py-12 bg-slate-50 min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

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
                                                    <span>Serah Terima: {{ $collab->handover_date->translatedFormat('d F Y') }}</span>
                                                </div>
                                            @endif

                                            @if($collab->pic_name)
                                                <div class="flex items-center gap-1 text-[11px]">
                                                    <i class="ki-filled ki-profile-user text-slate-400 text-xs"></i>
                                                    <span>Penerima: <strong class="text-slate-700">{{ $collab->pic_name }}</strong></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="self-start md:self-center shrink-0">
                                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-red-50 text-red-700 border border-red-100 font-bold text-xs">
                                        <i class="ki-filled ki-cube-2 text-sm text-red-600"></i>
                                        <span>{{ (int) $collab->items->sum('quantity') }} Unit ({{ $collab->items->count() }} Jenis)</span>
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
    </section>
@endsection
