<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Încarcă paginile de oraș aprobate (database/data/city-pages.php). Doar aditiv:
 * nu suprascrie un oraș care are deja conținut (editat din admin).
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach (require database_path('data/city-pages.php') as $c) {
            $existing = DB::table('cities')->where('slug', $c['slug'])->first();
            if ($existing && filled($existing->intro ?? null)) {
                continue;
            }

            $short = preg_replace('/-napoca$/', '', $c['slug']);
            $data = [
                'name' => $c['name'],
                'county' => $c['county'],
                'region' => $c['region'],
                'coverage' => 'on_request',
                'is_published' => true,
                'is_active' => true,
                'sort_order' => $c['sort'],
                'primary_keyword' => 'parbrize '.str_replace('-', ' ', $short),
                'secondary_keywords' => json_encode([
                    'parbriz '.str_replace('-', ' ', $short),
                    'înlocuire parbriz '.mb_strtolower($c['name']),
                    'schimbare parbriz '.mb_strtolower($c['name']),
                ], JSON_UNESCAPED_UNICODE),
                'search_volume' => $c['volume'],
                'seo_title' => "Parbrize {$c['name']} – înlocuire și montaj parbriz | Înlocuire Parbriz",
                'meta_description' => "Înlocuire parbriz în {$c['name']}: ofertă pe tipul corect de sticlă (senzori, cameră, încălzire) și montaj prin ateliere partenere verificate. Îți confirmăm disponibilitatea.",
                'h1' => "Înlocuire parbriz în {$c['name']}",
                'intro' => $c['intro'],
                'areas' => json_encode($c['areas'], JSON_UNESCAPED_UNICODE),
                'sections' => json_encode(array_map(fn ($s) => ['heading' => $s[0], 'body' => $s[1]], $c['sections']), JSON_UNESCAPED_UNICODE),
                'faq' => json_encode(array_map(fn ($f) => ['q' => $f[0], 'a' => $f[1]], $c['faq']), JSON_UNESCAPED_UNICODE),
                'updated_at' => $now,
            ];

            $existing
                ? DB::table('cities')->where('id', $existing->id)->update($data)
                : DB::table('cities')->insert($data + ['slug' => $c['slug'], 'created_at' => $now]);
        }

        // București: are deja pagini dedicate (pagina principală + sectoare); acoperire activă.
        DB::table('cities')->where('slug', 'bucuresti')->update([
            'region' => 'bucuresti-ilfov', 'coverage' => 'active', 'sort_order' => 1, 'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        // Conținut — nu se șterge la rollback.
    }
};
