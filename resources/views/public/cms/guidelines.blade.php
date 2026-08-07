@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Petunjuk Penulis</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Panduan Penulisan & Penyerahan Naskah (Author Guidelines)</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
                <h3 class="text-xl font-bold text-slate-900">1. Ketentuan Umum Naskah</h3>
                <p>Naskah yang dikirimkan harus merupakan karya orisinal yang belum pernah dipublikasikan di jurnal lain dan tidak sedang dalam proses penelaahan di media ilmiah manapun.</p>

                <h3 class="text-xl font-bold text-slate-900 pt-4 border-t border-slate-100">2. Struktur Penulisan Artikel</h3>
                <ol class="list-decimal pl-5 space-y-2">
                    <li><strong>Judul:</strong> Singkat, padat, dan mencerminkan isi riset (maksimal 18 kata).</li>
                    <li><strong>Abstrak & Kata Kunci:</strong> Abstrak dwibahasa (Indonesia & Inggris) antara 150 - 250 kata, disertai 3-5 kata kunci.</li>
                    <li><strong>Pendahuluan (Introduction):</strong> Latar belakang, kebaruan (novelty), dan tujuan penelitian.</li>
                    <li><strong>Metode Penelitian (Methods):</strong> Rincian prosedur riset, desain sampel, serta analisis data.</li>
                    <li><strong>Hasil & Pembahasan (Results & Discussion):</strong> Penyajian data objektif didukung tabel/grafik dan komparasi literatur.</li>
                    <li><strong>Kesimpulan (Conclusion):</strong> Ringkasan hasil utama dan implikasi riset.</li>
                    <li><strong>Referensi:</strong> Menggunakan gaya pengutipan standar IEEE / APA dengan manajer referensi (Mendeley/Zotero).</li>
                </ol>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-slate-900">Siap Mengirimkan Naskah Ilmiah Anda?</h4>
                        <p class="text-xs text-slate-500">Mulai langkah pertama pengajuan naskah ilmiah melalui sistem wizard online IGNITE.</p>
                    </div>
                    <a href="{{ route('submissions.create.step1') }}" class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-xs shadow-md transition flex items-center gap-2">
                        <i class="ki-filled ki-cloud-change"></i> Submit Article Sekarang &nearr;
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
