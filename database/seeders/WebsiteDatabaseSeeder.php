<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WebsiteCollaboration;
use Modules\Website\Models\WebsiteCollaborationItem;
use Modules\Website\Models\WebsiteNews;
use Modules\Website\Models\WebsiteOfficer;
use Modules\Website\Models\WebsitePartner;
use Modules\Website\Models\WebsiteProgram;
use Modules\Website\Models\WebsiteSetting;
use Modules\Website\Models\WebsiteVisitation;
use Modules\Website\Models\WebsiteDonation;

class WebsiteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Landing Page Settings matching design mock
        $settings = [
            // Header / Brand
            'brand_name' => 'Yayasan Satriabudi Dharma Setia',
            'brand_sub' => 'IGNITE Publishing Portal',
            
            // Hero Section
            'hero_title' => 'Yayasan Satriabudi Dharma Setia',
            'hero_subtitle' => 'Membangun Akses Kesehatan dan Pendidikan untuk Indonesia.',
            'hero_button_text' => 'Baca Selengkapnya',
            'hero_button_url' => '#profil',

            // Red Overlay Stat Counters
            'stat_1_number' => '150+',
            'stat_1_label' => 'Kerjasama Sukses',
            'stat_2_number' => '125 T',
            'stat_2_label' => 'Dana Terkumpul',
            'stat_3_number' => '79+',
            'stat_3_label' => 'Mitra Jejaring',

            // Profile Section
            'profile_tag' => 'Profil',
            'profile_title' => 'Menciptakan generasi muda unggul melalui pendidikan bermutu, kesehatan prima, dan lingkungan hidup yang terpelihara.',
            'profile_desc' => 'Melalui aliansi strategis dengan institusi nasional dan internasional, kami menghadirkan program berbasis bukti riset ilmiah yang transparan dan akuntabel.',
            'profile_button_text' => 'Selengkapnya tentang kami',
            'profile_box_1_title' => 'Pendidikan',
            'profile_box_1_desc' => 'Penguatan kapabilitas SDM riset dan beasiswa tingkat tinggi secara berkesinambungan.',
            'profile_box_2_title' => 'Kesehatan',
            'profile_box_2_desc' => 'Dukungan fasilitas kesehatan, diagnostik molekuler, dan pencegahan penyakit tropis.',
            'profile_box_3_title' => 'Lingkungan',
            'profile_box_3_desc' => 'Pelestarian keanekaragaman hayati dan penerapan riset sains ramah lingkungan.',

            // Method Section
            'method_tag' => 'Metode',
            'method_title' => 'Pendekatan terarah untuk mencapai hasil yang optimal',
            'method_desc' => 'Kami menerjemahkan komitmen menjadi dampak berkesinambungan melalui aliansi strategis bersama mitra riset terpercaya di seluruh Indonesia.',
            'method_step_1_title' => 'Mengkaji Riset & Kebutuhan',
            'method_step_1_desc' => 'Pemetaan isu strategis sains & kesehatan berbasis fakta ilmiah untuk pemangku kepentingan nasional.',
            'method_step_2_title' => 'Merancang dan Menjalankan Program',
            'method_step_2_desc' => 'Eksekusi program publikasi & fasilitas riset secara transparan dengan standar akuntabilitas tinggi.',
            'method_step_3_title' => 'Mengevaluasi Capaian',
            'method_step_3_desc' => 'Monitoring dampak ilmiah berkelanjutan terhadap kemajuan sains dan derajat kesehatan masyarakat.',

            // Partners Section
            'partners_tag' => 'Mitra Kami',
            'partners_title' => 'Kami Percaya Setiap Mitra Adalah Bagian Berharga dalam Perjalanan Jangka Panjang',

            // Official YSDS Contact & Operational Info (dharma.or.id)
            'contact_address' => 'Ruko C-17, Pasar Modern Intermoda – BSD, Jl. Raya Cisauk Lapan, Sampora, Cisauk, Tangerang, Banten 15345',
            'contact_email' => 'admin@dharma.or.id',
            'contact_phone' => '(021) 5020-8805',
            'contact_whatsapp' => '0896-0298-2179',
            'contact_hours' => 'Senin – Jumat: 08.30 – 17.00 WIB',
            'parent_website_url' => 'https://www.dharma.or.id',

            // About Us & Institutional Leadership (dharma.or.id)
            'about_founder' => 'Erlina V. F. Ratu (Pendiri sejak 2016)',
            'about_chairman' => 'dr. Vincentius Simeon Weo Budhyanto',
            'about_vision' => 'Membangun akses kesehatan prima dan pendidikan unggul untuk seluruh rakyat Indonesia melalui pemanfaatan sains, riset genomik, dan inovasi ilmiah terpercaya.',
            'about_mission' => "1. Menyelenggarakan dan mendanai riset genomik molekuler berstandar global.\n2. Membangun platform publikasi ilmiah berkala yang transparan dan akuntabel.\n3. Menyediakan bantuan fasilitas laboratorium dan diagnostik kesehatan untuk faskes di seluruh Indonesia.\n4. Mendukung pendidikan generasi muda melalui program beasiswa dan kemitraan akademik.",
            'about_governance' => "• Independensi dewan redaksi dalam pengambilan keputusan naskah tanpa konflik kepentingan.\n• Penelaahan sejawat berbasis blind peer-review yang akuntabel dan transparan.\n• Dukungan penuh terhadap gerakan Open Access (Akses Terbuka) dengan lisensi internasional Creative Commons.",

            // Editorial Policies & Author Guidelines
            'guidelines_general' => 'Naskah yang dikirimkan harus merupakan karya orisinal yang belum pernah dipublikasikan di jurnal lain dan tidak sedang dalam proses penelaahan di media ilmiah manapun. Naskah diserahkan secara online melalui sistem wizard pengajuan naskah IGNITE.',
            'guidelines_structure' => "1. Judul: Singkat, padat, dan mencerminkan substansi riset (maksimal 18 kata).\n2. Abstrak & Kata Kunci: Dwibahasa (Indonesia & Inggris) antara 150-250 kata dengan 3-5 kata kunci.\n3. Pendahuluan (Introduction): Latar belakang, urgensi, kebaruan (novelty), dan hipotesis/tujuan.\n4. Metode (Methods): Prosedur riset, instrumen laboratorium, kelaikan etik (ethical clearance), dan analisis statistik.\n5. Hasil & Pembahasan (Results & Discussion): Temuan objektif dengan visualisasi tabel/grafik beresolusi tinggi.\n6. Kesimpulan: Ringkasan temuan utama dan rekomendasi riset lanjutan.\n7. Referensi: Format IEEE/APA dengan referensi primer minimal 80% dari 5 tahun terakhir.",
            'ethics_content' => 'Jurnal-jurnal yang diterbitkan oleh IGNITE - Yayasan Satriabudi Dharma Setia mematuhi pedoman baku Committee on Publication Ethics (COPE). Kami menjunjung tinggi integritas akademik dan menolak tegas segala bentuk fabrikasi data, falsifikasi hasil, serta plagiarisme dengan ambang batas kesamaan maksimal 20% melalui uji Turnitin.',
            'indexing_content' => 'Seluruh artikel yang diterima dan diterbitkan secara resmi diberikan nomor pengenal Digital Object Identifier (DOI) permanen melalui Crossref serta diindeks secara berkala pada Google Scholar, Garuda (Garba Rujukan Digital Kemendikbudristek), dan dalam proses pengajuan akreditasi SINTA & DOAJ.',
        ];

        foreach ($settings as $key => $val) {
            WebsiteSetting::setByKey($key, $val, 'cms');
        }

        // Default Programs
        $programs = [
            [
                'title' => 'IGNITE',
                'badge_text' => 'Publikasi Ilmiah',
                'description' => 'Platform pengelolaan dan penerbitan jurnal ilmiah terbuka berstandar internasional.',
                'icon' => 'ki-filled ki-rocket',
                'link_url' => '/catalog-journals',
                'order_no' => 1,
            ],
            [
                'title' => 'Pendidikan',
                'badge_text' => 'Beasiswa',
                'description' => 'Program beasiswa pendidikan sains dan kesehatan untuk talenta muda berprestasi.',
                'icon' => 'ki-filled ki-teacher',
                'link_url' => '/about-us',
                'order_no' => 2,
            ],
            [
                'title' => 'EJA Kuliah',
                'badge_text' => 'Pelatihan',
                'description' => 'Peningkatan kapasitas akademik mahasiswa dan dosen melalui kuliah pakar terkemuka.',
                'icon' => 'ki-filled ki-book-open',
                'link_url' => '/about-us',
                'order_no' => 3,
            ],
            [
                'title' => 'Kelola',
                'badge_text' => 'Manajemen',
                'description' => 'Pemberdayaan tata kelola laboratorium dan riset klinis terstandarisasi.',
                'icon' => 'ki-filled ki-setting-2',
                'link_url' => '/about-us',
                'order_no' => 4,
            ],
            [
                'title' => 'DASH',
                'badge_text' => 'Kesehatan',
                'description' => 'Inisiatif kesehatan publik dan diagnostik genomik molekuler presisi tinggi.',
                'icon' => 'ki-filled ki-heart',
                'link_url' => '/about-us',
                'order_no' => 5,
            ],
        ];

        foreach ($programs as $prog) {
            WebsiteProgram::updateOrCreate(['title' => $prog['title']], $prog);
        }

        // Default News matching design mock
        $newsItems = [
            [
                'title' => 'Simposium Nasional GenAI dan Genomik Indonesia 2026',
                'summary' => 'Kolaborasi antar peneliti nasional dalam memanfaatkan kecerdasan buatan untuk akselerasi analisis genomik.',
                'category' => 'Berita Utama',
                'published_at' => '2026-05-10',
                'is_published' => true,
            ],
            [
                'title' => 'Peluncuran Platform Publikasi Jurnal Terbuka IGNITE',
                'summary' => 'Sistem tata kelola naskah berbasis peer-review resmi diluncurkan untuk memfasilitasi riset kesehatan.',
                'category' => 'Pengumuman',
                'published_at' => '2026-06-01',
                'is_published' => true,
            ],
            [
                'title' => 'Inisiatif Program Beasiswa Riset Sains Yayasan Satriabudi',
                'summary' => 'Pendaftaran program beasiswa riset untuk mahasiswa pascasarjana bidang sains molekuler resmi dibuka.',
                'category' => 'Program',
                'published_at' => '2026-07-15',
                'is_published' => true,
            ],
        ];

        foreach ($newsItems as $news) {
            WebsiteNews::updateOrCreate(['title' => $news['title']], $news);
        }

        // Default Main Partners (Platinum Partners)
        $mainPartners = [
            [
                'name' => 'PaninBank',
                'type' => 'main',
                'website_url' => 'https://www.panin.co.id',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Ultima Genomics',
                'type' => 'main',
                'website_url' => 'https://www.ultimagenomics.com',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'PacBio',
                'type' => 'main',
                'website_url' => 'https://www.pacb.com',
                'order_no' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'MGI Tech',
                'type' => 'main',
                'website_url' => 'https://en.mgi-tech.com',
                'order_no' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Oxford Nanopore Technologies',
                'type' => 'main',
                'website_url' => 'https://nanoporetech.com',
                'order_no' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($mainPartners as $partner) {
            WebsitePartner::updateOrCreate(['name' => $partner['name']], $partner);
        }

        // Default Supporting Partners (Universities & Academic Institutions)
        $supportingPartners = [
            'Universitas Indonesia',
            'Institut Pertanian Bogor',
            'Universitas Gadjah Mada',
            'Universitas Airlangga',
            'Universitas Padjadjaran',
            'Institut Teknologi Del',
            'Universitas Diponegoro',
            'Universitas Brawijaya',
            'Universitas Hasanuddin',
            'Universitas Sumatera Utara',
            'Universitas Udayana',
            'Universitas Jember',
            'Universitas Sebelas Maret',
            'Universitas Andalas',
            'Universitas Lampung',
            'Universitas Sam Ratulangi',
            'Universitas Pattimura',
            'Universitas Cenderawasih',
            'Universitas Negeri Padang',
            'Universitas Negeri Makassar',
            'Universitas Mataram',
            'Universitas Lambung Mangkurat',
            'Universitas Borneo Tarakan',
            'Universitas Kristen Satya Wacana',
            'Universitas Kristen Maranatha',
            'Universitas Internasional Batam',
            'Universitas Muhammadiyah Palembang',
            'Universitas Muhammadiyah Kendari',
            'Universitas Muhammadiyah Palangkaraya',
            'Universitas Teknologi Sumbawa',
            'Universitas Tanjungpura',
            'Universitas Jambi',
        ];

        foreach ($supportingPartners as $index => $name) {
            WebsitePartner::updateOrCreate(
                ['name' => $name],
                [
                    'name' => $name,
                    'type' => 'supporting',
                    'order_no' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        // Clean up legacy placeholder names if present
        WebsiteOfficer::whereIn('name', [
            'Dewan Pengawas YSDS',
            'Wakil Ketua Yayasan',
            'Sekretaris Eksekutif YSDS',
            'Bendahara Yayasan',
            'Direktur Program Riset & Jurnal'
        ])->delete();

        // Default Organizational Officers & Leadership (dharma.or.id & IGNITE Journal)
        $officers = [
            // Level 1: Dewan Pembina & Dewan Pengawas
            [
                'name' => 'Erlina V. F. Ratu',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Pendiri & Ketua Dewan Pembina',
                'category' => 'pembina',
                'hierarchy_level' => 1,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Pendiri Yayasan Satriabudi Dharma Setia sejak tahun 2016 yang mendedikasikan diri untuk kemajuan akses kesehatan, riset genomik, dan beasiswa pendidikan anak bangsa.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Shimon Kana',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Anggota Dewan Pembina',
                'category' => 'pembina',
                'hierarchy_level' => 1,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Berperan menentukan arah dan haluan strategis Yayasan Satriabudi Dharma Setia dalam pengabdian kesehatan dan pendidikan nasional.',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Elisa R. Budidharma',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Dewan Pengawas Yayasan',
                'category' => 'pengawas',
                'hierarchy_level' => 1,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Bertanggung jawab melakukan evaluasi dan pengawasan operasional berkala yang dilaksanakan oleh Pengurus Yayasan.',
                'order_no' => 3,
                'is_active' => true,
            ],

            // Level 2: Pimpinan Harian / Ketua Yayasan
            [
                'name' => 'Vincentius Simeon Weo Budhyanto',
                'title_prefix' => 'dr.',
                'title_suffix' => 'Sp.PK',
                'position' => 'Ketua Yayasan',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 2,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Dokter spesialis patologi klinik yang memimpin operasional yayasan, pengembangan pusat riset genomik, serta aliansi strategis dengan puluhan universitas dan fasilitas kesehatan.',
                'order_no' => 1,
                'is_active' => true,
            ],

            // Level 3: Sekretaris, Bendahara & Manajemen Eksekutif
            [
                'name' => 'Yunianti Lafau',
                'title_prefix' => 'dr.',
                'title_suffix' => null,
                'position' => 'Sekretaris Kepala',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Memimpin kesekretariatan yayasan, tata kelola persuratan resmi, dan koordinasi administratif seluruh program kerja yayasan.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Oppey Luqita',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Sekretaris Anggota',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mendukung operasional kesekretariatan, dokumentasi kerja sama, serta korespondensi kelembagaan.',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Salmon Wahani',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Bendahara Kepala',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengelola akuntabilitas keuangan, audit independen dana bantuan, dan transparansi anggaran program yayasan.',
                'order_no' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Ayub Budisetia',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Bendahara Anggota',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mendukung pengelolaan perbendaharaan yayasan, pembukuan keuangan, dan pelaporan pertanggungjawaban hibah.',
                'order_no' => 4,
                'is_active' => true,
            ],

            // Level 4: Dewan Redaksi Jurnal & Komite Ilmiah IGNITE
            [
                'name' => 'Editor-in-Chief IGNITE',
                'title_prefix' => 'Prof. Dr.',
                'title_suffix' => 'Sp.A(K), Ph.D',
                'position' => 'Ketua Dewan Redaksi Jurnal (Editor-in-Chief)',
                'category' => 'dewan_redaksi',
                'hierarchy_level' => 4,
                'affiliation' => 'Komite Ilmiah IGNITE / Universitas Mitra',
                'bio' => 'Pakar riset kesehatan terkemuka yang bertanggung jawab terhadap standar mutu manuskrip, proses double-blind review, dan etika publikasi.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Managing Editor IGNITE',
                'title_prefix' => 'Dr.',
                'title_suffix' => 'M.Biomed',
                'position' => 'Manajer Redaksi Pelaksana (Managing Editor)',
                'category' => 'dewan_redaksi',
                'hierarchy_level' => 4,
                'affiliation' => 'Komite Ilmiah IGNITE',
                'bio' => 'Mengawasi alur kerja telaah sejawat (peer-review), komunikasi dengan mitra bebestari, dan penerbitan berkala naskah.',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Tim Komite Etik & Ahli Bioinformatika',
                'title_prefix' => 'Dr.',
                'title_suffix' => 'Ph.D',
                'position' => 'Ketua Komite Ahli Bioinformatika & Genomik',
                'category' => 'tim_ahli',
                'hierarchy_level' => 4,
                'affiliation' => 'Pusat Riset Genomik Molekuler',
                'bio' => 'Memberikan telaah teknis dan kurasi saintifik data genomik serta pipeline bioinformatika pada manuskrip riset.',
                'order_no' => 3,
                'is_active' => true,
            ],

            // Level 5: Staff Operasional Yayasan (dharma.or.id)
            [
                'name' => 'Mulia Rahmad Hutomo',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Asset and Distribution Officer',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengelola inventaris aset, logistik alat kesehatan, dan distribusi bantuan peralatan medis ke faskes di seluruh Indonesia.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Faisal Muda',
                'title_prefix' => 'dr.',
                'title_suffix' => null,
                'position' => 'Research and Medical Officer',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengawal koordinasi medis, kelaikan riset genomik, dan supervisi program kesehatan masyarakat.',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Daeng Deni Mardaeni',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Senior Developer',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Merancang dan mengembangkan arsitektur platform digital, portal publikasi ilmiah IGNITE, dan infrastruktur sistem informasi yayasan.',
                'order_no' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Armi Purnama Sari',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Tutor & Konten Kreator',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Pengembangan konten edukasi, modul pembelajaran daring, dan pendampingan tutor siswa.',
                'order_no' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Elisabet Ledo',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Administrasi & Guru SMK Fensensius',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'SMK Fensensius / Yayasan Satriabudi Dharma Setia',
                'bio' => 'Tata kelola administrasi pendidikan vokasi dan pengajaran siswa SMK Fensensius.',
                'order_no' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Heppy Aminulloh',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Grants Officer for School',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Manajemen hibah pendidikan, penyaluran bantuan sarana sekolah, dan kemitraan lembaga donor pendidikan.',
                'order_no' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Darius Meo',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Tutor Cyberschool & Guru SMK Fensensius',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Pelangi Cyberschool / SMK Fensensius',
                'bio' => 'Pengajaran bidang teknik dan pendampingan belajar online pada PKBM Pelangi Indonesia Cyberschool.',
                'order_no' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Monica Juniarty Clara',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Tutor Montessori',
                'category' => 'staff',
                'hierarchy_level' => 5,
                'affiliation' => 'Pelangi Montessori / Yayasan Satriabudi Dharma Setia',
                'bio' => 'Pendidik PAUD dan implementasi kurikulum Montessori bagi tumbuh kembang anak usia dini.',
                'order_no' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($officers as $officer) {
            WebsiteOfficer::updateOrCreate(
                ['name' => $officer['name'], 'position' => $officer['position']],
                $officer
            );
        }

        // Default Collaboration Institutions & Equipment Handover
        $collaborations = [
            [
                'institution_name' => 'RSUP Dr. Sardjito Yogyakarta',
                'category'         => 'Rumah Sakit Rujukan Nasional',
                'location'         => 'Sleman, D.I. Yogyakarta',
                'handover_date'    => '2024-08-15',
                'pic_name'         => 'Direktur Utama & Kepala Lab Molekuler',
                'description'      => 'Serah terima hibah fasilitas laboratorium diagnostik molekuler genomik untuk penguatan deteksi dini penyakit genetik, onkologi, dan infeksi tropis di wilayah D.I. Yogyakarta dan Jawa Bagian Selatan.',
                'order_no'         => 1,
                'is_active'        => true,
                'items'            => [
                    [
                        'item_number'    => '1',
                        'name'           => 'Real-Time PCR Detection System 96-Well',
                        'unit'           => 'Unit',
                        'quantity'       => 2,
                        'specifications' => 'Multi-channel fluorophore detection dengan software kuantifikasi otomatis.',
                        'order_no'       => 1,
                    ],
                    [
                        'item_number'    => '2',
                        'name'           => 'Biosafety Cabinet (BSC) Class II Type A2',
                        'unit'           => 'Unit',
                        'quantity'       => 2,
                        'specifications' => 'HEPA filter 99.995% dengan microprocessor airflow control.',
                        'order_no'       => 2,
                    ],
                    [
                        'item_number'    => '3',
                        'name'           => 'Refrigerated High-Speed Microcentrifuge',
                        'unit'           => 'Unit',
                        'quantity'       => 4,
                        'specifications' => 'Kapasitas 24 x 1.5/2.0 mL, kecepatan maksimum 15,000 RPM.',
                        'order_no'       => 3,
                    ],
                    [
                        'item_number'    => '4',
                        'name'           => 'Set Adjustable Micropipette (0.5 - 1000 µL)',
                        'unit'           => 'Set',
                        'quantity'       => 10,
                        'specifications' => 'Autoclavable ergonomic micropipette 4 ukuran (P10, P20, P200, P1000) dengan tip box.',
                        'order_no'       => 4,
                    ],
                    [
                        'item_number'    => '5',
                        'name'           => 'Ultra-Low Temperature Freezer -86°C (728 Liter)',
                        'unit'           => 'Unit',
                        'quantity'       => 1,
                        'specifications' => 'Dual refrigeration system untuk penyimpanan jangka panjang spesimen biobank.',
                        'order_no'       => 5,
                    ],
                ],
            ],
            [
                'institution_name' => 'Fakultas Kedokteran Universitas Indonesia / RSCM',
                'category'         => 'Perguruan Tinggi & Rumah Sakit Pendidikan',
                'location'         => 'Salemba, Jakarta Pusat',
                'handover_date'    => '2024-11-20',
                'pic_name'         => 'Dekan FKUI & Kepala Lab Terpadu',
                'description'      => 'Kemitraan strategis riset translasi genomik presisi guna akselerasi publikasi internasional dan pengembangan teknologi sequencing generasi baru.',
                'order_no'         => 2,
                'is_active'        => true,
                'items'            => [
                    [
                        'item_number'    => '1',
                        'name'           => 'Next-Generation Sequencing (NGS) Library Prep System',
                        'unit'           => 'Paket',
                        'quantity'       => 1,
                        'specifications' => 'Sistem automasi preparasi pustaka DNA/RNA genomik skala tinggi.',
                        'order_no'       => 1,
                    ],
                    [
                        'item_number'    => '2',
                        'name'           => 'Thermal Cycler Gradient PCR 96-Well',
                        'unit'           => 'Unit',
                        'quantity'       => 3,
                        'specifications' => 'Independent temperature zones untuk optimasi primer PCR.',
                        'order_no'       => 2,
                    ],
                    [
                        'item_number'    => '3',
                        'name'           => 'Fluorometer Qubit 4 Starter Kit',
                        'unit'           => 'Unit',
                        'quantity'       => 2,
                        'specifications' => 'Kuantifikasi akurat konsentrasi DNA/RNA ultra-rendah.',
                        'order_no'       => 3,
                    ],
                    [
                        'item_number'    => '4',
                        'name'           => 'Vortex Mixer & Mini Centrifuge Shaker',
                        'unit'           => 'Unit',
                        'quantity'       => 6,
                        'specifications' => 'Speed variable dengan adapter microtube dan strip PCR.',
                        'order_no'       => 4,
                    ],
                ],
            ],
            [
                'institution_name' => 'RSUP Dr. Hasan Sadikin Bandung',
                'category'         => 'Rumah Sakit Rujukan Jawa Barat',
                'location'         => 'Bandung, Jawa Barat',
                'handover_date'    => '2025-02-10',
                'pic_name'         => 'Kepala Instalasi Laboratorium Sentral',
                'description'      => 'Pengadaan instrumen ekstraksi dan spektrofotometri cepat untuk penanganan spesimen klinis diagnostik kesehatan masyarakat di wilayah Jawa Barat.',
                'order_no'         => 3,
                'is_active'        => true,
                'items'            => [
                    [
                        'item_number'    => '1',
                        'name'           => 'Automated Nucleic Acid Extraction System 32-Channel',
                        'unit'           => 'Unit',
                        'quantity'       => 1,
                        'specifications' => 'Ekstraksi otomatis magnetic bead 32 sampel dalam 25 menit.',
                        'order_no'       => 1,
                    ],
                    [
                        'item_number'    => '2',
                        'name'           => 'UV/Vis Microvolume Spectrophotometer NanoDrop One',
                        'unit'           => 'Unit',
                        'quantity'       => 1,
                        'specifications' => 'Pengukuran absorbansi 190-850 nm tanpa kuvet (1 µL sampel).',
                        'order_no'       => 2,
                    ],
                    [
                        'item_number'    => '3',
                        'name'           => 'Medical Grade Refrigerator +4°C (400 Liter)',
                        'unit'           => 'Unit',
                        'quantity'       => 2,
                        'specifications' => 'Sistem pendingin stabil dengan alarm suhu dan data logger otomatis.',
                        'order_no'       => 3,
                    ],
                ],
            ],
        ];

        foreach ($collaborations as $collabData) {
            $items = $collabData['items'] ?? [];
            unset($collabData['items']);

            $collab = WebsiteCollaboration::updateOrCreate(
                ['institution_name' => $collabData['institution_name']],
                $collabData
            );

            // Bersihkan item lama jika ada untuk idempotensi seeder
            $collab->items()->delete();

            foreach ($items as $itemData) {
                $collab->items()->create($itemData);
            }
        }

        // Default Authentic YSDS Field Visitations
        $visitations = [
            [
                'title'            => 'Visitasi Penyerahan Mesin PCR & Pelatihan Diagnostik RSUD TC Hillers Maumere',
                'slug'             => 'visitasi-penyerahan-mesin-pcr-rsud-tc-hillers-maumere',
                'institution_name' => 'RSUD Dr. T.C. Hillers Maumere',
                'city'             => 'Kabupaten Sikka',
                'province'         => 'Nusa Tenggara Timur',
                'visit_date'       => '2023-10-18',
                'delegation_team'  => 'dr. Vincent, Sp.PK & Tim Teknis YSDS',
                'summary'          => 'Instalasi mesin Real-Time PCR serta pelatihan operasional bagi analis laboratorium RSUD Dr. T.C. Hillers Maumere guna mempercepat deteksi molekuler di Flores.',
                'description'      => "Tim Yayasan Satriabudi Dharma Setia (YSDS) melaksanakan visitasi langsung ke RSUD Dr. T.C. Hillers Maumere, Kabupaten Sikka, Nusa Tenggara Timur.\n\nDalam kunjungan ini, tim YSDS melakukan serah terima resmi 1 unit Real-Time PCR 96-well, 1 unit Biosafety Cabinet Class II, serta reagen pendukung deteksi molekuler. Selain penyerahan alat, tim ahli YSDS memberikan pendampingan teknis intensif selama 3 hari kepada para analis laboratorium setempat mengenai standar biosafety, ekstraksi asam nukleat, dan interpretasi kurva amplifikasi PCR.",
                'is_published'     => true,
                'order_no'         => 1,
            ],
            [
                'title'            => 'Supervisi Fasilitas Diagnostik & Penguatan Lab Biomolekuler RSUD Ben Mboi Ruteng',
                'slug'             => 'supervisi-fasilitas-diagnostik-rsud-ben-mboi-ruteng',
                'institution_name' => 'RSUD Dr. Ben Mboi Ruteng',
                'city'             => 'Kabupaten Manggarai',
                'province'         => 'Nusa Tenggara Timur',
                'visit_date'       => '2023-11-05',
                'delegation_team'  => 'dr. Yunianti Lafau & Tim Biomedis YSDS',
                'summary'          => 'Kunjungan supervisi dan kalibrasi peralatan laboratorium molekuler di dataran tinggi Flores untuk memperkuat kesiapsiagaan deteksi dini penyakit menular.',
                'description'      => "Yayasan Satriabudi Dharma Setia melakukan kunjungan supervisi ke laboratorium RSUD Dr. Ben Mboi di Ruteng, Kabupaten Manggarai.\n\nKegiatan meliputi pengecekan performa mesin thermal cycler, verifikasi alur kerja ruangan PCR bertekanan negatif, dan sesi diskusi bersama jajaran manajemen RSUD serta dokter spesialis patologi klinik terkait ketersediaan reagensia diagnostik.",
                'is_published'     => true,
                'order_no'         => 2,
            ],
            [
                'title'            => 'Visitasi Program Savu Smart Island & Peningkatan Kapasitas Lab Sabu Raijua',
                'slug'             => 'visitasi-program-savu-smart-island-sabu-raijua',
                'institution_name' => 'Dinas Kesehatan & Labkesda Kab. Sabu Raijua',
                'city'             => 'Kabupaten Sabu Raijua',
                'province'         => 'Nusa Tenggara Timur',
                'visit_date'       => '2024-02-14',
                'delegation_team'  => 'Daeng Deni Mardaeni & Tim Lapangan YSDS',
                'summary'          => 'Monitoring implementasi digitalisasi pendidikan Savu Smart Island serta peninjauan fasilitas cold chain rantai dingin sampel medis di pulau terluar NTT.',
                'description'      => "Kunjungan kerja gabungan tim pendidikan dan kesehatan YSDS ke Pulau Sabu (Sabu Raijua).\n\nTim memantau pemanfaatan perangkat digital pembelajaran di sekolah-sekolah sasaran Program Organisasi Penggerak (POP) Kemendikbudristek, serta meninjau kesiapan sarana penyimpanan spesimen medis di fasilitas kesehatan setempat.",
                'is_published'     => true,
                'order_no'         => 3,
            ],
            [
                'title'            => 'Visitasi Kesiapan Laboratorium Ekstraksi Genomik RSUD Komodo Labuan Bajo',
                'slug'             => 'visitasi-kesiapan-lab-genomik-rsud-komodo-labuan-bajo',
                'institution_name' => 'RSUD Komodo Labuan Bajo',
                'city'             => 'Kabupaten Manggarai Barat',
                'province'         => 'Nusa Tenggara Timur',
                'visit_date'       => '2024-05-22',
                'delegation_team'  => 'dr. Vincent, Sp.PK & Konsultan Molekuler',
                'summary'          => 'Pendampingan teknis dan verifikasi ruang laboratorium diagnostik modern di destinasi pariwisata super prioritas Labuan Bajo.',
                'description'      => "Sebagai bagian dari komitmen pemerataan akses diagnostik berstandar internasional, tim YSDS meninjau instalasi laboratorium di RSUD Komodo Labuan Bajo.\n\nVisitasi difokuskan pada penguatan kapasitas tenaga medis dalam mengoperasikan alat otomatisasi ekstraksi DNA/RNA dan penyusunan SOP alur sampel rujukan wisatawan maupun masyarakat lokal.",
                'is_published'     => true,
                'order_no'         => 4,
            ],
            [
                'title'            => 'Kunjungan Kemitraan Riset Genomik Lab Mikrobiologi Fakultas Kedokteran UI',
                'slug'             => 'kunjungan-kemitraan-riset-genomik-lab-mikrobiologi-fkui',
                'institution_name' => 'Laboratorium Mikrobiologi FKUI',
                'city'             => 'Jakarta Pusat',
                'province'         => 'DKI Jakarta',
                'visit_date'       => '2024-07-10',
                'delegation_team'  => 'Pengurus Yayasan & Tim Riset PacBio YSDS',
                'summary'          => 'Diskusi strategis percepatan riset sekuensing genom dan evaluasi pemanfaatan instrumen laboratorium hasil kemitraan akademik.',
                'description'      => "Pertemuan koordinasi berkala antara YSDS dan tim peneliti Departemen Mikrobiologi FKUI - RSCM.\n\nDiskusi menyoroti capaian publikasi riset genomik patogen, pemanfaatan platform sekuensing long-read PacBio dan Oxford Nanopore, serta rencana pelatihan bioinformatika bagi akademisi.",
                'is_published'     => true,
                'order_no'         => 5,
            ],
            [
                'title'            => 'Visitasi Penyerahan Alat & Supervisi Cold Chain RSUD Kalabahi Alor',
                'slug'             => 'visitasi-penyerahan-alat-supervisi-rsud-kalabahi-alor',
                'institution_name' => 'RSUD Kalabahi Alor',
                'city'             => 'Kabupaten Alor',
                'province'         => 'Nusa Tenggara Timur',
                'visit_date'       => '2024-08-30',
                'delegation_team'  => 'dr. Yunianti Lafau & Tim Logistik YSDS',
                'summary'          => 'Peninjauan langsung sistem cold chain dan serah terima peralatan penunjang laboratorium di kepulauan Alor.',
                'description'      => "Menjangkau fasilitas kesehatan di wilayah kepulauan timur Indonesia, YSDS melaksanakan visitasi ke RSUD Kalabahi, Alor.\n\nTim memverifikasi berfungsinya freezer biomedis suhu rendah, mikrosentrifus, dan micropipette set guna menunjang akurasi uji diagnostik warga kepulauan Alor tanpa harus merujuk sampel ke Kupang.",
                'is_published'     => true,
                'order_no'         => 6,
            ],
        ];

        foreach ($visitations as $visitData) {
            WebsiteVisitation::updateOrCreate(
                ['slug' => $visitData['slug']],
                $visitData
            );
        }

        // Default Sample Verified Donations
        $sampleDonations = [
            [
                'donation_code'   => 'DON-2610-PCR01',
                'donor_name'      => 'PT Sinar Mitra Farma',
                'donor_type'      => 'institution',
                'email'           => 'csr@sinarmitrafarma.co.id',
                'phone'           => '02157891234',
                'program_target'  => 'alkes_pcr_3t',
                'amount'          => 25000000,
                'transfer_date'   => '2026-10-01',
                'payment_method'  => 'bank_transfer',
                'bank_name'       => 'BCA',
                'is_anonymous'    => false,
                'message'         => 'Semoga bantuan sarana diagnostik PCR bermanfaat bagi faskes dan masyarakat di NTT.',
                'status'          => 'verified',
                'admin_notes'     => 'Dana CSR korporasi telah masuk ke rekening BCA YSDS.',
                'verified_at'     => '2026-10-01 14:30:00',
            ],
            [
                'donation_code'   => 'DON-2610-BSW02',
                'donor_name'      => 'dr. Robert Tanujaya, Sp.A',
                'donor_type'      => 'individual',
                'email'           => 'robert.tanujaya@gmail.com',
                'phone'           => '081298765432',
                'program_target'  => 'beasiswa_smk_fensensius',
                'amount'          => 5000000,
                'transfer_date'   => '2026-10-02',
                'payment_method'  => 'bank_transfer',
                'bank_name'       => 'Bank Mandiri',
                'is_anonymous'    => false,
                'message'         => 'Dukungan untuk biaya pendidikan dan asrama adik-adik siswa SMK Fensensius.',
                'status'          => 'verified',
                'admin_notes'     => 'Mutasi Mandiri confirmed.',
                'verified_at'     => '2026-10-02 16:15:00',
            ],
            [
                'donation_code'   => 'DON-2610-RBH03',
                'donor_name'      => 'Hamba Allah',
                'donor_type'      => 'individual',
                'email'           => 'donatur.peduli@yahoo.com',
                'phone'           => '081388990011',
                'program_target'  => 'rumah_baca_halmahera',
                'amount'          => 1500000,
                'transfer_date'   => '2026-10-03',
                'payment_method'  => 'bank_transfer',
                'bank_name'       => 'BCA',
                'is_anonymous'    => true,
                'message'         => 'Untuk pengadaan buku-buku sains dan perpustakaan anak Halmahera.',
                'status'          => 'verified',
                'admin_notes'     => 'Valid. Anonim publik.',
                'verified_at'     => '2026-10-03 10:20:00',
            ],
            [
                'donation_code'   => 'DON-2610-UMM04',
                'donor_name'      => 'Alumni FK Angkatan 2005',
                'donor_type'      => 'institution',
                'email'           => 'alumni.fk05@alumni.ac.id',
                'phone'           => '081122334455',
                'program_target'  => 'umum',
                'amount'          => 10000000,
                'transfer_date'   => '2026-10-04',
                'payment_method'  => 'bank_transfer',
                'bank_name'       => 'BCA',
                'is_anonymous'    => false,
                'message'         => 'Apresiasi program kemanusiaan YSDS. Teruslah mengabdi untuk Indonesia.',
                'status'          => 'verified',
                'admin_notes'     => 'Terverifikasi.',
                'verified_at'     => '2026-10-04 11:00:00',
            ],
            [
                'donation_code'   => 'DON-2610-NEW05',
                'donor_name'      => 'Ibu Maria Christine',
                'donor_type'      => 'individual',
                'email'           => 'maria.christine@outlook.com',
                'phone'           => '081765432109',
                'program_target'  => 'beasiswa_smk_fensensius',
                'amount'          => 750000,
                'transfer_date'   => '2026-10-06',
                'payment_method'  => 'bank_transfer',
                'bank_name'       => 'BCA',
                'is_anonymous'    => false,
                'message'         => 'Semoga berkah untuk adik-adik perawat.',
                'status'          => 'pending',
                'admin_notes'     => null,
                'verified_at'     => null,
            ],
        ];

        foreach ($sampleDonations as $donationData) {
            WebsiteDonation::updateOrCreate(
                ['donation_code' => $donationData['donation_code']],
                $donationData
            );
        }
    }
}

