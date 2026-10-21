@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.events.admin.index') }}" class="hover:text-red-600">Kegiatan &amp; Acara</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Tambah Kegiatan Baru</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('website.events.admin.index') }}" class="kt-btn kt-btn-outline kt-btn-icon text-gray-600">
                    <i class="ki-filled ki-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Kegiatan / Acara Baru</h1>
                    <p class="text-xs text-gray-500 mt-1">Publikasikan simposium, workshop teknologi molekuler, seminar genomik, dan forum kemitraan.</p>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="ki-filled ki-information text-red-600"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('website.events.admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Konten Utama (2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="kt-card p-6 space-y-5 shadow-xs">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Nama Kegiatan / Simposium <span class="text-red-600">*</span></label>
                            <input type="text" name="title" id="event_title" value="{{ old('title') }}" placeholder="Contoh: BioAI and Genomics Symposium - Indonesia" class="kt-input w-full text-sm font-semibold" required onkeyup="updateSlugPreview(this.value)" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Slug URL (Opsional / Otomatis)</label>
                            <div class="flex items-center gap-1">
                                <span class="text-xs text-gray-400 font-mono bg-gray-50 px-3 py-2.5 rounded-l-lg border border-r-0 border-gray-200">/kegiatan/</span>
                                <input type="text" name="slug" id="event_slug" value="{{ old('slug') }}" placeholder="bioai-and-genomics-symposium-indonesia" class="kt-input w-full text-xs font-mono rounded-l-none" />
                            </div>
                            <span class="text-[10px] text-gray-400">Dibiarkan kosong untuk membuat slug otomatis dari nama kegiatan.</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Tag / Kategori Badge</label>
                                <input type="text" name="tag" value="{{ old('tag', 'Kegiatan Terbaru') }}" placeholder="Kegiatan Terbaru" class="kt-input w-full text-xs" />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Tahun Pelaksanaan <span class="text-red-600">*</span></label>
                                <input type="text" name="year" value="{{ old('year', date('Y')) }}" placeholder="2026" class="kt-input w-full text-xs font-bold" required />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Nomor Urut Prioritas</label>
                                <input type="number" name="order_no" value="{{ old('order_no', 1) }}" class="kt-input w-full text-xs" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Mitra Kolaborasi</label>
                                <input type="text" name="partner_name" value="{{ old('partner_name') }}" placeholder="Contoh: Ultima Genomic" class="kt-input w-full text-xs" />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Sponsor Pendukung</label>
                                <input type="text" name="sponsor_name" value="{{ old('sponsor_name') }}" placeholder="Contoh: Panin Bank" class="kt-input w-full text-xs" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Ringkasan Singkat (Summary)</label>
                            <textarea name="summary" rows="3" placeholder="Tuliskan 1-2 kalimat ringkasan kegiatan untuk kartu beranda dan katalog..." class="kt-input w-full text-xs leading-relaxed">{{ old('summary') }}</textarea>
                            <span class="text-[10px] text-gray-400">Maksimal 1000 karakter.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Deskripsi Lengkap / Agenda</label>
                            <textarea name="description" rows="10" placeholder="Tuliskan latar belakang, tujuan, topik ilmiah, susunan acara, dan pembicara..." class="kt-input w-full text-xs leading-relaxed font-sans">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Parameter, Jadwal, Lokasi & Publikasi -->
                <div class="space-y-6">
                    <!-- Status & Visibilitas -->
                    <div class="kt-card p-6 space-y-5 shadow-xs">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-3">Status &amp; Tampilan</h3>

                        <div class="space-y-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500 mt-1" {{ old('is_published', true) ? 'checked' : '' }} />
                                <div>
                                    <div class="text-xs font-bold text-gray-900">Publikasikan ke Website</div>
                                    <div class="text-[11px] text-gray-500">Dapat diakses oleh publik di portal web dan katalog kegiatan.</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500 mt-1" {{ old('is_featured', false) ? 'checked' : '' }} />
                                <div>
                                    <div class="text-xs font-bold text-gray-900">Sorotan Beranda (Featured)</div>
                                    <div class="text-[11px] text-gray-500">Tampilkan pada Section "Kegiatan Terbaru" di Homepage publik.</div>
                                </div>
                            </label>
                        </div>

                        <div class="pt-4 border-t border-gray-150 flex items-center justify-between gap-3">
                            <a href="{{ route('website.events.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                                Batal
                            </a>
                            <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-5 py-2.5">
                                <i class="ki-filled ki-check mr-1"></i> Simpan Kegiatan
                            </button>
                        </div>
                    </div>

                    <!-- Jadwal & Lokasi -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-3">Jadwal &amp; Tempat</h3>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="text" name="event_date" value="{{ old('event_date') }}" placeholder="Contoh: Kamis, 15 Mei 2026" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Waktu / Jam</label>
                            <input type="text" name="event_time" value="{{ old('event_time') }}" placeholder="Contoh: 10.00 - 16.00 WIB" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Lokasi / Tempat</label>
                            <input type="text" name="location" value="{{ old('location') }}" placeholder="Contoh: Jakarta Convention Center & Hybrid" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tautan Registrasi / Pendaftaran</label>
                            <input type="text" name="registration_url" value="{{ old('registration_url', '/contact') }}" placeholder="https://... atau /contact" class="kt-input w-full text-xs" />
                        </div>
                    </div>

                    <!-- Banner / Foto Kegiatan -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-3">Banner / Poster Acara</h3>

                        <div class="space-y-2">
                            <input type="file" name="banner_image" accept="image/*" class="kt-input w-full text-xs" onchange="previewBanner(event)" />
                            <div class="text-[10px] text-gray-400">Format: JPG, PNG, WEBP. Maks 3MB. Disarankan rasio 16:9 atau 4:3.</div>
                        </div>

                        <div id="banner_preview_box" class="hidden rounded-xl border border-gray-200 overflow-hidden bg-gray-50 aspect-video relative">
                            <img id="banner_preview_img" src="#" alt="Pratinjau Banner" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function updateSlugPreview(title) {
            const slugInput = document.getElementById('event_slug');
            if (!slugInput.dataset.touched) {
                slugInput.value = title
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        }

        document.getElementById('event_slug').addEventListener('input', function() {
            this.dataset.touched = 'true';
        });

        function previewBanner(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('banner_preview_img').src = e.target.result;
                    document.getElementById('banner_preview_box').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
