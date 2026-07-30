<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Issues\Models\Issue;
use Modules\Journals\Models\Journal;
use Tests\TestCase;

class WebsiteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

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
        $this->get(route('website.announcements'))->assertStatus(200);
    }
}
