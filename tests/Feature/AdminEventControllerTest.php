<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteEvent;
use Tests\TestCase;

class AdminEventControllerTest extends TestCase
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

    public function test_guest_cannot_access_admin_events(): void
    {
        $response = $this->get(route('website.events.admin.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_admin_events_index(): void
    {
        WebsiteEvent::create([
            'title'        => 'BioAI and Genomics Symposium - Indonesia',
            'slug'         => 'bioai-and-genomics-symposium-indonesia',
            'tag'          => 'Kegiatan Terbaru',
            'year'         => '2026',
            'partner_name' => 'Ultima Genomic',
            'sponsor_name' => 'Panin Bank',
            'summary'      => 'Ringkasan acara simposium.',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('website.events.admin.index'));

        $response->assertStatus(200);
        $response->assertViewIs('website::admin.events.index');
        $response->assertSee('BioAI and Genomics Symposium - Indonesia');
        $response->assertSee('Ultima Genomic');
        $response->assertSee('Panin Bank');
        $response->assertSee('2026');
    }

    public function test_authenticated_user_can_access_create_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('website.events.admin.create'));

        $response->assertStatus(200);
        $response->assertViewIs('website::admin.events.create');
        $response->assertSee('Tambah Kegiatan / Acara Baru');
    }

    public function test_authenticated_user_can_store_event_with_banner(): void
    {
        Storage::fake('public');
        $banner = UploadedFile::fake()->image('event_banner.jpg', 1200, 630);

        $response = $this->actingAs($this->user)->post(route('website.events.admin.store'), [
            'title'            => 'Workshop Bioinformatika & GenAI 2026',
            'tag'              => 'Lokakarya Nasional',
            'year'             => '2026',
            'partner_name'     => 'BRIN',
            'sponsor_name'     => 'Bank Mandiri',
            'banner_image'     => $banner,
            'summary'          => 'Pelatihan intensif pipeline bioinformatika presisi.',
            'description'      => 'Deskripsi lengkap workshop bioinformatika...',
            'event_date'       => '12 - 14 Agustus 2026',
            'event_time'       => '09.00 - 17.00 WIB',
            'location'         => 'Gedung BJ Habibie, Jakarta',
            'registration_url' => 'https://bit.ly/workshop-bioai',
            'order_no'         => 2,
            'is_published'     => '1',
            'is_featured'      => '1',
        ]);

        $response->assertRedirect(route('website.events.admin.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('website_events', [
            'title'        => 'Workshop Bioinformatika & GenAI 2026',
            'partner_name' => 'BRIN',
            'sponsor_name' => 'Bank Mandiri',
            'year'         => '2026',
            'is_published' => true,
            'is_featured'  => true,
        ]);

        $createdEvent = WebsiteEvent::where('title', 'Workshop Bioinformatika & GenAI 2026')->first();
        $this->assertNotNull($createdEvent->banner_image);
        Storage::disk('public')->assertExists($createdEvent->banner_image);
    }

    public function test_authenticated_user_can_access_edit_form(): void
    {
        $event = WebsiteEvent::create([
            'title'        => 'Simposium Genomik 2025',
            'year'         => '2025',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('website.events.admin.edit', $event->id));

        $response->assertStatus(200);
        $response->assertViewIs('website::admin.events.edit');
        $response->assertSee('Simposium Genomik 2025');
    }

    public function test_authenticated_user_can_update_event(): void
    {
        $event = WebsiteEvent::create([
            'title'        => 'Simposium Lama',
            'year'         => '2024',
            'is_published' => false,
        ]);

        $response = $this->actingAs($this->user)->put(route('website.events.admin.update', $event->id), [
            'title'        => 'Simposium Diperbarui 2026',
            'year'         => '2026',
            'partner_name' => 'Mitra Baru',
            'is_published' => '1',
            'is_featured'  => '1',
        ]);

        $response->assertRedirect(route('website.events.admin.index'));
        $this->assertDatabaseHas('website_events', [
            'id'           => $event->id,
            'title'        => 'Simposium Diperbarui 2026',
            'partner_name' => 'Mitra Baru',
            'is_published' => true,
            'is_featured'  => true,
        ]);
    }

    public function test_authenticated_user_can_toggle_published_and_featured_status(): void
    {
        $event = WebsiteEvent::create([
            'title'        => 'Event Uji Coba Toggle',
            'year'         => '2026',
            'is_published' => true,
            'is_featured'  => false,
        ]);

        $toggleResponse = $this->actingAs($this->user)->patch(route('website.events.admin.toggle', $event->id));
        $toggleResponse->assertRedirect();
        $this->assertFalse($event->fresh()->is_published);

        $featureResponse = $this->actingAs($this->user)->patch(route('website.events.admin.featured', $event->id));
        $featureResponse->assertRedirect();
        $this->assertTrue($event->fresh()->is_featured);
    }

    public function test_authenticated_user_can_delete_event(): void
    {
        $event = WebsiteEvent::create([
            'title'        => 'Event Akan Dihapus',
            'year'         => '2026',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->delete(route('website.events.admin.destroy', $event->id));

        $response->assertRedirect(route('website.events.admin.index'));
        $this->assertDatabaseMissing('website_events', [
            'id' => $event->id,
        ]);
    }
}
