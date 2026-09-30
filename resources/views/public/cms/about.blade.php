@extends('website::layouts.public')

@section('public_content')
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-10 mb-8 shadow-xl">
        <div class="relative z-10">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __('Informasi Institusi') }}</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">{{ __('Tentang IGNITE & Yayasan Satriabudi Dharma Setia') }}</h1>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto space-y-6 pb-12">
        <!-- Leadership & Profile Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <i class="ki-filled ki-crown text-2xl"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">{{ __('Pendiri & Pembina Yayasan') }}</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['about_founder'] ?? 'Erlina V. F. Ratu (Pendiri sejak 2016)' }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                    <i class="ki-filled ki-user text-2xl"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">{{ __('Ketua Yayasan') }}</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-0.5">{{ $settings['about_chairman'] ?? 'dr. Vincentius Simeon Weo Budhyanto' }}</h4>
                </div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
            <div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Visi Yayasan') }}</h3>
                <p class="text-slate-600 leading-relaxed">
                    {{ $settings['about_vision'] ?? 'Membangun akses kesehatan prima dan pendidikan unggul untuk seluruh rakyat Indonesia melalui pemanfaatan sains, riset genomik, dan inovasi ilmiah terpercaya.' }}
                </p>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Misi Yayasan') }}</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['about_mission'] ?? "1. Menyelenggarakan dan mendanai riset genomik molekuler berstandar global.\n2. Membangun platform publikasi ilmiah berkala yang transparan dan akuntabel.\n3. Menyediakan bantuan fasilitas laboratorium dan diagnostik kesehatan untuk faskes di seluruh Indonesia.\n4. Mendukung pendidikan generasi muda melalui program beasiswa dan kemitraan akademik." }}
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Prinsip Tata Kelola Publikasi Ilmiah') }}</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['about_governance'] ?? "• Independensi dewan redaksi dalam pengambilan keputusan naskah tanpa konflik kepentingan.\n• Penelaahan sejawat berbasis blind peer-review yang akuntabel dan transparan.\n• Dukungan penuh terhadap gerakan Open Access (Akses Terbuka) dengan lisensi internasional Creative Commons." }}
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">
                    {{ __('Ingin melihat susunan dewan pembina, pengawas, pengurus harian, dan dewan redaksi jurnal lengkap?') }}
                </p>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('website.officers.public') }}" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                        <i class="ki-filled ki-people text-white"></i>
                        <span>{{ __('Struktur Pengurus') }}</span> &rarr;
                    </a>
                    <a href="{{ $settings['parent_website_url'] ?? 'https://www.dharma.or.id' }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                        <span>dharma.or.id</span> &nearr;
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
