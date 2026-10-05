<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Mail\AssistanceRequestAdminNotificationMail;
use Modules\Website\Mail\AssistanceRequestConfirmationMail;
use Modules\Website\Mail\AssistanceRequestStatusUpdatedMail;
use Modules\Website\Models\WebsiteAssistanceRequest;
use Modules\Website\Models\WebsiteCollaboration;
use Tests\TestCase;

class PublicAssistanceRequestTest extends TestCase
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

    public function test_visitor_can_view_assistance_request_page(): void
    {
        $response = $this->get(route('website.assistance.public'));

        $response->assertStatus(200);
        $response->assertSee('Permohonan Bantuan');
        $response->assertSee('Yayasan Satriabudi Dharma Setia');
        $response->assertSee('Nama Instansi / Rumah Sakit / Lab');
        $response->assertSee('Lacak Permohonan');
    }

    public function test_visitor_can_submit_assistance_request_successfully_and_trigger_emails(): void
    {
        Mail::fake();

        $payload = [
            'institution_name' => 'RSUD Dr. T.C. Hillers Maumere',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Clara Valentinus',
            'pic_position'     => 'Kepala Instalasi Laboratorium',
            'pic_phone'        => '081234567890',
            'pic_email'        => 'lab@rsudmaumere.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Kabupaten Sikka',
            'address'          => 'Jl. Wairklau No. 1, Kota Uneng, Alok, Sikka',
            'assistance_type'  => 'Peralatan Diagnostik & PCR Kit',
            'equipment_needed' => 'Mesin Real-Time PCR 96 Well dan Reagen Deteksi Genomik',
            'urgency_reason'   => 'Fasilitas rujukan diagnostik terdekat berjarak 300 km via laut.',
        ];

        $response = $this->post(route('website.assistance.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('ticket_code');

        $ticketCode = session('ticket_code');
        $this->assertNotNull($ticketCode);
        $this->assertStringStartsWith('REQ-', $ticketCode);

        $this->assertDatabaseHas('website_assistance_requests', [
            'ticket_code'      => $ticketCode,
            'institution_name' => 'RSUD Dr. T.C. Hillers Maumere',
            'pic_name'         => 'dr. Clara Valentinus',
            'pic_email'        => 'lab@rsudmaumere.go.id',
            'status'           => 'pending',
            'city'             => 'Kabupaten Sikka',
        ]);

        Mail::assertQueued(AssistanceRequestAdminNotificationMail::class);
        Mail::assertQueued(AssistanceRequestConfirmationMail::class, function ($mail) {
            return $mail->assistanceRequest->pic_email === 'lab@rsudmaumere.go.id';
        });
    }

    public function test_visitor_can_submit_assistance_request_with_attachment(): void
    {
        Mail::fake();
        Storage::fake('public');

        $file = UploadedFile::fake()->create('proposal_alkes_rsud.pdf', 500, 'application/pdf');

        $payload = [
            'institution_name' => 'Puskesmas Nita',
            'institution_type' => 'Puskesmas',
            'pic_name'         => 'dr. Maria Goretti',
            'pic_position'     => 'Kepala Puskesmas',
            'pic_phone'        => '081398765432',
            'pic_email'        => 'puskesmasnita@sikkakab.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Kabupaten Sikka',
            'address'          => 'Jl. Trans Maumere Larantuka Km 12',
            'assistance_type'  => 'Cold Chain & Reagen Transport',
            'equipment_needed' => 'Freezer Bio-medis -20°C untuk penyimpanan sampel',
            'urgency_reason'   => 'Listrik sering padam dan jarak ke RSUD cukup jauh.',
            'attachment'       => $file,
        ];

        $response = $this->post(route('website.assistance.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $request = WebsiteAssistanceRequest::where('institution_name', 'Puskesmas Nita')->first();
        $this->assertNotNull($request);
        $this->assertNotNull($request->ticket_code);
        $this->assertNotNull($request->attachment_path);

        Storage::disk('public')->assertExists($request->attachment_path);
    }

    public function test_visitor_can_track_assistance_request_using_ticket_code(): void
    {
        $assistanceRequest = WebsiteAssistanceRequest::create([
            'ticket_code'      => 'REQ-2610-TEST1',
            'institution_name' => 'RSUD Komodo Labuan Bajo',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Melky',
            'pic_phone'        => '08128889999',
            'pic_email'        => 'melky@rsudkomodo.go.id',
            'assistance_type'  => 'Mesin PCR & Reagen',
            'equipment_needed' => 'Reagen ekstraksi RNA dan PCR master mix',
            'status'           => 'reviewed',
            'reviewed_at'      => now(),
        ]);

        $response = $this->get(route('website.assistance.track', ['ticket' => 'REQ-2610-TEST1']));

        $response->assertStatus(200);
        $response->assertSee('REQ-2610-TEST1');
        $response->assertSee('RSUD Komodo Labuan Bajo');
        $response->assertSee('Sedang Ditinjau');
        $response->assertSee('Telaah Medis');
    }

    public function test_visitor_tracking_nonexistent_ticket_shows_not_found(): void
    {
        $response = $this->get(route('website.assistance.track', ['ticket' => 'REQ-0000-NONE']));

        $response->assertStatus(200);
        $response->assertSee('Nomor Tiket Tidak Ditemukan');
        $response->assertSee('REQ-0000-NONE');
    }

    public function test_honeypot_silently_ignores_spambots(): void
    {
        Mail::fake();

        $payload = [
            'institution_name' => 'Spam Medical Center',
            'institution_type' => 'Klinik Pratama',
            'pic_name'         => 'Spam Bot',
            'pic_phone'        => '0000000000',
            'pic_email'        => 'spambot@promotions.org',
            'assistance_type'  => 'Promo Alat',
            'equipment_needed' => 'Buy our equipment discount 50%',
            'website_hp'       => 'I am a spambot', // Bot fills honeypot
        ];

        $response = $this->post(route('website.assistance.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('website_assistance_requests', [
            'institution_name' => 'Spam Medical Center',
            'pic_email'        => 'spambot@promotions.org',
        ]);

        Mail::assertNothingQueued();
    }

    public function test_validation_errors_when_required_fields_missing(): void
    {
        $response = $this->post(route('website.assistance.submit'), []);

        $response->assertSessionHasErrors([
            'institution_name',
            'institution_type',
            'pic_name',
            'pic_phone',
            'pic_email',
            'assistance_type',
            'equipment_needed',
        ]);
    }

    public function test_admin_can_view_assistance_requests_index(): void
    {
        $req = WebsiteAssistanceRequest::create([
            'institution_name' => 'RSUD Ruteng',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Robertus',
            'pic_phone'        => '0812341234',
            'pic_email'        => 'robertus@rsudruteng.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Manggarai',
            'assistance_type'  => 'Mesin PCR & Biosafety Cabinet',
            'equipment_needed' => 'Mesin PCR',
            'status'           => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.assistance.index'));

        $response->assertStatus(200);
        $response->assertSee('RSUD Ruteng');
        $response->assertSee('dr. Robertus');
        $response->assertSee('Manggarai');
        $response->assertSee($req->ticket_code);
    }

    public function test_admin_viewing_request_auto_transitions_pending_to_reviewed(): void
    {
        $assistanceRequest = WebsiteAssistanceRequest::create([
            'institution_name' => 'Klinik Pratama St. Antonius',
            'institution_type' => 'Klinik Pratama',
            'pic_name'         => 'Sr. Maria',
            'pic_phone'        => '08122334455',
            'pic_email'        => 'antonius@klinik.org',
            'assistance_type'  => 'Alat Rapid Diagnostik',
            'equipment_needed' => 'Centrifuge dan tabung EDTA',
            'status'           => 'pending',
        ]);

        $this->assertNull($assistanceRequest->reviewed_at);

        $response = $this->actingAs($this->admin)->get(route('website.assistance.show', $assistanceRequest->id));

        $response->assertStatus(200);
        $response->assertSee('Klinik Pratama St. Antonius');
        $response->assertSee('Centrifuge dan tabung EDTA');

        $assistanceRequest->refresh();
        $this->assertEquals('reviewed', $assistanceRequest->status);
        $this->assertNotNull($assistanceRequest->reviewed_at);
    }

    public function test_admin_can_update_status_and_notes_and_triggers_email(): void
    {
        Mail::fake();

        $assistanceRequest = WebsiteAssistanceRequest::create([
            'institution_name' => 'RSUD Komodo Labuan Bajo',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Melky',
            'pic_phone'        => '08128889999',
            'pic_email'        => 'melky@rsudkomodo.go.id',
            'assistance_type'  => 'Mesin PCR & Reagen',
            'equipment_needed' => 'Reagen ekstraksi RNA dan PCR master mix',
            'status'           => 'reviewed',
        ]);

        $response = $this->actingAs($this->admin)->put(route('website.assistance.status', $assistanceRequest->id), [
            'status'      => 'approved',
            'admin_notes' => 'Telah diverifikasi tim medik YSDS, disetujui untuk alokasi pengiriman reagen.',
        ]);

        $response->assertRedirect(route('website.assistance.show', $assistanceRequest->id));
        $response->assertSessionHas('success');

        $assistanceRequest->refresh();
        $this->assertEquals('approved', $assistanceRequest->status);
        $this->assertNotNull($assistanceRequest->approved_at);
        $this->assertEquals('Telah diverifikasi tim medik YSDS, disetujui untuk alokasi pengiriman reagen.', $assistanceRequest->admin_notes);

        Mail::assertQueued(AssistanceRequestStatusUpdatedMail::class, function ($mail) {
            return $mail->assistanceRequest->pic_email === 'melky@rsudkomodo.go.id';
        });
    }

    public function test_admin_can_view_printable_disposition_sheet(): void
    {
        $assistanceRequest = WebsiteAssistanceRequest::create([
            'institution_name' => 'RSUD Ende',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Yohanes',
            'pic_phone'        => '08123334444',
            'pic_email'        => 'yohanes@rsudende.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Ende',
            'assistance_type'  => 'Alat PCR',
            'equipment_needed' => 'Thermal Cycler 96 Well',
            'status'           => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.assistance.print', $assistanceRequest->id));

        $response->assertStatus(200);
        $response->assertSee('LEMBAR DISPOSISI');
        $response->assertSee('RSUD Ende');
        $response->assertSee($assistanceRequest->ticket_code);
    }

    public function test_admin_can_convert_assistance_request_to_collaboration(): void
    {
        $assistanceRequest = WebsiteAssistanceRequest::create([
            'institution_name' => 'RSUD Kalabahi Alor',
            'institution_type' => 'Rumah Sakit Umum Daerah (RSUD)',
            'pic_name'         => 'dr. Fransiskus',
            'pic_phone'        => '08125556666',
            'pic_email'        => 'frans@rsudalor.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Kabupaten Alor',
            'assistance_type'  => 'Peralatan Ekstraksi & Reagen',
            'equipment_needed' => 'Automated Nucleic Acid Extractor 32 sample',
            'status'           => 'reviewed',
        ]);

        $response = $this->actingAs($this->admin)->post(route('website.assistance.convert_collaboration', $assistanceRequest->id));

        $collaboration = WebsiteCollaboration::where('institution_name', 'RSUD Kalabahi Alor')->first();
        $this->assertNotNull($collaboration);
        $this->assertEquals('Rumah Sakit Umum Daerah (RSUD)', $collaboration->category);
        $this->assertEquals('dr. Fransiskus', $collaboration->pic_name);

        $response->assertRedirect(route('website.collaborations.show', $collaboration->id));
        $response->assertSessionHas('success');

        $assistanceRequest->refresh();
        $this->assertEquals('approved', $assistanceRequest->status);
        $this->assertStringContainsString((string) $collaboration->id, $assistanceRequest->admin_notes);
    }

    public function test_admin_can_export_assistance_requests_to_csv(): void
    {
        WebsiteAssistanceRequest::create([
            'institution_name' => 'Labkesda Sumba Timur',
            'institution_type' => 'Laboratorium Kesehatan Daerah (Labkesda)',
            'pic_name'         => 'dr. Yunus',
            'pic_phone'        => '08137778888',
            'pic_email'        => 'labkesda@sumbatimur.go.id',
            'province'         => 'Nusa Tenggara Timur',
            'city'             => 'Waingapu',
            'assistance_type'  => 'Reagen Ekstraksi & Tip Filter',
            'equipment_needed' => 'Tip aerosol filter 10ul, 200ul, 1000ul',
            'status'           => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.assistance.export'));

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('content-type'));
        $this->assertStringContainsString('rekap_permohonan_bantuan_ysds_', $response->headers->get('content-disposition'));
        $this->assertStringContainsString('Labkesda Sumba Timur', $response->streamedContent());
        $this->assertStringContainsString('Waingapu', $response->streamedContent());
    }

    public function test_admin_can_delete_assistance_request(): void
    {
        $assistanceRequest = WebsiteAssistanceRequest::create([
            'institution_name' => 'RS Swasta Uji Coba',
            'institution_type' => 'Rumah Sakit Swasta',
            'pic_name'         => 'Bpk. Tester',
            'pic_phone'        => '0812345678',
            'pic_email'        => 'test@example.com',
            'assistance_type'  => 'Tes Bantuan',
            'equipment_needed' => 'Dummy test',
            'status'           => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('website.assistance.destroy', $assistanceRequest->id));

        $response->assertRedirect(route('website.assistance.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('website_assistance_requests', [
            'id' => $assistanceRequest->id,
        ]);
    }
}
