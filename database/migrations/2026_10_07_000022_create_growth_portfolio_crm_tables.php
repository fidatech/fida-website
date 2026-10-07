<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranking_targets', function (Blueprint $table): void {
            $table->id();
            $table->string('keyword', 255);
            $table->string('locale', 5)->default('en');
            $table->string('target_url', 512)->nullable();
            $table->decimal('target_position', 6, 2)->default(3);
            $table->boolean('active')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['keyword', 'locale']);
        });

        Schema::create('clients', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 190);
            $table->string('company_name', 190)->nullable();
            $table->string('sector', 120)->nullable()->index();
            $table->string('contact_person', 190)->nullable();
            $table->string('email', 190)->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('whatsapp', 60)->nullable();
            $table->text('address')->nullable();
            $table->string('website', 512)->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('portfolio_projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 190);
            $table->string('slug', 190)->unique();
            $table->string('project_type', 120)->nullable()->index();
            $table->string('status', 40)->default('active')->index();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->json('technologies')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('live_url', 512)->nullable();
            $table->string('repository_url', 512)->nullable();
            $table->boolean('public')->default(false)->index();
            $table->foreignId('content_page_id')->nullable()->constrained('content_pages')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('project_screenshots', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('portfolio_project_id')->constrained()->cascadeOnDelete();
            $table->string('disk', 30)->default('public');
            $table->string('path', 1024);
            $table->string('caption', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('portfolio_project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contract_number', 120)->nullable()->unique();
            $table->string('title', 190);
            $table->date('signed_at')->nullable();
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->string('currency', 12)->default('AFN');
            $table->string('status', 40)->default('active')->index();
            $table->text('payment_terms')->nullable();
            $table->text('scope_summary')->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment_disk', 30)->nullable();
            $table->string('attachment_path', 1024)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('project_screenshots');
        Schema::dropIfExists('portfolio_projects');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('ranking_targets');
    }
};
