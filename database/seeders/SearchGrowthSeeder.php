<?php

namespace Database\Seeders;

use App\Models\ContentPage;
use Illuminate\Database\Seeder;

class SearchGrowthSeeder extends Seeder
{
    public function run(): void
    {
        $updates = [
            'hrmis-payroll-software-afghanistan' => ['HRMIS & Payroll Software Afghanistan | Fida', 'Manage employee records, attendance, leave, payroll, approvals and reporting with HRMIS and payroll software designed for organizations in Afghanistan.'],
            'erp-systems-afghanistan' => ['ERP Systems Afghanistan | Fida Technologies', 'Connect finance, procurement, inventory, HR, operations and reporting with ERP software designed around the real workflows of organizations in Afghanistan.'],
            'ngo-ingo-software-afghanistan' => ['NGO & INGO Management Software Afghanistan | Fida', 'Manage programmes, grants, budgets, procurement, HR, field operations, assets, beneficiaries and donor reporting in one NGO/INGO management platform.'],
            'telecommunications-oss-bss-software-afghanistan' => ['Telecom OSS/BSS Software Afghanistan | Fida', 'Connect subscriber accounts, orders, billing, collections, customer care, service assurance, sites and field operations with telecom OSS/BSS software.'],
            'pharmacy-pharmaceutical-software-afghanistan' => ['Pharmacy & Pharmaceutical Software Afghanistan | Fida', 'Manage medicines, batches, expiry, inventory, procurement, sales, finance and reporting with pharmacy and pharmaceutical software for Afghanistan.'],
            'procurement-inventory-management-software-afghanistan' => ['Procurement & Inventory Software Afghanistan | Fida', 'Control purchase requests, approvals, suppliers, purchase orders, receipts, warehouses, stock, issues and reporting with connected procurement software.'],
            'business-intelligence-reporting-afghanistan' => ['Business Intelligence & Reporting Afghanistan | Fida', 'Turn ERP, finance and operational data into governed dashboards, KPIs, management reports and decision-ready business intelligence.'],
            'technology-company-afghanistan' => ['Technology Company Afghanistan | Fida Technologies', 'Fida Technologies is a Kabul technology company for ERP, MIS, accounting, custom software, websites and mobile apps. Compare technology companies in Afghanistan by capability.'],
            'manufacturing-erp-software-afghanistan' => ['Manufacturing ERP Software Afghanistan | Fida', 'Connect materials, production, inventory, purchasing, costing, quality, maintenance, sales and finance with manufacturing ERP software.'],
            'mining-extractives-software-afghanistan' => ['Mining & Extractives Software Afghanistan | Fida', 'Manage sites, production, equipment, fuel, workforce, procurement, inventory, finance and reporting with mining operations software.'],
            'products' => ['Business Software Products Afghanistan | Fida', 'Explore Fida software products for real estate, Sarafi and remittance operations, pharmacy management and business account management.'],
            'solutions' => ['Enterprise Software Solutions Afghanistan | Fida', 'Explore ERP, MIS, finance, workflow, data, integration and digital transformation solutions designed for organizations in Afghanistan.'],
        ];

        foreach ($updates as $slug => [$title, $description]) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page) {
                continue;
            }

            $metaTitle = (array) $page->meta_title;
            $metaDescription = (array) $page->meta_description;
            $metadata = (array) $page->metadata;

            $metaTitle['en'] = $title;
            $metaDescription['en'] = $description;
            $metadata['search_growth'] = [
                'optimized_at' => '2026-10-02',
                'source' => 'Google Search Console',
                'reason' => 'High-impression page with CTR or position improvement opportunity.',
            ];

            $page->update([
                'meta_title' => $metaTitle,
                'meta_description' => $metaDescription,
                'metadata' => $metadata,
                'sitemap_last_modified_at' => now(),
            ]);
        }
    }
}
