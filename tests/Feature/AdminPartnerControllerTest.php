<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsitePartner;
use Tests\TestCase;

class AdminPartnerControllerTest extends TestCase
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

    public function test_authenticated_user_can_access_partners_index(): void
    {
        WebsitePartner::create([
            'name' => 'PaninBank',
            'type' => 'main',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('website.partners.index'));
        $response->assertStatus(200);
        $response->assertViewIs('website::admin.partners.index');
        $response->assertSee('PaninBank');
    }

    public function test_authenticated_user_can_create_partner(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($this->user)->post(route('website.partners.store'), [
            'name'        => 'Universitas Gadjah Mada',
            'type'        => 'supporting',
            'website_url' => 'https://ugm.ac.id',
            'order_no'    => 1,
            'is_active'   => 1,
            'logo'        => $file,
        ]);

        $response->assertRedirect(route('website.partners.index'));
        $this->assertDatabaseHas('website_partners', [
            'name' => 'Universitas Gadjah Mada',
            'type' => 'supporting',
        ]);
    }

    public function test_authenticated_user_can_update_partner(): void
    {
        $partner = WebsitePartner::create([
            'name' => 'PacBio Old',
            'type' => 'main',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->put(route('website.partners.update', $partner->id), [
            'name'        => 'PacBio New Name',
            'type'        => 'main',
            'website_url' => 'https://pacb.com',
            'order_no'    => 5,
            'is_active'   => 1,
        ]);

        $response->assertRedirect(route('website.partners.index'));
        $this->assertDatabaseHas('website_partners', [
            'id'   => $partner->id,
            'name' => 'PacBio New Name',
        ]);
    }

    public function test_authenticated_user_can_toggle_and_delete_partner(): void
    {
        $partner = WebsitePartner::create([
            'name' => 'Institut Pertanian Bogor',
            'type' => 'supporting',
            'is_active' => true,
        ]);

        $toggleResponse = $this->actingAs($this->user)->patch(route('website.partners.toggle', $partner->id));
        $toggleResponse->assertRedirect(route('website.partners.index'));
        $this->assertFalse($partner->fresh()->is_active);

        $deleteResponse = $this->actingAs($this->user)->delete(route('website.partners.destroy', $partner->id));
        $deleteResponse->assertRedirect(route('website.partners.index'));
        $this->assertDatabaseMissing('website_partners', ['id' => $partner->id]);
    }

    public function test_public_home_renders_partners_section(): void
    {
        WebsitePartner::create([
            'name' => 'Ultima Genomics Test',
            'type' => 'main',
            'is_active' => true,
        ]);

        WebsitePartner::create([
            'name' => 'Universitas Indonesia Test',
            'type' => 'supporting',
            'is_active' => true,
        ]);

        $response = $this->get(route('website.home'));
        $response->assertStatus(200);
        $response->assertSee('Mitra Kami');
        $response->assertSee('Ultima Genomics Test');
        $response->assertSee('Universitas Indonesia Test');
    }
}
