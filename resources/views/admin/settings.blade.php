@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <span>Website</span>
        <span>/</span>
        <span class="font-semibold text-gray-800">Landing Page Settings</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-success-50 border border-success-200 text-success-700 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="kt-card">
            <div class="kt-card-header min-h-16 py-5 border-b border-gray-200">
                <h3 class="kt-card-title text-xl font-bold">Pengaturan Landing Page Publik IGNITE</h3>
            </div>
            <div class="kt-card-body p-6">
                <form action="{{ route('website.settings.update') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Section: Hero Banner -->
                    <div class="space-y-4">
                        <h4 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-2">1. Hero Banner Section</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="kt-label font-medium text-gray-700">Hero Judul Utama (Heading)</label>
                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" class="kt-input w-full" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Hero Subtitle</label>
                                <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}" class="kt-input w-full" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Label Tombol Hero</label>
                                <input type="text" name="hero_button_text" value="{{ $settings['hero_button_text'] ?? '' }}" class="kt-input w-full" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Link Tombol Hero</label>
                                <input type="text" name="hero_button_url" value="{{ $settings['hero_button_url'] ?? '' }}" class="kt-input w-full" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Counter Stats -->
                    <div class="space-y-4">
                        <h4 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-2">2. Stat Counter Overlay (Banner Merah)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-2">
                                <label class="font-semibold text-xs text-gray-600">Statistik 1</label>
                                <input type="text" name="stat_1_number" value="{{ $settings['stat_1_number'] ?? '' }}" class="kt-input w-full" placeholder="150+" />
                                <input type="text" name="stat_1_label" value="{{ $settings['stat_1_label'] ?? '' }}" class="kt-input w-full" placeholder="Kerjasama Global" />
                            </div>
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-2">
                                <label class="font-semibold text-xs text-gray-600">Statistik 2</label>
                                <input type="text" name="stat_2_number" value="{{ $settings['stat_2_number'] ?? '' }}" class="kt-input w-full" placeholder="125 T" />
                                <input type="text" name="stat_2_label" value="{{ $settings['stat_2_label'] ?? '' }}" class="kt-input w-full" placeholder="Riset & Hibah Terbuka" />
                            </div>
                            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-2">
                                <label class="font-semibold text-xs text-gray-600">Statistik 3</label>
                                <input type="text" name="stat_3_number" value="{{ $settings['stat_3_number'] ?? '' }}" class="kt-input w-full" placeholder="79+" />
                                <input type="text" name="stat_3_label" value="{{ $settings['stat_3_label'] ?? '' }}" class="kt-input w-full" placeholder="Publikasi Ilmiah" />
                            </div>
                        </div>
                    </div>

                    <!-- Section: Profil -->
                    <div class="space-y-4">
                        <h4 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-2">3. Section Profil & Komitmen</h4>
                        <div class="space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="kt-label font-medium text-gray-700">Tag / Kategori Profil</label>
                                    <input type="text" name="profile_tag" value="{{ $settings['profile_tag'] ?? 'Profil' }}" class="kt-input w-full" placeholder="Profil" />
                                </div>
                                <div>
                                    <label class="kt-label font-medium text-gray-700">Label Tombol Profil</label>
                                    <input type="text" name="profile_button_text" value="{{ $settings['profile_button_text'] ?? 'Selengkapnya tentang kami' }}" class="kt-input w-full" placeholder="Selengkapnya tentang kami" />
                                </div>
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Judul Profil</label>
                                <input type="text" name="profile_title" value="{{ $settings['profile_title'] ?? '' }}" class="kt-input w-full" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Deskripsi Profil</label>
                                <textarea name="profile_desc" rows="2" class="kt-input w-full p-3">{{ $settings['profile_desc'] ?? '' }}</textarea>
                            </div>

                            <!-- 3 Pillars (Pendidikan, Kesehatan, Lingkungan) -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Pillar 1: Pendidikan</label>
                                    <input type="text" name="profile_box_1_title" value="{{ $settings['profile_box_1_title'] ?? 'Pendidikan' }}" class="kt-input w-full text-xs" />
                                    <textarea name="profile_box_1_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['profile_box_1_desc'] ?? '' }}</textarea>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Pillar 2: Kesehatan</label>
                                    <input type="text" name="profile_box_2_title" value="{{ $settings['profile_box_2_title'] ?? 'Kesehatan' }}" class="kt-input w-full text-xs" />
                                    <textarea name="profile_box_2_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['profile_box_2_desc'] ?? '' }}</textarea>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Pillar 3: Lingkungan</label>
                                    <input type="text" name="profile_box_3_title" value="{{ $settings['profile_box_3_title'] ?? 'Lingkungan' }}" class="kt-input w-full text-xs" />
                                    <textarea name="profile_box_3_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['profile_box_3_desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Pendekatan Terarah -->
                    <div class="space-y-4">
                        <h4 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-2">4. Section Metode (Pendekatan Terarah)</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="kt-label font-medium text-gray-700">Tag / Kategori Metode</label>
                                <input type="text" name="method_tag" value="{{ $settings['method_tag'] ?? 'Metode' }}" class="kt-input w-full" placeholder="Metode" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Judul Metode</label>
                                <input type="text" name="method_title" value="{{ $settings['method_title'] ?? '' }}" class="kt-input w-full" />
                            </div>
                            <div>
                                <label class="kt-label font-medium text-gray-700">Deskripsi Ringkas Metode</label>
                                <textarea name="method_desc" rows="2" class="kt-input w-full p-3">{{ $settings['method_desc'] ?? '' }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Langkah 1</label>
                                    <input type="text" name="method_step_1_title" value="{{ $settings['method_step_1_title'] ?? '' }}" class="kt-input w-full text-xs" />
                                    <textarea name="method_step_1_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['method_step_1_desc'] ?? '' }}</textarea>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Langkah 2</label>
                                    <input type="text" name="method_step_2_title" value="{{ $settings['method_step_2_title'] ?? '' }}" class="kt-input w-full text-xs" />
                                    <textarea name="method_step_2_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['method_step_2_desc'] ?? '' }}</textarea>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 space-y-2">
                                    <label class="text-xs font-bold text-gray-700">Langkah 3</label>
                                    <input type="text" name="method_step_3_title" value="{{ $settings['method_step_3_title'] ?? '' }}" class="kt-input w-full text-xs" />
                                    <textarea name="method_step_3_desc" rows="2" class="kt-input w-full p-2 text-xs">{{ $settings['method_step_3_desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="kt-btn kt-btn-primary text-white">
                            <i class="ki-filled ki-check text-white mr-1"></i> Simpan Perubahan CMS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
