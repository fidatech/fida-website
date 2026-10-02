<?php

use App\Http\Controllers\Admin\ArticleAuthorController as AdminArticleAuthorController;
use App\Http\Controllers\Admin\ArticleCategoryController as AdminArticleCategoryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ContentPageController as AdminContentPageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PageRedirectController as AdminPageRedirectController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WebsiteSettingsController as AdminWebsiteSettingsController;
use App\Http\Controllers\DefaultLocaleRedirectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleTaxonomyController;
use App\Http\Controllers\AnalyticsEventController;
use App\Http\Controllers\IndexNowKeyController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LlmDiscoveryController;
use App\Http\Controllers\MarketingPageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/sitemaps/{group}.xml', [SitemapController::class, 'show'])
    ->where('group', '[a-z-]+')
    ->name('sitemap.group');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/llms.txt', LlmDiscoveryController::class)->name('llms');
Route::get('/indexnow-key.txt', IndexNowKeyController::class)->name('indexnow.key');
Route::get('/search', SearchController::class)->name('search');

Route::post('/contact/lead', LeadController::class)
    ->middleware('throttle:5,1')
    ->name('leads.store');

Route::post('/analytics/event', AnalyticsEventController::class)
    ->middleware('throttle:60,1')
    ->name('analytics.event');

Route::get('/{defaultLocale}/{path?}', DefaultLocaleRedirectController::class)
    ->where([
        'defaultLocale' => preg_quote((string) config('website.default_locale'), '/'),
        'path' => '.*',
    ])
    ->name('default-locale.redirect');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])
            ->middleware('capability:analytics.view')
            ->name('analytics.index');
        Route::post('/analytics/search-console', [AdminAnalyticsController::class, 'importSearchConsole'])
            ->middleware('capability:analytics.view')
            ->name('analytics.search-console.import');
        Route::post('/analytics/ai-insight', [AdminAnalyticsController::class, 'generateAiInsight'])
            ->middleware('capability:analytics.view')
            ->name('analytics.ai-insight');
        Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::resource('content-pages', AdminContentPageController::class)
            ->except('show')
            ->parameters(['content-pages' => 'contentPage'])
            ->middleware('capability:content.manage');

        Route::resource('article-categories', AdminArticleCategoryController::class)
            ->except('show')
            ->parameters(['article-categories' => 'articleCategory'])
            ->middleware('capability:content.manage');

        Route::resource('article-authors', AdminArticleAuthorController::class)
            ->except('show')
            ->parameters(['article-authors' => 'articleAuthor'])
            ->middleware('capability:content.manage');

        Route::resource('redirects', AdminPageRedirectController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->parameters(['redirects' => 'pageRedirect'])
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
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('localized.home');
        Route::get('/search', SearchController::class)->name('localized.search');
        Route::get('/articles/category/{articleCategory:slug}', [ArticleTaxonomyController::class, 'category'])
            ->name('localized.articles.category');
        Route::get('/articles/author/{articleAuthor:slug}', [ArticleTaxonomyController::class, 'author'])
            ->name('localized.articles.author');
        Route::get('/{page:slug}', MarketingPageController::class)
            ->where('page', '[a-z0-9-]+')
            ->name('localized.pages.show');
    });

Route::get('/articles/category/{articleCategory:slug}', [ArticleTaxonomyController::class, 'category'])
    ->name('articles.category');
Route::get('/articles/author/{articleAuthor:slug}', [ArticleTaxonomyController::class, 'author'])
    ->name('articles.author');

Route::get('/{page:slug}', MarketingPageController::class)
    ->where('page', '[a-z0-9-]+')
    ->name('pages.show');
