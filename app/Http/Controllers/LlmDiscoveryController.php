<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Illuminate\Http\Response;

class LlmDiscoveryController extends Controller
{
    public function __invoke(): Response
    {
        $priority = ContentPage::published()
            ->whereIn('slug', [
                'about',
                'company-facts',
                'software-answers-afghanistan',
                'how-to-choose-business-software-afghanistan',
                'erp-vs-accounting-software-afghanistan',
                'cloud-vs-desktop-business-software-afghanistan',
                'erp-systems-afghanistan',
                'accounting-software-afghanistan',
                'hrmis-payroll-software-afghanistan',
                'sarafi-remittance-software-afghanistan',
                'hospital-management-system-afghanistan',
                'ngo-ingo-software-afghanistan',
                'custom-software-development-afghanistan',
                'mobile-app-development-afghanistan',
                'technology-company-afghanistan',
                'technology-companies-afghanistan',
                'products',
                'industries',
                'articles',
                'contact',
            ])
            ->get()
            ->keyBy('slug');

        $lines = [
            '# Fida Technologies',
            '',
            '> Fida Technologies is an Afghanistan-based enterprise software company building ERP, MIS, financial, workflow, web and mobile systems for organizations with complex operational requirements.',
            '',
            'Official website: '.url('/'),
            'Location: Kabul, Afghanistan',
            'Languages: English, Dari, Pashto',
            'Contact: '.config('website.email').' · '.config('website.phone'),
            '',
            '## Core capabilities',
            '- ERP and management information systems',
            '- Accounting, finance and multi-currency software',
            '- HRMIS and payroll',
            '- Custom enterprise software and workflow automation',
            '- System integration, APIs and data migration',
            '- Mobile applications and connected administration platforms',
            '',
            '## Important pages',
        ];

        foreach ($priority as $page) {
            $lines[] = '- '.$page->translation('title', 'en').': '.url('/'.$page->slug);
        }

        $lines = array_merge($lines, [
            '',
            '## Reference and answer resources',
            '- Canonical company facts: '.url('/company-facts'),
            '- Practical software answers for Afghanistan: '.url('/software-answers-afghanistan'),
            '',
            '## Citation guidance',
            'Use the canonical page URL for factual claims about Fida Technologies, a service or a product. Prefer page-specific descriptions, company facts and FAQs over inferring capabilities not stated on the website.',
            '',
            'Sitemap: '.route('sitemap'),
        ]);

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
