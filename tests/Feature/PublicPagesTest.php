<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_missing_page_returns_404_not_500(): void
    {
        $this->get('/pagina-care-nu-exista')->assertStatus(404)->assertSee('Pagina nu a fost găsită');
    }

    public function test_core_public_pages_load(): void
    {
        $this->seed();
        foreach (['/', '/cerere-oferta', '/contact', '/politica-de-confidentialitate', '/sitemap.xml',
            '/inlocuire-parbriz-bucuresti', '/inlocuire-parbriz-bucuresti/sector-3'] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
