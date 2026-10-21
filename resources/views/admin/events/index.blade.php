@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Kegiatan &amp; Acara</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kegiatan &amp; Acara Simposium</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola agenda simposium ilmiah, kegiatan riset genomik, lokakarya, dan forum inovasi yayasan.</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('website.events.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Halaman Publik
                </a>
                <a href="{{ route('website.events.admin.create') }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Kegiatan Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="ki-filled ki-information text-red-600"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Stat Counter Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-calendar"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $totalEvents }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Kegiatan</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $publishedCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Diterbitkan (Publik)</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-time"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $draftCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Draft / Arsip</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-star"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $featuredCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Sorotan (Homepage)</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.events.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan, mitra, sponsor, atau lokasi..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-44">
                    <select name="year" class="kt-select w-full text-xs">
                        <option value="">-- Semua Tahun --</option>
                        @foreach($availableYears as $yr)
                            <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-44">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Diterbitkan</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                        <i class="ki-filled ki-filter mr-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'year', 'status']))
                        <a href="{{ route('website.events.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Kegiatan -->
        <div class="kt-card shadow-sm">
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-16 text-center">Banner</th>
                                <th class="px-4 py-3">Nama Kegiatan &amp; Tag</th>
                                <th class="px-4 py-3 w-28 text-center">Tahun</th>
                                <th class="px-4 py-3 w-44">Mitra &amp; Sponsor</th>
                                <th class="px-4 py-3 w-36">Jadwal &amp; Lokasi</th>
                                <th class="px-4 py-3 text-center w-28">Status</th>
                                <th class="px-4 py-3 text-center w-24">Sorotan</th>
                                <th class="px-4 py-3 text-right w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($events as $event)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 text-center">
                                        @if($event->banner_url)
                                            <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200 shadow-xs mx-auto" />
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-red-50 border border-red-100 text-red-600 flex items-center justify-center mx-auto text-base">
                                                <i class="ki-filled ki-calendar"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-red-50 text-red-600 border border-red-100">
                                                    {{ $event->tag ?: 'Kegiatan Terbaru' }}
                                                </span>
                                            </div>
                                            <div class="font-bold text-gray-900 text-sm hover:text-red-600 transition">
                                                <a href="{{ route('website.events.admin.edit', $event->id) }}">
                                                    {{ $event->title }}
                                                </a>
                                            </div>
                                            @if($event->summary)
                                                <p class="text-gray-500 line-clamp-1 text-[11px]">{{ $event->summary }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-bold text-gray-800">
                                        {{ $event->year }}
                                    </td>
                                    <td class="px-4 py-3 space-y-1">
                                        @if($event->partner_name)
                                            <div class="text-[11px] text-gray-600">
                                                <span class="text-gray-400">Mitra:</span> <span class="font-semibold text-gray-800">{{ $event->partner_name }}</span>
                                            </div>
                                        @endif
                                        @if($event->sponsor_name)
                                            <div class="text-[11px] text-gray-600">
                                                <span class="text-gray-400">Sponsor:</span> <span class="font-semibold text-gray-800">{{ $event->sponsor_name }}</span>
                                            </div>
                                        @endif
                                        @if(!$event->partner_name && !$event->sponsor_name)
                                            <span class="text-gray-400 italic text-[11px]">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 space-y-1 text-[11px]">
                                        @if($event->event_date)
                                            <div class="flex items-center gap-1 font-medium text-gray-800">
                                                <i class="ki-filled ki-calendar text-red-500 text-xs"></i>
                                                <span>{{ $event->event_date }}</span>
                                            </div>
                                        @endif
                                        @if($event->location)
                                            <div class="flex items-center gap-1 text-gray-500">
                                                <i class="ki-filled ki-geolocation text-gray-400 text-xs"></i>
                                                <span class="truncate max-w-[150px]">{{ $event->location }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('website.events.admin.toggle', $event->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="cursor-pointer transition hover:opacity-80" title="Klik untuk beralih status">
                                                @if($event->is_published)
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 inline-flex items-center gap-1">
                                                        <i class="ki-filled ki-check-circle text-xs"></i> Publik
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 inline-flex items-center gap-1">
                                                        <i class="ki-filled ki-time text-xs"></i> Draft
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('website.events.admin.featured', $event->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="cursor-pointer transition hover:opacity-80" title="Klik untuk toggle sorotan homepage">
                                                @if($event->is_featured)
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200 inline-flex items-center gap-1">
                                                        <i class="ki-filled ki-star text-xs"></i> Ya
                                                    </span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-500">
                                                        Tidak
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('website.events.show', $event->slug) }}" target="_blank" class="kt-btn kt-btn-xs kt-btn-ghost text-gray-500 hover:text-red-600" title="Lihat di Web">
                                                <i class="ki-filled ki-eye text-sm"></i>
                                            </a>
                                            <a href="{{ route('website.events.admin.edit', $event->id) }}" class="kt-btn kt-btn-xs kt-btn-ghost text-warning hover:bg-amber-50" title="Edit Kegiatan">
                                                <i class="ki-filled ki-notepad-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('website.events.admin.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan \'{{ $event->title }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="kt-btn kt-btn-xs kt-btn-ghost text-danger hover:bg-red-50" title="Hapus Kegiatan">
                                                    <i class="ki-filled ki-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 text-gray-400">
                                        <i class="ki-filled ki-calendar text-4xl mb-2 text-gray-300 block"></i>
                                        Belum ada kegiatan atau agenda yang tersimpan.
                                        <br>
                                        <a href="{{ route('website.events.admin.create') }}" class="kt-btn kt-btn-primary text-white text-xs mt-3 inline-flex items-center gap-1">
                                            <i class="ki-filled ki-plus"></i> Tambah Kegiatan Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($events->hasPages())
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
