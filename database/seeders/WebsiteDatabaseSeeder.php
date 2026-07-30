<?php

namespace Modules\Website\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Website\Models\WebsiteNews;
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

            // Stats Counters
            'stat_1_number' => '150+',
            'stat_1_label' => 'Kerjasama Global',
            'stat_2_number' => '125 T',
            'stat_2_label' => 'Riset & Hibah Terbuka',
            'stat_3_number' => '79+',
            'stat_3_label' => 'Publikasi Ilmiah',

            // Profil Section
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

            // Method Section (Pendekatan Terarah)
            'method_tag' => 'Metode',
            'method_title' => 'Pendekatan terarah untuk mencapai hasil yang optimal',
            'method_desc' => 'Kami menerjemahkan komitmen menjadi dampak berkesinambungan melalui aliansi strategis bersama mitra riset terpercaya di seluruh Indonesia.',
            'method_step_1_title' => 'Mengkaji Riset & Kebutuhan',
            'method_step_1_desc' => 'Pemetaan isu strategis sains & kesehatan berbasis fakta ilmiah untuk pemangku kepentingan nasional.',
            'method_step_2_title' => 'Merancang dan Menjalankan Program',
            'method_step_2_desc' => 'Eksekusi program publikasi & fasilitas riset secara transparan dengan standar akuntabilitas tinggi.',
            'method_step_3_title' => 'Menevaluasi dan Mengembangkan',
            'method_step_3_desc' => 'Pemeriksaan berkala untuk memastkan efektivitas dampak program ilmiah yang kontinyu bagi masyarakat.',

            // Featured Project / Simposium Section
            'project_tag' => 'Proyek Terbaru',
            'project_title' => 'GenAI and Genomics Symposium - Indonesia',
            'project_time' => '10.00 - 16.00 WIB',
            'project_date' => 'Kamis, 15 Mei 2026',
            'project_location' => 'Jakarta, Indonesia',
            'project_organizer' => 'Penyelenggara: Yayasan Satriabudi Dharma Setia',
        ];

        foreach ($settings as $key => $val) {
            WebsiteSetting::setByKey($key, $val, 'landing');
        }

        // Default Programs matching design mock cards
        $programs = [
            [
                'title' => 'IGNITE',
                'badge_text' => 'Program Utama',
                'description' => 'Platform pengelolaan jurnal ilmiah & workflow editorial berbasis peer-review independen.',
                'icon' => 'ki-filled ki-rocket',
                'link_url' => '/catalog-journals',
                'order_no' => 1,
            ],
            [
                'title' => 'Pendidikan',
                'badge_text' => 'Beasiswa',
                'description' => 'Pengembangan kapasitas akademik & sains untuk mahasiswa dan peneliti muda Indonesia.',
                'icon' => 'ki-filled ki-teacher',
                'link_url' => '/about-us',
                'order_no' => 2,
            ],
            [
                'title' => 'EJA Kuliah',
                'badge_text' => 'Dukungan',
                'description' => 'Bantuan studi tinggi untuk mendukung calon pemimpin riset masa depan.',
                'icon' => 'ki-filled ki-user-tick',
                'link_url' => '/about-us',
                'order_no' => 3,
            ],
            [
                'title' => 'Kelola',
                'badge_text' => 'Manajemen',
                'description' => 'Pendampingan tata kelola riset laboratorium dan tata kelola jurnal terakreditasi.',
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
    }
}
