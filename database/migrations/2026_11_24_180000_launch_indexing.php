<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Lansare (decizia proprietarului, 24.11.2026 16:50: „vreau să indexez site-ul”).
 * Oprește noindex o singură dată; după aceea comutatorul din admin → Setări site → SEO rămâne sursa.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }
        $seo = (array) SiteSetting::getValue('seo', []);
        $seo['noindex'] = false;
        $seo['default_robots'] = 'index,follow';
        $seo['launched_at'] = now()->toIso8601String();
        SiteSetting::setValue('seo', $seo);
    }

    public function down(): void
    {
        $seo = (array) SiteSetting::getValue('seo', []);
        $seo['noindex'] = true;
        SiteSetting::setValue('seo', $seo);
    }
};
