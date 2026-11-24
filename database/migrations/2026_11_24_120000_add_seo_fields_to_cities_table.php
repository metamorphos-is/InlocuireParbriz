<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Câmpuri SEO + conținut pentru paginile de oraș (aditiv). */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->string('region', 32)->nullable()->after('county');
            $table->string('coverage', 16)->default('on_request')->after('region'); // active|on_request
            $table->boolean('is_published')->default(false)->after('coverage');
            $table->unsignedSmallInteger('sort_order')->default(100)->after('is_published');
            $table->string('primary_keyword', 120)->nullable();
            $table->json('secondary_keywords')->nullable();
            $table->unsignedInteger('search_volume')->nullable();
            $table->string('seo_title', 190)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('h1', 190)->nullable();
            $table->text('intro')->nullable();
            $table->json('areas')->nullable();
            $table->json('sections')->nullable(); // [{heading, body}]
            $table->json('faq')->nullable();      // [{q, a}]
        });
    }

    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['region', 'coverage', 'is_published', 'sort_order', 'primary_keyword', 'secondary_keywords',
                'search_volume', 'seo_title', 'meta_description', 'h1', 'intro', 'areas', 'sections', 'faq']);
        });
    }
};
