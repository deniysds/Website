@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Informasi Institusi</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Tentang IGNITE & Yayasan Satriabudi Dharma Setia</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-6 text-slate-700 leading-relaxed text-sm">
                <h3 class="text-xl font-bold text-slate-900">Visi dan Misi</h3>
                <p>Yayasan Satriabudi Dharma Setia didirikan dengan komitmen kuat untuk meningkatkan derajat kesehatan masyarakat dan pendidikan unggul di Indonesia. Melalui portal publikasi ilmiah IGNITE, kami memfasilitasi diseminasi riset-riset akademik berkualitas yang dapat diakses secara transparan oleh dunia ilmiah internasional.</p>

                <h3 class="text-xl font-bold text-slate-900 pt-4 border-t border-slate-100">Prinsip Tata Kelola Publikasi</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Independensi dewan redaksi dalam pengambilan keputusan penerimaan naskah.</li>
                    <li>Proses peer-review berbasis metode blind review yang transparan dan akuntabel.</li>
                    <li>Dukungan penuh terhadap gerakan Open Access (Akses Terbuka) untuk meningkatkan jangkauan dampak penelitian.</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
