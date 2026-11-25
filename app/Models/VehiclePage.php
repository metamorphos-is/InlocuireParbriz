<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** Pagină de marcă (/parbriz-auto/{marca}) sau de model (/parbriz-auto/{marca}/{model}). */
class VehiclePage extends Model
{
    public const ADAS = [
        'none' => 'Fără cameră pe parbriz (în general)',
        'optional' => 'Cameră pe parbriz la unele versiuni',
        'common' => 'Cameră pe parbriz frecventă',
    ];

    protected $fillable = [
        'kind', 'brand_slug', 'brand_name', 'model_slug', 'model_name', 'years', 'bodies',
        'h1', 'seo_title', 'meta_description', 'primary_keyword', 'secondary_keywords', 'search_volume',
        'intro', 'variants', 'adas', 'sections', 'faq', 'image', 'sort_order', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'secondary_keywords' => 'array',
            'variants' => 'array',
            'sections' => 'array',
            'faq' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'search_volume' => 'integer',
        ];
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeBrands(Builder $q): Builder
    {
        return $q->where('kind', 'brand');
    }

    public function scopeModels(Builder $q): Builder
    {
        return $q->where('kind', 'model');
    }

    public function isBrand(): bool
    {
        return $this->kind === 'brand';
    }

    /** „Volkswagen Passat B6” sau „Volkswagen”. */
    public function fullName(): string
    {
        return trim($this->brand_name.' '.($this->model_name ?? ''));
    }

    public function path(): string
    {
        return '/parbriz-auto/'.$this->brand_slug.($this->model_slug ? '/'.$this->model_slug : '');
    }

    public function url(): string
    {
        return url($this->path());
    }

    public function label(): string
    {
        return 'Parbriz '.$this->fullName();
    }
}
