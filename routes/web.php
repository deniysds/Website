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
    Route::get('/about-us', [WebsiteController::class, 'about'])->name('about');
    Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
    Route::post('/contact', [WebsiteController::class, 'submitContactForm'])->name('contact.submit');
    Route::get('/author-guidelines', [WebsiteController::class, 'guidelines'])->name('guidelines');
    Route::get('/publication-ethics', [WebsiteController::class, 'publicationEthics'])->name('ethics');
    Route::get('/indexing-info', [WebsiteController::class, 'indexingInfo'])->name('indexing');
    Route::get('/announcements', [WebsiteController::class, 'announcements'])->name('announcements');

    // Admin CMS Settings, Partners & Contacts Inquiry Routes
    Route::middleware(['auth'])->prefix('admin/website')->group(function () {
        Route::get('/settings', [WebsiteController::class, 'adminSettings'])->name('settings');
        Route::post('/settings', [WebsiteController::class, 'updateAdminSettings'])->name('settings.update');

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
            Route::get('/{id}', [\Modules\Website\Http\Controllers\AdminContactController::class, 'show'])->name('show');
            Route::put('/{id}/status', [\Modules\Website\Http\Controllers\AdminContactController::class, 'updateStatus'])->name('status');
            Route::delete('/{id}', [\Modules\Website\Http\Controllers\AdminContactController::class, 'destroy'])->name('destroy');
        });
    });
});
