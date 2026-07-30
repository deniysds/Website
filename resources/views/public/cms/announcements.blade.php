@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Warta Publikasi</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Pengumuman & Pembaruan Sistem (Announcements)</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-3">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-red-50 text-red-600 border border-red-100">Pemberitahuan Sistem</span>
                    <h3 class="text-lg font-bold text-slate-900">Peluncuran Portal Publikasi Ilmiah IGNITE v2.0</h3>
                    <p class="text-xs text-slate-400">Dipublikasikan pada: 29 Juli 2026</p>
                    <p class="text-slate-600 text-sm leading-relaxed">Selamat datang di portal publikasi terbaru Yayasan Satriabudi Dharma Setia. Seluruh proses penyerahan naskah, peer-review, dan akses terbitan kini terintegrasi secara otomatis.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-3">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-slate-100 text-slate-700 border border-slate-200">Call for Papers</span>
                    <h3 class="text-lg font-bold text-slate-900">Call for Papers: Edisi Khusus Riset Genomik & Kesehatan Masyarakat 2026</h3>
                    <p class="text-xs text-slate-400">Dipublikasikan pada: 25 Juli 2026</p>
                    <p class="text-slate-600 text-sm leading-relaxed">Dewan redaksi mengundang para peneliti dan praktisi untuk mengirimkan hasil riset original terbaru untuk diterbitkan pada terbitan mendatang.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
