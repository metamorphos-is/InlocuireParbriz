<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SiteSettingCacheTest extends TestCase
{
    use RefreshDatabase;

    /** Pe server cache-ul e serializat (database): valoarea trebuie să revină ca array, nu ca obiect incomplet. */
    public function test_value_survives_serialized_cache_store(): void
    {
        config(['cache.default' => 'file']);
        Cache::flush();
        SiteSetting::setValue('company', ['phone' => '0711 111 111']);

        $this->assertSame('0711 111 111', SiteSetting::getValue('company')['phone']);
        $this->assertSame('0711 111 111', SiteSetting::getValue('company')['phone']); // a doua citire = din cache
        $this->assertSame('x', SiteSetting::getValue('lipsa', 'x'));
        Cache::flush();
    }
}
