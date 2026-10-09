<?php

use App\Models\ContentPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table): void {
            $table->id();
            $table->string('reference', 30)->nullable()->unique();
            $table->string('organization', 190);
            $table->string('organization_type', 40)->index();
            $table->string('contact_name', 120);
            $table->string('job_title', 120)->nullable();
            $table->string('email', 190)->index();
            $table->string('phone', 40)->nullable();
            $table->string('procurement_type', 60)->index();
            $table->string('project_title', 220);
            $table->date('submission_deadline')->nullable()->index();
            $table->string('location', 160)->nullable();
            $table->string('budget', 80)->nullable();
            $table->text('requirements');
            $table->json('attachments')->nullable();
            $table->string('locale', 5)->default('en');
            $table->text('source_url')->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->text('internal_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        if (ContentPage::query()->where('slug', 'government-public-sector-software-afghanistan')->exists()) {
            app(\Database\Seeders\RfqPageSeeder::class)->run();
        }

    }

    public function down(): void
    {
        ContentPage::query()->where('slug', 'request-for-quotation')->delete();
        Schema::dropIfExists('rfqs');
    }
};
