<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Issues\Models\Issue;
use Modules\Journals\Models\Journal;
use Modules\Usermanagement\Models\User;
use Tests\TestCase;

class WebsiteControllerTest extends TestCase
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

    public function test_can_access_public_home_page(): void
    {
        $response = $this->get(route('website.home'));
        $response->assertStatus(200);
        $response->assertViewIs('website::public.home');
    }

    public function test_can_access_public_journals_listing(): void
    {
        $response = $this->get(route('website.journals.index'));
        $response->assertStatus(200);
        $response->assertViewIs('website::public.journals');
    }

    public function test_can_access_public_journal_detail_page(): void
    {
        $journal = Journal::create([
            'name' => 'Ignite Genomic Journal',
            'slug' => 'ignite-genomic-journal',
            'is_active' => true,
        ]);

        $response = $this->get(route('website.journals.show', $journal->slug));
        $response->assertStatus(200);
        $response->assertViewIs('website::public.journal-detail');
        $response->assertSee('Ignite Genomic Journal');
    }

    public function test_can_access_public_issue_archive_page(): void
    {
        $response = $this->get(route('website.issues.archive'));
        $response->assertStatus(200);
        $response->assertViewIs('website::public.issue-archive');
    }

    public function test_can_access_public_cms_pages(): void
    {
        $this->get(route('website.about'))->assertStatus(200);
        $this->get(route('website.contact'))->assertStatus(200);
        $this->get(route('website.guidelines'))->assertStatus(200);
        $this->get(route('website.ethics'))->assertStatus(200);
        $this->get(route('website.indexing'))->assertStatus(200);
    }

    public function test_authenticated_user_can_access_and_update_admin_settings(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('website.settings'));
        $response->assertStatus(200);
        $response->assertViewIs('website::admin.settings');

        $postResponse = $this->actingAs($user)->post(route('website.settings.update'), [
            'hero_title' => 'Yayasan Satriabudi Terbaru',
            'hero_subtitle' => 'Subtitle Terbaru',
            'profile_tag' => 'Profil Terbaru',
        ]);

        $postResponse->assertRedirect(route('website.settings'));
        $this->get(route('website.home'))->assertSee('Yayasan Satriabudi Terbaru');
    }

    public function test_admin_can_update_official_contact_and_about_cms_settings(): void
    {
        $user = User::factory()->create();

        $payload = [
            'contact_address'    => 'Kantor Pusat BSD Intermoda C-17, Tangerang',
            'contact_email'      => 'official@dharma.or.id',
            'contact_phone'      => '(021) 5020-8805',
            'contact_whatsapp'   => '0896-0298-2179',
            'about_founder'      => 'Ibu Erlina V. F. Ratu',
            'about_chairman'     => 'dr. Vincentius Simeon',
            'about_vision'       => 'Visi Riset Genomik & Kesehatan Indonesia',
            'guidelines_general' => 'Ketentuan naskah orisinal terkini',
        ];

        $update = $this->actingAs($user)->post(route('website.settings.update'), $payload);
        $update->assertRedirect(route('website.settings'));

        // Cek halaman kontak publik
        $contactRes = $this->get(route('website.contact'));
        $contactRes->assertStatus(200);
        $contactRes->assertSee('Kantor Pusat BSD Intermoda C-17, Tangerang');
        $contactRes->assertSee('official@dharma.or.id');
        $contactRes->assertSee('(021) 5020-8805');
        $contactRes->assertSee('0896-0298-2179');

        // Cek halaman tentang kami
        $aboutRes = $this->get(route('website.about'));
        $aboutRes->assertStatus(200);
        $aboutRes->assertSee('Ibu Erlina V. F. Ratu');
        $aboutRes->assertSee('dr. Vincentius Simeon');
        $aboutRes->assertSee('Visi Riset Genomik &amp; Kesehatan Indonesia', false);

        // Cek halaman panduan penulis
        $guideRes = $this->get(route('website.guidelines'));
        $guideRes->assertStatus(200);
        $guideRes->assertSee('Ketentuan naskah orisinal terkini');

        // Cek footer halaman utama
        $homeRes = $this->get(route('website.home'));
        $homeRes->assertStatus(200);
        $homeRes->assertSee('Kantor Pusat BSD Intermoda C-17, Tangerang');
        $homeRes->assertSee('official@dharma.or.id');
    }
}
