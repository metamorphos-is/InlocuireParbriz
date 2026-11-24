<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeoResearchRun extends Model
{
    public const TYPES = [
        'national_plan' => 'Plan național complet (volume, sugestii, SERP, competitori, orașe)',
        'search_volume' => 'Volume de căutare pentru o listă de cuvinte',
        'suggestions' => 'Sugestii de cuvinte pornind de la un cuvânt',
        'related' => 'Cuvinte înrudite',
        'serp' => 'Analiză SERP (top 10 Google)',
        'competitor' => 'Cuvintele pe care se poziționează un domeniu',
    ];

    protected $fillable = [
        'type', 'params', 'status', 'summary', 'error', 'cost', 'requested_by', 'started_at', 'finished_at',
    ];

    protected function casts(): array
    {
        return [
            'params' => 'array',
            'summary' => 'array',
            'cost' => 'decimal:4',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(DataForSeoRequest::class, 'research_run_id');
    }
}
