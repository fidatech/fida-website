<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WebsiteSeeder::class);
        $this->call(EnterpriseAuthoritySeeder::class);
        $this->call(EnterpriseCoreSeeder::class);
        $this->call(ReleaseDiscoveryCleanupSeeder::class);
        $this->call(SearchGrowthSeeder::class);
        $this->call(AiDiscoveryContentSeeder::class);
        $this->call(SearchAuthorityExpansionSeeder::class);
        $this->call(SearchAuthorityContentWaveSeeder::class);
        $this->call(SearchAuthorityContentWaveTwoSeeder::class);
        $this->call(SearchAuthorityContentWaveThreeSeeder::class);
        $this->call(AfghanIndustryOpportunitySeeder::class);
        $this->call(GovernmentNgoCapabilitySeeder::class);
        $this->call(ErpNextAfghanistanSeeder::class);
    }
}
