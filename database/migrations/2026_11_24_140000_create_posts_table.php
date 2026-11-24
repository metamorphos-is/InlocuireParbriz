<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('posts')) {
            return;
        }

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 40)->default('ghiduri');
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('primary_keyword', 120)->nullable();
            $table->json('secondary_keywords')->nullable();
            $table->unsignedInteger('search_volume')->nullable();
            $table->string('seo_title', 190)->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->json('faq')->nullable();
            $table->string('related_service', 120)->nullable();
            $table->string('author', 120)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['is_published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
