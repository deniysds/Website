<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteCollaboration;
use Modules\Website\Models\WebsiteCollaborationItem;
use Tests\TestCase;

class AdminCollaborationControllerTest extends TestCase
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

    public function test_authenticated_user_can_access_collaborations_index(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'RSUP Dr. Sardjito',
            'category'         => 'Rumah Sakit',
            'location'         => 'Yogyakarta',
            'is_active'        => true,
        ]);

        $collab->items()->create([
            'item_number' => '1',
            'name'        => 'Real-Time PCR',
            'unit'        => 'Unit',
            'quantity'    => 2,
        ]);

        $response = $this->actingAs($this->user)->get(route('website.collaborations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('website::admin.collaborations.index');
        $response->assertSee('RSUP Dr. Sardjito');
        $response->assertSee('Rumah Sakit');
        $response->assertSee('Yogyakarta');
    }

    public function test_authenticated_user_can_create_collaboration(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('hospital_logo.png');

        $response = $this->actingAs($this->user)->post(route('website.collaborations.store'), [
            'institution_name' => 'RSUP Sanglah Denpasar',
            'category'         => 'Rumah Sakit',
            'location'         => 'Denpasar, Bali',
            'handover_date'    => '2025-03-01',
            'pic_name'         => 'Dr. I Nyoman, Sp.PK',
            'description'      => 'Hibah alat deteksi genomik.',
            'order_no'         => 1,
            'is_active'        => 1,
            'institution_logo' => $file,
        ]);

        $collab = WebsiteCollaboration::where('institution_name', 'RSUP Sanglah Denpasar')->first();
        $this->assertNotNull($collab);
        $response->assertRedirect(route('website.collaborations.show', $collab->id));

        $this->assertDatabaseHas('website_collaborations', [
            'institution_name' => 'RSUP Sanglah Denpasar',
            'location'         => 'Denpasar, Bali',
        ]);
    }

    public function test_authenticated_user_can_view_collaboration_detail_with_equipments(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'FK Unair',
            'category'         => 'Perguruan Tinggi',
            'location'         => 'Surabaya',
            'is_active'        => true,
        ]);

        $item = $collab->items()->create([
            'item_number'    => 'EQ-01',
            'name'           => 'Biosafety Cabinet Class II',
            'unit'           => 'Unit',
            'quantity'       => 3,
            'specifications' => 'HEPA filter certified',
        ]);

        $response = $this->actingAs($this->user)->get(route('website.collaborations.show', $collab->id));
        $response->assertStatus(200);
        $response->assertViewIs('website::admin.collaborations.show');
        $response->assertSee('FK Unair');
        $response->assertSee('Biosafety Cabinet Class II');
        $response->assertSee('EQ-01');
        $response->assertSee('3');
    }

    public function test_authenticated_user_can_update_collaboration(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'Nama Lama Instansi',
            'category'         => 'Lembaga Riset',
            'is_active'        => true,
        ]);

        $response = $this->actingAs($this->user)->put(route('website.collaborations.update', $collab->id), [
            'institution_name' => 'Nama Baru Lembaga Riset',
            'category'         => 'Pusat Penelitian',
            'location'         => 'Bogor',
            'is_active'        => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('website_collaborations', [
            'id'               => $collab->id,
            'institution_name' => 'Nama Baru Lembaga Riset',
            'location'         => 'Bogor',
        ]);
    }

    public function test_authenticated_user_can_toggle_and_delete_collaboration(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'RSUD Jayapura',
            'is_active'        => true,
        ]);

        $toggleResponse = $this->actingAs($this->user)->patch(route('website.collaborations.toggle', $collab->id));
        $toggleResponse->assertRedirect();
        $this->assertFalse($collab->fresh()->is_active);

        $deleteResponse = $this->actingAs($this->user)->delete(route('website.collaborations.destroy', $collab->id));
        $deleteResponse->assertRedirect(route('website.collaborations.index'));
        $this->assertDatabaseMissing('website_collaborations', ['id' => $collab->id]);
    }

    public function test_authenticated_user_can_manage_equipment_items(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'RS Dr. Wahidin Sudirohusodo Makassar',
            'is_active'        => true,
        ]);

        // 1. Tambah Peralatan
        $storeResponse = $this->actingAs($this->user)->post(route('website.collaborations.items.store', $collab->id), [
            'item_number'    => '1',
            'name'           => 'Centrifuge Refrigerated',
            'unit'           => 'Unit',
            'quantity'       => 5,
            'specifications' => 'Spesifikasi Rotor 24 x 2 mL',
            'order_no'       => 1,
        ]);

        $storeResponse->assertRedirect(route('website.collaborations.show', $collab->id));
        $this->assertDatabaseHas('website_collaboration_items', [
            'collaboration_id' => $collab->id,
            'item_number'      => '1',
            'name'             => 'Centrifuge Refrigerated',
            'unit'             => 'Unit',
            'quantity'         => 5,
        ]);

        $item = $collab->items()->first();

        // 2. Ubah Peralatan
        $updateResponse = $this->actingAs($this->user)->put(route('website.collaborations.items.update', [$collab->id, $item->id]), [
            'item_number'    => '1A',
            'name'           => 'Centrifuge Refrigerated High-Capacity',
            'unit'           => 'Unit',
            'quantity'       => 7,
            'specifications' => 'Spesifikasi rotor diperbarui',
            'order_no'       => 1,
        ]);

        $updateResponse->assertRedirect(route('website.collaborations.show', $collab->id));
        $this->assertDatabaseHas('website_collaboration_items', [
            'id'          => $item->id,
            'item_number' => '1A',
            'name'        => 'Centrifuge Refrigerated High-Capacity',
            'quantity'    => 7,
        ]);

        // 3. Hapus Peralatan
        $deleteResponse = $this->actingAs($this->user)->delete(route('website.collaborations.items.destroy', [$collab->id, $item->id]));
        $deleteResponse->assertRedirect(route('website.collaborations.show', $collab->id));
        $this->assertDatabaseMissing('website_collaboration_items', ['id' => $item->id]);
    }

    public function test_public_collaboration_page_renders_institutions_and_equipments(): void
    {
        $collab = WebsiteCollaboration::create([
            'institution_name' => 'RSUP Prof. Dr. I.G.N.G. Ngoerah',
            'category'         => 'Rumah Sakit',
            'location'         => 'Denpasar',
            'handover_date'    => '2024-10-10',
            'pic_name'         => 'Prof. Ngoerah Lab',
            'is_active'        => true,
        ]);

        $collab->items()->create([
            'item_number'    => '01',
            'name'           => 'Sequencing Analyzer System',
            'unit'           => 'Set',
            'quantity'       => 2,
            'specifications' => 'Sistem lengkap sekuensing gen',
        ]);

        $response = $this->get(route('website.collaborations.public'));
        $response->assertStatus(200);
        $response->assertSee('Kolaborasi & Penyerahan Peralatan');
        $response->assertSee('RSUP Prof. Dr. I.G.N.G. Ngoerah');
        $response->assertSee('Sequencing Analyzer System');
        $response->assertSee('01');
        $response->assertSee('Set');
        $response->assertSee('2');
    }

    public function test_public_collaboration_page_filter_and_search(): void
    {
        $collab1 = WebsiteCollaboration::create([
            'institution_name' => 'Universitas Indonesia',
            'category'         => 'Perguruan Tinggi',
            'location'         => 'Depok',
            'is_active'        => true,
        ]);
        $collab1->items()->create([
            'item_number' => '1',
            'name'        => 'PCR System UI',
            'unit'        => 'Unit',
            'quantity'    => 1,
        ]);

        $collab2 = WebsiteCollaboration::create([
            'institution_name' => 'RS Jiwa Daerah',
            'category'         => 'Rumah Sakit',
            'location'         => 'Semarang',
            'is_active'        => true,
        ]);

        // Search instansi name
        $searchResponse = $this->get(route('website.collaborations.public', ['search' => 'Indonesia']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Universitas Indonesia');
        $searchResponse->assertDontSee('RS Jiwa Daerah');

        // Filter category
        $filterResponse = $this->get(route('website.collaborations.public', ['category' => 'Rumah Sakit']));
        $filterResponse->assertStatus(200);
        $filterResponse->assertSee('RS Jiwa Daerah');
        $filterResponse->assertDontSee('Universitas Indonesia');
    }
}
