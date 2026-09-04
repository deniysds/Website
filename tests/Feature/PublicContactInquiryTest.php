<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Usermanagement\Models\User;
use Modules\Website\Mail\ContactInquiryMail;
use Modules\Website\Models\WebsiteContact;
use Tests\TestCase;

class PublicContactInquiryTest extends TestCase
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

    public function test_visitor_can_submit_contact_inquiry_and_trigger_email(): void
    {
        Mail::fake();

        $payload = [
            'first_name' => 'Budi',
            'phone'      => '08123456789',
            'email'      => 'budi@example.com',
            'message'    => 'Bagaimana cara mengajukan naskah riset klinis ke jurnal IGNITE?',
        ];

        $response = $this->post(route('website.contact.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('website_contacts', [
            'first_name' => 'Budi',
            'email'      => 'budi@example.com',
            'status'     => 'unread',
        ]);

        Mail::assertQueued(ContactInquiryMail::class, function ($mail) {
            return $mail->contact->email === 'budi@example.com';
        });
    }

    public function test_admin_can_view_inquiries_and_update_status(): void
    {
        $contact = WebsiteContact::create([
            'first_name' => 'Siti',
            'phone'      => '08987654321',
            'email'      => 'siti@example.com',
            'message'    => 'Pertanyaan terkait biaya publikasi naskah.',
            'status'     => 'unread',
        ]);

        // Index page
        $indexResponse = $this->actingAs($this->admin)->get(route('website.contacts.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Siti');
        $indexResponse->assertSee('siti@example.com');

        // Show page (auto marks as read)
        $showResponse = $this->actingAs($this->admin)->get(route('website.contacts.show', $contact->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Pertanyaan terkait biaya publikasi naskah.');
        $this->assertEquals('read', $contact->fresh()->status);

        // Update status & notes
        $updateResponse = $this->actingAs($this->admin)->put(route('website.contacts.status', $contact->id), [
            'status'      => 'replied',
            'admin_notes' => 'Sudah dibalas melalui email resmi redaksi.',
        ]);

        $updateResponse->assertRedirect(route('website.contacts.show', $contact->id));
        $this->assertEquals('replied', $contact->fresh()->status);
        $this->assertEquals('Sudah dibalas melalui email resmi redaksi.', $contact->fresh()->admin_notes);
    }

    public function test_honeypot_blocks_spambots(): void
    {
        Mail::fake();

        $payload = [
            'first_name' => 'Spam Bot',
            'phone'      => '000000000',
            'email'      => 'bot@spam.com',
            'message'    => 'Buy cheap drugs now!',
            'website_hp' => 'I am a bot', // Bot fills honeypot
        ];

        $response = $this->post(route('website.contact.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Harus dicegat, tidak boleh disimpan ke database
        $this->assertDatabaseMissing('website_contacts', [
            'email' => 'bot@spam.com',
        ]);

        Mail::assertNothingSent();
    }

    public function test_admin_can_export_inquiries_to_csv(): void
    {
        WebsiteContact::create([
            'first_name' => 'Ahmad',
            'phone'      => '0811111111',
            'email'      => 'ahmad@example.com',
            'message'    => 'Pertanyaan ekspor CSV.',
            'status'     => 'unread',
        ]);

        $response = $this->actingAs($this->admin)->get(route('website.contacts.export'));

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment; filename="inquiries_export_', $response->headers->get('content-disposition'));
        $this->assertStringContainsString('Ahmad', $response->streamedContent());
        $this->assertStringContainsString('ahmad@example.com', $response->streamedContent());
    }
}
