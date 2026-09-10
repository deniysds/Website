<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WebsiteNews;
use Modules\Website\Models\WebsiteOfficer;
use Modules\Website\Models\WebsitePartner;
use Modules\Website\Models\WebsiteProgram;
use Modules\Website\Models\WebsiteSetting;

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

        // Default Organizational Officers & Leadership (dharma.or.id & IGNITE Journal)
        $officers = [
            // Level 1: Dewan Pembina & Dewan Pengawas
            [
                'name' => 'Erlina V. F. Ratu',
                'title_prefix' => 'Ibu',
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
                'name' => 'Dewan Pengawas YSDS',
                'title_prefix' => null,
                'title_suffix' => null,
                'position' => 'Anggota Dewan Pengawas',
                'category' => 'pengawas',
                'hierarchy_level' => 1,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Bertanggung jawab melakukan supervisi tata kelola, audit kepatuhan lembaga, serta memastikan seluruh program yayasan berjalan transparan dan akuntabel.',
                'order_no' => 2,
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
                'bio' => 'Dokter spesialis patologi klinik yang memimpin operasional yayasan, pengembangan pusat riset genomik, serta aliansi strategis dengan puluhan universitas dan faskes.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Wakil Ketua Yayasan',
                'title_prefix' => 'dr.',
                'title_suffix' => 'M.Biomed',
                'position' => 'Wakil Ketua & Direktur Eksekutif',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 2,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengoordinasikan integrasi program riset ilmiah lintas institusi dan pembinaan ekosistem jurnal akses terbuka.',
                'order_no' => 2,
                'is_active' => true,
            ],

            // Level 3: Sekretaris, Bendahara & Manajemen Eksekutif
            [
                'name' => 'Sekretaris Eksekutif YSDS',
                'title_prefix' => null,
                'title_suffix' => 'S.H., M.Kn.',
                'position' => 'Sekretaris Yayasan',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengawal kepatuhan hukum, tata persuratan resmi, dan kemitraan legalitas kelembagaan yayasan.',
                'order_no' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Bendahara Yayasan',
                'title_prefix' => null,
                'title_suffix' => 'S.E., Ak., CA',
                'position' => 'Bendahara Yayasan',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'Yayasan Satriabudi Dharma Setia',
                'bio' => 'Mengelola akuntabilitas keuangan, audit independen dana hibah riset, dan transparansi anggaran program yayasan.',
                'order_no' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Direktur Program Riset & Jurnal',
                'title_prefix' => 'Dr.',
                'title_suffix' => 'M.Sc.',
                'position' => 'Direktur Operasional Riset & Jurnal',
                'category' => 'pengurus_harian',
                'hierarchy_level' => 3,
                'affiliation' => 'IGNITE - Yayasan Satriabudi Dharma Setia',
                'bio' => 'Memimpin manajemen harian portal jurnal IGNITE dan penyelenggaraan simposium ilmiah nasional.',
                'order_no' => 3,
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
        ];

        foreach ($officers as $officer) {
            WebsiteOfficer::updateOrCreate(
                ['name' => $officer['name'], 'position' => $officer['position']],
                $officer
            );
        }
    }
}
