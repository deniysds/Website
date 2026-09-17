@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <span>Website</span>
        <span>/</span>
        <span class="font-semibold text-gray-800">Master Pengaturan Konten & CMS</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-xl bg-success-50 border border-success-200 text-success-700 text-sm font-medium flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-success-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="kt-card shadow-sm">
            <div class="kt-card-header min-h-16 py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="kt-card-title text-xl font-bold text-gray-900">Master Pengaturan Konten & CMS Publik IGNITE</h3>
                    <p class="text-xs text-gray-500 mt-1">Kelola kontak resmi yayasan, alamat kantor, profil pimpinan, dan pedoman jurnal tanpa hardcoding.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('website.collaborations.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                        <i class="ki-filled ki-briefcase mr-1"></i> Kolaborasi & Alat
                    </a>
                    <a href="{{ route('website.officers.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                        <i class="ki-filled ki-people mr-1"></i> Dewan Pengurus
                    </a>
                    <a href="{{ route('website.partners.index') }}" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                        <i class="ki-filled ki-element-11 mr-1"></i> Mitra Kami
                    </a>
                    <a href="{{ route('website.home') }}" target="_blank" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                        <i class="ki-filled ki-eye mr-1"></i> Pratinjau Website
                    </a>
                </div>

            </div>

            <div class="kt-card-body p-6" x-data="{ activeTab: 'contact' }">
                <!-- Tab Navigation Buttons -->
                <div class="flex flex-wrap border-b border-gray-200 gap-2 mb-6">
                    <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-red-600 text-red-600 font-bold border-b-2' : 'text-gray-500 hover:text-gray-800'" class="px-4 py-2.5 text-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="ki-filled ki-geolocation"></i> 1. Kontak & Kantor Yayasan
                    </button>
                    <button type="button" @click="activeTab = 'about'" :class="activeTab === 'about' ? 'border-red-600 text-red-600 font-bold border-b-2' : 'text-gray-500 hover:text-gray-800'" class="px-4 py-2.5 text-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="ki-filled ki-badge"></i> 2. Tentang Kami & Pimpinan
                    </button>
                    <button type="button" @click="activeTab = 'guidelines'" :class="activeTab === 'guidelines' ? 'border-red-600 text-red-600 font-bold border-b-2' : 'text-gray-500 hover:text-gray-800'" class="px-4 py-2.5 text-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="ki-filled ki-book-open"></i> 3. Pedoman & Kebijakan Jurnal
                    </button>
                    <button type="button" @click="activeTab = 'landing'" :class="activeTab === 'landing' ? 'border-red-600 text-red-600 font-bold border-b-2' : 'text-gray-500 hover:text-gray-800'" class="px-4 py-2.5 text-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="ki-filled ki-picture"></i> 4. Landing Page & Beranda
                    </button>
                </div>

                <form action="{{ route('website.settings.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- TAB 1: KONTAK & KANTOR RESMI YAYASAN (dharma.or.id) -->
                    <div x-show="activeTab === 'contact'" class="space-y-6">
                        <div class="bg-red-50/50 p-4 rounded-xl border border-red-100 flex items-start gap-3">
                            <i class="ki-filled ki-information-2 text-red-600 text-lg mt-0.5"></i>
                            <div class="text-xs text-red-900 leading-relaxed">
                                <strong>Sinkronisasi Identitas Resmi:</strong> Data di bawah ini digunakan di seluruh halaman publik (Footer, Halaman Kontak, dan Tombol WhatsApp Cepat). Data default disinkronkan langsung dari situs induk <strong>dharma.or.id</strong>.
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="kt-label font-bold text-xs text-gray-700">Alamat Kantor Operasional Resmi</label>
                                <textarea name="contact_address" rows="2" class="kt-input w-full text-xs p-3" placeholder="Ruko C-17, Pasar Modern Intermoda BSD...">{{ $settings['contact_address'] ?? 'Ruko C-17, Pasar Modern Intermoda – BSD, Jl. Raya Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten 15345' }}</textarea>
                                <p class="text-[11px] text-gray-400 mt-1">Alamat lengkap kantor yayasan yang akan tampil di footer dan halaman kontak.</p>
                            </div>

                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Email Resmi Yayasan / Redaksi</label>
                                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'admin@dharma.or.id' }}" class="kt-input w-full text-xs" placeholder="admin@dharma.or.id" />
                            </div>

                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Nomor Telepon Kantor</label>
                                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '(021) 5020-8805' }}" class="kt-input w-full text-xs" placeholder="(021) 5020-8805" />
                            </div>

                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Nomor WhatsApp Layanan Cepat</label>
                                <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '0896-0298-2179' }}" class="kt-input w-full text-xs" placeholder="0896-0298-2179" />
                                <p class="text-[11px] text-gray-400 mt-1">Pengunjung dapat mengklik nomor ini untuk langsung chat ke WhatsApp admin.</p>
                            </div>

                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Jam Operasional Kantor</label>
                                <input type="text" name="contact_hours" value="{{ $settings['contact_hours'] ?? 'Senin – Jumat: 08.30 – 17.00 WIB' }}" class="kt-input w-full text-xs" placeholder="Senin – Jumat: 08.30 – 17.00 WIB" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="kt-label font-bold text-xs text-gray-700">Tautan Situs Induk Yayasan (dharma.or.id)</label>
                                <input type="url" name="parent_website_url" value="{{ $settings['parent_website_url'] ?? 'https://www.dharma.or.id' }}" class="kt-input w-full text-xs" placeholder="https://www.dharma.or.id" />
                                <p class="text-[11px] text-gray-400 mt-1">Tautan rujukan ke situs portal utama yayasan pada navbar dan footer.</p>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: TENTANG KAMI & PIMPINAN (ABOUT US CMS) -->
                    <div x-show="activeTab === 'about'" class="space-y-6" style="display: none;">
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Identitas & Struktur Pimpinan Yayasan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Pendiri & Pembina Yayasan</label>
                                    <input type="text" name="about_founder" value="{{ $settings['about_founder'] ?? 'Erlina V. F. Ratu (Pendiri sejak 2016)' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Ketua Yayasan</label>
                                    <input type="text" name="about_chairman" value="{{ $settings['about_chairman'] ?? 'dr. Vincentius Simeon Weo Budhyanto' }}" class="kt-input w-full text-xs" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Visi, Misi & Sejarah Pendirian</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Visi Yayasan</label>
                                    <textarea name="about_vision" rows="2" class="kt-input w-full text-xs p-3">{{ $settings['about_vision'] ?? 'Membangun akses kesehatan prima dan pendidikan unggul untuk seluruh rakyat Indonesia melalui pemanfaatan sains, riset genomik, dan inovasi ilmiah terpercaya.' }}</textarea>
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Misi Yayasan</label>
                                    <textarea name="about_mission" rows="3" class="kt-input w-full text-xs p-3">{{ $settings['about_mission'] ?? '1. Menyelenggarakan dan mendanai riset genomik molekuler berstandar global.
2. Membangun platform publikasi ilmiah berkala yang transparan dan akuntabel.
3. Menyediakan bantuan fasilitas laboratorium dan diagnostik kesehatan untuk faskes di seluruh Indonesia.
4. Mendukung pendidikan generasi muda melalui program beasiswa dan kemitraan akademik.' }}</textarea>
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Prinsip Tata Kelola Publikasi Ilmiah</label>
                                    <textarea name="about_governance" rows="3" class="kt-input w-full text-xs p-3">{{ $settings['about_governance'] ?? '• Independensi dewan redaksi dalam pengambilan keputusan naskah tanpa konflik kepentingan.
• Penelaahan sejawat berbasis blind peer-review yang akuntabel dan transparan.
• Dukungan penuh terhadap gerakan Open Access (Akses Terbuka) dengan lisensi internasional Creative Commons.' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 3: PEDOMAN PENULIS & ETIKA PUBLIKASI -->
                    <div x-show="activeTab === 'guidelines'" class="space-y-6" style="display: none;">
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Pedoman Penulisan Naskah (Author Guidelines)</h4>
                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Ketentuan Umum & Format Naskah</label>
                                <textarea name="guidelines_general" rows="3" class="kt-input w-full text-xs p-3">{{ $settings['guidelines_general'] ?? 'Naskah yang dikirimkan harus merupakan karya orisinal yang belum pernah dipublikasikan di jurnal lain dan tidak sedang dalam proses penelaahan di media ilmiah manapun. Naskah diserahkan secara online melalui sistem wizard pengajuan naskah IGNITE.' }}</textarea>
                            </div>
                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Struktur Penulisan Artikel (Format IMRAD)</label>
                                <textarea name="guidelines_structure" rows="5" class="kt-input w-full text-xs p-3">{{ $settings['guidelines_structure'] ?? '1. Judul: Singkat, padat, dan mencerminkan substansi riset (maksimal 18 kata).
2. Abstrak & Kata Kunci: Dwibahasa (Indonesia & Inggris) antara 150-250 kata dengan 3-5 kata kunci.
3. Pendahuluan (Introduction): Latar belakang, urgensi, kebaruan (novelty), dan hipotesis/tujuan.
4. Metode (Methods): Prosedur riset, instrumen laboratorium, kelaikan etik (ethical clearance), dan analisis statistik.
5. Hasil & Pembahasan (Results & Discussion): Temuan objektif dengan visualisasi tabel/grafik beresolusi tinggi.
6. Kesimpulan: Ringkasan temuan utama dan rekomendasi riset lanjutan.
7. Referensi: Format IEEE/APA dengan referensi primer minimal 80% dari 5 tahun terakhir.' }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Standar Etika Publikasi (Publication Ethics)</h4>
                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Pernyataan Etika & Integritas Peneliti</label>
                                <textarea name="ethics_content" rows="4" class="kt-input w-full text-xs p-3">{{ $settings['ethics_content'] ?? 'Jurnal-jurnal yang diterbitkan oleh IGNITE - Yayasan Satriabudi Dharma Setia mematuhi pedoman baku Committee on Publication Ethics (COPE). Kami menjunjung tinggi integritas akademik dan menolak tegas segala bentuk fabrikasi data, falsifikasi hasil, serta plagiarisme dengan ambang batas kesamaan maksimal 20% melalui uji Turnitin.' }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Informasi Pengindeksan (Indexing Targets)</h4>
                            <div>
                                <label class="kt-label font-bold text-xs text-gray-700">Informasi Pengindeksan & DOI Resmi</label>
                                <textarea name="indexing_content" rows="3" class="kt-input w-full text-xs p-3">{{ $settings['indexing_content'] ?? 'Seluruh artikel yang diterima dan diterbitkan secara resmi diberikan nomor pengenal Digital Object Identifier (DOI) permanen melalui Crossref serta diindeks secara berkala pada Google Scholar, Garuda (Garba Rujukan Digital Kemendikbudristek), dan dalam proses pengajuan akreditasi SINTA & DOAJ.' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 4: LANDING PAGE & BERANDA -->
                    <div x-show="activeTab === 'landing'" class="space-y-6" style="display: none;">
                        <!-- Section: Hero Banner -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Hero Banner Utama</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Hero Judul Utama (Heading)</label>
                                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Yayasan Satriabudi Dharma Setia' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Hero Subtitle</label>
                                    <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Label Tombol Hero</label>
                                    <input type="text" name="hero_button_text" value="{{ $settings['hero_button_text'] ?? 'Baca Selengkapnya' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Link Tombol Hero</label>
                                    <input type="text" name="hero_button_url" value="{{ $settings['hero_button_url'] ?? '#profil' }}" class="kt-input w-full text-xs" />
                                </div>
                            </div>
                        </div>

                        <!-- Section: Counter Stats -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Stat Counter Overlay (Banner Merah)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 space-y-2">
                                    <label class="font-bold text-xs text-gray-600">Statistik 1</label>
                                    <input type="text" name="stat_1_number" value="{{ $settings['stat_1_number'] ?? '150+' }}" class="kt-input w-full text-xs" placeholder="150+" />
                                    <input type="text" name="stat_1_label" value="{{ $settings['stat_1_label'] ?? 'Kerjasama Global' }}" class="kt-input w-full text-xs" placeholder="Kerjasama Global" />
                                </div>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 space-y-2">
                                    <label class="font-bold text-xs text-gray-600">Statistik 2</label>
                                    <input type="text" name="stat_2_number" value="{{ $settings['stat_2_number'] ?? '125 T' }}" class="kt-input w-full text-xs" placeholder="125 T" />
                                    <input type="text" name="stat_2_label" value="{{ $settings['stat_2_label'] ?? 'Riset & Hibah Terbuka' }}" class="kt-input w-full text-xs" placeholder="Riset & Hibah Terbuka" />
                                </div>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 space-y-2">
                                    <label class="font-bold text-xs text-gray-600">Statistik 3</label>
                                    <input type="text" name="stat_3_number" value="{{ $settings['stat_3_number'] ?? '79+' }}" class="kt-input w-full text-xs" placeholder="79+" />
                                    <input type="text" name="stat_3_label" value="{{ $settings['stat_3_label'] ?? 'Publikasi Ilmiah' }}" class="kt-input w-full text-xs" placeholder="Publikasi Ilmiah" />
                                </div>
                            </div>
                        </div>

                        <!-- Section: Agenda / Simposium Proyek -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-2">Agenda Proyek / Simposium Terkini</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Tag Agenda</label>
                                    <input type="text" name="project_tag" value="{{ $settings['project_tag'] ?? 'Proyek Terbaru' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Nama Agenda / Simposium</label>
                                    <input type="text" name="project_title" value="{{ $settings['project_title'] ?? 'GenAI and Genomics Symposium - Indonesia' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Waktu Pelaksanaan</label>
                                    <input type="text" name="project_time" value="{{ $settings['project_time'] ?? '10.00 - 16.00 WIB' }}" class="kt-input w-full text-xs" />
                                </div>
                                <div>
                                    <label class="kt-label font-bold text-xs text-gray-700">Tanggal Pelaksanaan</label>
                                    <input type="text" name="project_date" value="{{ $settings['project_date'] ?? 'Kamis, 15 Mei 2026' }}" class="kt-input w-full text-xs" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan Perubahan -->
                    <div class="pt-6 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            * Perubahan akan langsung tersimpan di basis data dan ditampilkan di portal publik seketika.
                        </div>
                        <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-6 py-2.5 shadow-md">
                            <i class="ki-filled ki-check text-white mr-1.5"></i> Simpan Seluruh Pengaturan CMS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
