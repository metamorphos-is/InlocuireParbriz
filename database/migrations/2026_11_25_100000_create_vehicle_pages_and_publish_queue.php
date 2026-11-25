<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Doar aditiv: paginile pe mărci/modele auto (/parbriz-auto/...) și coada de publicare zilnică
 * (un articol / o pagină nouă pe zi, publicată automat de scheduler — vezi routes/console.php).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vehicle_pages')) {
            Schema::create('vehicle_pages', function (Blueprint $table) {
                $table->id();
                $table->string('kind', 10)->default('model'); // brand | model
                $table->string('brand_slug', 60);
                $table->string('brand_name', 80);
                $table->string('model_slug', 80)->nullable();
                $table->string('model_name', 120)->nullable();
                $table->string('years', 60)->nullable();
                $table->string('bodies', 190)->nullable();
                $table->string('h1', 190)->nullable();
                $table->string('seo_title', 190)->nullable();
                $table->string('meta_description', 320)->nullable();
                $table->string('primary_keyword', 120)->nullable();
                $table->json('secondary_keywords')->nullable();
                $table->unsignedInteger('search_volume')->nullable();
                $table->text('intro')->nullable();
                $table->json('variants')->nullable();
                $table->string('adas', 20)->nullable(); // none | optional | common
                $table->json('sections')->nullable();
                $table->json('faq')->nullable();
                $table->string('image', 120)->nullable();
                $table->unsignedInteger('sort_order')->default(100);
                $table->boolean('is_published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->unique(['brand_slug', 'model_slug']);
                $table->index(['kind', 'is_published']);
            });
        }

        if (! Schema::hasTable('publish_queue')) {
            Schema::create('publish_queue', function (Blueprint $table) {
                $table->id();
                $table->string('publishable_type', 120);
                $table->unsignedBigInteger('publishable_id');
                $table->unsignedInteger('position')->default(1000);
                $table->date('not_before')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->string('note', 255)->nullable();
                $table->timestamps();
                $table->unique(['publishable_type', 'publishable_id']);
                $table->index(['published_at', 'position']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('publish_queue');
        Schema::dropIfExists('vehicle_pages');
    }
};
