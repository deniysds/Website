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
                <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['guidelines_general'] ?? 'Naskah yang dikirimkan harus merupakan karya orisinal yang belum pernah dipublikasikan di jurnal lain dan tidak sedang dalam proses penelaahan di media ilmiah manapun.' }}
                </div>

                <h3 class="text-xl font-bold text-slate-900 pt-4 border-t border-slate-100">2. Struktur Penulisan Artikel</h3>
                <div class="text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-200">
                    {{ $settings['guidelines_structure'] ?? "1. Judul: Singkat, padat, dan mencerminkan substansi riset (maksimal 18 kata).\n2. Abstrak & Kata Kunci: Dwibahasa (Indonesia & Inggris) antara 150-250 kata dengan 3-5 kata kunci.\n3. Pendahuluan (Introduction): Latar belakang, urgensi, kebaruan (novelty), dan hipotesis/tujuan.\n4. Metode (Methods): Prosedur riset, instrumen laboratorium, kelaikan etik, dan analisis statistik.\n5. Hasil & Pembahasan (Results & Discussion): Temuan objektif dengan visualisasi tabel/grafik beresolusi tinggi.\n6. Kesimpulan: Ringkasan temuan utama dan rekomendasi riset lanjutan.\n7. Referensi: Format IEEE/APA dengan referensi primer minimal 80% dari 5 tahun terakhir." }}
                </div>

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
