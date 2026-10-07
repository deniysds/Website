@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.documents.admin.index') }}" class="hover:text-red-600">Pusat Dokumen</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Edit Dokumen</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6 max-w-4xl">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('website.documents.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3 py-2">
                <i class="ki-filled ki-arrow-left mr-1"></i> Kembali
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Dokumen Publik</h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ $document->title }}</p>
            </div>
        </div>

        <form action="{{ route('website.documents.admin.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="kt-card p-6 sm:p-8 space-y-5">
                <!-- Judul Dokumen -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Judul Dokumen <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $document->title) }}" required
                           class="kt-input w-full text-xs">
                    @error('title')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori & Tahun Terbit -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Kategori Dokumen <span class="text-red-600">*</span>
                        </label>
                        <select name="category" required class="kt-select w-full text-xs">
                            <option value="laporan_tahunan" {{ old('category', $document->category) === 'laporan_tahunan' ? 'selected' : '' }}>Laporan Tahunan (Annual Report)</option>
                            <option value="laporan_keuangan" {{ old('category', $document->category) === 'laporan_keuangan' ? 'selected' : '' }}>Laporan Keuangan Teraudit</option>
                            <option value="legalitas_sk" {{ old('category', $document->category) === 'legalitas_sk' ? 'selected' : '' }}>Legalitas & SK Kemenkumham</option>
                            <option value="panduan_sop" {{ old('category', $document->category) === 'panduan_sop' ? 'selected' : '' }}>SOP & Panduan Program</option>
                            <option value="brosur_profil" {{ old('category', $document->category) === 'brosur_profil' ? 'selected' : '' }}>Brosur & Profil Yayasan</option>
                        </select>
                        @error('category')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Tahun Terbit / Periode
                        </label>
                        <input type="number" name="published_year" value="{{ old('published_year', $document->published_year) }}" min="2010" max="{{ date('Y') + 1 }}"
                               class="kt-input w-full text-xs">
                        @error('published_year')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Deskripsi / Keterangan Dokumen
                    </label>
                    <textarea name="description" rows="3" class="kt-textarea w-full text-xs">{{ old('description', $document->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Berkas Saat Ini & Opsi Penggantian -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Berkas Dokumen
                    </label>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center justify-between mb-3 text-xs">
                        <div class="flex items-center gap-2">
                            <i class="ki-filled ki-file text-blue-600 text-base"></i>
                            <span class="font-bold text-gray-800">{{ basename($document->file_path) }}</span>
                            <span class="text-gray-400">({{ $document->formatted_file_size }})</span>
                        </div>
                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 hover:underline font-bold text-xs">
                            Lihat Berkas Saat Ini &nearr;
                        </a>
                    </div>

                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center hover:border-blue-400 transition-colors">
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip"
                               class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        <p class="text-[11px] text-gray-400 mt-2">Kosongkan jika tidak ingin mengganti berkas yang ada. Maksimal 20MB.</p>
                    </div>
                    @error('file')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan & Status Aktif -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Nomor Urut Tampilan
                        </label>
                        <input type="number" name="order_no" value="{{ old('order_no', $document->order_no) }}" min="0" class="kt-input w-full text-xs">
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $document->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4">
                            <span class="text-xs font-bold text-gray-800">Publikasikan Langsung (Status Aktif)</span>
                        </label>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('website.documents.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-4 py-2">
                        Batal
                    </a>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-6 py-2.5">
                        <i class="ki-filled ki-check text-white mr-1"></i> Simpan Perubahan Dokumen
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
