<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MarketingPageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

Route::post('/contact/lead', LeadController::class)
    ->middleware('throttle:5,1')
    ->name('leads.store');

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
