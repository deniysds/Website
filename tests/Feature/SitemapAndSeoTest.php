<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Website\Models\WebsiteDocument;
use Modules\Website\Models\WebsiteNews;
use Modules\Website\Models\WebsiteVisitation;
use Tests\TestCase;

class SitemapAndSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:migrate', ['module' => 'Usermanagement']);
        $this->artisan('module:migrate', ['module' => 'Journals']);
        $this->artisan('module:migrate', ['module' => 'Issues']);
        $this->artisan('module:migrate', ['module' => 'Website']);
    }

    public function test_sitemap_xml_returns_valid_response_and_contains_core_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('xml', $response->headers->get('Content-Type'));
        $response->assertSee('urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"', false);
        $response->assertSee(route('website.home'));
        $response->assertSee(route('website.about'));
        $response->assertSee(route('website.documents.public'));
        $response->assertSee(route('website.donation.public'));
        $response->assertSee(route('website.assistance.public'));
    }

    public function test_sitemap_xml_includes_dynamic_news_and_visitations(): void
    {
        $news = WebsiteNews::create([
            'title'        => 'Berita Terkini Riset Medis YSDS',
            'summary'      => 'Ringkasan berita riset medis.',
            'category'     => 'Berita Utama',
            'is_published' => true,
        ]);

        $visitation = WebsiteVisitation::create([
            'title'            => 'Visitasi Labkesda Flores Barat',
            'slug'             => 'visitasi-labkesda-flores-barat',
            'institution_name' => 'Labkesda Flores Barat',
            'city'             => 'Manggarai Barat',
            'province'         => 'NTT',
            'visit_date'       => '2024-05-10',
            'is_published'     => true,
            'order_no'         => 1,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee(route('website.news.show', $news->slug));
        $response->assertSee(route('website.visitations.show', $visitation->slug));
    }
}
