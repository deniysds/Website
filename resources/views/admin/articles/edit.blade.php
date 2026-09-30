@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.articles.admin.index') }}" class="hover:text-red-600">Artikel Non-Jurnal</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Edit Artikel</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('website.articles.admin.index') }}" class="kt-btn kt-btn-outline kt-btn-icon text-gray-600">
                    <i class="ki-filled ki-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Artikel Non-Jurnal</h1>
                    <p class="text-xs text-gray-500 mt-1">Perbarui judul, ringkasan, isi naskah, sampul, atau status publikasi artikel.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('website.news.show', $article->slug) }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Publik
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

        <form action="{{ route('website.articles.admin.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kolom Kiri: Konten Utama (2 Kolom) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="kt-card p-6 space-y-5 shadow-xs">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Judul Artikel <span class="text-red-600">*</span></label>
                            <input type="text" name="title" id="article_title" value="{{ old('title', $article->title) }}" placeholder="Masukkan judul artikel yang menarik..." class="kt-input w-full text-sm font-semibold" required />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Slug URL</label>
                            <div class="flex items-center gap-1">
                                <span class="text-xs text-gray-400 font-mono bg-gray-50 px-3 py-2.5 rounded-l-lg border border-r-0 border-gray-200">/berita/</span>
                                <input type="text" name="slug" id="article_slug" value="{{ old('slug', $article->slug) }}" class="kt-input w-full text-xs font-mono rounded-l-none" />
                            </div>
                            <span class="text-[10px] text-gray-400">Harus unik dan ramah SEO. Mengubah slug dapat mempengaruhi tautan yang telah dibagikan.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Ringkasan Singkat / Lead Paragraph</label>
                            <textarea name="summary" rows="3" placeholder="Tuliskan 1-2 paragraf ringkasan penting..." class="kt-input w-full text-xs leading-relaxed">{{ old('summary', $article->summary) }}</textarea>
                            <span class="text-[10px] text-gray-400">Maksimal 1000 karakter.</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-800 uppercase tracking-wider">Isi Lengkap Artikel <span class="text-red-600">*</span></label>
                            <textarea name="content" id="article_content" rows="18" placeholder="Tuliskan isi artikel lengkap..." class="kt-input w-full text-xs font-normal leading-relaxed font-sans" required>{{ old('content', $article->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Pengaturan & Publikasi (1 Kolom) -->
                <div class="space-y-6">
                    <!-- Status Publikasi Card -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-gray-900 border-b border-gray-150 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-send text-red-600"></i> Publikasi
                        </h3>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div>
                                <span class="text-xs font-bold text-gray-800 block">Status Publikasi</span>
                                <span class="text-[10px] text-gray-500">Dapat dibaca oleh umum jika aktif</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $article->is_published ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <div>
                                <span class="text-xs font-bold text-gray-800 block">Jadikan Sorotan Utama</span>
                                <span class="text-[10px] text-gray-500">Ditampilkan sebagai banner unggulan di katalog</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" class="sr-only peer" {{ old('is_featured', $article->is_featured ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tanggal Terbit</label>
                            <input type="date" name="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d') : '') }}" class="kt-input w-full text-xs font-mono" />
                        </div>

                        <div class="p-3 bg-slate-50 rounded-xl text-xs space-y-1 text-slate-600 border border-slate-200">
                            <div class="flex justify-between">
                                <span>Total Tayangan:</span>
                                <strong class="font-mono">{{ number_format($article->views_count) }} kali</strong>
                            </div>
                            <div class="flex justify-between">
                                <span>Estimasi Baca:</span>
                                <strong>{{ $article->reading_time }}</strong>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center gap-2">
                            <button type="submit" class="kt-btn kt-btn-primary w-full text-white text-xs font-semibold py-2.5">
                                <i class="ki-filled ki-check mr-1 text-white"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('website.articles.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Metadata Kategori & Penulis -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-gray-900 border-b border-gray-150 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-category text-red-600"></i> Metadata Artikel
                        </h3>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Kategori <span class="text-red-600">*</span></label>
                            <select name="category" class="kt-select w-full text-xs" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $article->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Penulis / Kontributor</label>
                            <input type="text" name="author_name" value="{{ old('author_name', $article->author_name) }}" class="kt-input w-full text-xs" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-700">Tagar / Kata Kunci</label>
                            <input type="text" name="tags" value="{{ old('tags', $article->tags) }}" placeholder="Contoh: genomik, riset, beasiswa, kesehatan" class="kt-input w-full text-xs" />
                            <span class="text-[10px] text-gray-400">Pisahkan dengan tanda koma (,).</span>
                        </div>
                    </div>

                    <!-- Gambar Sampul -->
                    <div class="kt-card p-6 space-y-4 shadow-xs">
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-gray-900 border-b border-gray-150 pb-3 flex items-center gap-2">
                            <i class="ki-filled ki-picture text-red-600"></i> Gambar Sampul (Cover)
                        </h3>

                        <div class="space-y-3">
                            <div id="image_preview_box" class="w-full h-40 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-400 text-xs overflow-hidden relative">
                                @if($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover rounded-xl" />
                                @else
                                    <i class="ki-filled ki-picture text-3xl mb-1 text-slate-300"></i>
                                    <span>Belum ada foto sampul</span>
                                @endif
                            </div>

                            <input type="file" name="image" id="article_image_input" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" onchange="previewArticleImage(this)" />
                            <span class="text-[10px] text-gray-400 block">Pilih gambar baru untuk mengganti sampul yang ada. Format JPG, PNG, WEBP (maks. 3MB).</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewArticleImage(input) {
            const box = document.getElementById('image_preview_box');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    box.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-xl" />`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
