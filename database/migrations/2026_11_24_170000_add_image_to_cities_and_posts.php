<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Imaginea principală (cheie din config/images.php) pentru orașe și articole. Doar aditiv. */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('cities', 'image')) {
            Schema::table('cities', fn (Blueprint $t) => $t->string('image', 120)->nullable());
        }
        if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'image')) {
            Schema::table('posts', fn (Blueprint $t) => $t->string('image', 120)->nullable());
        }
    }

    public function down(): void
    {
        // Aditiv; nu se șterge.
    }
};
