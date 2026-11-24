<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public const REGIONS = [
        'bucuresti-ilfov' => 'București și Ilfov',
        'transilvania' => 'Transilvania',
        'banat-crisana' => 'Banat și Crișana',
        'moldova' => 'Moldova',
        'muntenia' => 'Muntenia',
        'oltenia' => 'Oltenia',
        'dobrogea' => 'Dobrogea',
    ];

    public const COVERAGE = [
        'active' => 'Acoperire confirmată (ateliere partenere active)',
        'on_request' => 'La cerere (confirmăm disponibilitatea)',
    ];

    /** Orașe cu pagini proprii, în afara sistemului generic. */
    public const DEDICATED = ['bucuresti', 'ilfov'];

    protected $fillable = [
        'name', 'slug', 'county', 'is_active', 'region', 'coverage', 'is_published', 'sort_order',
        'primary_keyword', 'secondary_keywords', 'search_volume', 'seo_title', 'meta_description',
        'h1', 'intro', 'areas', 'sections', 'faq', 'image',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'secondary_keywords' => 'array',
            'areas' => 'array',
            'sections' => 'array',
            'faq' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => \App\Support\Navigation::forget());
        static::deleted(fn () => \App\Support\Navigation::forget());
    }

    public function sectors(): HasMany
    {
        return $this->hasMany(CitySector::class);
    }

    public function scopeWithPublicPage(Builder $q): Builder
    {
        return $q->where('is_published', true)->where('is_active', true)->whereNotIn('slug', self::DEDICATED);
    }

    public function url(): string
    {
        return url('/inlocuire-parbriz-'.$this->slug);
    }

    public function hasActiveCoverage(): bool
    {
        return $this->coverage === 'active';
    }
}
