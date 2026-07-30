<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('/author-guidelines', [WebsiteController::class, 'guidelines'])->name('guidelines');
    Route::get('/announcements', [WebsiteController::class, 'announcements'])->name('announcements');

    // Admin CMS Settings Routes
    Route::middleware(['auth'])->prefix('admin/website')->group(function () {
        Route::get('/settings', [WebsiteController::class, 'adminSettings'])->name('settings');
        Route::post('/settings', [WebsiteController::class, 'updateAdminSettings'])->name('settings.update');
    });
});
