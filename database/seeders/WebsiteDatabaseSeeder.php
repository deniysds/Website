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
use Modules\Website\Models\WebsiteDocument;
use Illuminate\Support\Facades\Storage;

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
            'hero_button_text' => 'Donasi',
            'hero_button_url' => '/donasi',

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
            'profile_desc' => 'Berkontribusi bagi kemajuan bangsa dengan membangun masa depan yang lebih cerah bagi generasi muda Indonesia melalui program pendidikan, kesehatan, dan lingkungan yang berdampak serta berkelanjutan.',
            'profile_button_text' => 'Selengkapnya',
            'profile_box_1_title' => 'Pendidikan yang Berkualitas',
            'profile_box_1_desc' => 'Penguatan kapabilitas SDM riset dan beasiswa tingkat tinggi secara berkesinambungan.',
            'profile_box_2_title' => 'Kesehatan yang Prima',
            'profile_box_2_desc' => 'Dukungan fasilitas kesehatan, diagnostik molekuler, dan pencegahan penyakit tropis.',
            'profile_box_3_title' => 'Lingkungan Hidup yang Terpelihara',
            'profile_box_3_desc' => 'Pelestarian keanekaragaman hayati dan penerapan riset sains ramah lingkungan.',

            // Method / Alur Kerja Section
            'method_tag' => 'Alur Kerja',
            'method_title' => 'Pendekatan terarah untuk mencapai hasil yang berdampak',
            'method_desc' => 'Kami mengembangkan setiap program melalui proses yang terarah, kolaboratif, dan berbasis kebutuhan. Setiap tahapan dirancang untuk memastikan program berjalan tepat sasaran dan memberikan manfaat yang nyata.',
            'method_step_1_title' => 'Mengidentifikasi Kebutuhan yang Berdampak',
            'method_step_1_subtitle' => 'Memahami tantangan, kebutuhan, dan potensi',
            'method_step_1_desc' => 'Kami mempelajari kebutuhan, permasalahan, serta potensi melalui riset, pengumpulan data, dan komunikasi dengan pihak terkait.',
            'method_step_2_title' => 'Merancang dan Menjalankan Program',
            'method_step_2_subtitle' => 'Mewujudkan solusi yang tepat sasaran',
            'method_step_2_desc' => 'Berdasarkan identifikasi, kami menyusun strategi dan melaksanakan program bersama mitra, ahli, komunitas, serta pemangku kepentingan.',
            'method_step_3_title' => 'Mengevaluasi dan Mengembangkan',
            'method_step_3_subtitle' => 'Mengukur hasil untuk perbaikan berkelanjutan',
            'method_step_3_desc' => 'Kami memantau pelaksanaan, mengukur hasil, dan mengevaluasi program sebagai dasar untuk meningkatkan kualitas serta efektivitasnya.',

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
                'description' => 'Menyediakan layanan serta teknologi penelitian genomik yang terjangkau bagi peneliti di seluruh Indonesia.',
                'icon' => 'dna',
                'link_url' => '/catalog-journals',
                'order_no' => 1,
            ],
            [
                'title' => 'Pendidikan',
                'badge_text' => 'Pendidikan',
                'description' => 'Berfokus pada penyediaan akses pendidikan yang merata, terutama di daerah 3T (Terdepan, Terluar, Tertinggal).',
                'icon' => 'leaf',
                'link_url' => '/about-us',
                'order_no' => 2,
            ],
            [
                'title' => 'ISA Kuliah',
                'badge_text' => 'Beasiswa',
                'description' => 'Skema bantuan pembiayaan kuliah, khususnya di bidang kesehatan dan kedokteran, di kami menanggung seluruh biaya.',
                'icon' => 'graduation-cap',
                'link_url' => '/about-us',
                'order_no' => 3,
            ],
            [
                'title' => 'Katalis',
                'badge_text' => 'Kesehatan',
                'description' => 'Berfungsi sebagai akselerator peningkatan kualitas pelayanan medis di Indonesia melalui donasi alat kesehatan,',
                'icon' => 'cross',
                'link_url' => '/about-us',
                'order_no' => 4,
            ],
            [
                'title' => 'DASH',
                'badge_text' => 'Akses Global',
                'description' => 'Berfokus pada penyediaan akses pendidikan yang merata, terutama di daerah 3T (Terdepan, Terluar, Tertinggal).',
                'icon' => 'globe',
                'link_url' => '/about-us',
                'order_no' => 5,
            ],
        ];

        foreach ($programs as $prog) {
            WebsiteProgram::updateOrCreate(['title' => $prog['title']], $prog);
        }

        // Default Events / Kegiatan
        $defaultEvents = [
            [
                'title' => 'BioAI and Genomics Symposium - Indonesia',
                'slug' => 'bioai-and-genomics-symposium-indonesia',
                'tag' => 'Kegiatan Terbaru',
                'year' => '2026',
                'partner_name' => 'Ultima Genomic',
                'sponsor_name' => 'Panin Bank',
                'banner_image' => null,
                'summary' => 'Menghubungkan lebih dari 150+ peneliti, institusi laboratorium, dan praktisi genomik nasional dalam forum ilmiah terstandarisasi untuk akselerasi riset presisi.',
                'description' => 'Simposium Nasional BioAI and Genomics Indonesia 2026 merupakan wadah strategis kolaborasi lintas institusi antara akademisi, praktisi medis, dan industri teknologi biologi molekuler. Forum ini membahas pemanfaatan kecerdasan buatan (GenAI) dalam analisis sekuensing genomik skala besar, penemuan biomarker penyakit tropis, dan pengembangan terapi terarah di Indonesia.',
                'event_date' => 'Kamis, 15 Mei 2026',
                'event_time' => '10.00 - 16.00 WIB',
                'location' => 'Jakarta Convention Center (JCC) & Virtual Hybrid',
                'registration_url' => '/contact',
                'is_featured' => true,
                'is_published' => true,
                'order_no' => 1,
            ],
        ];

        foreach ($defaultEvents as $evt) {
            \Modules\Website\Models\WebsiteEvent::updateOrCreate(['slug' => $evt['slug']], $evt);
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

        // Default Partners (Platform, Universitas, Perusahaan, Klinik & RS, Instansi)
        $allPartners = [
            // 1. Platform (Main Partners)
            ['name' => 'PaninBank', 'logo_path' => 'mitra/1. Panin & Platform/1. panin.png', 'type' => 'main', 'category' => 'platform', 'order_no' => 1, 'website_url' => 'https://www.panin.co.id'],
            ['name' => 'Ultima Genomics', 'logo_path' => 'mitra/1. Panin & Platform/2. Ultima Genomics.png', 'type' => 'main', 'category' => 'platform', 'order_no' => 2, 'website_url' => 'https://www.ultimagenomics.com'],
            ['name' => 'PacBio', 'logo_path' => 'mitra/1. Panin & Platform/3. Pacbio.png', 'type' => 'main', 'category' => 'platform', 'order_no' => 3, 'website_url' => 'https://www.pacb.com'],
            ['name' => 'MGI Tech', 'logo_path' => 'mitra/1. Panin & Platform/4. MGI.png', 'type' => 'main', 'category' => 'platform', 'order_no' => 4, 'website_url' => 'https://en.mgi-tech.com'],
            ['name' => 'Oxford Nanopore Technologies', 'logo_path' => 'mitra/1. Panin & Platform/5. Oxford Nanophore.png', 'type' => 'main', 'category' => 'platform', 'order_no' => 5, 'website_url' => 'https://nanoporetech.com'],

            // 2. Universitas (Supporting Partners - Perguruan Tinggi & Riset Akademik)
            ['name' => 'Chinese Academy of Sciences', 'logo_path' => 'mitra/2. Universitas/01. Chinese Academy.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 1],
            ['name' => 'IMPLAD', 'logo_path' => 'mitra/2. Universitas/02. Implad.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 2],
            ['name' => 'Zhejiang University', 'logo_path' => 'mitra/2. Universitas/03. Zhejiang_University_Logo.svg.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 3],
            ['name' => 'Universitas Syiah Kuala', 'logo_path' => 'mitra/2. Universitas/3. Universtitas Syiah Kuala.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 4],
            ['name' => 'Universitas Sumatera Utara', 'logo_path' => 'mitra/2. Universitas/4. Universitas Sumatera Utara.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 5],
            ['name' => 'Institut Teknologi Del', 'logo_path' => 'mitra/2. Universitas/3. IT DEL.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 6],
            ['name' => 'Universitas HKBP Nommensen', 'logo_path' => 'mitra/2. Universitas/4. Universitas HKBP Nommensen.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 7],
            ['name' => 'SMA Santo Thomas 1 Medan', 'logo_path' => 'mitra/2. Universitas/5. SMA Santho Medan 1.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 8],
            ['name' => 'Universitas Negeri Padang', 'logo_path' => 'mitra/2. Universitas/6. Universitas Negeri Padang.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 9],
            ['name' => 'Universitas Riau', 'logo_path' => 'mitra/2. Universitas/7. Universitas Negeri Riau.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 10],
            ['name' => 'Universitas Internasional Batam', 'logo_path' => 'mitra/2. Universitas/8. Universtias Internasional Batam.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 11],
            ['name' => 'Universitas Merangin', 'logo_path' => 'mitra/2. Universitas/9. Universitas Merangin.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 12],
            ['name' => 'Universitas Jambi', 'logo_path' => 'mitra/2. Universitas/10. Universitas Jambi.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 13],
            ['name' => 'Universitas Bengkulu', 'logo_path' => 'mitra/2. Universitas/11. Universitas Bengkulu.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 14],
            ['name' => 'Universitas Muhammadiyah Palembang', 'logo_path' => 'mitra/2. Universitas/12. Universitas Muhammadiyah Palembang.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 15],
            ['name' => 'Universitas Lampung', 'logo_path' => 'mitra/2. Universitas/13. Umiversitas Lampung.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 16],
            ['name' => 'Universitas Negeri Jakarta', 'logo_path' => 'mitra/2. Universitas/14. Universitas Negeri Jakarta.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 17],
            ['name' => 'Universitas Pamulang', 'logo_path' => 'mitra/2. Universitas/16. Universitas Pamulang.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 18],
            ['name' => 'UIN Maulana Malik Ibrahim Malang', 'logo_path' => 'mitra/2. Universitas/29. UIN Malang.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 19],
            ['name' => 'Universitas YARSI', 'logo_path' => 'mitra/2. Universitas/15. Universitas YARSI.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 20],
            ['name' => 'Institut Pertanian Bogor', 'logo_path' => 'mitra/2. Universitas/17. Institut Pertanian Bogor.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 21],
            ['name' => 'Universitas Kristen Maranatha', 'logo_path' => 'mitra/2. Universitas/18. Universitas Kristen Maranatha.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 22],
            ['name' => 'Universitas Swadaya Gunung Jati', 'logo_path' => 'mitra/2. Universitas/19. Universitas Swadaya Gunung Jati.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 23],
            ['name' => 'Universitas Indonesia', 'logo_path' => 'mitra/2. Universitas/20. Universitas Indonesia.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 24],
            ['name' => 'SMK Maarif Magelang', 'logo_path' => 'mitra/2. Universitas/21. SMK Maarif Magelang.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 25],
            ['name' => 'Universitas Diponegoro', 'logo_path' => 'mitra/2. Universitas/22. Universitas Diponegoro.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 26],
            ['name' => 'Universitas Kristen Satya Wacana', 'logo_path' => 'mitra/2. Universitas/23. Universitas Kristen Satya Wacana.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 27],
            ['name' => 'Universitas Sebelas Maret', 'logo_path' => 'mitra/2. Universitas/24. Universitas Sebelas Maret.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 28],
            ['name' => 'Universitas Katolik Soegijapranata', 'logo_path' => 'mitra/2. Universitas/25. Universitas Katolik Soegjapranata.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 29],
            ['name' => 'Universitas Gadjah Mada', 'logo_path' => 'mitra/2. Universitas/26. Universitas Gadjah Mada.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 30],
            ['name' => 'Universitas Airlangga', 'logo_path' => 'mitra/2. Universitas/27. Universitas Airlangga.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 31],
            ['name' => 'Universitas Brawijaya', 'logo_path' => 'mitra/2. Universitas/28. Universitas Brawijaya.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 32],
            ['name' => 'Universitas Muhammadiyah Gorontalo', 'logo_path' => 'mitra/2. Universitas/51. Muhammadiyah Gorontalo.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 33],
            ['name' => 'Universitas Negeri Jember', 'logo_path' => 'mitra/2. Universitas/30. Universitas Negeri Jember.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 34],
            ['name' => 'Universitas Palangka Raya', 'logo_path' => 'mitra/2. Universitas/36. Universitas Palangkaraya.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 35],
            ['name' => 'Universitas Kristen Wira Wacana Sumba', 'logo_path' => 'mitra/2. Universitas/31. Universitas Kristen Wira Wacanan Sumba.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 36],
            ['name' => 'Universitas Mataram', 'logo_path' => 'mitra/2. Universitas/32. Universitas Mataram.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 37],
            ['name' => 'Universitas Nusa Cendana', 'logo_path' => 'mitra/2. Universitas/33. Universitas Nusa Cendana.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 38],
            ['name' => 'Universitas Teknologi Sumbawa', 'logo_path' => 'mitra/2. Universitas/34. Universitas Teknologi Sumbawa.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 39],
            ['name' => 'Universitas Tanjungpura', 'logo_path' => 'mitra/2. Universitas/35. Universitas Tanjungpura Pontianak.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 40],
            ['name' => 'Universitas Muhammadiyah Palangkaraya', 'logo_path' => 'mitra/2. Universitas/50. niversitas_Palangka_Raya.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 41],
            ['name' => 'Universitas Lambung Mangkurat', 'logo_path' => 'mitra/2. Universitas/37. Universitas Lambung Mangkurat.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 42],
            ['name' => 'Universitas Mulawarman', 'logo_path' => 'mitra/2. Universitas/38. Universitas Mulawarman.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 43],
            ['name' => 'Universitas Borneo Tarakan', 'logo_path' => 'mitra/2. Universitas/39. Universitas Borneo Tarakan.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 44],
            ['name' => 'Universitas Sam Ratulangi', 'logo_path' => 'mitra/2. Universitas/40. Universitas Sam Ratulangi Manado.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 45],
            ['name' => 'Universitas Tadulako', 'logo_path' => 'mitra/2. Universitas/41. Universitas Tadulako.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 46],
            ['name' => 'Universitas Negeri Makassar', 'logo_path' => 'mitra/2. Universitas/42. Universitas Negeri Makassar.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 47],
            ['name' => 'Universitas Sulawesi Barat', 'logo_path' => 'mitra/2. Universitas/43 Universitas Sulawesi Barat.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 48],
            ['name' => 'Universitas Muhammadiyah Kendari', 'logo_path' => 'mitra/2. Universitas/44. Universitas Muhammdiyah Kendari.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 49],
            ['name' => 'Universitas Pattimura', 'logo_path' => 'mitra/2. Universitas/45. Universitas Pattiomura.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 50],
            ['name' => 'Universitas Khairun', 'logo_path' => 'mitra/2. Universitas/46. Universitas_Khairun.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 51],
            ['name' => 'Institut Teknologi Sepuluh Nopember', 'logo_path' => 'mitra/2. Universitas/55. ITS.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 52],
            ['name' => 'Universitas Cenderawasih', 'logo_path' => 'mitra/2. Universitas/47. Universitas Cendrawasih.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 53],
            ['name' => 'Universitas Papua', 'logo_path' => 'mitra/2. Universitas/48. Universitas Papua.webp', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 54],
            ['name' => 'Universitas Warmadewa', 'logo_path' => 'mitra/2. Universitas/49. WARMADEWA.png', 'type' => 'supporting', 'category' => 'universitas', 'order_no' => 55],

            // 3. Perusahaan (Supporting Partners - Industri & Korporasi)
            ['name' => 'Budi Trikora Abadi', 'logo_path' => 'mitra/3. Perusahaan/0. Logo BTA.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 1],
            ['name' => 'PT Equilab International', 'logo_path' => 'mitra/3. Perusahaan/1. PT Equilab.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 2],
            ['name' => 'Westerindo', 'logo_path' => 'mitra/3. Perusahaan/2. Westerindo.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 3],
            ['name' => 'CareNow', 'logo_path' => 'mitra/3. Perusahaan/4. Care Now.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 4],
            ['name' => 'Pertamedika Bina Medika', 'logo_path' => 'mitra/3. Perusahaan/5. Pertamnida Medika.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 5],
            ['name' => 'Genomik Solidaritas Indonesia (GSI Lab)', 'logo_path' => 'mitra/3. Perusahaan/6. Genomik Solidaritas Indonesia.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 6],
            ['name' => 'Ikatan Dokter Indonesia (IDI)', 'logo_path' => 'mitra/3. Perusahaan/7. IDI Logo.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 7],
            ['name' => 'Tana Lab', 'logo_path' => 'mitra/3. Perusahaan/9. Tana Lab.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 8],
            ['name' => 'Datahelix', 'logo_path' => 'mitra/3. Perusahaan/18 Datahelix.webp', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 9],
            ['name' => 'Konsorsium Bioteknologi Indonesia', 'logo_path' => 'mitra/3. Perusahaan/10. Konsorsium Bioteknologi Indonesia.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 10],
            ['name' => 'Perhimpunan Periset Indonesia', 'logo_path' => 'mitra/3. Perusahaan/20 Perhimpunan Periset.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 11],
            ['name' => 'Bhumi Foundation', 'logo_path' => 'mitra/3. Perusahaan/20. Bhumi.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 12],
            ['name' => 'PathGen Diagnostik Teknologi', 'logo_path' => 'mitra/3. Perusahaan/11. Pathgen.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 13],
            ['name' => 'Widya Herbal', 'logo_path' => 'mitra/3. Perusahaan/16. Widya Herbal.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 14],
            ['name' => 'Widya Genomics', 'logo_path' => 'mitra/3. Perusahaan/17. Widya Genomic.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 15],
            ['name' => 'Widya Life Science', 'logo_path' => 'mitra/3. Perusahaan/15. Widya Hayati.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 16],
            ['name' => 'Saraswanti Genomics', 'logo_path' => 'mitra/3. Perusahaan/13. Saraswati.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 17],
            ['name' => 'SIROS', 'logo_path' => 'mitra/3. Perusahaan/14. Siros.png', 'type' => 'supporting', 'category' => 'perusahaan', 'order_no' => 18],

            // 4. Klinik & Rumah Sakit (Supporting Partners - Fasyankes & RS)
            ['name' => 'Klinik Satriabudi Dharma Medika', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/1. Klinik Satriabudi.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 1],
            ['name' => 'Primaya Hospital', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/2. RS Primaya.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 2],
            ['name' => 'Kemenkes RSK Dharmais', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/3. RS Dharmais.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 3],
            ['name' => 'Kemenkes RSAB Harapan Kita', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/6. RSAB Harapan Kita.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 4],
            ['name' => 'Kemenkes RSPON Mahar Mardjono', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/4. RS PON.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 5],
            ['name' => 'RS Medistra', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/5. RS Medistra.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 6],
            ['name' => 'RS Panti Nugroho', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/9. RS Pantio Nugroho.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 7],
            ['name' => 'Yayasan Panti Rapih RS Panti Rahayu', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/9. RS Panti Rahayu.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 8],
            ['name' => 'Yayasan Panti Rapih RS Panti Rini', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/8 RS Panti Rini.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 9],
            ['name' => 'Rumah Sakit Panti Rapih Yogyakarta', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/7. RS Panti Rapih 2.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 10],
            ['name' => 'Yayasan Panti Rapih RS Santa Elisabeth', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/9. RS Santa Elizabeth.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 11],
            ['name' => 'RSKB Dharma Usadha Sidhi Bali', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/12. RSKB Dharma Sidhi Bali.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 12],
            ['name' => 'RSUD Labuang Baji', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/14. RS Labuang Baji.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 13],
            ['name' => 'RSUD Tamiyang Layang', 'logo_path' => 'mitra/4. Klinik & Rumah Sakit/13. RS Tamiyang Layang.png', 'type' => 'supporting', 'category' => 'rumah_sakit', 'order_no' => 14],

            // 5. Instansi (Supporting Partners - Pemerintah & Lembaga Negara)
            ['name' => 'Badan Riset dan Inovasi Nasional (BRIN)', 'logo_path' => 'mitra/5. Instansi/logo-brin.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 1],
            ['name' => 'Pemerintah Kabupaten Kulon Progo', 'logo_path' => 'mitra/5. Instansi/1. Pemkab Kulon Porogo.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 2],
            ['name' => 'Pemerintah Provinsi NTT', 'logo_path' => 'mitra/5. Instansi/2. Pemprov NTT.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 3],
            ['name' => 'Pemerintah Kabupaten Sumba Timur', 'logo_path' => 'mitra/5. Instansi/3. Pemkab Sumba Timur NTT.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 4],
            ['name' => 'Pemerintah Provinsi Kalimantan Barat', 'logo_path' => 'mitra/5. Instansi/4. Pemprov Kalbar.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 5],
            ['name' => 'Pemerintah Kabupaten Melawi', 'logo_path' => 'mitra/5. Instansi/5. Pemkab Melawi.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 6],
            ['name' => 'Pemerintah Kabupaten Kapuas Hulu', 'logo_path' => 'mitra/5. Instansi/6. Pemkab Kapuas Hulu.png', 'type' => 'supporting', 'category' => 'instansi', 'order_no' => 7],
        ];

        foreach ($allPartners as $p) {
            $p['is_active'] = true;
            WebsitePartner::updateOrCreate(['name' => $p['name']], $p);
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

        // Mock PDF file for seeder if not exists
        $mockPdfContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000098 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n178\n%%EOF\n";
        $mockDir = 'website/documents';
        if (!Storage::disk('public')->exists($mockDir)) {
            Storage::disk('public')->makeDirectory($mockDir);
        }
        $mockPdfPath = $mockDir . '/sample_ysds_doc.pdf';
        if (!Storage::disk('public')->exists($mockPdfPath)) {
            Storage::disk('public')->put($mockPdfPath, $mockPdfContent);
        }

        // Default Authentic YSDS Official Documents & Downloads
        $sampleDocuments = [
            [
                'title'          => 'Laporan Tahunan Yayasan Satriabudi Dharma Setia (Annual Report 2024)',
                'slug'           => 'laporan-tahunan-ysds-2024',
                'category'       => 'laporan_tahunan',
                'description'    => 'Laporan komprehensif kinerja program kemanusiaan, serah terima alat diagnostik molekuler, beasiswa vokasi, serta capaian strategis YSDS sepanjang tahun 2024.',
                'file_path'      => $mockPdfPath,
                'file_size'      => 4520192,
                'file_extension' => 'pdf',
                'published_year' => 2024,
                'download_count' => 142,
                'order_no'       => 1,
                'is_active'      => true,
            ],
            [
                'title'          => 'Laporan Keuangan Teraudit Independen YSDS Tahun Buku 2023 (Opini WTP)',
                'slug'           => 'laporan-keuangan-teraudit-ysds-2023',
                'category'       => 'laporan_keuangan',
                'description'    => 'Hasil audit keuangan independen oleh Kantor Akuntan Publik (KAP) dengan opini Wajar Tanpa Pengecualian (WTP) sebagai bukti akuntabilitas dan tata kelola yayasan yang bersih.',
                'file_path'      => $mockPdfPath,
                'file_size'      => 2840500,
                'file_extension' => 'pdf',
                'published_year' => 2023,
                'download_count' => 89,
                'order_no'       => 2,
                'is_active'      => true,
            ],
            [
                'title'          => 'Salinan Akta Pendirian & Keputusan Menkumham RI Badan Hukum Yayasan',
                'slug'           => 'sk-kemenkumham-akta-pendirian-yayasan-ysds',
                'category'       => 'legalitas_sk',
                'description'    => 'Dokumen legalitas formal pengesahan badan hukum Yayasan Satriabudi Dharma Setia dari Kementerian Hukum dan HAM Republik Indonesia beserta NPWP resmi yayasan.',
                'file_path'      => $mockPdfPath,
                'file_size'      => 1230400,
                'file_extension' => 'pdf',
                'published_year' => 2016,
                'download_count' => 215,
                'order_no'       => 3,
                'is_active'      => true,
            ],
            [
                'title'          => 'Standar Operasional Prosedur (SOP) Pengajuan Hibah Alkes & Mesin PCR 3T',
                'slug'           => 'sop-pengajuan-hibah-alkes-mesin-pcr-3t',
                'category'       => 'panduan_sop',
                'description'    => 'Pedoman baku, tata cara permohonan, kriteria kelayakan, dan tahapan verifikasi fasilitas kesehatan (RSUD/Labkesda) di daerah Tertinggal, Terdepan, dan Terluar (3T).',
                'file_path'      => $mockPdfPath,
                'file_size'      => 1650300,
                'file_extension' => 'pdf',
                'published_year' => 2024,
                'download_count' => 320,
                'order_no'       => 4,
                'is_active'      => true,
            ],
            [
                'title'          => 'Petunjuk Teknis & Panduan Seleksi Beasiswa Pendidikan SMK Fensensius',
                'slug'           => 'panduan-seleksi-beasiswa-smk-fensensius',
                'category'       => 'panduan_sop',
                'description'    => 'Informasi syarat pendaftaran, alur tes kemampuan akademik, wawancara, dan fasilitas bebas biaya sekolah & asrama bagi siswa berprestasi.',
                'file_path'      => $mockPdfPath,
                'file_size'      => 980200,
                'file_extension' => 'pdf',
                'published_year' => 2025,
                'download_count' => 178,
                'order_no'       => 5,
                'is_active'      => true,
            ],
            [
                'title'          => 'Company Profile & Dokumen Profil Ekosistem Yayasan Satriabudi Dharma Setia',
                'slug'           => 'company-profile-ekosistem-ysds',
                'category'       => 'brosur_profil',
                'description'    => 'Brosur dan portofolio resmi profil yayasan, visi misi, rekam jejak riset genomik, klinik kesehatan, jaringan sekolah, dan mitra internasional.',
                'file_path'      => $mockPdfPath,
                'file_size'      => 5820400,
                'file_extension' => 'pdf',
                'published_year' => 2024,
                'download_count' => 412,
                'order_no'       => 6,
                'is_active'      => true,
            ],
        ];

        foreach ($sampleDocuments as $docData) {
            WebsiteDocument::updateOrCreate(
                ['slug' => $docData['slug']],
                $docData
            );
        }
    }
}

