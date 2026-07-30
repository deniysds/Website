@extends('website::layouts.public')

@section('public_content')
    <section class="bg-slate-900 text-white py-12 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Hubungi Kami</span>
            <h1 class="text-3xl font-extrabold text-white mt-1">Kontak Redaksi & Layanan Publik</h1>
        </div>
    </section>

    <section class="py-12 bg-slate-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Alamat Kantor Redaksi</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Yayasan Satriabudi Dharma Setia<br>
                        Gedung Publikasi IGNITE Lt. 4<br>
                        Jakarta, Indonesia
                    </p>
                    <div class="pt-4 border-t border-slate-100 space-y-2 text-sm text-slate-700">
                        <p class="flex items-center gap-2"><i class="ki-filled ki-sms text-red-600"></i> Email: info@satriabudi.org</p>
                        <p class="flex items-center gap-2"><i class="ki-filled ki-phone text-red-600"></i> Telepon: +62 21 1234 5678</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Kirim Pesan Pertanyaan</h3>
                    <form class="space-y-4 text-sm">
                        <div>
                            <label class="block font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="email@domain.com">
                        </div>
                        <div>
                            <label class="block font-medium text-slate-700 mb-1">Pesan</label>
                            <textarea rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-red-500 focus:outline-none" placeholder="Tuliskan pertanyaan atau kendala Anda..."></textarea>
                        </div>
                        <button type="button" class="w-full py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
