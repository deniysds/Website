@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.visitations.admin.index') }}" class="hover:text-red-600">Visitasi Lapangan</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Tambah Laporan</span>
    </div>
@endsection

@section('content')
<div class="container-fixed py-6 max-w-4xl space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('website.visitations.admin.index') }}" class="p-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 transition" title="Kembali">
            <i class="ki-filled ki-arrow-left text-base"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Laporan Visitasi</h1>
            <p class="text-xs text-gray-500 mt-0.5">Dokumentasikan agenda kunjungan tim YSDS ke faskes daerah.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-xs space-y-1">
            <div class="font-bold flex items-center gap-1">
                <i class="ki-filled ki-information"></i> Terdapat kesalahan pengisian formulir:
            </div>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="kt-card p-6 sm:p-8">
        <form action="{{ route('website.visitations.admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf

            <!-- Informasi Pokok Kunjungan -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    1. Informasi Pokok Kunjungan
                </h3>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Judul Laporan Visitasi <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Visitasi Penyerahan Mesin PCR & Pelatihan Diagnostik RSUD TC Hillers Maumere" class="kt-input w-full text-xs" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nama Rumah Sakit / Instansi Faskes <span class="text-red-600">*</span></label>
                        <input type="text" name="institution_name" required value="{{ old('institution_name') }}" placeholder="Contoh: RSUD Dr. T.C. Hillers Maumere" class="kt-input w-full text-xs" />
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tanggal Kunjungan / Serah Terima</label>
                        <input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="Contoh: Kabupaten Sikka" class="kt-input w-full text-xs" />
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province') }}" placeholder="Contoh: Nusa Tenggara Timur" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tim Delegasi YSDS yang Hadir</label>
                    <input type="text" name="delegation_team" value="{{ old('delegation_team') }}" placeholder="Contoh: dr. Vincent, Sp.PK & Tim Teknis YSDS" class="kt-input w-full text-xs" />
                </div>
            </div>

            <!-- Narasi & Deskripsi Kunjungan -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    2. Narasi &amp; Hasil Kunjungan
                </h3>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Ringkasan Singkat (Summary)</label>
                    <textarea name="summary" rows="2" placeholder="Ringkasan 1-2 kalimat mengenai fokus dan hasil kunjungan..." class="kt-input w-full text-xs p-3 leading-relaxed">{{ old('summary') }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Laporan Lengkap &amp; Catatan Supervisi</label>
                    <textarea name="description" rows="6" placeholder="Tuliskan jalannya agenda visitasi, spesifikasi peralatan yang diserahkan, sesi pelatihan, dan kesiapan analis lab..." class="kt-input w-full text-xs p-3 leading-relaxed">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tautan Video Dokumentasi (YouTube / Drive - Opsional)</label>
                    <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="kt-input w-full text-xs" />
                </div>
            </div>

            <!-- Media Foto & Publikasi -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    3. Berkas Foto &amp; Status Publikasi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Foto Sampul Utama (Cover Image)</label>
                        <input type="file" name="cover_image" accept="image/*" class="kt-input w-full text-xs p-2" />
                        <span class="text-[11px] text-gray-400 mt-1 block">Format: JPG, PNG, WEBP. Maks: 3MB.</span>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Galeri Foto Lapangan Tambahan (Multi)</label>
                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="kt-input w-full text-xs p-2" />
                        <span class="text-[11px] text-gray-400 mt-1 block">Dapat memilih lebih dari 1 file foto dokumentasi.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Urutan Tampil (Order No)</label>
                        <input type="number" name="order_no" value="{{ old('order_no', 0) }}" min="0" class="kt-input w-full text-xs" />
                    </div>

                    <div class="pt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }} class="kt-checkbox" />
                            <span class="font-bold text-gray-800">Publikasikan Langsung ke Portal Publik</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('website.visitations.admin.index') }}" class="kt-btn kt-btn-outline text-gray-600 text-xs px-4 py-2.5">
                    Batal
                </a>
                <button type="submit" class="kt-btn bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-6 py-2.5">
                    Simpan Laporan Visitasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
