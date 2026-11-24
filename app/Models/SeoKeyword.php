<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKeyword extends Model
{
    public const INTENTS = [
        'commercial' => 'Comercial',
        'transactional' => 'Tranzacțional',
        'informational' => 'Informațional',
        'navigational' => 'Navigațional',
        'local' => 'Local',
    ];

    protected $fillable = [
        'keyword', 'location_code', 'language_code', 'search_volume', 'cpc', 'competition',
        'competition_level', 'keyword_difficulty', 'intent', 'monthly_searches', 'cluster',
        'city_slug', 'assigned_path', 'role', 'priority', 'content_type', 'source', 'notes', 'fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'monthly_searches' => 'array',
            'cpc' => 'decimal:2',
            'competition' => 'decimal:4',
            'fetched_at' => 'datetime',
        ];
    }

    /** Normalizare: litere mici, spații simple. Păstrăm diacriticele — Google le tratează ca variante. */
    public static function normalize(string $keyword): string
    {
        return trim(preg_replace('/\s+/u', ' ', mb_strtolower($keyword)));
    }
}
