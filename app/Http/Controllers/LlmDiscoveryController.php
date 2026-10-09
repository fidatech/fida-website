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
                'web-digital-platforms-afghanistan',
                'ai-automation-solutions-afghanistan',
                'iot-smart-systems-afghanistan',
                'data-center-it-infrastructure-afghanistan',
                'network-engineering-operations-afghanistan',
                'cloud-servers-virtualization-afghanistan',
                'cybersecurity-infrastructure-security-afghanistan',
                'enterprise-hardware-technology-supply-afghanistan',
                'systems-integration-deployment-afghanistan',
                'managed-it-services-afghanistan',
                'government-ngo-technology-procurement-afghanistan',
                'request-for-quotation',
                'technology-company-afghanistan',
                'technology-companies-afghanistan',
                'products',
                'projects',
                'industries',
                'articles',
                'contact',
            ])
            ->get()
            ->keyBy('slug');

        $lines = [
            '# Fida Technologies',
            '',
            '> Fida Technologies is an Afghanistan-based technology company delivering ERP and custom software, web and mobile platforms, AI and IoT solutions, data centers, networks, servers, cybersecurity, enterprise hardware, systems integration and managed IT services for government, NGOs and organizations with complex operational requirements.',
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
            '- AI automation and IoT smart systems',
            '- Data centers, server rooms, cloud, servers and virtualization',
            '- Network engineering, structured connectivity and operations',
            '- Cybersecurity and infrastructure security',
            '- Enterprise hardware and technology supply',
            '- Systems integration, deployment and managed IT services',
            '- Government and NGO RFQ, RFP and tender response',
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
            '- Government and NGO technology procurement: '.url('/government-ngo-technology-procurement-afghanistan'),
            '- RFQ / RFP submission: '.url('/request-for-quotation'),
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
