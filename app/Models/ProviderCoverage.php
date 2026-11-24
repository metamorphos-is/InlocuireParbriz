<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderCoverage extends Model
{
    protected $table = 'provider_coverage';

    public $timestamps = false;

    protected $fillable = ['provider_id', 'city_id', 'sector_id'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(CitySector::class, 'sector_id');
    }
}
