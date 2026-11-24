<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Primele articole de blog (database/data/blog-posts.php). Doar aditiv: nu atinge articolele existente. */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        foreach (require database_path('data/blog-posts.php') as $i => $p) {
            if (DB::table('posts')->where('slug', $p['slug'])->exists()) {
                continue;
            }
            DB::table('posts')->insert([
                'title' => $p['title'],
                'slug' => $p['slug'],
                'category' => $p['category'],
                'excerpt' => $p['excerpt'],
                'body' => trim($p['body']),
                'primary_keyword' => $p['primary_keyword'],
                'secondary_keywords' => json_encode($p['secondary_keywords'], JSON_UNESCAPED_UNICODE),
                'search_volume' => $p['search_volume'],
                'seo_title' => null,
                'meta_description' => $p['excerpt'],
                'faq' => json_encode($p['faq'], JSON_UNESCAPED_UNICODE),
                'related_service' => $p['related_service'],
                'author' => 'Echipa Înlocuire Parbriz',
                'is_published' => true,
                'published_at' => $now->copy()->subMinutes(10 - $i),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Conținut — nu se șterge la rollback.
    }
};
