<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Lărgește `vehicle_pages.years` (60 → 190): generațiile multiple (ex. Sandero 1/2/3) nu încăpeau. Nu pierde date. */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('vehicle_pages')) {
            Schema::table('vehicle_pages', fn (Blueprint $t) => $t->string('years', 190)->nullable()->change());
        }
    }

    public function down(): void
    {
        // Fără revenire: micșorarea ar putea tăia date.
    }
};
