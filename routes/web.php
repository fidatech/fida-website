<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ContentPageController as AdminContentPageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WebsiteSettingsController as AdminWebsiteSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexNowKeyController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MarketingPageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/indexnow-key.txt', IndexNowKeyController::class)->name('indexnow.key');

Route::post('/contact/lead', LeadController::class)
    ->middleware('throttle:5,1')
    ->name('leads.store');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::resource('content-pages', AdminContentPageController::class)
            ->except('show')
            ->parameters(['content-pages' => 'contentPage'])
            ->middleware('capability:content.manage');

        Route::resource('leads', AdminLeadController::class)
            ->only(['index', 'show', 'update'])
            ->middleware('capability:leads.manage');

        Route::resource('users', AdminUserController::class)
            ->except(['show', 'destroy'])
            ->middleware('capability:users.manage');

        Route::get('/settings', [AdminWebsiteSettingsController::class, 'edit'])
            ->middleware('capability:settings.manage')
            ->name('settings.edit');
        Route::put('/settings', [AdminWebsiteSettingsController::class, 'update'])
            ->middleware('capability:settings.manage')
            ->name('settings.update');
    });
});

Route::prefix('{locale}')
    ->where(['locale' => implode('|', array_keys(config('website.locales')))])
    ->middleware('locale')
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('localized.home');
        Route::get('/{page:slug}', MarketingPageController::class)
            ->where('page', '[a-z0-9-]+')
            ->name('localized.pages.show');
    });

Route::get('/{page:slug}', MarketingPageController::class)
    ->where('page', '[a-z0-9-]+')
    ->name('pages.show');
