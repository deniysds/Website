@extends('website::layouts.public')

@section('public_content')
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-10 mb-8 shadow-xl">
        <div class="relative z-10">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">{{ __('Standar Akademik') }}</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">{{ __('Pernyataan Etika Publikasi & Malpraktik') }}</h1>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto space-y-6 pb-12">
        <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
            <div class="text-slate-700 leading-relaxed whitespace-pre-line bg-red-50/50 p-5 rounded-xl border border-red-100">
                {{ $settings['ethics_content'] ?? 'Seluruh jurnal di bawah naungan Yayasan Satriabudi Dharma Setia (IGNITE) berkomitmen penuh untuk menjunjung tinggi standar etika publikasi ilmiah berdasarkan pedoman Committee on Publication Ethics (COPE).' }}
            </div>

            <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">{{ __("1. Tanggung Jawab Penulis (Authors' Responsibilities)") }}</h3>
            <ul class="list-disc pl-5 space-y-2 text-slate-600 leading-relaxed">
                <li>Naskah yang diajukan harus orisinal, bebas plagiarisme, dan belum pernah dipublikasikan di jurnal lain.</li>
                <li>Semua data riset yang disajikan harus akurat dan bebas dari manipulasi (fabrication/falsification).</li>
                <li>Semua kontributor yang memberikan sumbangsih signifikan harus dicantumkan sebagai penulis atau rekan penulis.</li>
            </ul>

            <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">{{ __("2. Tanggung Jawab Penelaah (Reviewers' Responsibilities)") }}</h3>
            <ul class="list-disc pl-5 space-y-2 text-slate-600 leading-relaxed">
                <li>Menjaga kerahasiaan naskah yang ditelaah dan tidak menggunakannya untuk kepentingan pribadi.</li>
                <li>Memberikan masukan objektif dan konstruktif untuk meningkatkan mutu akademik naskah.</li>
                <li>Segera memberitahukan dewan redaksi jika terdapat konflik kepentingan.</li>
            </ul>

            <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">{{ __("3. Tanggung Jawab Dewan Redaksi (Editors' Responsibilities)") }}</h3>
            <ul class="list-disc pl-5 space-y-2 text-slate-600 leading-relaxed">
                <li>Mengambil keputusan penerimaan atau penolakan naskah semata-mata berdasarkan merit akademik dan relevansi riset.</li>
                <li>Menjamin kerahasiaan identitas penulis dan penelaah dalam sistem *double-blind review*.</li>
            </ul>
        </div>
    </div>
@endsection
