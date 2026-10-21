@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.events.admin.index') }}" class="hover:text-red-600">Kegiatan &amp; Acara</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Edit Kegiatan</span>
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
                    <h1 class="text-2xl font-bold text-gray-900">Edit Kegiatan: {{ $event->title }}</h1>
                    <p class="text-xs text-gray-500 mt-1">Perbarui parameter acara, jadwal, pembicara, materi, atau gambar banner kegiatan.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('website.events.show', $event->slug) }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Lihat Halaman Publik
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="ki-filled ki-information text-red-600"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('website.events.admin.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Konten Utama (2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="kt-card p-6 space-y-5 shadow-xs">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Nama Kegiatan / Simposium <span class="text-red-600">*</span></label>
                            <input type="text" name="title" id="event_title" value="{{ old('title', $event->title) }}" class="kt-input w-full text-sm font-semibold" required onkeyup="updateSlugPreview(this.value)" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Slug URL</label>
                            <div class="flex items-center gap-1">
                                <span class="text-xs text-gray-400 font-mono bg-gray-50 px-3 py-2.5 rounded-l-lg border border-r-0 border-gray-200">/kegiatan/</span>
                                <input type="text" name="slug" id="event_slug" value="{{ old('slug', $event->slug) }}" class="kt-input w-full text-xs font-mono rounded-l-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Tag / Kategori Badge</label>
                                <input type="text" name="tag" value="{{ old('tag', $event->tag) }}" class="kt-input w-full text-xs" />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Tahun Pelaksanaan <span class="text-red-600">*</span></label>
                                <input type="text" name="year" value="{{ old('year', $event->year) }}" class="kt-input w-full text-xs font-bold" required />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Nomor Urut Prioritas</label>
                                <input type="number" name="order_no" value="{{ old('order_no', $event->order_no) }}" class="kt-input w-full text-xs" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Mitra Kolaborasi</label>
                                <input type="text" name="partner_name" value="{{ old('partner_name', $event->partner_name) }}" class="kt-input w-full text-xs" />
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Sponsor Pendukung</label>
                                <input type="text" name="sponsor_name" value="{{ old('sponsor_name', $event->sponsor_name) }}" class="kt-input w-full text-xs" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Ringkasan Singkat (Summary)</label>
                            <textarea name="summary" rows="3" class="kt-input w-full text-xs leading-relaxed">{{ old('summary', $event->summary) }}</textarea>
                            <span class="text-[10px] text-gray-400">Maksimal 1000 karakter.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Deskripsi Lengkap / Agenda</label>
                            <textarea name="description" rows="10" class="kt-input w-full text-xs leading-relaxed font-sans">{{ old('description', $event->description) }}</textarea>
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
                                <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500 mt-1" {{ old('is_published', $event->is_published) ? 'checked' : '' }} />
                                <div>
                                    <div class="text-xs font-bold text-gray-900">Publikasikan ke Website</div>
                                    <div class="text-[11px] text-gray-500">Dapat diakses oleh publik di portal web dan katalog kegiatan.</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500 mt-1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} />
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
                                <i class="ki-filled ki-check mr-1"></i> Perbarui Kegiatan
                            </button>
                        </div>
                    </div>

                    <!-- Jadwal & Lokasi -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-3">Jadwal &amp; Tempat</h3>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="text" name="event_date" value="{{ old('event_date', $event->event_date) }}" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Waktu / Jam</label>
                            <input type="text" name="event_time" value="{{ old('event_time', $event->event_time) }}" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Lokasi / Tempat</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tautan Registrasi / Pendaftaran</label>
                            <input type="text" name="registration_url" value="{{ old('registration_url', $event->registration_url) }}" class="kt-input w-full text-xs" />
                        </div>
                    </div>

                    <!-- Banner / Foto Kegiatan -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider border-b border-gray-150 pb-3">Banner / Poster Acara</h3>

                        <div class="space-y-2">
                            <input type="file" name="banner_image" accept="image/*" class="kt-input w-full text-xs" onchange="previewBanner(event)" />
                            <div class="text-[10px] text-gray-400">Format: JPG, PNG, WEBP. Maks 3MB.</div>
                        </div>

                        @if($event->banner_url)
                            <div id="current_banner_box" class="space-y-1">
                                <div class="text-[11px] font-semibold text-gray-500">Banner Saat Ini:</div>
                                <div class="rounded-xl border border-gray-200 overflow-hidden bg-gray-50 aspect-video relative">
                                    <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover" />
                                </div>
                            </div>
                        @endif

                        <div id="banner_preview_box" class="hidden rounded-xl border border-gray-200 overflow-hidden bg-gray-50 aspect-video relative">
                            <img id="banner_preview_img" src="#" alt="Pratinjau Banner Baru" class="w-full h-full object-cover" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function updateSlugPreview(title) {
            const slugInput = document.getElementById('event_slug');
            if (slugInput.dataset.manualEdit !== 'true') {
                slugInput.value = title
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        }

        document.getElementById('event_slug').addEventListener('input', function() {
            this.dataset.manualEdit = 'true';
        });

        function previewBanner(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('banner_preview_img').src = e.target.result;
                    document.getElementById('banner_preview_box').classList.remove('hidden');
                    const cur = document.getElementById('current_banner_box');
                    if (cur) cur.classList.add('opacity-50');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
