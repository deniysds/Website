@extends('layouts.auth')

@section('content')
    <div class="min-h-screen bg-slate-50 text-slate-800 flex flex-col font-sans">
        <!-- Header / Navigation Bar -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('website.home') }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-red-600 to-rose-500 flex items-center justify-center text-white font-bold text-xl shadow-md">
                            I
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight text-slate-900">IGNITE</span>
                            <span class="block text-xs font-medium text-red-600 tracking-wider uppercase">Publishing Portal</span>
                        </div>
                    </a>
                </div>

                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('website.home') }}" class="text-sm font-semibold {{ request()->routeIs('website.home') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Home</a>
                    <a href="{{ route('website.journals.index') }}" class="text-sm font-semibold {{ request()->routeIs('website.journals*') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Daftar Jurnal</a>
                    <a href="{{ route('website.issues.archive') }}" class="text-sm font-semibold {{ request()->routeIs('website.issues*') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Arsip Terbitan</a>
                    <a href="{{ route('website.guidelines') }}" class="text-sm font-semibold {{ request()->routeIs('website.guidelines') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Panduan Penulis</a>
                    <a href="{{ route('website.about') }}" class="text-sm font-semibold {{ request()->routeIs('website.about') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Tentang Kami</a>
                    <a href="{{ route('website.contact') }}" class="text-sm font-semibold {{ request()->routeIs('website.contact') ? 'text-red-600' : 'text-slate-600 hover:text-red-600' }} transition">Kontak</a>
                </nav>

                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition shadow-sm">
                            <i class="ki-filled ki-element-11 mr-2 text-white"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-red-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition shadow-sm">
                            Kirim Naskah
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="grow">
            @yield('public_content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="space-y-4 md:col-span-2">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold text-lg">
                                I
                            </div>
                            <span class="text-lg font-bold text-white tracking-tight">Yayasan Satriabudi Dharma Setia (IGNITE)</span>
                        </div>
                        <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                            Membangun Akses Kesehatan dan Pendidikan untuk Indonesia melalui publikasi ilmiah berkala, terpercaya, dan berstandar internasional.
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigasi Publik</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('website.journals.index') }}" class="hover:text-white transition">Daftar Jurnal</a></li>
                            <li><a href="{{ route('website.issues.archive') }}" class="hover:text-white transition">Arsip Terbitan</a></li>
                            <li><a href="{{ route('website.guidelines') }}" class="hover:text-white transition">Panduan Penulis</a></li>
                            <li><a href="{{ route('website.announcements') }}" class="hover:text-white transition">Pengumuman</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kontak & Informasi</h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li class="flex items-start gap-2"><i class="ki-filled ki-geolocation text-red-500 mt-1"></i> Jakarta, Indonesia</li>
                            <li class="flex items-center gap-2"><i class="ki-filled ki-sms text-red-500"></i> info@satriabudi.org</li>
                            <li class="flex items-center gap-2"><i class="ki-filled ki-phone text-red-500"></i> +62 21 1234 5678</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p>&copy; {{ date('Y') }} IGNITE - Yayasan Satriabudi Dharma Setia. All rights reserved.</p>
                    <p>Powered by IGNITE Publishing System</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
