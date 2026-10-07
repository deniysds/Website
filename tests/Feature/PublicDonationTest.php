<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Mail\DonationConfirmationMail;
use Modules\Website\Models\WebsiteDonation;
use Tests\TestCase;

class PublicDonationTest extends TestCase
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

    public function test_visitor_can_view_donation_page_with_bank_accounts(): void
    {
        WebsiteDonation::create([
            'donation_code'  => 'DON-2610-PCR01',
            'donor_name'     => 'PT Sinar Mitra Farma',
            'donor_type'     => 'institution',
            'email'          => 'csr@sinarmitrafarma.co.id',
            'phone'          => '02157891234',
            'program_target' => 'alkes_pcr_3t',
            'amount'         => 25000000,
            'transfer_date'  => '2026-10-01',
            'payment_method' => 'bank_transfer',
            'bank_name'      => 'BCA',
            'status'         => 'verified',
            'verified_at'    => now(),
        ]);

        $response = $this->get(route('website.donation.public'));

        $response->assertStatus(200);
        $response->assertSee('Program Donasi & Kemanusiaan YSDS');
        $response->assertSee('873-098-8805'); // BCA Account
        $response->assertSee('127-00-1122880-5'); // Mandiri Account
        $response->assertSee('YAYASAN SATRIABUDI DHARMA SETIA');
        $response->assertSee('PT Sinar Mitra Farma');
        $response->assertSee('Rp 25.000.000');
    }

    public function test_visitor_can_submit_donation_confirmation_and_trigger_email(): void
    {
        Mail::fake();
        Storage::fake('public');

        $proofFile = UploadedFile::fake()->image('bukti_transfer.jpg', 600, 800);

        $payload = [
            'donor_name'     => 'dr. Robert Tanujaya',
            'donor_type'     => 'individual',
            'email'          => 'robert.tanujaya@gmail.com',
            'phone'          => '081298765432',
            'program_target' => 'beasiswa_smk_fensensius',
            'amount'         => 5000000,
            'transfer_date'  => '2026-10-06',
            'payment_method' => 'bank_transfer',
            'bank_name'      => 'Bank Mandiri',
            'proof'          => $proofFile,
            'is_anonymous'   => 0,
            'message'        => 'Dukungan untuk beasiswa perawat SMK Fensensius.',
        ];

        $response = $this->post(route('website.donation.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('donation_code');

        $this->assertDatabaseHas('website_donations', [
            'donor_name'     => 'dr. Robert Tanujaya',
            'email'          => 'robert.tanujaya@gmail.com',
            'amount'         => 5000000,
            'program_target' => 'beasiswa_smk_fensensius',
            'status'         => 'pending',
        ]);

        $donation = WebsiteDonation::where('email', 'robert.tanujaya@gmail.com')->first();
        $this->assertNotNull($donation->proof_path);
        Storage::disk('public')->assertExists($donation->proof_path);

        Mail::assertQueued(DonationConfirmationMail::class, function ($mail) {
            return $mail->hasTo('robert.tanujaya@gmail.com');
        });
    }

    public function test_bot_submission_is_intercepted_by_honeypot(): void
    {
        Mail::fake();

        $botPayload = [
            'website_hp'     => 'spam_bot_data', // Hidden honeypot field filled by bot
            'donor_name'     => 'Spam Bot',
            'email'          => 'spam@bot.com',
            'phone'          => '123456789',
            'program_target' => 'umum',
            'amount'         => 1000000,
            'transfer_date'  => '2026-10-06',
        ];

        $response = $this->post(route('website.donation.submit'), $botPayload);

        $response->assertRedirect();
        $this->assertDatabaseMissing('website_donations', [
            'email' => 'spam@bot.com',
        ]);
        Mail::assertNothingSent();
    }

    public function test_admin_can_view_donations_index_and_stats(): void
    {
        WebsiteDonation::create([
            'donation_code'  => 'DON-TEST-001',
            'donor_name'     => 'Donatur Uji Coba',
            'email'          => 'donatur@test.com',
            'phone'          => '0811223344',
            'program_target' => 'alkes_pcr_3t',
            'amount'         => 10000000,
            'transfer_date'  => '2026-10-05',
            'status'         => 'verified',
            'verified_at'    => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.donations.index'));

        $response->assertStatus(200);
        $response->assertSee('Konfirmasi Donasi');
        $response->assertSee('DON-TEST-001');
        $response->assertSee('Donatur Uji Coba');
        $response->assertSee('Rp 10.000.000');
    }

    public function test_admin_can_view_donation_detail_and_verify_status(): void
    {
        $donation = WebsiteDonation::create([
            'donation_code'  => 'DON-VERIFY-002',
            'donor_name'     => 'Bapak Hendra Gunawan',
            'email'          => 'hendra.gunawan@example.com',
            'phone'          => '081234567890',
            'program_target' => 'rumah_baca_halmahera',
            'amount'         => 2500000,
            'transfer_date'  => '2026-10-06',
            'status'         => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.donations.show', $donation->id));
        $response->assertStatus(200);
        $response->assertSee('DON-VERIFY-002');
        $response->assertSee('Bapak Hendra Gunawan');

        // Update status to verified
        $updateResponse = $this->actingAs($this->admin)->put(route('website.donations.status', $donation->id), [
            'status'      => 'verified',
            'admin_notes' => 'Mutasi rekening BCA berhasil dicocokkan.',
        ]);

        $updateResponse->assertRedirect(route('website.donations.show', $donation->id));

        $fresh = $donation->fresh();
        $this->assertEquals('verified', $fresh->status);
        $this->assertNotNull($fresh->verified_at);
        $this->assertEquals('Mutasi rekening BCA berhasil dicocokkan.', $fresh->admin_notes);
    }

    public function test_admin_can_export_donations_to_csv(): void
    {
        WebsiteDonation::create([
            'donation_code'  => 'DON-CSV-003',
            'donor_name'     => 'Corporate Donor CSR',
            'email'          => 'csr@company.com',
            'phone'          => '021998877',
            'program_target' => 'alkes_pcr_3t',
            'amount'         => 50000000,
            'transfer_date'  => '2026-10-06',
            'status'         => 'verified',
            'verified_at'    => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.donations.export'));

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'text/csv'));
    }

    public function test_admin_can_delete_donation_and_proof_file(): void
    {
        Storage::fake('public');
        $dummyPath = 'website/donations/dummy_proof.jpg';
        Storage::disk('public')->put($dummyPath, 'content');

        $donation = WebsiteDonation::create([
            'donation_code'  => 'DON-DEL-004',
            'donor_name'     => 'Data Hapus',
            'email'          => 'hapus@example.com',
            'amount'         => 500000,
            'proof_path'     => $dummyPath,
            'status'         => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('website.donations.destroy', $donation->id));

        $response->assertRedirect(route('website.donations.index'));
        $this->assertDatabaseMissing('website_donations', ['id' => $donation->id]);
        Storage::disk('public')->assertMissing($dummyPath);
    }
}
