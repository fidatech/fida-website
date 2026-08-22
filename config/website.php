<?php

return [
    'name' => 'Fida Technologies',
    'legal_name' => 'Fida Technologies & Marketing Services',
    'url' => env('APP_URL', 'https://fida.af'),
    'indexable' => env(
        'WEBSITE_INDEXABLE',
        ! str_starts_with((string) parse_url(env('APP_URL', 'https://fida.af'), PHP_URL_HOST), 'stage.'),
    ),
    'email' => env('WEBSITE_EMAIL', 'info@fida.af'),
    'phone' => env('WEBSITE_PHONE', '+93784006200'),
    'whatsapp' => env('WEBSITE_WHATSAPP', '93784006200'),
    'social_image' => env('WEBSITE_SOCIAL_IMAGE'),
    'search_verification' => [
        'google' => env('GOOGLE_SITE_VERIFICATION'),
        'bing' => env('BING_SITE_VERIFICATION'),
    ],
    'indexnow' => [
        'key' => env('INDEXNOW_KEY'),
        'endpoint' => env('INDEXNOW_ENDPOINT', 'https://api.indexnow.org/indexnow'),
    ],
    'analytics' => [
        'ga4_measurement_id' => env('GOOGLE_ANALYTICS_ID'),
        'require_consent' => env('ANALYTICS_REQUIRE_CONSENT', true),
    ],
    'address' => [
        'line' => '',
        'city' => 'Kabul',
        'country' => 'Afghanistan',
        'country_code' => 'AF',
    ],
    'map_embed_url' => null,
    'branding' => [
        'name' => 'Fida',
        'tagline' => 'Technologies',
        'logo_path' => null,
        'logo_url' => null,
    ],
    'appearance' => [
        'default_theme' => 'midnight',
        'default_palette' => 'fida',
        'themes' => [
            'midnight' => [
                'label' => 'Midnight',
                'description' => 'The balanced original Fida surface.',
                'background' => '#07080b',
                'background_soft' => '#0d0f14',
                'surface' => '#111319',
            ],
            'obsidian' => [
                'label' => 'Obsidian',
                'description' => 'Deeper neutral black with crisp contrast.',
                'background' => '#050506',
                'background_soft' => '#0b0b0d',
                'surface' => '#141416',
            ],
            'deep_navy' => [
                'label' => 'Deep navy',
                'description' => 'A technical blue-black atmosphere.',
                'background' => '#050914',
                'background_soft' => '#09111f',
                'surface' => '#0d1728',
            ],
        ],
        'palettes' => [
            'fida' => [
                'label' => 'Fida lime',
                'description' => 'Signature lime, violet and cyan.',
                'primary' => '#c9ff4a',
                'primary_soft' => '#e7ffab',
                'secondary' => '#846cff',
                'highlight' => '#4ee8ff',
            ],
            'electric' => [
                'label' => 'Electric blue',
                'description' => 'Clear blue with cyan and violet depth.',
                'primary' => '#55a7ff',
                'primary_soft' => '#b8dcff',
                'secondary' => '#725cff',
                'highlight' => '#54f4dc',
            ],
            'royal' => [
                'label' => 'Royal violet',
                'description' => 'Premium violet with magenta and sky accents.',
                'primary' => '#a78bfa',
                'primary_soft' => '#ddd1ff',
                'secondary' => '#f05bd8',
                'highlight' => '#62d9ff',
            ],
            'ember' => [
                'label' => 'Ember',
                'description' => 'Warm orange balanced by gold and violet.',
                'primary' => '#ff9b52',
                'primary_soft' => '#ffd0ad',
                'secondary' => '#ff5f7a',
                'highlight' => '#ffd65a',
            ],
        ],
    ],
    'locales' => [
        'en' => ['label' => 'English', 'native' => 'English', 'direction' => 'ltr'],
        'fa' => ['label' => 'Dari', 'native' => 'دری', 'direction' => 'rtl'],
        'ps' => ['label' => 'Pashto', 'native' => 'پښتو', 'direction' => 'rtl'],
    ],
    'default_locale' => 'en',
    'expertise' => [
        'ERP systems',
        'accounting software',
        'custom software development',
        'mobile application development',
        'business process automation',
    ],
    'stats' => [
        ['value' => '70+', 'key' => 'clients'],
        ['value' => '10+', 'key' => 'experience'],
        ['value' => '3', 'key' => 'languages'],
    ],
    'featured_solutions' => [
        [
            'key' => 'erp',
            'icon' => 'layers',
            'url' => '/erp-systems-afghanistan',
        ],
        [
            'key' => 'accounting',
            'icon' => 'chart',
            'url' => '/accounting-software-afghanistan',
        ],
        [
            'key' => 'custom',
            'icon' => 'code',
            'url' => '/custom-software-development-afghanistan',
        ],
        [
            'key' => 'mobile',
            'icon' => 'mobile',
            'url' => '/mobile-app-development-afghanistan',
        ],
    ],
    'products' => [
        ['key' => 'realist', 'accent' => '#6f6bff', 'status' => 'ERP', 'url' => '/realist-real-estate-erp'],
        ['key' => 'prime', 'accent' => '#16c7a3', 'status' => 'FinTech', 'url' => '/prime-sarafi-software'],
        ['key' => 'darmal', 'accent' => '#2c8cff', 'status' => 'HealthTech', 'url' => '/darmal-pharmacy-erp'],
        ['key' => 'ograyi', 'accent' => '#ff8a5c', 'status' => 'Mobile', 'url' => '/ograyi-account-manager'],
    ],
    'industries' => ['real_estate', 'finance', 'logistics', 'pharmacy', 'construction', 'retail'],
];
