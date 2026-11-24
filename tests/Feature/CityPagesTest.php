<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\Cities\Pages\ManageCities;
use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CityPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_national_and_links_city_pages(): void
    {
        $this->seed();
        $html = $this->get('/')->assertOk()->getContent();
        $this->assertStringContainsString('Înlocuire parbriz în orașul tău', $html);
        $this->assertStringNotContainsString('marketplace', strtolower($html));
        foreach (City::query()->withPublicPage()->get() as $c) {
            $this->assertStringContainsString('/inlocuire-parbriz-'.$c->slug.'"', $html);
        }
        $this->assertStringContainsString('/inlocuire-parbriz-bucuresti"', $html);
    }

    public function test_all_seeded_city_pages_render_with_unique_titles_and_h1(): void
    {
        $this->seed();
        $cities = City::query()->withPublicPage()->get();
        $this->assertCount(18, $cities);

        $titles = [];
        foreach ($cities as $city) {
            $html = $this->get('/inlocuire-parbriz-'.$city->slug)->assertOk()
                ->assertSee('Înlocuire parbriz în '.$city->name)
                ->assertSee('Disponibilitate confirmată la cerere') // fără promisiuni de acoperire
                ->getContent();
            preg_match('#<title>(.*?)</title>#s', $html, $m);
            $titles[] = $m[1];
            $this->assertGreaterThanOrEqual(2, count((array) $city->sections));
        }
        $this->assertSame(count($titles), count(array_unique($titles)), 'titluri duplicate');
    }

    public function test_city_content_is_not_city_swapped(): void
    {
        $this->seed();
        $intros = City::query()->withPublicPage()->get()->map(fn ($c) => str_replace($c->name, 'X', $c->intro.implode(' ', array_column((array) $c->sections, 'body'))));
        $this->assertSame($intros->count(), $intros->unique()->count());
    }

    public function test_dedicated_and_unpublished_pages_are_not_routed_generically(): void
    {
        $this->seed();
        City::query()->where('slug', 'arad')->update(['is_published' => false]);
        $this->get('/inlocuire-parbriz-arad')->assertNotFound();
        $this->get('/inlocuire-parbriz-bucuresti')->assertOk();  // pagina dedicată existentă
        $this->get('/inlocuire-parbriz-la-domiciliu')->assertOk();
    }

    public function test_menu_and_sitemap_list_city_pages(): void
    {
        $this->seed();
        $this->get('/')->assertSee('Parbrize Timișoara')->assertSee('Moldova');
        $this->get('/sitemap.xml')->assertSee('/inlocuire-parbriz-cluj-napoca', false);
    }

    public function test_active_coverage_changes_the_promise(): void
    {
        $this->seed();
        City::query()->where('slug', 'brasov')->update(['coverage' => 'active']);
        $this->get('/inlocuire-parbriz-brasov')->assertSee('Ateliere partenere active în Brașov');
    }

    public function test_admin_can_open_city_editor(): void
    {
        $this->seed();
        $admin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($admin)->get('/admin/cities')->assertOk()->assertSee('Timișoara');
    }
}
