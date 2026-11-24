<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoPage extends Model
{
    protected $fillable = [
        'path', 'title', 'meta_description', 'h1', 'body', 'robots', 'status',
        'city_id', 'sector_id', 'category_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(CitySector::class, 'sector_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
