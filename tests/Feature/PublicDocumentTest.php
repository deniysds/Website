<?php

namespace Modules\Website\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Usermanagement\Models\User;
use Modules\Website\Models\WebsiteDocument;
use Tests\TestCase;

class PublicDocumentTest extends TestCase
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

    public function test_visitor_can_view_document_portal_page(): void
    {
        WebsiteDocument::create([
            'title'          => 'Laporan Tahunan YSDS 2024',
            'category'       => 'laporan_tahunan',
            'description'    => 'Laporan kinerja program kemanusiaan tahun 2024.',
            'file_path'      => 'website/documents/sample.pdf',
            'file_size'      => 1024000,
            'file_extension' => 'pdf',
            'published_year' => 2024,
            'download_count' => 50,
            'order_no'       => 1,
            'is_active'      => true,
        ]);

        $response = $this->get(route('website.documents.public'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Unduhan');
        $response->assertSee('Laporan Tahunan YSDS 2024');
        $response->assertSee('Laporan Tahunan');
        $response->assertSee('2024');
        $response->assertSee('KB');
    }

    public function test_visitor_can_filter_documents_by_category(): void
    {
        WebsiteDocument::create([
            'title'          => 'Laporan Tahunan 2024',
            'category'       => 'laporan_tahunan',
            'file_path'      => 'website/documents/doc1.pdf',
            'file_size'      => 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        WebsiteDocument::create([
            'title'          => 'SK Kemenkumham Pendirian Yayasan',
            'category'       => 'legalitas_sk',
            'file_path'      => 'website/documents/doc2.pdf',
            'file_size'      => 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        $response = $this->get(route('website.documents.public', ['category' => 'legalitas_sk']));

        $response->assertStatus(200);
        $response->assertSee('SK Kemenkumham Pendirian Yayasan');
        $response->assertDontSee('Laporan Tahunan 2024');
    }

    public function test_visitor_can_search_documents(): void
    {
        WebsiteDocument::create([
            'title'          => 'Panduan SOP Permohonan Alkes PCR',
            'category'       => 'panduan_sop',
            'file_path'      => 'website/documents/sop.pdf',
            'file_size'      => 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        WebsiteDocument::create([
            'title'          => 'Company Profile YSDS',
            'category'       => 'brosur_profil',
            'file_path'      => 'website/documents/profile.pdf',
            'file_size'      => 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        $response = $this->get(route('website.documents.public', ['q' => 'Alkes PCR']));

        $response->assertStatus(200);
        $response->assertSee('Panduan SOP Permohonan Alkes PCR');
        $response->assertDontSee('Company Profile YSDS');
    }

    public function test_visitor_can_download_document_and_increment_counter(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('laporan.pdf', 500, 'application/pdf');
        $storedPath = $file->store('website/documents', 'public');

        $doc = WebsiteDocument::create([
            'title'          => 'Laporan Keuangan Teraudit 2023',
            'category'       => 'laporan_keuangan',
            'file_path'      => $storedPath,
            'file_size'      => 500 * 1024,
            'file_extension' => 'pdf',
            'download_count' => 10,
            'is_active'      => true,
        ]);

        $this->assertEquals(10, $doc->download_count);

        $response = $this->get(route('website.documents.download', $doc->slug));

        $response->assertStatus(200);
        $this->assertEquals(11, $doc->fresh()->download_count);
    }

    public function test_visitor_can_preview_pdf_document(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('sop_bantuan.pdf', 300, 'application/pdf');
        $storedPath = $file->store('website/documents', 'public');

        $doc = WebsiteDocument::create([
            'title'          => 'SOP Bantuan Faskes',
            'category'       => 'panduan_sop',
            'file_path'      => $storedPath,
            'file_size'      => 300 * 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        $response = $this->get(route('website.documents.preview', $doc->slug));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_admin_can_view_document_management_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('website.documents.admin.index'));

        $response->assertStatus(200);
        $response->assertSee('Pusat Dokumen & Unduhan Publik', false);
        $response->assertSee('Unggah Dokumen Baru');
    }

    public function test_admin_can_create_document_with_file_upload(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('annual_report_2025.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($this->admin)->post(route('website.documents.admin.store'), [
            'title'          => 'Annual Report YSDS 2025',
            'category'       => 'laporan_tahunan',
            'description'    => 'Laporan pertanggungjawaban program tahun 2025.',
            'published_year' => 2025,
            'order_no'       => 1,
            'file'           => $file,
            'is_active'      => 1,
        ]);

        $response->assertRedirect(route('website.documents.admin.index'));

        $this->assertDatabaseHas('website_documents', [
            'title'          => 'Annual Report YSDS 2025',
            'category'       => 'laporan_tahunan',
            'file_extension' => 'pdf',
            'published_year' => 2025,
            'is_active'      => 1,
        ]);
    }

    public function test_admin_can_toggle_document_status(): void
    {
        $doc = WebsiteDocument::create([
            'title'          => 'Dokumen Uji Coba',
            'category'       => 'panduan_sop',
            'file_path'      => 'website/documents/sample.pdf',
            'file_size'      => 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('website.documents.admin.toggle', $doc));

        $response->assertRedirect();
        $this->assertFalse($doc->fresh()->is_active);
    }

    public function test_admin_can_delete_document(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('delete_me.pdf', 100, 'application/pdf');
        $storedPath = $file->store('website/documents', 'public');

        $doc = WebsiteDocument::create([
            'title'          => 'Dokumen Usang',
            'category'       => 'panduan_sop',
            'file_path'      => $storedPath,
            'file_size'      => 100 * 1024,
            'file_extension' => 'pdf',
            'is_active'      => true,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('website.documents.admin.destroy', $doc));

        $response->assertRedirect(route('website.documents.admin.index'));
        $this->assertDatabaseMissing('website_documents', ['id' => $doc->id]);
    }
}
