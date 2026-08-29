<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Support\LocalizedUrl;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = Str::limit(Str::squish((string) $request->string('q')), 80, '');
        $searchable = mb_strlen($query) >= 2;
        $locale = app()->getLocale();
        $fallbackLocale = config('website.default_locale');

        $pages = ContentPage::published()
            ->where(function (Builder $builder) use ($query, $locale, $fallbackLocale, $searchable): void {
                if (! $searchable) {
                    $builder->whereRaw('1 = 0');

                    return;
                }

                $term = '%'.$query.'%';

                foreach (['title', 'summary', 'body'] as $field) {
                    $builder->orWhere("{$field}->{$locale}", 'like', $term);

                    if ($locale !== $fallbackLocale) {
                        $builder->orWhere("{$field}->{$fallbackLocale}", 'like', $term);
                    }
                }
            })
            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('marketing.search', [
            'query' => $query,
            'searchable' => $searchable,
            'pages' => $pages,
            'seo' => [
                'title' => __('website.search.meta_title'),
                'description' => __('website.search.meta_description'),
                'canonical' => LocalizedUrl::path('/search'),
                'type' => 'website',
                'robots' => 'noindex,follow,noarchive',
            ],
        ]);
    }
}
