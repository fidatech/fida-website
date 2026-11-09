<?php

namespace App\Providers;

use App\Models\ContentPage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.marketing', function (ViewContract $view): void {
            $navigationPages = ContentPage::query()
                ->select(['id', 'type', 'slug', 'title', 'eyebrow', 'status', 'published_at', 'featured', 'sort_order'])
                ->published()
                ->whereIn('type', ['service', 'solution', 'product', 'industry', 'case-study', 'article'])
                ->orderByDesc('featured')
                ->orderBy('sort_order')
                ->orderBy('title->en')
                ->get()
                ->groupBy('type');

            $view->with('navigationPages', $navigationPages);
        });
    }
}
