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
                'projects',
                'industries',
                'articles',
                'request-for-quotation',
                'government-ngo-technology-solutions-afghanistan',
                'web-digital-platforms-afghanistan',
                'ai-automation-solutions-afghanistan',
                'iot-smart-infrastructure-afghanistan',
                'data-center-it-infrastructure-afghanistan',
                'network-infrastructure-operations-afghanistan',
                'cloud-server-infrastructure-afghanistan',
                'cybersecurity-solutions-afghanistan',
                'enterprise-hardware-technology-supply-afghanistan',
                'systems-integration-deployment-afghanistan',
                'managed-it-services-afghanistan',
                'contact',
            ])
            ->get()
            ->keyBy('slug');

        $lines = [
            '# Fida Technologies',
            '',
            '> Fida Technologies is an Afghanistan-based enterprise technology company delivering software, ERP, web and mobile platforms, AI and IoT, data-center and network infrastructure, cloud, cybersecurity, enterprise hardware supply, systems integration and managed IT services for government, NGOs and complex organizations.',
            '',
            'Official website: '.url('/'),
            'Location: '.config('website.address.line').', '.config('website.address.city').' '.config('website.address.postal_code').', '.config('website.address.country'),
            'Official LinkedIn: '.config('website.official_profiles.linkedin'),
            'Official Facebook: '.config('website.official_profiles.facebook'),
            'Official GitHub: '.config('website.official_profiles.github'),
            'Google Business Profile: '.config('website.google_maps_url'),
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
            '- AI and intelligent automation',
            '- IoT and smart infrastructure',
            '- Data centers, servers, storage and backup',
            '- Network infrastructure and operations',
            '- Cloud and virtualization',
            '- Cybersecurity and infrastructure security',
            '- Enterprise hardware and technology supply',
            '- Systems integration, deployment and managed IT services',
            '',
            '## Procurement',
            '- Formal RFQ / RFP / tender submission: '.url('/request-for-quotation'),
            '- Procurement email: info@fida.af',
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
            '- Public products and solutions portfolio: '.url('/projects'),
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
