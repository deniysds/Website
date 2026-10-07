<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\AdminPartnerController;
use Modules\Website\Http\Controllers\WebsiteController;

Route::name('website.')->group(function () {
    Route::get('/', [WebsiteController::class, 'home'])->name('home');
    Route::get('/catalog-journals', [WebsiteController::class, 'journals'])->name('journals.index');
    Route::get('/catalog-journals/{slug}', [WebsiteController::class, 'journalDetail'])->name('journals.show');
    Route::get('/catalog-journals/{slug}/issue/current', [WebsiteController::class, 'currentIssue'])->name('journals.current-issue');
    Route::get('/catalog-issues/archive', [WebsiteController::class, 'issueArchive'])->name('issues.archive');
    Route::get('/catalog-issues/{id}', [WebsiteController::class, 'issueDetail'])->name('issues.show');
    Route::get('/catalog-articles', [WebsiteController::class, 'articles'])->name('articles.index');
    Route::get('/catalog-articles/{slug}', [WebsiteController::class, 'articleDetail'])->name('articles.show');
    Route::get('/catalog-articles/{slug}/download', [WebsiteController::class, 'downloadArticle'])->name('articles.download');
    Route::get('/catalog-articles/{slug}/pdf', [WebsiteController::class, 'viewPdf'])->name('articles.view_pdf');
    Route::get('/catalog-articles/{slug}/export/ris', [WebsiteController::class, 'exportRis'])->name('articles.export.ris');
    Route::get('/catalog-articles/{slug}/export/bib', [WebsiteController::class, 'exportBibtex'])->name('articles.export.bib');
    Route::get('/feed/articles.xml', [WebsiteController::class, 'rssFeed'])->name('feed.rss');
    Route::get('/feed/rss', [WebsiteController::class, 'rssFeed'])->name('feed.rss_alias');
    Route::get('/oai', [WebsiteController::class, 'oaiFeed'])->name('oai');
    Route::get('/oai-pmh', [WebsiteController::class, 'oaiFeed'])->name('oai_alias');
    Route::get('/about-us', [WebsiteController::class, 'about'])->name('about');
    Route::get('/pengurus', [WebsiteController::class, 'officers'])->name('officers.public');
    Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
    Route::post('/contact', [WebsiteController::class, 'submitContactForm'])->name('contact.submit')->middleware('throttle:10,1');
    Route::get('/author-guidelines', [WebsiteController::class, 'guidelines'])->name('guidelines');
    Route::get('/publication-ethics', [WebsiteController::class, 'publicationEthics'])->name('ethics');
    Route::get('/indexing-info', [WebsiteController::class, 'indexingInfo'])->name('indexing');
    Route::get('/announcements', [WebsiteController::class, 'announcements'])->name('announcements');
    Route::get('/kolaborasi', [WebsiteController::class, 'collaborations'])->name('collaborations.public');
    Route::get('/berita', [WebsiteController::class, 'news'])->name('news.index');
    Route::get('/berita/{slug}', [WebsiteController::class, 'newsDetail'])->name('news.show');
    Route::get('/visitasi', [WebsiteController::class, 'visitations'])->name('visitations.public');
    Route::get('/visitasi/{slug}', [WebsiteController::class, 'visitationDetail'])->name('visitations.show');
    Route::get('/donasi', [WebsiteController::class, 'donation'])->name('donation.public');
    Route::post('/donasi', [WebsiteController::class, 'submitDonation'])->name('donation.submit')->middleware('throttle:10,1');
    Route::get('/permohonan-bantuan', [WebsiteController::class, 'assistanceRequest'])->name('assistance.public');
    Route::get('/permohonan-bantuan/lacak', [WebsiteController::class, 'trackAssistanceRequest'])->name('assistance.track');
    Route::post('/permohonan-bantuan', [WebsiteController::class, 'submitAssistanceRequest'])->name('assistance.submit')->middleware('throttle:10,1');
    Route::get('/dokumen', [WebsiteController::class, 'documents'])->name('documents.public');
    Route::get('/dokumen/{slug}/download', [WebsiteController::class, 'downloadDocument'])->name('documents.download');
    Route::get('/dokumen/{slug}/preview', [WebsiteController::class, 'previewDocument'])->name('documents.preview');
    Route::get('/sitemap.xml', [WebsiteController::class, 'sitemapXml'])->name('sitemap.xml');

    // Admin CMS Settings, Partners, Officers & Contacts Inquiry Routes
    Route::middleware(['auth'])->prefix('admin/website')->group(function () {
        Route::get('/settings', [WebsiteController::class, 'adminSettings'])->name('settings');
        Route::post('/settings', [WebsiteController::class, 'updateAdminSettings'])->name('settings.update');

        // Artikel & Berita Non-Jurnal (Articles & News Management)
        Route::prefix('articles')->name('articles.admin.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminArticleController::class, 'toggleStatus'])->name('toggle');
        });

        // Officers Management (Dewan Pengurus & Struktur Organisasi)
        Route::prefix('officers')->name('officers.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminOfficerController::class, 'index'])->name('index');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminOfficerController::class, 'store'])->name('store');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminOfficerController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminOfficerController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminOfficerController::class, 'toggleStatus'])->name('toggle');
        });

        // Partners Management (Mitra Kami)
        Route::prefix('partners')->name('partners.')->group(function () {
            Route::get('/', [AdminPartnerController::class, 'index'])->name('index');
            Route::post('/', [AdminPartnerController::class, 'store'])->name('store');
            Route::put('/{id}', [AdminPartnerController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPartnerController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [AdminPartnerController::class, 'toggleStatus'])->name('toggle');
        });

        // Contact Messages & Inquiries Management (Kotak Masuk Pertanyaan Publik)
        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminContactController::class, 'index'])->name('index');
            Route::get('/export/csv', [\Modules\Website\Http\Controllers\AdminContactController::class, 'exportCsv'])->name('export');
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminContactController::class, 'show'])->name('show');
            Route::put('/{id}/status', [\Modules\Website\Http\Controllers\AdminContactController::class, 'updateStatus'])->name('status');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminContactController::class, 'destroy'])->name('destroy');
        });

        // Assistance Requests Management (Permohonan Bantuan Faskes & Alkes)
        Route::prefix('assistance-requests')->name('assistance.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'index'])->name('index');
            Route::get('/export/csv', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'exportCsv'])->name('export');
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'show'])->name('show');
            Route::get('/{id}/print', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'printDisposisi'])->name('print');
            Route::post('/{id}/convert-collaboration', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'convertToCollaboration'])->name('convert_collaboration');
            Route::put('/{id}/status', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'updateStatus'])->name('status');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminAssistanceRequestController::class, 'destroy'])->name('destroy');
        });

        // Field Visitations Management (Dokumentasi Visitasi & Kunjungan Lapangan)
        Route::prefix('visitations')->name('visitations.admin.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminVisitationController::class, 'toggleStatus'])->name('toggle');
        });

        // Donations Management (Penggalangan Dana & Konfirmasi Donasi)
        Route::prefix('donations')->name('donations.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminDonationController::class, 'index'])->name('index');
            Route::get('/export/csv', [\Modules\Website\Http\Controllers\AdminDonationController::class, 'exportCsv'])->name('export');
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminDonationController::class, 'show'])->name('show');
            Route::put('/{id}/status', [\Modules\Website\Http\Controllers\AdminDonationController::class, 'updateStatus'])->name('status');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminDonationController::class, 'destroy'])->name('destroy');
        });

        // Documents Management (Pusat Unduhan & Dokumen Publik)
        Route::prefix('documents')->name('documents.admin.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminDocumentController::class, 'toggleStatus'])->name('toggle');
        });

        // Collaborations & Equipments Management (Kolaborasi & Penyerahan Alat ke Instansi)
        Route::prefix('collaborations')->name('collaborations.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'index'])->name('index');
            Route::get('/export/csv', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'exportCsv'])->name('export');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'show'])->name('show');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'toggleStatus'])->name('toggle');

            // Cetak BAST Penyerahan Peralatan Instansi
            Route::get('/{id}/print-bast', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'printBast'])->name('print_bast');

            // Peralatan yang telah diserahkan (Equipments / Items)
            Route::get('/{id}/items/export/csv', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'exportItemsCsv'])->name('items.export');
            Route::get('/{id}/items/import-template', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'downloadImportTemplate'])->name('items.import_template');
            Route::post('/{id}/items/import', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'importItems'])->name('items.import');
            Route::post('/{id}/items', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'storeItem'])->name('items.store');
            Route::put('/{id}/items/{itemId}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'updateItem'])->name('items.update');
            Route::delete('/{id}/items/{itemId}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'destroyItem'])->name('items.destroy');
        });
    });
});

