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
        // În cache punem doar valoarea (array/scalar), nu modelul: Laravel 13 restricționează
        // ce clase se pot deserializa din cache (cache.serializable_classes).
        $value = Cache::remember("site_setting_v2:{$key}", 300, function () use ($key) {
            return ['v' => static::query()->where('key', $key)->value('value')];
        });

        $raw = $value['v'] ?? null;
        if (is_string($raw)) {
            $raw = json_decode($raw, true) ?? $raw;
        }

        return $raw ?? $default;
    }

    public static function setValue(string $key, mixed $value): self
    {
        $setting = static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting_v2:{$key}");
        Cache::forget("site_setting:{$key}");

        return $setting;
    }
}
