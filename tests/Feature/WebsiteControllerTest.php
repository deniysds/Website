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
}
