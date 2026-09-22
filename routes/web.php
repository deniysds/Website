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
    Route::get('/catalog-articles/{slug}/export/ris', [WebsiteController::class, 'exportRis'])->name('articles.export.ris');
    Route::get('/catalog-articles/{slug}/export/bib', [WebsiteController::class, 'exportBibtex'])->name('articles.export.bib');
    Route::get('/about-us', [WebsiteController::class, 'about'])->name('about');
    Route::get('/pengurus', [WebsiteController::class, 'officers'])->name('officers.public');
    Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
    Route::post('/contact', [WebsiteController::class, 'submitContactForm'])->name('contact.submit')->middleware('throttle:10,1');
    Route::get('/author-guidelines', [WebsiteController::class, 'guidelines'])->name('guidelines');
    Route::get('/publication-ethics', [WebsiteController::class, 'publicationEthics'])->name('ethics');
    Route::get('/indexing-info', [WebsiteController::class, 'indexingInfo'])->name('indexing');
    Route::get('/announcements', [WebsiteController::class, 'announcements'])->name('announcements');
    Route::get('/kolaborasi', [WebsiteController::class, 'collaborations'])->name('collaborations.public');

    // Admin CMS Settings, Partners, Officers & Contacts Inquiry Routes
    Route::middleware(['auth'])->prefix('admin/website')->group(function () {
        Route::get('/settings', [WebsiteController::class, 'adminSettings'])->name('settings');
        Route::post('/settings', [WebsiteController::class, 'updateAdminSettings'])->name('settings.update');

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

        // Collaborations & Equipments Management (Kolaborasi & Penyerahan Alat ke Instansi)
        Route::prefix('collaborations')->name('collaborations.')->group(function () {
            Route::get('/', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'index'])->name('index');
            Route::post('/', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'show'])->name('show');
            Route::put('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'toggleStatus'])->name('toggle');

            // Peralatan yang telah diserahkan (Equipments / Items)
            Route::post('/{id}/items', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'storeItem'])->name('items.store');
            Route::put('/{id}/items/{itemId}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'updateItem'])->name('items.update');
            Route::delete('/{id}/items/{itemId}', [\Modules\Website\Http\Controllers\AdminCollaborationController::class, 'destroyItem'])->name('items.destroy');
        });
    });
});

