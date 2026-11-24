<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    /** Regula din prompt: niciun link din meniu spre o pagină inexistentă. */
    public function test_every_menu_link_resolves(): void
    {
        $this->seed();
        $nav = config('navigation');
        $urls = collect($nav['servicii']['groups'])->flatMap(fn ($g) => collect($g['items'])->pluck('url'))
            ->push($nav['servicii']['all']['url'], $nav['servicii']['footer']['url'])
            ->merge(collect($nav['locatii']['regions'])->flatMap(fn ($r) => collect($r['items'])->pluck('url')->push($r['main']['url'])))
            ->merge(collect($nav['simple'])->pluck('url'))
            ->unique();

        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
        $this->assertGreaterThan(15, $urls->count());
    }

    public function test_header_renders_mega_menu(): void
    {
        $this->seed();
        $this->get('/')->assertOk()
            ->assertSee('Servicii pentru sticlă auto')
            ->assertSee('Înlocuire parbriz Sector 6')
            ->assertSee('Alte orașe');
    }

    public function test_zone_query_preselects_other_city(): void
    {
        $this->seed();
        $this->get('/cerere-oferta?zona=alt_oras')->assertOk()->assertSee('value="alt_oras" selected', false);
    }
}
