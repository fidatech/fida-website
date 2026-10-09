<?php

use Database\Seeders\GovernmentTechnologySolutionsSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        app(GovernmentTechnologySolutionsSeeder::class)->run();
    }

    public function down(): void
    {
        \App\Models\ContentPage::query()->whereIn('slug', [
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
        ])->delete();
    }
};
