@extends('layouts.web')

@section('content')
    <div class="min-h-screen flex flex-col font-sans">
        <div class="w-full max-w-7xl mx-auto flex flex-col grow">

            <!-- Header Navbar Presisi Desain Gambar 2 -->
            <header
                class="bg-white rounded-sm shadow-xs mb-6 px-6 py-4 flex items-center justify-between sticky top-4 z-50">
                <!-- Logo Yayasan Satriabudi Dharma Setia Resmi -->
                <a href="{{ route('website.home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('assets/media/app/logo-ysds.png') }}" alt="Logo Yayasan Satriabudi Dharma Setia" class="h-10 sm:h-11 w-auto object-contain shrink-0 transition group-hover:scale-105" />
                    <div class="hidden sm:block leading-tight">
                        <span class="text-xs font-black text-slate-900 uppercase tracking-wider block">YAYASAN SATRIABUDI</span>
                        <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest block">DHARMA SETIA</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-6">
                    <a href="{{ route('website.home') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.home') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Beranda') }}</a>
                    <a href="{{ route('website.about') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.about') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Profil') }}</a>
                    <a href="{{ route('website.officers.public') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.officers.public') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Pengurus') }}</a>
                    <a href="{{ route('website.collaborations.public') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.collaborations*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Kolaborasi') }}</a>
                    <a href="{{ route('website.journals.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.journals*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Program & Jurnal') }}</a>
                    <a href="{{ route('website.issues.archive') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.issues*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Publikasi') }}</a>
                    <a href="{{ route('website.articles.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.articles*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition flex items-center gap-1.5"><i class="ki-filled ki-magnifier text-xs"></i> {{ __('Cari Artikel') }}</a>
                    <a href="{{ route('website.guidelines') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.guidelines') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Panduan') }}</a>
                    <a href="{{ route('website.announcements') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.announcements') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">{{ __('Pengumuman') }}</a>
                </nav>

                <!-- Action Button Kontak, Submit Article & Locale Switcher -->
                <div class="flex items-center space-x-3">
                    <!-- Public Locale Switcher -->
                    <div class="flex items-center border border-slate-200 rounded-xl p-0.5 bg-slate-50 text-xs font-bold shadow-2xs">
                        <a href="{{ route('locale.switch', 'id') }}" title="Bahasa Indonesia" class="px-2.5 py-1.5 rounded-lg transition {{ app()->getLocale() === 'id' ? 'bg-white text-red-600 shadow-xs font-extrabold' : 'text-slate-500 hover:text-slate-900' }}">
                            ID 🇮🇩
                        </a>
                        <a href="{{ route('locale.switch', 'en') }}" title="English" class="px-2.5 py-1.5 rounded-lg transition {{ app()->getLocale() === 'en' ? 'bg-white text-red-600 shadow-xs font-extrabold' : 'text-slate-500 hover:text-slate-900' }}">
                            EN 🇬🇧
                        </a>
                    </div>

                    <a href="{{ route('submissions.create.step1') }}"
                        class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                        <i class="ki-filled ki-cloud-change text-red-500"></i> {{ __('Submit Article') }}
                    </a>
                    <a href="{{ route('website.contact') }}"
                        class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1">
                        {{ __('Kontak') }} &nearr;
                    </a>
                </div>
            </header>

            <!-- Main Content Container Centered -->
            <main class="grow space-y-6">
                @yield('public_content')
            </main>

            <!-- Footer -->
            <footer class="bg-slate-950 text-slate-300 rounded-xl border border-slate-800 mt-12 overflow-hidden">
                <div class="px-6 sm:px-8 py-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="space-y-4 md:col-span-2">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('assets/media/app/logo-ysds.png') }}" alt="Logo Yayasan Satriabudi Dharma Setia" class="h-10 w-auto object-contain rounded bg-white/95 p-1 shrink-0 shadow-xs" />
                                <span class="text-base font-bold text-white tracking-tight">Yayasan Satriabudi Dharma Setia</span>
                            </div>
                            <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                                {{ __('Membangun Akses Kesehatan dan Pendidikan untuk Indonesia melalui publikasi ilmiah berkala, terpercaya, dan berstandar internasional.') }}
                            </p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">{{ __('Navigasi Publik') }}</h4>
                            <ul class="space-y-2 text-xs">
                                <li><a href="{{ route('website.about') }}"
                                        class="hover:text-white transition">{{ __('Profil & Tentang Kami') }}</a></li>
                                <li><a href="{{ route('website.officers.public') }}"
                                        class="hover:text-white transition">{{ __('Struktur Pengurus & Redaksi') }}</a></li>
                                <li><a href="{{ route('website.collaborations.public') }}"
                                        class="hover:text-white transition">{{ __('Kolaborasi & Penyerahan Alat') }}</a></li>
                                <li><a href="{{ route('website.journals.index') }}"
                                        class="hover:text-white transition">{{ __('Daftar Jurnal') }}</a></li>
                                <li><a href="{{ route('website.issues.archive') }}"
                                        class="hover:text-white transition">{{ __('Arsip Terbitan') }}</a></li>
                                <li><a href="{{ route('website.articles.index') }}"
                                        class="hover:text-white transition text-red-400 font-semibold">{{ __('Pencarian Artikel') }}</a></li>
                                <li><a href="{{ route('website.guidelines') }}" class="hover:text-white transition">{{ __('Panduan Penulis') }}</a></li>
                                <li><a href="{{ route('website.ethics') }}" class="hover:text-white transition">{{ __('Etika Publikasi') }}</a></li>
                                <li><a href="{{ route('website.indexing') }}" class="hover:text-white transition">{{ __('Informasi Pengindeksan') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">{{ __('Kontak & Informasi') }}</h4>
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
                                        <i class="ki-filled ki-arrow-up-right text-xs"></i> Situs Utama Yayasan (dharma.or.id)
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