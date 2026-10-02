<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $updates = [
            'hrmis-payroll-software-afghanistan' => [
                'title' => 'HRMIS & Payroll Software Afghanistan | Fida',
                'description' => 'Manage employee records, attendance, leave, payroll, approvals and reporting with HRMIS and payroll software designed for organizations in Afghanistan.',
            ],
            'erp-systems-afghanistan' => [
                'title' => 'ERP Systems Afghanistan | Fida Technologies',
                'description' => 'Connect finance, procurement, inventory, HR, operations and reporting with ERP software designed around the real workflows of organizations in Afghanistan.',
            ],
            'ngo-ingo-software-afghanistan' => [
                'title' => 'NGO & INGO Management Software Afghanistan | Fida',
                'description' => 'Manage programmes, grants, budgets, procurement, HR, field operations, assets, beneficiaries and donor reporting in one NGO/INGO management platform.',
            ],
            'telecommunications-oss-bss-software-afghanistan' => [
                'title' => 'Telecom OSS/BSS Software Afghanistan | Fida',
                'description' => 'Connect subscriber accounts, orders, billing, collections, customer care, service assurance, sites and field operations with telecom OSS/BSS software.',
            ],
            'pharmacy-pharmaceutical-software-afghanistan' => [
                'title' => 'Pharmacy & Pharmaceutical Software Afghanistan | Fida',
                'description' => 'Manage medicines, batches, expiry, inventory, procurement, sales, finance and reporting with pharmacy and pharmaceutical software for Afghanistan.',
            ],
            'procurement-inventory-management-software-afghanistan' => [
                'title' => 'Procurement & Inventory Software Afghanistan | Fida',
                'description' => 'Control purchase requests, approvals, suppliers, purchase orders, receipts, warehouses, stock, issues and reporting with connected procurement software.',
            ],
            'business-intelligence-reporting-afghanistan' => [
                'title' => 'Business Intelligence & Reporting Afghanistan | Fida',
                'description' => 'Turn ERP, finance and operational data into governed dashboards, KPIs, management reports and decision-ready business intelligence.',
            ],
            'technology-company-afghanistan' => [
                'title' => 'Technology Company Afghanistan | Fida Technologies',
                'description' => 'Fida Technologies builds ERP, MIS, financial systems, custom software, integrations and mobile applications for organizations in Afghanistan.',
            ],
            'manufacturing-erp-software-afghanistan' => [
                'title' => 'Manufacturing ERP Software Afghanistan | Fida',
                'description' => 'Connect materials, production, inventory, purchasing, costing, quality, maintenance, sales and finance with manufacturing ERP software.',
            ],
            'mining-extractives-software-afghanistan' => [
                'title' => 'Mining & Extractives Software Afghanistan | Fida',
                'description' => 'Manage sites, production, equipment, fuel, workforce, procurement, inventory, finance and reporting with mining operations software.',
            ],
            'products' => [
                'title' => 'Business Software Products Afghanistan | Fida',
                'description' => 'Explore Fida software products for real estate, Sarafi and remittance operations, pharmacy management and business account management.',
            ],
            'solutions' => [
                'title' => 'Enterprise Software Solutions Afghanistan | Fida',
                'description' => 'Explore ERP, MIS, finance, workflow, data, integration and digital transformation solutions designed for organizations in Afghanistan.',
            ],
        ];

        foreach ($updates as $slug => $optimization) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page) {
                continue;
            }

            $metaTitle = (array) $page->meta_title;
            $metaDescription = (array) $page->meta_description;
            $metadata = (array) $page->metadata;

            $metaTitle['en'] = $optimization['title'];
            $metaDescription['en'] = $optimization['description'];
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

    public function down(): void
    {
        // Search metadata improvements are intentionally retained on rollback.
    }
};
