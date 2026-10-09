<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const TITLES = [
        'realist-real-estate-erp' => [
            'en' => 'Realist ERP — Real Estate Management System',
            'fa' => 'Realist ERP — سیستم مدیریت املاک',
            'ps' => 'Realist ERP — د املاکو مدیریت سیستم',
        ],
        'prime-sarafi-software' => [
            'en' => 'Prime Sarafi — Sarafi Management System',
            'fa' => 'Prime Sarafi — سیستم مدیریت صرافی',
            'ps' => 'Prime Sarafi — د صرافۍ مدیریت سیستم',
        ],
        'darmal-pharmacy-erp' => [
            'en' => 'Darmal — Pharmacy & Pharmaceutical ERP',
            'fa' => 'Darmal — سیستم دواخانه و شرکت دارویی',
            'ps' => 'Darmal — د درملتون او درملو شرکت ERP',
        ],
        'ograyi-account-manager' => [
            'en' => 'Ograyi — Account Manager (Mobile App)',
            'fa' => 'Ograyi — مدیریت حساب (اپلیکیشن موبایل)',
            'ps' => 'Ograyi — د حساب مدیریت (موبایل اپلېکېشن)',
        ],
    ];

    private const ORIGINAL_TITLES = [
        'realist-real-estate-erp' => [
            'en' => 'Realist ERP for Real Estate & Construction',
            'fa' => 'Realist ERP برای املاک و ساختمان',
            'ps' => 'د املاکو او ساختمان لپاره Realist ERP',
        ],
        'prime-sarafi-software' => [
            'en' => 'Prime Sarafi & Remittance Management Software',
            'fa' => 'نرم‌افزار مدیریت صرافی و حواله Prime',
            'ps' => 'د Prime صرافۍ او حوالو مدیریت سافټویر',
        ],
        'darmal-pharmacy-erp' => [
            'en' => 'Darmal Pharmacy & Pharmaceutical ERP',
            'fa' => 'Darmal ERP برای دواخانه و شرکت دارویی',
            'ps' => 'د درملتون او درملو شرکت لپاره Darmal ERP',
        ],
        'ograyi-account-manager' => [
            'en' => 'OGRAYI Mobile Credit & Debit Account Manager',
            'fa' => 'OGRAYI برای مدیریت حساب قرض و طلب',
            'ps' => 'OGRAYI د پور او طلب حسابونو مدیریت',
        ],
    ];

    public function up(): void
    {
        foreach (self::TITLES as $slug => $title) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page) {
                continue;
            }

            $page->title = $title;
            $page->sitemap_last_modified_at = now();
            $page->save();
        }
    }

    public function down(): void
    {
        foreach (self::ORIGINAL_TITLES as $slug => $title) {
            $page = ContentPage::query()->where('slug', $slug)->first();

            if (! $page || (array) $page->title !== self::TITLES[$slug]) {
                continue;
            }

            $page->title = $title;
            $page->save();
        }
    }
};
