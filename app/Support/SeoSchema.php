<?php

namespace App\Support;

use App\Models\ContentPage;
use Illuminate\Support\Collection;

final class SeoSchema
{
    public static function articleCollection(string $title, string $description, string $canonical, Collection $articles): array
    {
        $collectionId = $canonical.'#collection';
        $items = $articles->values()->map(fn (ContentPage $article, int $index): array => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => LocalizedUrl::path('/'.$article->slug),
            'name' => $article->translation('title'),
        ])->all();

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::organization(),
                self::website(),
                [
                    '@type' => 'CollectionPage',
                    '@id' => $collectionId,
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'inLanguage' => app()->getLocale(),
                    'isPartOf' => ['@id' => url('/').'#website'],
                    'mainEntity' => ['@id' => $canonical.'#items'],
                ],
                [
                    '@type' => 'ItemList',
                    '@id' => $canonical.'#items',
                    'numberOfItems' => count($items),
                    'itemListElement' => $items,
                ],
            ],
        ];
    }

    public static function home(string $title, string $description, string $canonical, ?string $topic = null, ?string $image = null): array
    {
        $webPage = [
            '@type' => 'WebPage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'inLanguage' => app()->getLocale(),
            'isPartOf' => ['@id' => url('/').'#website'],
            'about' => $topic
                ? ['@type' => 'Thing', 'name' => $topic]
                : ['@id' => url('/').'#organization'],
        ];
        $graph = [self::organization(), self::website()];

        if ($image) {
            $imageId = $canonical.'#primaryimage';
            $webPage['primaryImageOfPage'] = ['@id' => $imageId];
            $graph[] = self::image($imageId, $image);
        }

        $graph[] = $webPage;

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    public static function page(ContentPage $page, string $title, string $description, string $canonical, array $faqs = [], ?array $archive = null): array
    {
        $pageId = $canonical.'#webpage';
        $serviceId = $canonical.'#service';
        $productId = $canonical.'#software';
        $articleId = $canonical.'#article';
        $breadcrumbId = $canonical.'#breadcrumb';
        $webPageType = match ($page->slug) {
            'about' => 'AboutPage',
            'contact', 'request-for-quotation' => 'ContactPage',
            'services', 'projects', 'solutions', 'products', 'industries', 'case-studies', 'articles' => 'CollectionPage',
            default => 'WebPage',
        };
        $breadcrumbItems = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => __('website.page.home'),
                'item' => LocalizedUrl::path('/'),
            ],
        ];

        if ($archive !== null) {
            $breadcrumbItems[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $archive['label'],
                'item' => $archive['path'],
            ];
        }

        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbItems) + 1,
            'name' => $page->translation('title'),
            'item' => $canonical,
        ];

        $graph = [
            self::organization(),
            self::website(),
            [
                '@type' => $webPageType,
                '@id' => $pageId,
                'url' => $canonical,
                'name' => $title,
                'description' => $description,
                'inLanguage' => app()->getLocale(),
                'isPartOf' => ['@id' => url('/').'#website'],
                'breadcrumb' => ['@id' => $breadcrumbId],
                'datePublished' => ($page->published_at ?? $page->created_at)?->toAtomString(),
                'dateModified' => $page->updated_at?->toAtomString(),
            ],
            [
                '@type' => 'BreadcrumbList',
                '@id' => $breadcrumbId,
                'itemListElement' => $breadcrumbItems,
            ],
        ];
        $webPageIndex = 2;
        $imageId = $canonical.'#primaryimage';

        if ($page->primaryQuery() !== '') {
            $graph[$webPageIndex]['about'] = [
                '@type' => 'Thing',
                'name' => $page->primaryQuery(),
            ];
        }

        if ($page->socialImage()) {
            $graph[$webPageIndex]['primaryImageOfPage'] = ['@id' => $imageId];
            $graph[] = self::image($imageId, $page->socialImage());
        }

        if ($page->reviewed_at) {
            $graph[$webPageIndex]['lastReviewed'] = $page->reviewed_at->toDateString();
        }

        if (filled($page->reviewer_name)) {
            $graph[$webPageIndex]['reviewedBy'] = [
                '@type' => 'Person',
                'name' => $page->reviewer_name,
            ];
        }

        if (in_array($page->type, ['solution', 'service'], true)) {
            $graph[$webPageIndex]['mainEntity'] = ['@id' => $serviceId];
            $graph[] = [
                '@type' => 'Service',
                '@id' => $serviceId,
                'url' => $canonical,
                'name' => $page->translation('title'),
                'description' => $page->translation('summary'),
                'serviceType' => $page->translation('title'),
                'provider' => ['@id' => url('/').'#organization'],
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => config('website.address.country'),
                ],
            ];
        }

        if ($page->type === 'product' && ($product = $page->productProfile()) !== null) {
            $graph[$webPageIndex]['mainEntity'] = ['@id' => $productId];
            $graph[] = [
                '@type' => 'SoftwareApplication',
                '@id' => $productId,
                'url' => $canonical,
                'name' => $page->translation('title'),
                'description' => $page->translation('summary'),
                'applicationCategory' => $product['category'],
                'operatingSystem' => $product['platform'],
                'featureList' => $product['features'],
                'publisher' => ['@id' => url('/').'#organization'],
                'inLanguage' => app()->getLocale(),
                'countriesSupported' => config('website.address.country_code'),
            ];

            if ($page->socialImage()) {
                $graph[array_key_last($graph)]['image'] = ['@id' => $imageId];
            }
        }

        if (in_array($page->type, ['article', 'case-study'], true)) {
            $graph[$webPageIndex]['mainEntity'] = ['@id' => $articleId];
            $author = $page->byline()
                ? array_filter([
                    '@type' => 'Person',
                    'name' => $page->byline(),
                    'url' => $page->articleAuthor?->active
                        ? LocalizedUrl::path('/articles/author/'.$page->articleAuthor->slug)
                        : null,
                ])
                : ['@id' => url('/').'#organization'];
            $graph[] = [
                '@type' => 'Article',
                '@id' => $articleId,
                'url' => $canonical,
                'headline' => $page->translation('title'),
                'description' => $page->translation('summary'),
                'inLanguage' => app()->getLocale(),
                'datePublished' => ($page->published_at ?? $page->created_at)?->toAtomString(),
                'dateModified' => $page->updated_at?->toAtomString(),
                'mainEntityOfPage' => ['@id' => $pageId],
                'author' => $author,
                'publisher' => ['@id' => url('/').'#organization'],
            ];

            if ($page->type === 'article' && $page->articleCategory?->active) {
                $graph[array_key_last($graph)]['articleSection'] = $page->articleCategory->translation('name');
            }

            if ($page->socialImage()) {
                $graph[array_key_last($graph)]['image'] = ['@id' => $imageId];
            }
        }

        if ($faqs !== []) {
            $graph[] = [
                '@type' => 'FAQPage',
                '@id' => $canonical.'#faq',
                'url' => $canonical.'#frequently-asked-questions',
                'mainEntity' => array_map(fn (array $faq): array => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'inLanguage' => $faq['locale'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                        'inLanguage' => $faq['locale'],
                    ],
                ], $faqs),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    private static function organization(): array
    {
        $organization = [
            '@type' => 'Organization',
            '@id' => url('/').'#organization',
            'name' => config('website.name'),
            'alternateName' => [
                'Fida Technologies Afghanistan',
                'Fida Tech Afghanistan',
                'فدا تکنالوژی',
            ],
            'legalName' => config('website.legal_name'),
            'additionalType' => 'https://schema.org/ProfessionalService',
            'foundingDate' => '2022',
            'description' => 'Fida Technologies is an Afghanistan-based enterprise technology company delivering ERP and custom software, web and mobile platforms, AI and IoT, data centers, networks, servers, cybersecurity, enterprise hardware, systems integration and managed IT services. Operations began in 2022 following professional technology experience that started in 2014, and the company was formally licensed in 2024.',
            'url' => url('/'),
            'email' => config('website.email'),
            'telephone' => config('website.phone'),
            'address' => array_filter([
                '@type' => 'PostalAddress',
                'addressLocality' => config('website.address.city'),
                'postalCode' => config('website.address.postal_code'),
                'addressCountry' => config('website.address.country_code'),
            ]),
            'areaServed' => [
                '@type' => 'Country',
                'name' => config('website.address.country'),
            ],
            'foundingLocation' => [
                '@type' => 'Place',
                'name' => config('website.address.city').', '.config('website.address.country'),
            ],
            'knowsAbout' => config('website.expertise'),
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'contactType' => 'sales',
                    'telephone' => config('website.phone'),
                    'email' => config('website.email'),
                    'areaServed' => config('website.address.country_code'),
                    'availableLanguage' => array_column(config('website.locales'), 'label'),
                ],
                [
                    '@type' => 'ContactPoint',
                    'contactType' => 'procurement',
                    'telephone' => config('website.phone'),
                    'email' => config('website.rfq_email', config('website.email')),
                    'areaServed' => config('website.address.country_code'),
                    'availableLanguage' => array_column(config('website.locales'), 'label'),
                ],
            ],
        ];

        if (config('website.address.line')) {
            $organization['address']['streetAddress'] = config('website.address.line');
        }

        if (config('website.google_maps_url')) {
            $organization['location'] = [
                '@type' => 'Place',
                'name' => config('website.name').' Kabul office',
                'address' => $organization['address'],
                'hasMap' => config('website.google_maps_url'),
                'identifier' => array_filter([
                    '@type' => 'PropertyValue',
                    'propertyID' => 'Google Place ID',
                    'value' => config('website.google_place_id'),
                ]),
            ];
        }

        $sameAs = collect(config('website.same_as', []))
            ->filter(fn (mixed $url): bool => is_string($url) && filter_var($url, FILTER_VALIDATE_URL) !== false)
            ->unique()
            ->values()
            ->all();

        if ($sameAs !== []) {
            $organization['sameAs'] = $sameAs;
        }

        if (config('website.branding.logo_url')) {
            $organization['logo'] = [
                '@type' => 'ImageObject',
                'url' => config('website.branding.logo_url'),
            ];
        }

        return $organization;
    }

    private static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/').'#website',
            'url' => url('/'),
            'name' => config('website.name'),
            'publisher' => ['@id' => url('/').'#organization'],
            'inLanguage' => array_keys(config('website.locales')),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search').'?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    private static function image(string $id, string $url): array
    {
        return [
            '@type' => 'ImageObject',
            '@id' => $id,
            'url' => $url,
            'contentUrl' => $url,
        ];
    }
}
