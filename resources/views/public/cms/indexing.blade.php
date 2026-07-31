@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-950 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Pengindeksan & Repositori</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Informasi Pengindeksan & Pengenalan Digital (Indexing)</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
                <p>Seluruh artikel yang dipublikasikan pada portal IGNITE dikelola dengan metadata terstruktur dan siap terhubung ke database pengindeksan nasional maupun internasional.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 font-bold flex items-center justify-center text-lg">
                            <i class="ki-filled ki-document"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Identifikasi DOI & Crossref</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Setiap naskah yang terbit diberikan nomor Digital Object Identifier (DOI) permanen yang terdaftar di Crossref.</p>
                    </div>

                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 font-bold flex items-center justify-center text-lg">
                            <i class="ki-filled ki-shield-check"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Pengindeksan Nasional (SINTA)</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Penyelarasan standar tata kelola jurnal sesuai instrumen akreditasi Jurnal Ilmiah Kemendikbudristek (SINTA).</p>
                    </div>

                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 font-bold flex items-center justify-center text-lg">
                            <i class="ki-filled ki-eye"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Google Scholar & GARUDA</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Pengindeksan otomatis ke Google Scholar dan Portal GARUDA untuk memaksimalkan keterbacaan artikel.</p>
                    </div>

                    <div class="p-6 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 font-bold flex items-center justify-center text-lg">
                            <i class="ki-filled ki-folder"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base">Preservasi Digital (PKP PN)</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Arsip digital tersimpan aman dalam jaringan preservasi naskah untuk menjamin aksesibilitas jangka panjang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
