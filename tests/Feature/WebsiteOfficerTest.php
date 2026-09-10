<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteOfficer;
use Tests\TestCase;

class WebsiteOfficerTest extends TestCase
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

    public function test_public_officers_page_can_be_rendered(): void
    {
        WebsiteOfficer::create([
            'name' => 'Erlina V. F. Ratu',
            'title_prefix' => 'Ibu',
            'position' => 'Pendiri & Dewan Pembina',
            'category' => 'pembina',
            'hierarchy_level' => 1,
            'is_active' => true,
        ]);

        WebsiteOfficer::create([
            'name' => 'Vincentius Simeon',
            'title_prefix' => 'dr.',
            'title_suffix' => 'Sp.PK',
            'position' => 'Ketua Yayasan',
            'category' => 'pengurus_harian',
            'hierarchy_level' => 2,
            'is_active' => true,
        ]);

        $response = $this->get(route('website.officers.public'));
        $response->assertStatus(200);
        $response->assertViewIs('website::public.officers');
        $response->assertSee('Erlina V. F. Ratu');
        $response->assertSee('Vincentius Simeon');
        $response->assertSee('Dewan Pembina');
        $response->assertSee('Ketua Yayasan');
    }

    public function test_admin_can_view_officers_management_index(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('website.officers.index'));
        $response->assertStatus(200);
        $response->assertViewIs('website::admin.officers.index');
    }

    public function test_admin_can_create_new_officer_with_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $photo = UploadedFile::fake()->image('officer.jpg', 300, 300);

        $response = $this->actingAs($admin)->post(route('website.officers.store'), [
            'name' => 'Prof. Dr. Budi Santoso',
            'title_prefix' => 'Prof.',
            'title_suffix' => 'Ph.D',
            'position' => 'Ketua Dewan Pakar Genomik',
            'category' => 'tim_ahli',
            'hierarchy_level' => 4,
            'affiliation' => 'Universitas Indonesia',
            'email' => 'budi@dharma.or.id',
            'order_no' => 1,
            'is_active' => 1,
            'photo' => $photo,
        ]);

        $response->assertRedirect(route('website.officers.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('website_officers', [
            'name' => 'Prof. Dr. Budi Santoso',
            'position' => 'Ketua Dewan Pakar Genomik',
            'category' => 'tim_ahli',
            'hierarchy_level' => 4,
        ]);

        $officer = WebsiteOfficer::where('name', 'Prof. Dr. Budi Santoso')->first();
        $this->assertNotNull($officer->photo_path);
        Storage::disk('public')->assertExists($officer->photo_path);
    }

    public function test_admin_can_update_and_toggle_officer(): void
    {
        $admin = User::factory()->create();

        $officer = WebsiteOfficer::create([
            'name' => 'Nama Awal',
            'position' => 'Posisi Awal',
            'category' => 'pengurus_harian',
            'hierarchy_level' => 2,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('website.officers.update', $officer->id), [
            'name' => 'Nama Baru Diperbarui',
            'position' => 'Ketua Umum',
            'category' => 'pengurus_harian',
            'hierarchy_level' => 2,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('website.officers.index'));
        $this->assertDatabaseHas('website_officers', [
            'id' => $officer->id,
            'name' => 'Nama Baru Diperbarui',
            'position' => 'Ketua Umum',
        ]);

        // Test toggle status
        $toggleResponse = $this->actingAs($admin)->patch(route('website.officers.toggle', $officer->id));
        $toggleResponse->assertRedirect();
        $this->assertDatabaseHas('website_officers', [
            'id' => $officer->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_officer(): void
    {
        $admin = User::factory()->create();

        $officer = WebsiteOfficer::create([
            'name' => 'Officer to Delete',
            'position' => 'Humas',
            'category' => 'pengurus_harian',
            'hierarchy_level' => 3,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('website.officers.destroy', $officer->id));
        $response->assertRedirect(route('website.officers.index'));

        $this->assertDatabaseMissing('website_officers', [
            'id' => $officer->id,
        ]);
    }
}
