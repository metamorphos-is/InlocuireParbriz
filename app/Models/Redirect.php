<?php

namespace App\Models;

use App\Http\Middleware\HandleRedirects;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = ['from_path', 'to_path', 'status_code'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(HandleRedirects::CACHE_KEY));
        static::deleted(fn () => Cache::forget(HandleRedirects::CACHE_KEY));
    }
}
