<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteNews;
use Tests\TestCase;

class AdminArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:migrate', ['module' => 'Usermanagement']);
        $this->artisan('module:migrate', ['module' => 'Journals']);
        $this->artisan('module:migrate', ['module' => 'Issues']);
        $this->artisan('module:migrate', ['module' => 'Website']);

        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_access_admin_articles_index(): void
    {
        WebsiteNews::create([
            'title'        => 'Simposium Nasional Genomik 2026',
            'slug'         => 'simposium-nasional-genomik-2026',
            'category'     => 'Berita Utama',
            'author_name'  => 'Tim Humas YSDS',
            'summary'      => 'Ringkasan acara simposium nasional.',
            'content'      => 'Isi lengkap simposium nasional riset genomik...',
            'is_published' => true,
            'published_at' => '2026-09-01',
        ]);

        $response = $this->actingAs($this->user)->get(route('website.articles.admin.index'));

        $response->assertStatus(200);
        $response->assertViewIs('website::admin.articles.index');
        $response->assertSee('Simposium Nasional Genomik 2026');
        $response->assertSee('Berita Utama');
        $response->assertSee('Tim Humas YSDS');
    }

    public function test_authenticated_user_can_create_new_article_with_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover_berita.jpg', 800, 600);

        $response = $this->actingAs($this->user)->post(route('website.articles.admin.store'), [
            'title'        => 'Peluncuran Mesin Sekuensial Genomik Baru',
            'slug'         => 'peluncuran-mesin-sekuensial-genomik-baru',
            'category'     => 'Riset Populer',
            'author_name'  => 'Laboratorium Molekuler',
            'summary'      => 'Mesin generasi baru telah dipasang untuk melayani rumah sakit.',
            'content'      => 'Detail spesifikasi dan kemampuan analisis mesin sekuensing generasi mutakhir...',
            'tags'         => 'genomik, pcr, sekuensing',
            'image'        => $image,
            'is_published' => '1',
            'is_featured'  => '1',
            'published_at' => '2026-09-15',
        ]);

        $response->assertRedirect(route('website.articles.admin.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('website_news', [
            'title'        => 'Peluncuran Mesin Sekuensial Genomik Baru',
            'slug'         => 'peluncuran-mesin-sekuensial-genomik-baru',
            'category'     => 'Riset Populer',
            'is_featured'  => true,
            'is_published' => true,
        ]);

        $article = WebsiteNews::where('slug', 'peluncuran-mesin-sekuensial-genomik-baru')->first();
        $this->assertNotNull($article->image);
        Storage::disk('public')->assertExists($article->image);
    }

    public function test_authenticated_user_can_update_article(): void
    {
        $article = WebsiteNews::create([
            'title'        => 'Judul Awal Artikel',
            'slug'         => 'judul-awal-artikel',
            'category'     => 'Edukasi Kesehatan',
            'content'      => 'Konten awal artikel edukasi...',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->put(route('website.articles.admin.update', $article->id), [
            'title'        => 'Judul Artikel Baru yang Diperbarui',
            'slug'         => 'judul-artikel-baru-yang-diperbarui',
            'category'     => 'Edukasi Kesehatan',
            'author_name'  => 'Dr. Siti',
            'summary'      => 'Ringkasan baru.',
            'content'      => 'Konten yang telah direvisi dan disunting...',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('website.articles.admin.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('website_news', [
            'id'    => $article->id,
            'title' => 'Judul Artikel Baru yang Diperbarui',
            'slug'  => 'judul-artikel-baru-yang-diperbarui',
        ]);
    }

    public function test_authenticated_user_can_toggle_and_delete_article(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('test_delete.jpg');
        $imagePath = $image->store('news', 'public');

        $article = WebsiteNews::create([
            'title'        => 'Artikel untuk Dihapus',
            'slug'         => 'artikel-untuk-dihapus',
            'category'     => 'Opini & Kolom',
            'content'      => 'Isi opini singkat...',
            'image'        => $imagePath,
            'is_published' => true,
        ]);

        // Toggle to draft
        $toggleResponse = $this->actingAs($this->user)->patch(route('website.articles.admin.toggle', $article->id));
        $toggleResponse->assertRedirect();
        $this->assertFalse($article->fresh()->is_published);

        // Delete
        $deleteResponse = $this->actingAs($this->user)->delete(route('website.articles.admin.destroy', $article->id));
        $deleteResponse->assertRedirect(route('website.articles.admin.index'));
        $deleteResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('website_news', ['id' => $article->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_public_news_catalog_renders_published_articles(): void
    {
        $published = WebsiteNews::create([
            'title'        => 'Warta Program Bantuan 2026',
            'slug'         => 'warta-program-bantuan-2026',
            'category'     => 'Kegiatan Yayasan',
            'summary'      => 'Ringkasan publik warta program bantuan.',
            'content'      => 'Konten publik kegiatan yayasan satriabudi...',
            'is_published' => true,
            'published_at' => '2026-09-10',
        ]);

        $draft = WebsiteNews::create([
            'title'        => 'Artikel Rahasia Internal Belum Terbit',
            'slug'         => 'artikel-rahasia-internal-belum-terbit',
            'category'     => 'Internal',
            'content'      => 'Jangan tampilkan ini ke publik.',
            'is_published' => false,
        ]);

        $response = $this->get(route('website.news.index'));

        $response->assertStatus(200);
        $response->assertViewIs('website::public.news');
        $response->assertSee('Warta Program Bantuan 2026');
        $response->assertSee('Kegiatan Yayasan');
        $response->assertDontSee('Artikel Rahasia Internal Belum Terbit');
    }

    public function test_public_news_catalog_search_and_category_filter(): void
    {
        WebsiteNews::create([
            'title'        => 'Bioinformatika Tingkat Lanjut',
            'slug'         => 'bioinformatika-tingkat-lanjut',
            'category'     => 'Edukasi Kesehatan',
            'content'      => 'Mempelajari algoritma sekuensing DNA...',
            'is_published' => true,
        ]);

        WebsiteNews::create([
            'title'        => 'Kunjungan Kerja ke Rumah Sakit Mitra',
            'slug'         => 'kunjungan-kerja-ke-rs-mitra',
            'category'     => 'Kegiatan Yayasan',
            'content'      => 'Peninjauan fasilitas laboratorium PCR...',
            'is_published' => true,
        ]);

        // Search
        $searchResponse = $this->get(route('website.news.index', ['search' => 'Bioinformatika']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Bioinformatika Tingkat Lanjut');
        $searchResponse->assertDontSee('Kunjungan Kerja ke Rumah Sakit Mitra');

        // Filter Category
        $filterResponse = $this->get(route('website.news.index', ['category' => 'Kegiatan Yayasan']));
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('Kunjungan Kerja ke Rumah Sakit Mitra');
        $filterResponse->assertDontSee('Bioinformatika Tingkat Lanjut');
    }

    public function test_public_news_detail_renders_and_increments_views(): void
    {
        $article = WebsiteNews::create([
            'title'        => 'Mengenal Pemeriksaan Genomik Terkini',
            'slug'         => 'mengenal-pemeriksaan-genomik-terkini',
            'category'     => 'Edukasi Kesehatan',
            'author_name'  => 'dr. Budi Santoso',
            'summary'      => 'Penjelasan lengkap seputar manfaat diagnostik genomik.',
            'content'      => 'Pemeriksaan genomik memberikan pemahaman mendalam tentang variasi genetik individual...',
            'tags'         => 'genomik, kesehatan, dna',
            'views_count'  => 0,
            'is_published' => true,
            'published_at' => '2026-09-20',
        ]);

        $this->assertEquals(0, $article->views_count);

        $response = $this->get(route('website.news.show', $article->slug));

        $response->assertStatus(200);
        $response->assertViewIs('website::public.news-detail');
        $response->assertSee('Mengenal Pemeriksaan Genomik Terkini');
        $response->assertSee('dr. Budi Santoso');
        $response->assertSee('Pemeriksaan genomik memberikan pemahaman mendalam');

        $this->assertEquals(1, $article->fresh()->views_count);
    }

    public function test_public_news_detail_renders_rich_html_content(): void
    {
        $article = WebsiteNews::create([
            'title'        => 'Panduan Riset Molekuler YSDS',
            'slug'         => 'panduan-riset-molekuler-ysds',
            'category'     => 'Riset Populer',
            'author_name'  => 'Tim Redaksi YSDS',
            'summary'      => 'Ringkasan panduan riset molekuler.',
            'content'      => '<p>Paragraf pembuka riset.</p><h3>Metodologi</h3><ul><li>Sekuensing DNA</li><li>Analisis Bioinformatika</li></ul>',
            'is_published' => true,
            'published_at' => '2026-09-25',
        ]);

        $response = $this->get(route('website.news.show', $article->slug));

        $response->assertStatus(200);
        $response->assertSee('<p>Paragraf pembuka riset.</p>', false);
        $response->assertSee('<h3>Metodologi</h3>', false);
        $response->assertSee('<li>Sekuensing DNA</li>', false);
    }

    public function test_bilingual_article_renders_english_when_locale_is_en(): void
    {
        $article = WebsiteNews::create([
            'title'        => 'Inisiatif Riset Molekuler YSDS',
            'title_en'     => 'YSDS Molecular Research Initiative',
            'slug'         => 'inisiatif-riset-molekuler-ysds',
            'category'     => 'Riset Populer',
            'author_name'  => 'Tim Redaksi YSDS',
            'summary'      => 'Ringkasan naskah dalam bahasa Indonesia.',
            'summary_en'   => 'Executive summary of manuscript in English.',
            'content'      => '<p>Isi lengkap bahasa Indonesia.</p>',
            'content_en'   => '<p>Full content in English language.</p>',
            'is_published' => true,
            'published_at' => '2026-09-26',
        ]);

        // Default locale ID
        app()->setLocale('id');
        $responseId = $this->get(route('website.news.show', $article->slug));
        $responseId->assertStatus(200);
        $responseId->assertSee('Inisiatif Riset Molekuler YSDS');
        $responseId->assertSee('Isi lengkap bahasa Indonesia.');

        // Switch locale to EN
        session(['locale' => 'en']);
        $responseEn = $this->withSession(['locale' => 'en'])->get(route('website.news.show', $article->slug));
        $responseEn->assertStatus(200);
        $responseEn->assertSee('YSDS Molecular Research Initiative');
        $responseEn->assertSee('Executive summary of manuscript in English.');
        $responseEn->assertSee('Full content in English language.');
    }
}
