<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Website\Models\WebsiteEvent;
use Tests\TestCase;

class PublicEventTest extends TestCase
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

    public function test_public_user_can_view_events_catalog(): void
    {
        WebsiteEvent::create([
            'title'        => 'BioAI and Genomics Symposium - Indonesia',
            'slug'         => 'bioai-and-genomics-symposium-indonesia',
            'tag'          => 'Kegiatan Terbaru',
            'year'         => '2026',
            'partner_name' => 'Ultima Genomic',
            'sponsor_name' => 'Panin Bank',
            'summary'      => 'Akselerasi riset presisi dan genomik.',
            'is_published' => true,
            'is_featured'  => true,
        ]);

        $response = $this->get(route('website.events.public'));

        $response->assertStatus(200);
        $response->assertViewIs('website::public.events');
        $response->assertSee('BioAI and Genomics Symposium - Indonesia');
        $response->assertSee('Ultima Genomic');
        $response->assertSee('Panin Bank');
        $response->assertSee('2026');
    }

    public function test_public_user_can_view_event_detail(): void
    {
        $event = WebsiteEvent::create([
            'title'        => 'Simposium Internasional BioAI 2026',
            'slug'         => 'simposium-internasional-bioai-2026',
            'year'         => '2026',
            'partner_name' => 'Ultima Genomic',
            'sponsor_name' => 'Panin Bank',
            'summary'      => 'Ringkasan forum ilmiah genomik presisi.',
            'description'  => 'Uraian lengkap agenda forum BioAI dan Genomik Indonesia...',
            'event_date'   => 'Kamis, 15 Mei 2026',
            'event_time'   => '10.00 - 16.00 WIB',
            'location'     => 'Jakarta Convention Center',
            'is_published' => true,
        ]);

        $response = $this->get(route('website.events.show', $event->slug));

        $response->assertStatus(200);
        $response->assertViewIs('website::public.event-detail');
        $response->assertSee('Simposium Internasional BioAI 2026');
        $response->assertSee('Ultima Genomic');
        $response->assertSee('Panin Bank');
        $response->assertSee('Jakarta Convention Center');
        $response->assertSee('Kamis, 15 Mei 2026');
    }

    public function test_unpublished_event_returns_404(): void
    {
        $draftEvent = WebsiteEvent::create([
            'title'        => 'Draft Acara Internal',
            'slug'         => 'draft-acara-internal',
            'year'         => '2026',
            'is_published' => false,
        ]);

        $response = $this->get(route('website.events.show', $draftEvent->slug));
        $response->assertStatus(404);
    }

    public function test_home_page_displays_featured_event(): void
    {
        WebsiteEvent::create([
            'title'        => 'BioAI and Genomics Symposium - Indonesia',
            'slug'         => 'bioai-and-genomics-symposium-indonesia',
            'tag'          => 'Kegiatan Terbaru',
            'year'         => '2026',
            'partner_name' => 'Ultima Genomic',
            'sponsor_name' => 'Panin Bank',
            'summary'      => 'Akselerasi riset presisi dan genomik.',
            'is_published' => true,
            'is_featured'  => true,
        ]);

        $response = $this->get(route('website.home'));

        $response->assertStatus(200);
        $response->assertSee('BioAI and Genomics Symposium - Indonesia');
        $response->assertSee('Kegiatan Terbaru');
        $response->assertSee('Ultima Genomic');
        $response->assertSee('Panin Bank');
        $response->assertSee('2026');
        $response->assertSee('Tahun Pelaksanaan');
        $response->assertSee('Artikel Lainnya');
    }
}
