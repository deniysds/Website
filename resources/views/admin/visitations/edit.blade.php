@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.visitations.admin.index') }}" class="hover:text-red-600">Visitasi Lapangan</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Edit Laporan</span>
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
            <h1 class="text-2xl font-bold text-gray-900">Edit Laporan Visitasi</h1>
            <p class="text-xs text-gray-500 mt-0.5">{{ $visitation->institution_name }} &bull; {{ $visitation->title }}</p>
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
        <form action="{{ route('website.visitations.admin.update', $visitation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <!-- Informasi Pokok Kunjungan -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    1. Informasi Pokok Kunjungan
                </h3>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Judul Laporan Visitasi <span class="text-red-600">*</span></label>
                    <input type="text" name="title" required value="{{ old('title', $visitation->title) }}" class="kt-input w-full text-xs" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nama Rumah Sakit / Instansi Faskes <span class="text-red-600">*</span></label>
                        <input type="text" name="institution_name" required value="{{ old('institution_name', $visitation->institution_name) }}" class="kt-input w-full text-xs" />
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tanggal Kunjungan / Serah Terima</label>
                        <input type="date" name="visit_date" value="{{ old('visit_date', $visitation->visit_date ? $visitation->visit_date->format('Y-m-d') : '') }}" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Kota / Kabupaten</label>
                        <input type="text" name="city" value="{{ old('city', $visitation->city) }}" class="kt-input w-full text-xs" />
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province', $visitation->province) }}" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tim Delegasi YSDS yang Hadir</label>
                    <input type="text" name="delegation_team" value="{{ old('delegation_team', $visitation->delegation_team) }}" class="kt-input w-full text-xs" />
                </div>
            </div>

            <!-- Narasi & Deskripsi Kunjungan -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    2. Narasi &amp; Hasil Kunjungan
                </h3>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Ringkasan Singkat (Summary)</label>
                    <textarea name="summary" rows="2" class="kt-input w-full text-xs p-3 leading-relaxed">{{ old('summary', $visitation->summary) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Laporan Lengkap &amp; Catatan Supervisi</label>
                    <textarea name="description" rows="6" class="kt-input w-full text-xs p-3 leading-relaxed">{{ old('description', $visitation->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tautan Video Dokumentasi (YouTube / Drive - Opsional)</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $visitation->video_url) }}" class="kt-input w-full text-xs" />
                </div>
            </div>

            <!-- Media Foto & Publikasi -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-b border-gray-100 pb-2">
                    3. Berkas Foto &amp; Status Publikasi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Ganti Foto Sampul Utama</label>
                        <input type="file" name="cover_image" accept="image/*" class="kt-input w-full text-xs p-2" />
                        @if($visitation->cover_image)
                        <div class="mt-2 flex items-center gap-2">
                            <img src="{{ $visitation->cover_image_url }}" alt="Cover" class="w-16 h-12 object-cover rounded-lg border border-gray-200" />
                            <span class="text-[11px] text-gray-500">Foto sampul aktif saat ini</span>
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Tambah Foto Galeri Lapangan (Multi)</label>
                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="kt-input w-full text-xs p-2" />
                        @if(!empty($visitation->gallery_images))
                        <div class="mt-2 text-[11px] text-gray-500">
                            Tersimpan {{ count($visitation->gallery_images) }} foto dalam galeri.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Urutan Tampil (Order No)</label>
                        <input type="number" name="order_no" value="{{ old('order_no', $visitation->order_no) }}" min="0" class="kt-input w-full text-xs" />
                    </div>

                    <div class="pt-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $visitation->is_published) ? 'checked' : '' }} class="kt-checkbox" />
                            <span class="font-bold text-gray-800">Publikasikan ke Portal Publik</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('website.visitations.admin.index') }}" class="kt-btn kt-btn-outline text-gray-600 text-xs px-4 py-2.5">
                    Batal
                </a>
                <button type="submit" class="kt-btn bg-red-600 hover:bg-red-700 text-white font-bold text-xs px-6 py-2.5">
                    Perbarui Laporan Visitasi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
