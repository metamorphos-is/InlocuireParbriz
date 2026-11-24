<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Adaugă al treilea paragraf local (database/data/city-extra.php). Doar aditiv: nu modifică secțiunile existente. */
return new class extends Migration
{
    public function up(): void
    {
        foreach (require database_path('data/city-extra.php') as $slug => [$heading, $body]) {
            $city = DB::table('cities')->where('slug', $slug)->first(['id', 'sections']);
            if (! $city) {
                continue;
            }
            $sections = json_decode((string) $city->sections, true) ?: [];
            if (collect($sections)->contains(fn ($s) => ($s['heading'] ?? '') === $heading)) {
                continue;
            }
            $sections[] = ['heading' => $heading, 'body' => $body];
            DB::table('cities')->where('id', $city->id)->update(['sections' => json_encode($sections, JSON_UNESCAPED_UNICODE)]);
        }
    }

    public function down(): void
    {
        // Conținut; nu se șterge.
    }
};
