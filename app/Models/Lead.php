<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lead extends Model
{
    public const STATUSES = [
        'noua', 'in_analiza', 'atribuita', 'contactat', 'programata',
        'in_desfasurare', 'finalizata', 'refuzata', 'anulata', 'arhivata',
    ];

    protected $fillable = [
        'reference', 'category_id', 'city_id', 'sector_id',
        'customer_name', 'phone', 'email', 'address_text', 'description',
        'vehicle_brand', 'vehicle_model', 'vehicle_year', 'vehicle_vin',
        'glass_type', 'glass_features', 'service_location_type',
        'preferred_date', 'preferred_time', 'customer_type', 'insurance_casco',
        'urgency', 'preferred_schedule', 'status', 'assigned_provider_id',
        'agreed_amount', 'source', 'landing_path', 'consent_at', 'marketing_consent', 'ip_hash',
    ];

    protected function casts(): array
    {
        return [
            'urgency' => 'boolean',
            'insurance_casco' => 'boolean',
            'marketing_consent' => 'boolean',
            'glass_features' => 'array',
            'preferred_date' => 'date',
            'agreed_amount' => 'decimal:2',
            'consent_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (empty($lead->reference)) {
                $lead->reference = 'IP-'.strtoupper(Str::random(6));
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(CitySector::class, 'sector_id');
    }

    public function assignedProvider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'assigned_provider_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(LeadAssignment::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(LeadEvent::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }
}
