@extends('layouts.web')

@section('content')
    <div class="min-h-screen flex flex-col font-sans">
        <div class="w-full max-w-7xl mx-auto flex flex-col grow">

            <!-- Header Navbar Presisi Desain Gambar 2 -->
            <header
                class="bg-white rounded-sm shadow-xs mb-6 px-6 py-4 flex items-center justify-between sticky top-4 z-50">
                <!-- Logo Yayasan Satriabudi Dharma Setia Grid Brand -->
                <a href="{{ route('website.home') }}" class="flex items-center gap-3">
                    <div class="w-12 h-10 border border-slate-300 rounded p-0.5 grid grid-cols-2 gap-0.5 bg-white shrink-0">
                        <div
                            class="bg-red-700 rounded-xs flex items-center justify-center text-[7px] font-black text-white leading-none">
                            SATRIA</div>
                        <div
                            class="bg-green-700 rounded-xs flex items-center justify-center text-[7px] font-black text-white leading-none">
                            BUDI</div>
                        <div
                            class="bg-blue-800 rounded-xs flex items-center justify-center text-[7px] font-black text-white leading-none">
                            DHARMA</div>
                        <div
                            class="bg-amber-500 rounded-xs flex items-center justify-center text-[7px] font-black text-white leading-none">
                            SETIA</div>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-xs font-black text-slate-900 uppercase tracking-wider block">YAYASAN
                            SATRIABUDI</span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block">DHARMA
                            SETIA</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('website.home') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.home') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Beranda</a>
                    <a href="{{ route('website.about') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.about') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Profil</a>
                    <a href="{{ route('website.journals.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.journals*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Program
                        & Jurnal</a>
                    <a href="{{ route('website.issues.archive') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.issues*') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Publikasi</a>
                    <a href="{{ route('website.guidelines') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.guidelines') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Panduan</a>
                    <a href="{{ route('website.announcements') }}"
                        class="text-sm font-semibold {{ request()->routeIs('website.announcements') ? 'text-red-600 font-bold' : 'text-slate-700 hover:text-red-600' }} transition">Pengumuman</a>
                </nav>

                <!-- Action Button Kontak & Submit Article -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('submissions.create.step1') }}"
                        class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md transition flex items-center gap-1.5">
                        <i class="ki-filled ki-cloud-change text-red-500"></i> Submit Article
                    </a>
                    <a href="{{ route('website.contact') }}"
                        class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1">
                        Kontak &nearr;
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
                                <div
                                    class="w-10 h-8 border border-slate-600 rounded p-0.5 grid grid-cols-2 gap-0.5 bg-slate-900 shrink-0">
                                    <div
                                        class="bg-red-700 rounded-xs flex items-center justify-center text-[6px] font-black text-white leading-none">
                                        SATRIA</div>
                                    <div
                                        class="bg-green-700 rounded-xs flex items-center justify-center text-[6px] font-black text-white leading-none">
                                        BUDI</div>
                                    <div
                                        class="bg-blue-800 rounded-xs flex items-center justify-center text-[6px] font-black text-white leading-none">
                                        DHARMA</div>
                                    <div
                                        class="bg-amber-500 rounded-xs flex items-center justify-center text-[6px] font-black text-white leading-none">
                                        SETIA</div>
                                </div>
                                <span class="text-base font-bold text-white tracking-tight">Yayasan Satriabudi Dharma
                                    Setia</span>
                            </div>
                            <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                                Membangun Akses Kesehatan dan Pendidikan untuk Indonesia melalui publikasi ilmiah berkala,
                                terpercaya, dan berstandar internasional.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Navigasi Publik</h4>
                            <ul class="space-y-2 text-xs">
                                <li><a href="{{ route('website.journals.index') }}"
                                        class="hover:text-white transition">Daftar Jurnal</a></li>
                                <li><a href="{{ route('website.issues.archive') }}"
                                        class="hover:text-white transition">Arsip Terbitan</a></li>
                                <li><a href="{{ route('website.guidelines') }}" class="hover:text-white transition">Panduan
                                        Penulis</a></li>
                                <li><a href="{{ route('website.ethics') }}" class="hover:text-white transition">Etika
                                        Publikasi</a></li>
                                <li><a href="{{ route('website.indexing') }}" class="hover:text-white transition">Informasi
                                        Pengindeksan</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Kontak & Informasi</h4>
                            <ul class="space-y-2 text-xs text-slate-400">
                                <li class="flex items-start gap-2"><i
                                        class="ki-filled ki-geolocation text-red-500 mt-0.5"></i> Jakarta, Indonesia</li>
                                <li class="flex items-center gap-2"><i class="ki-filled ki-sms text-red-500"></i>
                                    info@satriabudi.org</li>
                                <li class="flex items-center gap-2"><i class="ki-filled ki-phone text-red-500"></i> +62 21
                                    1234 5678</li>
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