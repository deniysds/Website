<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WebsiteNews;
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
    }
}
