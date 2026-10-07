@extends('website::layouts.public')

@push('meta')
    <meta property="og:title" content="{{ __('Pusat Unduhan & Dokumen Resmi Yayasan Satriabudi Dharma Setia') }}" />
    <meta property="og:description" content="{{ __('Akses dan unduh Laporan Tahunan, Laporan Keuangan Teraudit, Legalitas Resmi, serta SOP Program Kemanusiaan YSDS.') }}" />
    <meta property="og:url" content="{{ route('website.documents.public') }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ __('Pusat Unduhan & Dokumen Resmi YSDS') }}" />
    <meta name="twitter:description" content="{{ __('Laporan Akuntabilitas, Audit Finansial, dan SOP Hibah Alkes YSDS.') }}" />
@endpush

@section('public_content')
    <!-- Banner Header Pusat Unduhan -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-12 mb-8 shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-950/40 via-slate-900/90 to-slate-900 pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-bold uppercase tracking-widest mb-3">
                <i class="ki-filled ki-document text-sm"></i> {{ __('Transparansi & Akuntabilitas Publik YSDS') }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('Pusat Unduhan & Dokumen Resmi Yayasan') }}
            </h1>
            <p class="text-slate-300 text-sm mt-3 leading-relaxed">
                {{ __('Wujud komitmen keterbukaan tata kelola Yayasan Satriabudi Dharma Setia. Akses Laporan Tahunan (Annual Report), Laporan Keuangan Teraudit Independen, Legalitas & SK Kemenkumham, serta Panduan & SOP Program Kemanusiaan.') }}
            </p>

            <!-- Counter Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-8 pt-8 border-t border-slate-800/80 max-w-xl">
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-white">{{ $categoryCounts['all'] ?? 0 }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Dokumen Publik') }}</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-blue-400">{{ number_format($totalDownloads ?? 0) }}</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Total Unduhan') }}</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-black text-emerald-400">100%</div>
                    <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mt-0.5">{{ __('Teraudit Akuntabel') }}</div>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-6xl mx-auto pb-16 space-y-8">
        
        <!-- Search Bar & Category Filter Pills -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-4">
            <!-- Search Form -->
            <form action="{{ route('website.documents.public') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="{{ __('Cari judul dokumen, kata kunci, atau tahun terbit...') }}"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-hidden transition" />
                    <i class="ki-filled ki-magnifier absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                </div>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition shrink-0">
                    {{ __('Cari') }}
                </button>
                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('website.documents.public') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 font-bold text-xs text-center transition shrink-0">
                        {{ __('Reset Filter') }}
                    </a>
                @endif
            </form>

            <!-- Category Pills -->
            <div class="flex flex-wrap gap-2 pt-2 border-t border-slate-100 text-xs font-semibold">
                <a href="{{ route('website.documents.public', array_filter(['search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ !request('category') ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                    <span>{{ __('Semua Dokumen') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ !request('category') ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['all'] ?? 0 }}</span>
                </a>
                <a href="{{ route('website.documents.public', array_filter(['category' => 'laporan_tahunan', 'search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('category') === 'laporan_tahunan' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-blue-50 hover:text-blue-700 text-slate-700' }}">
                    <span>{{ __('Laporan Tahunan') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === 'laporan_tahunan' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['laporan_tahunan'] ?? 0 }}</span>
                </a>
                <a href="{{ route('website.documents.public', array_filter(['category' => 'laporan_keuangan', 'search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('category') === 'laporan_keuangan' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700' }}">
                    <span>{{ __('Laporan Keuangan Audit') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === 'laporan_keuangan' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['laporan_keuangan'] ?? 0 }}</span>
                </a>
                <a href="{{ route('website.documents.public', array_filter(['category' => 'legalitas_sk', 'search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('category') === 'legalitas_sk' ? 'bg-purple-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-purple-50 hover:text-purple-700 text-slate-700' }}">
                    <span>{{ __('Legalitas & SK') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === 'legalitas_sk' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['legalitas_sk'] ?? 0 }}</span>
                </a>
                <a href="{{ route('website.documents.public', array_filter(['category' => 'panduan_sop', 'search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('category') === 'panduan_sop' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-amber-50 hover:text-amber-700 text-slate-700' }}">
                    <span>{{ __('SOP & Panduan') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === 'panduan_sop' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['panduan_sop'] ?? 0 }}</span>
                </a>
                <a href="{{ route('website.documents.public', array_filter(['category' => 'brosur_profil', 'search' => request('search')])) }}"
                   class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 {{ request('category') === 'brosur_profil' ? 'bg-red-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-red-50 hover:text-red-700 text-slate-700' }}">
                    <span>{{ __('Brosur & Profil') }}</span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ request('category') === 'brosur_profil' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">{{ $categoryCounts['brosur_profil'] ?? 0 }}</span>
                </a>
            </div>
        </div>

        <!-- Grid Cards Dokumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documents as $doc)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:border-blue-400 hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                    <div class="p-6 space-y-3">
                        <!-- Badges Header -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $doc->category_badge_class }}">
                                {{ $doc->category_label }}
                            </span>
                            @if($doc->published_year)
                                <span class="text-[11px] font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                    {{ $doc->published_year }}
                                </span>
                            @endif
                        </div>

                        <!-- Judul Dokumen -->
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug">
                            {{ $doc->title }}
                        </h3>

                        <!-- Deskripsi -->
                        @if($doc->description)
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                {{ $doc->description }}
                            </p>
                        @endif

                        <!-- Meta Info Berkas -->
                        <div class="flex items-center gap-3 text-[11px] text-slate-400 pt-2 border-t border-slate-100">
                            <span class="flex items-center gap-1 uppercase font-bold text-slate-600">
                                <i class="ki-filled ki-file text-xs text-blue-500"></i> {{ $doc->file_extension }}
                            </span>
                            <span>&bull;</span>
                            <span>{{ $doc->formatted_file_size }}</span>
                            <span>&bull;</span>
                            <span class="flex items-center gap-1">
                                <i class="ki-filled ki-file-down text-xs text-slate-400"></i> {{ $doc->download_count }}x diunduh
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons Footer -->
                    <div class="p-4 bg-slate-50/70 border-t border-slate-100 flex items-center gap-2">
                        @if(strtolower($doc->file_extension) === 'pdf')
                            <a href="{{ route('website.documents.preview', $doc->slug) }}" target="_blank"
                               class="flex-1 text-center py-2 px-3 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs transition flex items-center justify-center gap-1.5">
                                <i class="ki-filled ki-eye text-xs text-slate-500"></i>
                                <span>{{ __('Preview') }}</span>
                            </a>
                        @endif

                        <a href="{{ route('website.documents.download', $doc->slug) }}"
                           class="flex-1 text-center py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs shadow-xs transition flex items-center justify-center gap-1.5">
                            <i class="ki-filled ki-file-down text-xs text-white"></i>
                            <span>{{ __('Unduh') }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                        <i class="ki-filled ki-document"></i>
                    </div>
                    <h4 class="font-extrabold text-slate-800 text-base">{{ __('Tidak Ada Dokumen yang Ditemukan') }}</h4>
                    <p class="text-slate-500 text-xs mt-1 max-w-md mx-auto">
                        {{ __('Silakan coba ubah kata kunci pencarian atau pilih kategori lain.') }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('website.documents.public') }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold inline-block">
                            {{ __('Lihat Semua Dokumen') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($documents->hasPages())
            <div class="pt-4">
                {{ $documents->links() }}
            </div>
        @endif

        <!-- Notice Box Akuntabilitas -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 text-xs text-blue-900 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-xl font-black">
                <i class="ki-filled ki-shield-tick"></i>
            </div>
            <div class="space-y-1">
                <h4 class="font-extrabold text-blue-950 text-sm">{{ __('Standar Kepatuhan & Audit Independen') }}</h4>
                <p class="text-blue-800 leading-relaxed">
                    {{ __('Seluruh laporan pertanggungjawaban program dan laporan keuangan Yayasan Satriabudi Dharma Setia diaudit secara periodik oleh Kantor Akuntan Publik (KAP) independen serta dilaporkan kepada Kementerian Hukum dan HAM Republik Indonesia sesuai dengan ketentuan perundang-undangan yang berlaku.') }}
                </p>
            </div>
        </div>
    </div>
@endsection
