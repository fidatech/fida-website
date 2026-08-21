<?php

return [
    'name' => 'Fida Technologies',
    'legal_name' => 'Fida Technologies & Marketing Services',
    'url' => env('APP_URL', 'https://fida.af'),
    'email' => env('WEBSITE_EMAIL', 'info@fida.af'),
    'phone' => env('WEBSITE_PHONE', '+93784006200'),
    'whatsapp' => env('WEBSITE_WHATSAPP', '93784006200'),
    'address' => [
        'city' => 'Kabul',
        'country' => 'Afghanistan',
        'country_code' => 'AF',
    ],
    'locales' => [
        'en' => ['label' => 'English', 'native' => 'English', 'direction' => 'ltr'],
        'fa' => ['label' => 'Dari', 'native' => 'دری', 'direction' => 'rtl'],
        'ps' => ['label' => 'Pashto', 'native' => 'پښتو', 'direction' => 'rtl'],
    ],
    'default_locale' => 'en',
    'stats' => [
        ['value' => '70+', 'label' => 'business clients'],
        ['value' => '10+', 'label' => 'years of experience'],
        ['value' => '3', 'label' => 'working languages'],
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
        ['key' => 'realist', 'accent' => '#6f6bff', 'status' => 'ERP'],
        ['key' => 'prime', 'accent' => '#16c7a3', 'status' => 'FinTech'],
        ['key' => 'darmal', 'accent' => '#2c8cff', 'status' => 'HealthTech'],
        ['key' => 'ograyi', 'accent' => '#ff8a5c', 'status' => 'Mobile'],
    ],
    'industries' => ['real_estate', 'finance', 'logistics', 'pharmacy', 'construction', 'retail'],
];
