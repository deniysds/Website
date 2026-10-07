<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteVisitation;
use Tests\TestCase;

class PublicVisitationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('module:migrate', ['module' => 'Usermanagement']);
        $this->artisan('module:migrate', ['module' => 'Journals']);
        $this->artisan('module:migrate', ['module' => 'Issues']);
        $this->artisan('module:migrate', ['module' => 'Website']);

        $this->admin = User::factory()->create();
    }

    public function test_visitor_can_view_visitations_index_page(): void
    {
        WebsiteVisitation::create([
            'title'            => 'Visitasi Lab Molekuler RSUD TC Hillers Maumere',
            'slug'             => 'visitasi-lab-molekuler-rsud-tc-hillers-maumere',
            'institution_name' => 'RSUD TC Hillers Maumere',
            'city'             => 'Kabupaten Sikka',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2023-10-18',
            'summary'          => 'Instalasi mesin Real-Time PCR 96-well serta pendampingan biosafety analis.',
            'description'      => 'Deskripsi lengkap pelaksanaan visitasi.',
            'is_published'     => true,
            'order_no'         => 1,
        ]);

        $response = $this->get(route('website.visitations.public'));

        $response->assertStatus(200);
        $response->assertSee('Dokumentasi Visitasi');
        $response->assertSee('RSUD TC Hillers Maumere');
        $response->assertSee('Kabupaten Sikka');
    }

    public function test_visitor_can_filter_visitations_by_search_and_province(): void
    {
        WebsiteVisitation::create([
            'title'            => 'Visitasi Lab RSUD Kalabahi Alor',
            'slug'             => 'visitasi-lab-rsud-kalabahi-alor',
            'institution_name' => 'RSUD Kalabahi Alor',
            'city'             => 'Kabupaten Alor',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-08-30',
            'summary'          => 'Peninjauan cold chain dan freezer biomedis di kepulauan Alor.',
            'description'      => 'Deskripsi lengkap.',
            'is_published'     => true,
            'order_no'         => 1,
        ]);

        WebsiteVisitation::create([
            'title'            => 'Kunjungan Kemitraan Mikrobiologi FKUI',
            'slug'             => 'kunjungan-kemitraan-mikrobiologi-fkui',
            'institution_name' => 'Laboratorium Mikrobiologi FKUI',
            'city'             => 'Jakarta Pusat',
            'province'         => 'DKI Jakarta',
            'visit_date'       => '2024-07-10',
            'summary'          => 'Evaluasi pemanfaatan instrumen kemitraan PacBio.',
            'description'      => 'Deskripsi lengkap.',
            'is_published'     => true,
            'order_no'         => 2,
        ]);

        // Filter search: 'Alor'
        $response = $this->get(route('website.visitations.public', ['search' => 'Alor']));
        $response->assertStatus(200);
        $response->assertSee('RSUD Kalabahi Alor');
        $response->assertDontSee('Laboratorium Mikrobiologi FKUI');

        // Filter province: 'DKI Jakarta'
        $responseProvince = $this->get(route('website.visitations.public', ['province' => 'DKI Jakarta']));
        $responseProvince->assertStatus(200);
        $responseProvince->assertSee('Laboratorium Mikrobiologi FKUI');
        $responseProvince->assertDontSee('RSUD Kalabahi Alor');
    }

    public function test_visitor_can_view_visitation_detail_page(): void
    {
        $visitation = WebsiteVisitation::create([
            'title'            => 'Visitasi Lab RSUD Komodo Labuan Bajo',
            'slug'             => 'visitasi-lab-rsud-komodo-labuan-bajo',
            'institution_name' => 'RSUD Komodo Labuan Bajo',
            'city'             => 'Kabupaten Manggarai Barat',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-05-22',
            'delegation_team'  => 'dr. Vincent, Sp.PK & Tim Teknis YSDS',
            'summary'          => 'Pendampingan teknis dan verifikasi ruang lab modern.',
            'description'      => 'Narasi mendalam visitasi dan penyerahan instrumen ekstraksi PCR otomatis.',
            'is_published'     => true,
            'order_no'         => 1,
        ]);

        $response = $this->get(route('website.visitations.show', $visitation->slug));

        $response->assertStatus(200);
        $response->assertSee('RSUD Komodo Labuan Bajo');
        $response->assertSee('dr. Vincent, Sp.PK & Tim Teknis YSDS');
        $response->assertSee('Narasi mendalam visitasi');
    }

    public function test_admin_can_view_visitations_index_and_create_visitation(): void
    {
        $response = $this->actingAs($this->admin)->get(route('website.visitations.admin.index'));
        $response->assertStatus(200);
        $response->assertSee('Dokumentasi Visitasi');

        $payload = [
            'title'            => 'Visitasi Labkesda Sabu Raijua',
            'institution_name' => 'Labkesda Sabu Raijua',
            'city'             => 'Kabupaten Sabu Raijua',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-02-14',
            'delegation_team'  => 'Tim Lapangan YSDS',
            'summary'          => 'Monitoring implementasi POP Savu Smart Island.',
            'description'      => 'Deskripsi lengkap pelaksanaan kegiatan di Pulau Sabu.',
            'is_published'     => 1,
            'order_no'         => 5,
        ];

        $postResponse = $this->actingAs($this->admin)->post(route('website.visitations.admin.store'), $payload);
        $postResponse->assertRedirect(route('website.visitations.admin.index'));

        $this->assertDatabaseHas('website_visitations', [
            'institution_name' => 'Labkesda Sabu Raijua',
            'province'         => 'Nusa Tenggara Timur',
        ]);
    }

    public function test_admin_can_update_and_delete_visitation(): void
    {
        $visitation = WebsiteVisitation::create([
            'title'            => 'Kunjungan Awal',
            'slug'             => 'kunjungan-awal',
            'institution_name' => 'RSUD Uji Coba',
            'city'             => 'Kupang',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-01-01',
            'summary'          => 'Ringkasan awal',
            'description'      => 'Deskripsi awal',
            'is_published'     => true,
        ]);

        $updatePayload = [
            'title'            => 'Kunjungan Revisi Terkini',
            'institution_name' => 'RSUD Uji Coba Terupdate',
            'city'             => 'Kupang',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-01-05',
            'summary'          => 'Ringkasan diperbarui',
            'description'      => 'Deskripsi baru yang diperbarui',
            'is_published'     => 1,
        ];

        $putResponse = $this->actingAs($this->admin)->put(route('website.visitations.admin.update', $visitation->id), $updatePayload);
        $putResponse->assertRedirect(route('website.visitations.admin.index'));

        $this->assertDatabaseHas('website_visitations', [
            'id'               => $visitation->id,
            'institution_name' => 'RSUD Uji Coba Terupdate',
            'title'            => 'Kunjungan Revisi Terkini',
        ]);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('website.visitations.admin.destroy', $visitation->id));
        $deleteResponse->assertRedirect(route('website.visitations.admin.index'));

        $this->assertDatabaseMissing('website_visitations', [
            'id' => $visitation->id,
        ]);
    }

    public function test_admin_can_toggle_visitation_status(): void
    {
        $visitation = WebsiteVisitation::create([
            'title'            => 'Kunjungan Toggle',
            'slug'             => 'kunjungan-toggle',
            'institution_name' => 'RSUD Toggle',
            'city'             => 'Ende',
            'province'         => 'Nusa Tenggara Timur',
            'visit_date'       => '2024-03-01',
            'summary'          => 'Ringkasan',
            'description'      => 'Deskripsi',
            'is_published'     => true,
        ]);

        $patchResponse = $this->actingAs($this->admin)->patch(route('website.visitations.admin.toggle', $visitation->id));
        $patchResponse->assertRedirect();

        $this->assertFalse((bool) $visitation->fresh()->is_published);
    }
}
