<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('cui')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('status', 32)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('provider_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unique(['provider_id', 'category_id']);
        });

        Schema::create('provider_coverage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sector_id')->nullable()->constrained('city_sectors')->nullOnDelete();
            $table->unique(['provider_id', 'city_id', 'sector_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_coverage');
        Schema::dropIfExists('provider_category');
        Schema::dropIfExists('providers');
    }
};
