<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return ['value' => 'array'];
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember("site_setting:{$key}", 300, function () use ($key) {
            return static::query()->where('key', $key)->first();
        });

        return $setting?->value ?? $default;
    }

    public static function setValue(string $key, mixed $value): self
    {
        $setting = static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting:{$key}");

        return $setting;
    }
}
