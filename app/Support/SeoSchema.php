<?php

namespace App\Support;

use App\Models\ContentPage;

final class SeoSchema
{
    public static function home(string $title, string $description, string $canonical): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                self::organization(),
                self::website(),
                [
                    '@type' => 'WebPage',
                    '@id' => $canonical.'#webpage',
                    'url' => $canonical,
                    'name' => $title,
                    'description' => $description,
                    'inLanguage' => app()->getLocale(),
                    'isPartOf' => ['@id' => url('/').'#website'],
                    'about' => ['@id' => url('/').'#organization'],
                ],
            ],
        ];
    }

    public static function page(ContentPage $page, string $title, string $description, string $canonical, array $faqs = []): array
    {
        $pageId = $canonical.'#webpage';
        $serviceId = $canonical.'#service';
        $productId = $canonical.'#software';
        $breadcrumbId = $canonical.'#breadcrumb';
        $webPageType = match ($page->slug) {
            'about' => 'AboutPage',
            'contact' => 'ContactPage',
            'services', 'projects', 'solutions', 'products', 'industries', 'case-studies', 'articles' => 'CollectionPage',
            default => 'WebPage',
        };
        $graph = [
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
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => __('website.page.home'),
                        'item' => LocalizedUrl::path('/'),
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $page->translation('title'),
                        'item' => $canonical,
                    ],
                ],
            ],
        ];

        if (in_array($page->type, ['solution', 'service'], true)) {
            $graph[0]['mainEntity'] = ['@id' => $serviceId];
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
            $graph[0]['mainEntity'] = ['@id' => $productId];
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
            ];
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
            'legalName' => config('website.legal_name'),
            'url' => url('/'),
            'email' => config('website.email'),
            'telephone' => config('website.phone'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => config('website.address.city'),
                'addressCountry' => config('website.address.country_code'),
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => config('website.address.country'),
            ],
            'knowsAbout' => config('website.expertise'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'sales',
                'telephone' => config('website.phone'),
                'email' => config('website.email'),
                'areaServed' => config('website.address.country_code'),
                'availableLanguage' => array_column(config('website.locales'), 'label'),
            ],
        ];

        if (config('website.address.line')) {
            $organization['address']['streetAddress'] = config('website.address.line');
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
        ];
    }
}
