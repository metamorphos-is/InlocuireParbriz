<?php

use App\Models\City;
use App\Models\Post;
use App\Models\VehiclePage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * SEO etapa 2 (25.11.2026): mărci și modele auto, articole noi, orașe noi + coada de publicare zilnică.
 * Doar aditiv: nu modifică nimic din ce există deja (conținutul editat din admin rămâne neatins).
 * Elementele marcate `now` se publică imediat; restul intră în `publish_queue` și apar câte unul pe zi.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('vehicle_pages') || ! Schema::hasTable('publish_queue')) {
            return;
        }

        $now = now();
        $queue = [];
        $short = ['volkswagen' => 'VW'];

        $brands = collect(require database_path('data/vehicle-brands.php'))->keyBy('brand_slug');
        $models = require database_path('data/vehicle-models.php');
        $brandsNow = collect($models)->where('now', true)->pluck('brand')->unique()->all();

        foreach ($brands as $slug => $b) {
            if (DB::table('vehicle_pages')->where('brand_slug', $slug)->whereNull('model_slug')->exists()) {
                continue;
            }
            $live = in_array($slug, $brandsNow, true);
            DB::table('vehicle_pages')->insert([
                'kind' => 'brand', 'brand_slug' => $slug, 'brand_name' => $b['brand_name'], 'model_slug' => null, 'model_name' => null,
                'h1' => $b['h1'], 'seo_title' => $b['seo_title'], 'meta_description' => $b['meta_description'],
                'primary_keyword' => $b['primary_keyword'], 'secondary_keywords' => json_encode($b['secondary_keywords'], JSON_UNESCAPED_UNICODE),
                'search_volume' => $b['search_volume'], 'intro' => $b['intro'],
                'sections' => json_encode(array_map(fn ($s) => ['heading' => $s[0], 'body' => $s[1]], $b['sections']), JSON_UNESCAPED_UNICODE),
                'faq' => json_encode(array_map(fn ($f) => ['q' => $f[0], 'a' => $f[1]], $b['faq']), JSON_UNESCAPED_UNICODE),
                'sort_order' => $b['sort_order'], 'is_published' => $live, 'published_at' => $live ? $now : null,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        foreach ($models as $m) {
            if (DB::table('vehicle_pages')->where('brand_slug', $m['brand'])->where('model_slug', $m['slug'])->exists()) {
                continue;
            }
            $brandName = $brands[$m['brand']]['brand_name'];
            $titleBrand = $short[$m['brand']] ?? $brandName;
            $live = (bool) ($m['now'] ?? false);
            $id = DB::table('vehicle_pages')->insertGetId([
                'kind' => 'model', 'brand_slug' => $m['brand'], 'brand_name' => $brandName,
                'model_slug' => $m['slug'], 'model_name' => $m['name'], 'years' => $m['years'], 'bodies' => $m['bodies'],
                'h1' => "Parbriz {$brandName} {$m['name']}: variante, preț și înlocuire",
                'seo_title' => "Parbriz {$titleBrand} {$m['name']}: variante și preț | inlocuireparbriz.ro",
                'meta_description' => "Parbriz {$brandName} {$m['name']}".(mb_strlen($m['years']) <= 20 ? " ({$m['years']})" : '').": ce variante există — senzor de ploaie, încălzire, cameră — cum o afli pe a ta și cum primești oferta corectă.",
                'primary_keyword' => $m['primary'], 'secondary_keywords' => json_encode($m['secondary'], JSON_UNESCAPED_UNICODE),
                'search_volume' => $m['volume'], 'intro' => $m['intro'],
                'variants' => json_encode($m['variants'], JSON_UNESCAPED_UNICODE), 'adas' => $m['adas'],
                'sections' => json_encode(array_map(fn ($s) => ['heading' => $s[0], 'body' => $s[1]], $m['sections']), JSON_UNESCAPED_UNICODE),
                'faq' => json_encode(array_map(fn ($f) => ['q' => $f[0], 'a' => $f[1]], $m['faq']), JSON_UNESCAPED_UNICODE),
                'image' => $m['image'] ?? null, 'sort_order' => $m['sort'] ?? (100 + (int) ($m['queue'] ?? 0)),
                'is_published' => $live, 'published_at' => $live ? $now : null,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            if (! $live) {
                $queue[] = [VehiclePage::class, $id, (int) $m['queue']];
            }
        }

        foreach (require database_path('data/blog-posts-2.php') as $p) {
            if (DB::table('posts')->where('slug', $p['slug'])->exists()) {
                continue;
            }
            $live = (bool) ($p['now'] ?? false);
            $id = DB::table('posts')->insertGetId([
                'title' => $p['title'], 'slug' => $p['slug'], 'category' => $p['category'], 'excerpt' => $p['excerpt'], 'body' => $p['body'],
                'primary_keyword' => $p['primary_keyword'], 'secondary_keywords' => json_encode($p['secondary_keywords'], JSON_UNESCAPED_UNICODE),
                'search_volume' => $p['search_volume'], 'seo_title' => $p['seo_title'], 'meta_description' => $p['meta_description'],
                'faq' => json_encode($p['faq'], JSON_UNESCAPED_UNICODE), 'related_service' => $p['related_service'],
                'author' => 'Echipa inlocuireparbriz.ro', 'image' => $p['image'] ?? null,
                'is_published' => $live, 'published_at' => $live ? $now : null,
                'created_at' => $now, 'updated_at' => $now,
            ]);
            if (! $live) {
                $queue[] = [Post::class, $id, (int) $p['queue']];
            }
        }

        foreach (require database_path('data/city-pages-2.php') as $c) {
            $existing = DB::table('cities')->where('slug', $c['slug'])->first();
            if ($existing && (filled($existing->intro ?? null) || $existing->is_published)) {
                continue;
            }
            $kw = str_replace('-', ' ', $c['slug']);
            $data = [
                'name' => $c['name'], 'county' => $c['county'], 'region' => $c['region'], 'coverage' => 'on_request',
                'is_published' => false, 'is_active' => true, 'sort_order' => $c['sort'],
                'primary_keyword' => 'parbrize '.$kw,
                'secondary_keywords' => json_encode(['parbriz '.$kw, 'înlocuire parbriz '.mb_strtolower($c['name']), 'schimbare parbriz '.mb_strtolower($c['name'])], JSON_UNESCAPED_UNICODE),
                'search_volume' => $c['volume'],
                'seo_title' => "Parbrize {$c['name']} – înlocuire și montaj parbriz | inlocuireparbriz.ro",
                'meta_description' => "Înlocuire parbriz în {$c['name']}: ofertă pe tipul corect de sticlă (senzori, cameră, încălzire) și montaj prin ateliere partenere verificate. Îți confirmăm disponibilitatea.",
                'h1' => "Înlocuire parbriz în {$c['name']}", 'intro' => $c['intro'],
                'areas' => json_encode($c['areas'], JSON_UNESCAPED_UNICODE),
                'sections' => json_encode(array_map(fn ($s) => ['heading' => $s[0], 'body' => $s[1]], $c['sections']), JSON_UNESCAPED_UNICODE),
                'faq' => json_encode(array_map(fn ($f) => ['q' => $f[0], 'a' => $f[1]], $c['faq']), JSON_UNESCAPED_UNICODE),
                'updated_at' => $now,
            ];
            if ($existing) {
                DB::table('cities')->where('id', $existing->id)->update($data);
                $id = $existing->id;
            } else {
                $id = DB::table('cities')->insertGetId($data + ['slug' => $c['slug'], 'created_at' => $now]);
            }
            $queue[] = [City::class, $id, (int) $c['queue']];
        }

        foreach ($queue as [$type, $id, $position]) {
            DB::table('publish_queue')->insertOrIgnore([
                'publishable_type' => $type, 'publishable_id' => $id, 'position' => $position,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        \App\Support\Navigation::forget();
    }

    public function down(): void
    {
        // Conținut — nu se șterge la rollback.
    }
};
