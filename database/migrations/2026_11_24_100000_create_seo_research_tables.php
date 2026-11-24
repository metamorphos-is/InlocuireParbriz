<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Cercetare SEO (DataForSEO): cuvinte-cheie, jurnalul/cache-ul apelurilor API și rulările de cercetare.
 * Migrare doar aditivă — nu atinge tabelele existente.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dataforseo_requests', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint', 191);
            $table->char('payload_hash', 64);
            $table->json('payload');
            $table->longText('response')->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->integer('api_status_code')->nullable();
            $table->string('api_status_message')->nullable();
            $table->decimal('cost', 10, 4)->default(0);
            $table->string('status', 16)->default('ok'); // ok|error
            $table->foreignId('research_run_id')->nullable();
            $table->timestamps();
            $table->index(['endpoint', 'payload_hash']);
            $table->index('created_at');
        });

        Schema::create('seo_research_runs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 48); // national_plan|search_volume|suggestions|serp|competitor|...
            $table->json('params')->nullable();
            $table->string('status', 16)->default('pending'); // pending|running|done|failed
            $table->json('summary')->nullable();
            $table->text('error')->nullable();
            $table->decimal('cost', 10, 4)->default(0);
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword', 191);
            $table->unsignedInteger('location_code')->default(2642); // România
            $table->string('language_code', 8)->default('ro');
            $table->unsignedInteger('search_volume')->nullable();
            $table->decimal('cpc', 8, 2)->nullable();
            $table->decimal('competition', 5, 4)->nullable();
            $table->string('competition_level', 16)->nullable();
            $table->unsignedTinyInteger('keyword_difficulty')->nullable();
            $table->string('intent', 24)->nullable(); // commercial|transactional|informational|navigational|local
            $table->json('monthly_searches')->nullable();
            $table->string('cluster', 64)->nullable();
            $table->string('city_slug', 64)->nullable();
            $table->string('assigned_path', 191)->nullable(); // URL-ul paginii țintă (keyword → URL)
            $table->string('role', 16)->nullable(); // primary|secondary
            $table->string('priority', 8)->nullable(); // high|medium|low
            $table->string('content_type', 24)->nullable(); // service|city|sector|article|static
            $table->string('source', 32)->nullable(); // search_volume|suggestions|related|ranked|serp
            $table->text('notes')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
            $table->unique(['keyword', 'location_code', 'language_code']);
            $table->index('cluster');
            $table->index('assigned_path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
        Schema::dropIfExists('seo_research_runs');
        Schema::dropIfExists('dataforseo_requests');
    }
};
