<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'cui', 'contact_name', 'email', 'phone', 'status', 'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'provider_category');
    }

    public function coverage(): HasMany
    {
        return $this->hasMany(ProviderCoverage::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_provider_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(LeadAssignment::class);
    }
}
