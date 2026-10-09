<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $page = ContentPage::query()->where('slug', 'products')->first();

        if (! $page) {
            return;
        }

        $page->summary = [
            'en' => 'Explore Fida software products and the wider portfolio of ERP, finance, industry, web and digital systems.',
            'fa' => 'محصولات فیدا و پورتفولیوی گسترده سیستم‌های ERP، مالی، صنعتی، وب و دیجیتال را بررسی کنید.',
            'ps' => 'د فیدا محصولات او د ERP، مالي، سکتوري، وېب او ډیجیټل سیسټمونو پراخ پورټفولیو وګورئ.',
        ];
        $page->sitemap_last_modified_at = now();
        $page->save();
    }

    public function down(): void
    {
        $page = ContentPage::query()->where('slug', 'products')->first();

        if (! $page) {
            return;
        }

        $page->summary = [
            'en' => 'Review Fida product profiles for real estate, finance, pharmaceutical operations and mobile account management.',
            'fa' => 'پروفایل محصولات فیدا برای املاک، مالی، عملیات دارویی و مدیریت حساب موبایل را بررسی کنید.',
            'ps' => 'د املاکو، مالي، درملو عملیاتو او موبایل حساب مدیریت لپاره د فیدا محصولات وګورئ.',
        ];
        $page->save();
    }
};
