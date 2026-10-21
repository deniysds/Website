@extends('layouts.web')

@section('content')
    <div class="min-h-screen flex flex-col font-sans min-w-0 max-w-full overflow-x-hidden">
        <div class="w-full max-w-[1440px] 2xl:max-w-[1560px] mx-auto flex flex-col grow min-w-0 px-3 sm:px-4 lg:px-6 2xl:px-8">

            <!-- Header Navbar Presisi Desain Responsive -->
            <header x-data="{ mobileMenuOpen: false }"
                class="bg-white rounded-2xl shadow-xs mb-6 px-3 sm:px-5 py-3 sm:py-3.5 sticky top-4 z-50 border border-slate-200/80 transition-all">
                <div class="flex items-center justify-between gap-2.5 2xl:gap-4">
                    <!-- Logo Yayasan Satriabudi Dharma Setia Resmi (Hanya Logo tanpa teks agar navbar lega) -->
                    <a href="{{ route('website.home') }}" class="flex items-center group shrink-0" title="Yayasan Satriabudi Dharma Setia">
                        <img src="{{ asset('assets/media/app/logo-ysds.png') }}" alt="Logo Yayasan Satriabudi Dharma Setia" class="h-9 sm:h-10 w-auto object-contain shrink-0 transition group-hover:scale-105" />
                    </a>

                    <!-- Navigation Links (Desktop) -->
                    <nav class="hidden xl:flex items-center gap-1 2xl:gap-2 text-xs 2xl:text-sm font-semibold shrink-0">
                        <!-- Beranda -->
                        <a href="{{ route('website.home') }}"
                            class="px-3 py-2 rounded-xl transition whitespace-nowrap {{ request()->routeIs('website.home') ? 'text-red-600 font-bold bg-red-50/70' : 'text-slate-700 hover:text-red-600 hover:bg-slate-50' }}">
                            {{ __('Beranda') }}
                        </a>

                        <!-- Dropdown 1: Tentang Kami -->
                        @php
                            $isAboutActive = request()->routeIs('website.about') || request()->routeIs('website.officers.public') || request()->routeIs('website.collaborations*') || request()->routeIs('website.visitations*');
                        @endphp
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-xl transition whitespace-nowrap {{ $isAboutActive ? 'text-red-600 font-bold bg-red-50/70' : 'text-slate-700 hover:text-red-600 hover:bg-slate-50' }}">
                                <span>{{ __('Tentang Kami') }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400 group-hover:text-red-600" :class="{ 'rotate-180 text-red-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 x-cloak
                                 class="absolute left-0 top-full pt-1.5 z-50 w-64 origin-top-left">
                                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-100 p-2 space-y-1">
                                    <a href="{{ route('website.about') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.about') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-badge text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Profil Yayasan') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Visi, misi, dan latar belakang') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.officers.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.officers.public') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-people text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Struktur Pengurus') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Pembina, pengawas & pengurus') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.collaborations.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.collaborations*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-briefcase text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Mitra & Kolaborasi') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Jejaring institusi & kerja sama') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.visitations.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.visitations*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-geolocation text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Visitasi Lapangan') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Monitoring & kegiatan lapangan') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown 2: Program & Layanan -->
                        @php
                            $isServicesActive = request()->routeIs('website.journals*') || request()->routeIs('website.assistance*') || request()->routeIs('website.donation*');
                        @endphp
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-xl transition whitespace-nowrap {{ $isServicesActive ? 'text-red-600 font-bold bg-red-50/70' : 'text-slate-700 hover:text-red-600 hover:bg-slate-50' }}">
                                <span>{{ __('Program & Layanan') }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400 group-hover:text-red-600" :class="{ 'rotate-180 text-red-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 x-cloak
                                 class="absolute left-0 top-full pt-1.5 z-50 w-72 origin-top-left">
                                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-100 p-2 space-y-1">
                                    <a href="{{ route('website.journals.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.journals*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-book-open text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Program & Jurnal') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Katalog riset dan publikasi berkala') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.assistance.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.assistance*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-shield-tick text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Permohonan Bantuan') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Pengajuan fasilitas & bantuan riset') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.donation.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.donation*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-heart text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight text-red-600">{{ __('Donasi & Rekening') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Partisipasi dukungan program kesehatan') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown 3: Publikasi -->
                        @php
                            $isPubActive = request()->routeIs('website.issues*') || request()->routeIs('website.articles*') || request()->routeIs('website.guidelines') || request()->routeIs('website.announcements') || request()->routeIs('website.ethics') || request()->routeIs('website.indexing');
                        @endphp
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-xl transition whitespace-nowrap {{ $isPubActive ? 'text-red-600 font-bold bg-red-50/70' : 'text-slate-700 hover:text-red-600 hover:bg-slate-50' }}">
                                <span>{{ __('Publikasi') }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400 group-hover:text-red-600" :class="{ 'rotate-180 text-red-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 x-cloak
                                 class="absolute left-0 top-full pt-1.5 z-50 w-72 origin-top-left">
                                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-100 p-2 space-y-1">
                                    <a href="{{ route('website.issues.archive') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.issues*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-archive text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Arsip Publikasi') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Volume & edisi terbitan jurnal') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.articles.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.articles*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-magnifier text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Cari Artikel') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Telusuri manuskrip riset & DOI') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.guidelines') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.guidelines') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-document text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Panduan Penulis') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Author guidelines & format penulisan') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.announcements') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.announcements') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-notification-status text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Pengumuman Redaksi') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Call for papers & warta redaksi') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown 4: Informasi -->
                        @php
                            $isInfoActive = request()->routeIs('website.news*') || request()->routeIs('website.documents*');
                        @endphp
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false">
                            <button type="button" @click="open = !open"
                                class="flex items-center gap-1.5 px-3 py-2 rounded-xl transition whitespace-nowrap {{ $isInfoActive ? 'text-red-600 font-bold bg-red-50/70' : 'text-slate-700 hover:text-red-600 hover:bg-slate-50' }}">
                                <span>{{ __('Informasi') }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400 group-hover:text-red-600" :class="{ 'rotate-180 text-red-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 x-cloak
                                 class="absolute left-0 top-full pt-1.5 z-50 w-64 origin-top-left">
                                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-100 p-2 space-y-1">
                                    <a href="{{ route('website.news.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.news*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-newspaper text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Berita & Warta') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Kabar terkini dan rilis kegiatan') }}</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('website.documents.public') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('website.documents*') ? 'bg-red-50 text-red-600 font-bold' : 'text-slate-700 hover:bg-slate-50 hover:text-red-600' }}">
                                        <div class="w-7 h-7 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                            <i class="ki-filled ki-file-down text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold leading-tight">{{ __('Pusat Dokumen') }}</div>
                                            <div class="text-[10px] text-slate-400 font-normal">{{ __('Unduhan formulir & regulasi resmi') }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Action Button Kontak, Submit Article & Locale Switcher (Desktop) -->
                    <div class="hidden xl:flex items-center gap-2 shrink-0">
                        <!-- Public Locale Switcher -->
                        <div class="flex items-center border border-slate-200 rounded-xl p-0.5 bg-slate-50 text-[11px] font-bold shadow-2xs">
                            <a href="{{ route('locale.switch', 'id') }}" title="Bahasa Indonesia" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() === 'id' ? 'bg-white text-red-600 shadow-xs font-extrabold' : 'text-slate-500 hover:text-slate-900' }}">
                                ID 🇮🇩
                            </a>
                            <a href="{{ route('locale.switch', 'en') }}" title="English" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() === 'en' ? 'bg-white text-red-600 shadow-xs font-extrabold' : 'text-slate-500 hover:text-slate-900' }}">
                                EN 🇬🇧
                            </a>
                        </div>

                        <a href="{{ route('submissions.create.step1') }}"
                            class="px-2.5 2xl:px-3.5 py-1.5 2xl:py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5 whitespace-nowrap">
                            <i class="ki-filled ki-cloud-change text-red-500"></i> {{ __('Submit Article') }}
                        </a>
                        <a href="{{ route('website.contact') }}"
                            class="px-2.5 2xl:px-3.5 py-1.5 2xl:py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1 whitespace-nowrap">
                            {{ __('Kontak') }} &nearr;
                        </a>
                    </div>

                    <!-- Mobile & Tablet Hamburger Toggle -->
                    <div class="flex xl:hidden items-center gap-2">
                        <!-- Locale switch for mobile -->
                        <div class="flex items-center border border-slate-200 rounded-lg p-0.5 bg-slate-50 text-[11px] font-bold">
                            <a href="{{ route('locale.switch', 'id') }}" class="px-2 py-1 rounded {{ app()->getLocale() === 'id' ? 'bg-white text-red-600 font-extrabold shadow-2xs' : 'text-slate-500' }}">ID</a>
                            <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-white text-red-600 font-extrabold shadow-2xs' : 'text-slate-500' }}">EN</a>
                        </div>

                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 transition focus:outline-none" aria-label="Toggle navigation">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile & Tablet Navigation Drawer/Dropdown -->
                <div x-show="mobileMenuOpen"
                     x-data="{ mobileGroup: null }"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     x-cloak
                     class="xl:hidden pt-4 mt-4 border-t border-slate-200/80 space-y-2">
                    <nav class="flex flex-col space-y-1 text-sm font-semibold text-slate-700">
                        <!-- Beranda -->
                        <a href="{{ route('website.home') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('website.home') ? 'text-red-600 font-bold bg-red-50/50' : '' }}">
                            {{ __('Beranda') }}
                        </a>

                        <!-- Mobile Group 1: Tentang Kami -->
                        <div>
                            <button type="button" @click="mobileGroup = (mobileGroup === 'about' ? null : 'about')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-100 text-left {{ $isAboutActive ? 'text-red-600 font-bold bg-red-50/50' : '' }}">
                                <span>{{ __('Tentang Kami') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-red-600': mobileGroup === 'about' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileGroup === 'about'" x-cloak class="pl-4 pr-2 py-1 space-y-1 border-l-2 border-slate-200 ml-3 mt-1">
                                <a href="{{ route('website.about') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.about') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Profil Yayasan') }}</a>
                                <a href="{{ route('website.officers.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.officers.public') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Struktur Pengurus') }}</a>
                                <a href="{{ route('website.collaborations.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.collaborations*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Mitra & Kolaborasi') }}</a>
                                <a href="{{ route('website.visitations.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.visitations*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Visitasi Lapangan') }}</a>
                            </div>
                        </div>

                        <!-- Mobile Group 2: Program & Layanan -->
                        <div>
                            <button type="button" @click="mobileGroup = (mobileGroup === 'services' ? null : 'services')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-100 text-left {{ $isServicesActive ? 'text-red-600 font-bold bg-red-50/50' : '' }}">
                                <span>{{ __('Program & Layanan') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-red-600': mobileGroup === 'services' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileGroup === 'services'" x-cloak class="pl-4 pr-2 py-1 space-y-1 border-l-2 border-slate-200 ml-3 mt-1">
                                <a href="{{ route('website.journals.index') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.journals*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Program & Jurnal') }}</a>
                                <a href="{{ route('website.assistance.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.assistance*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Permohonan Bantuan') }}</a>
                                <a href="{{ route('website.donation.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 text-red-600 font-bold">{{ __('Donasi & Rekening') }}</a>
                            </div>
                        </div>

                        <!-- Mobile Group 3: Publikasi -->
                        <div>
                            <button type="button" @click="mobileGroup = (mobileGroup === 'publications' ? null : 'publications')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-100 text-left {{ $isPubActive ? 'text-red-600 font-bold bg-red-50/50' : '' }}">
                                <span>{{ __('Publikasi') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-red-600': mobileGroup === 'publications' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileGroup === 'publications'" x-cloak class="pl-4 pr-2 py-1 space-y-1 border-l-2 border-slate-200 ml-3 mt-1">
                                <a href="{{ route('website.issues.archive') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.issues*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Arsip Publikasi') }}</a>
                                <a href="{{ route('website.articles.index') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.articles*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Cari Artikel') }}</a>
                                <a href="{{ route('website.guidelines') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.guidelines') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Panduan Penulis') }}</a>
                                <a href="{{ route('website.announcements') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.announcements') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Pengumuman Redaksi') }}</a>
                            </div>
                        </div>

                        <!-- Mobile Group 4: Informasi -->
                        <div>
                            <button type="button" @click="mobileGroup = (mobileGroup === 'info' ? null : 'info')"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-100 text-left {{ $isInfoActive ? 'text-red-600 font-bold bg-red-50/50' : '' }}">
                                <span>{{ __('Informasi') }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-red-600': mobileGroup === 'info' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileGroup === 'info'" x-cloak class="pl-4 pr-2 py-1 space-y-1 border-l-2 border-slate-200 ml-3 mt-1">
                                <a href="{{ route('website.news.index') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.news*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Berita & Warta') }}</a>
                                <a href="{{ route('website.documents.public') }}" class="block px-3 py-1.5 rounded-md text-xs hover:bg-slate-50 {{ request()->routeIs('website.documents*') ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ __('Pusat Dokumen') }}</a>
                            </div>
                        </div>
                    </nav>
                    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('submissions.create.step1') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs shadow transition flex items-center justify-center gap-1.5">
                            <i class="ki-filled ki-cloud-change text-red-500"></i> {{ __('Submit Article') }}
                        </a>
                        <a href="{{ route('website.contact') }}" class="w-full text-center px-4 py-2.5 rounded-xl bg-red-600 text-white font-bold text-xs shadow transition flex items-center justify-center gap-1">
                            {{ __('Kontak') }} &nearr;
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Container Centered -->
            <main class="grow space-y-6 min-w-0 max-w-full">
                @yield('public_content')
            </main>

            <!-- Footer -->
            <footer class="bg-slate-950 text-slate-300 rounded-xl border border-slate-800 mt-12 overflow-hidden">
                <div class="px-6 sm:px-8 py-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/media/app/logo-ysds.png') }}" alt="Logo Yayasan Satriabudi Dharma Setia" class="h-10 w-auto object-contain rounded bg-white/95 p-1 shrink-0 shadow-xs" />
                                <span class="text-base font-bold text-white tracking-tight">Yayasan Satriabudi Dharma Setia</span>
                            </div>
                            <p class="text-xs text-slate-400 max-w-sm leading-relaxed">
                                {{ __('Membangun Akses Kesehatan dan Pendidikan untuk Indonesia melalui publikasi ilmiah berkala, terpercaya, dan berstandar internasional.') }}
                            </p>
                            <div class="pt-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-950/80 border border-red-800/60 text-red-400 text-[11px] font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> YSDS Digital Ecosystem
                                </span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">{{ __('Navigasi Portal') }}</h4>
                            <ul class="space-y-2 text-xs">
                                <li><a href="{{ route('website.about') }}"
                                        class="hover:text-white transition">{{ __('Profil & Tentang Kami') }}</a></li>
                                <li><a href="{{ route('website.officers.public') }}"
                                        class="hover:text-white transition">{{ __('Struktur Pengurus & Staff') }}</a></li>
                                <li><a href="{{ route('website.collaborations.public') }}"
                                        class="hover:text-white transition">{{ __('Kolaborasi & Penyerahan Alat') }}</a></li>
                                <li><a href="{{ route('website.visitations.public') }}"
                                        class="hover:text-white transition">{{ __('Dokumentasi Visitasi Lapangan') }}</a></li>
                                <li><a href="{{ route('website.donation.public') }}"
                                        class="hover:text-white transition text-red-400 font-semibold">{{ __('Kanal Donasi & Rekening Resmi') }}</a></li>
                                <li><a href="{{ route('website.assistance.public') }}"
                                        class="hover:text-white transition text-slate-300">{{ __('Permohonan Bantuan Faskes') }}</a></li>
                                <li><a href="{{ route('website.assistance.track') }}"
                                        class="hover:text-white transition text-slate-400">{{ __('Lacak Status Permohonan') }}</a></li>
                                <li><a href="{{ route('website.journals.index') }}"
                                        class="hover:text-white transition">{{ __('Katalog Jurnal Ilmiah') }}</a></li>
                                <li><a href="{{ route('website.issues.archive') }}"
                                        class="hover:text-white transition">{{ __('Arsip Terbitan') }}</a></li>
                                <li><a href="{{ route('website.news.index') }}"
                                        class="hover:text-white transition">{{ __('Berita & Warta Populer') }}</a></li>
                                <li><a href="{{ route('website.documents.public') }}"
                                        class="hover:text-white transition text-red-400 font-semibold flex items-center gap-1.5"><i class="ki-filled ki-file-down text-xs"></i> {{ __('Pusat Dokumen & Unduhan Resmi') }}</a></li>
                                <li><a href="{{ route('website.articles.index') }}"
                                        class="hover:text-white transition text-red-400 font-semibold">{{ __('Pencarian Artikel Jurnal') }}</a></li>
                                <li><a href="{{ route('website.guidelines') }}" class="hover:text-white transition">{{ __('Panduan Penulis') }}</a></li>
                                <li><a href="{{ route('website.ethics') }}" class="hover:text-white transition">{{ __('Etika Publikasi') }}</a></li>
                                <li><a href="{{ route('website.indexing') }}" class="hover:text-white transition">{{ __('Informasi Pengindeksan') }}</a></li>
                                <li><a href="{{ url('/sitemap.xml') }}" target="_blank" class="hover:text-white transition text-slate-400 flex items-center gap-1 text-[11px]"><i class="ki-filled ki-code text-xs"></i> {{ __('Peta Situs (Sitemap XML)') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">{{ __('Unit & Ekosistem YSDS') }}</h4>
                            <ul class="space-y-2 text-xs text-slate-300">
                                <li>
                                    <a href="https://www.kliniksatriabudi.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span>Klinik Satriabudi Medika BSD</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://genom.dharma.or.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span>Program Riset Genomik</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://pelangi.sch.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span>Pelangi Indonesia Cyberschool</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://fensensius.sch.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span>SMK Fensensius</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                                <li class="pt-2 border-t border-slate-900">
                                    <a href="https://pacbio.dharma.or.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span class="text-slate-400">YSDS x PacBio Collaboration</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://ont.dharma.or.id" target="_blank" rel="noopener noreferrer" class="hover:text-white transition flex items-center justify-between group">
                                        <span class="text-slate-400">YSDS x Oxford Nanopore</span>
                                        <i class="ki-filled ki-arrow-up-right text-[10px] text-slate-500 group-hover:text-white"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">{{ __('Kontak & Operasional') }}</h4>
                            <ul class="space-y-2 text-xs text-slate-400">
                                <li class="flex items-start gap-2">
                                    <i class="ki-filled ki-geolocation text-red-500 mt-0.5 shrink-0"></i>
                                    <span>{{ $settings['contact_address'] ?? 'Ruko C-17, Pasar Modern Intermoda – BSD, Tangerang' }}</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="ki-filled ki-sms text-red-500 shrink-0"></i>
                                    <a href="mailto:{{ $settings['contact_email'] ?? 'admin@dharma.or.id' }}" class="hover:text-white transition">{{ $settings['contact_email'] ?? 'admin@dharma.or.id' }}</a>
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="ki-filled ki-phone text-red-500 shrink-0"></i>
                                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['contact_phone'] ?? '02150208805') }}" class="hover:text-white transition">{{ $settings['contact_phone'] ?? '(021) 5020-8805' }}</a>
                                </li>
                                @if(!empty($settings['contact_whatsapp']))
                                    <li class="flex items-center gap-2">
                                        <i class="ki-filled ki-whatsapp text-emerald-500 shrink-0"></i>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_whatsapp']) }}" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition">WA: {{ $settings['contact_whatsapp'] }}</a>
                                    </li>
                                @endif
                                <li class="pt-2 border-t border-slate-900">
                                    <a href="{{ $settings['parent_website_url'] ?? 'https://www.dharma.or.id' }}" target="_blank" class="text-red-400 hover:text-red-300 transition flex items-center gap-1.5 font-semibold text-[11px]">
                                        <i class="ki-filled ki-arrow-up-right text-xs"></i> Situs Resmi Yayasan (dharma.or.id)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        class="mt-10 pt-6 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <p>&copy; {{ date('Y') }} IGNITE - Yayasan Satriabudi Dharma Setia. All rights reserved.</p>
                        <p>Powered by IGNITE Publishing System</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection