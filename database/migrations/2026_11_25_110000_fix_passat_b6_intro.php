<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Textul de intro pentru Passat B6 nu mai pomenește volumul de căutări (dată internă). Modifică doar dacă textul n-a fost editat din admin. */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('vehicle_pages')->where('brand_slug', 'volkswagen')->where('model_slug', 'passat-b6')
            ->where('intro', 'like', '%700 de căutări pe lună%')
            ->update(['intro' => DB::raw("REPLACE(intro, 'Passat B6 este cel mai căutat model când vine vorba de parbriz nou, cu peste 700 de căutări pe lună. Majoritatea', 'Passat B6 este unul dintre modelele pentru care se schimbă cel mai des parbrizul. Majoritatea')"), 'updated_at' => now()]);
    }

    public function down(): void
    {
    }
};
