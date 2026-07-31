@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-950 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Standar Akademik</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Pernyataan Etika Publikasi & Malpraktik</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
                <p>Seluruh jurnal di bawah naungan <strong>Yayasan Satriabudi Dharma Setia (IGNITE)</strong> berkomitmen penuh untuk menjunjung tinggi standar etika publikasi ilmiah berdasarkan pedoman Committee on Publication Ethics (COPE).</p>

                <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">1. Tanggung Jawab Penulis (Authors' Responsibilities)</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Naskah yang diajukan harus orisinal, bebas plagiarisme, dan belum pernah dipublikasikan di jurnal lain.</li>
                    <li>Semua data riset yang disajikan harus akurat dan bebas dari manipulasi (fabrication/falsification).</li>
                    <li>Semua kontributor yang memberikan sumbangsih signifikan harus dicantumkan sebagai penulis atau rekan penulis.</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">2. Tanggung Jawab Penelaah (Reviewers' Responsibilities)</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Menjaga kerahasiaan naskah yang ditelaah dan tidak menggunakannya untuk kepentingan pribadi.</li>
                    <li>Memberikan masukan objektif dan konstruktif untuk meningkatkan mutu akademik naskah.</li>
                    <li>Segera memberitahukan dewan redaksi jika terdapat konflik kepentingan.</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-4 border-t border-slate-100">3. Tanggung Jawab Dewan Redaksi (Editors' Responsibilities)</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Mengambil keputusan penerimaan atau penolakan naskah semata-mata berdasarkan merit akademik dan relevansi riset.</li>
                    <li>Menjamin kerahasiaan identitas penulis dan penelaah dalam sistem *double-blind review*.</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
