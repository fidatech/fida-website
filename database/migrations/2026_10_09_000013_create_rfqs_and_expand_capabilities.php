<?php

use Database\Seeders\GovernmentNgoCapabilitySeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table): void {
            $table->id();
            $table->string('reference', 30)->unique();
            $table->string('organization_name', 190);
            $table->string('organization_type', 50)->index();
            $table->string('contact_name', 120);
            $table->string('job_title', 120)->nullable();
            $table->string('email', 190)->index();
            $table->string('phone', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('procurement_reference', 120)->nullable()->index();
            $table->string('procurement_method', 30)->index();
            $table->date('submission_deadline')->nullable()->index();
            $table->json('capabilities');
            $table->string('budget_currency', 10)->nullable();
            $table->decimal('budget_min', 18, 2)->nullable();
            $table->decimal('budget_max', 18, 2)->nullable();
            $table->string('delivery_location', 190)->nullable();
            $table->text('project_summary');
            $table->longText('scope_requirements');
            $table->text('compliance_requirements')->nullable();
            $table->string('timeline', 190)->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('attachment_mime', 120)->nullable();
            $table->unsignedBigInteger('attachment_size')->nullable();
            $table->string('locale', 5)->default('en');
            $table->text('source_url')->nullable();
            $table->string('utm_source', 100)->nullable()->index();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 150)->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        (new GovernmentNgoCapabilitySeeder())->run();
    }

    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
