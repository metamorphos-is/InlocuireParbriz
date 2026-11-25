<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Post;
use App\Models\PublishQueueItem;
use App\Models\VehiclePage;
use App\Services\ContentPublisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/** SEO etapa 2: pagini auto, întrebări frecvente, coada de publicare zilnică și sitemap. */
class SeoWave2Test extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_hub_brand_and_model_pages_render_with_schema(): void
    {
        $this->seed();

        $this->get('/parbriz-auto')->assertOk()->assertSee('Parbriz pe marcă și model')->assertSee('/parbriz-auto/volkswagen/passat-b6', false);
        $this->get('/parbriz-auto/volkswagen')->assertOk()->assertSee('Parbriz Passat B6')->assertSee('"ItemList"', false);
        $this->get('/parbriz-auto/volkswagen/passat-b6')->assertOk()
            ->assertSee('<h1 class="ip-hero__title">Parbriz Volkswagen Passat B6: variante, preț și înlocuire</h1>', false)
            ->assertSee('"FAQPage"', false)->assertSee('"BreadcrumbList"', false)->assertSee('"Service"', false)
            ->assertSee('<link rel="canonical" href="https://inlocuireparbriz.ro/parbriz-auto/volkswagen/passat-b6">', false)
            ->assertSee('marca=Volkswagen', false);

        // Modelele din coadă nu sunt încă publice.
        $this->get('/parbriz-auto/volkswagen/golf-7')->assertNotFound();
        $this->get('/parbriz-auto/marca-inexistenta')->assertNotFound();
    }

    public function test_faq_page_hides_links_to_unpublished_posts(): void
    {
        $this->seed();
        $html = $this->get('/intrebari-frecvente')->assertOk()->assertSee('"FAQPage"', false)->getContent();
        $this->assertStringNotContainsString('/blog/itp-cu-parbriz-fisurat', $html);
        $this->assertStringContainsString('/blog/parbriz-iarna-fisuri', $html);
    }

    public function test_daily_publisher_publishes_one_item_per_day_in_order_and_sitemap_follows(): void
    {
        $this->seed();
        $first = PublishQueueItem::query()->pending()->orderBy('position')->first();
        $this->assertNotNull($first);
        $this->assertSame(VehiclePage::class, $first->publishable_type);
        $path = $first->publishable->path();

        $this->get($path)->assertNotFound();
        $this->assertStringNotContainsString($path.'<', $this->get('/sitemap.xml')->getContent());

        $this->artisan('content:publish-next')->assertSuccessful();
        $this->artisan('content:publish-next')->assertSuccessful(); // a doua rulare din aceeași zi nu mai publică nimic

        $this->assertSame(1, PublishQueueItem::query()->whereNotNull('published_at')->count());
        $this->get($path)->assertOk();
        $this->assertStringContainsString('https://inlocuireparbriz.ro'.$path.'</loc>', $this->get('/sitemap.xml')->getContent());

        // A doua zi se publică următorul.
        Carbon::setTestNow(now()->addDay()->setTime(10, 0));
        $this->artisan('content:publish-next')->assertSuccessful();
        $this->assertSame(2, PublishQueueItem::query()->whereNotNull('published_at')->count());
        Carbon::setTestNow();
    }

    public function test_queue_covers_posts_and_cities_and_publishing_them_works(): void
    {
        $this->seed();
        $publisher = app(ContentPublisher::class);

        $postItem = PublishQueueItem::query()->where('publishable_type', Post::class)->firstOrFail();
        $cityItem = PublishQueueItem::query()->where('publishable_type', City::class)->firstOrFail();
        $this->get($postItem->publishable->url())->assertNotFound();
        $this->get($cityItem->publishable->url())->assertNotFound();

        $publisher->publish($postItem, manual: true);
        $publisher->publish($cityItem, manual: true);

        $this->get($postItem->fresh()->publishable->url())->assertOk();
        $this->get($cityItem->fresh()->publishable->url())->assertOk();
        // Publicarea manuală nu consumă locul zilnic al publicării automate.
        $this->assertSame(0, $publisher->publishedToday());
    }

    public function test_seed_migration_is_resumable_after_a_partial_run(): void
    {
        // Simulează rularea întreruptă de pe server: rândurile există parțial, coada e goală.
        PublishQueueItem::query()->delete();
        VehiclePage::query()->whereIn('brand_slug', ['renault', 'nissan'])->where('kind', 'model')->delete();
        Post::query()->where('slug', 'parbriz-iarna-fisuri')->delete();

        (require database_path('migrations/2026_11_25_100100_seed_seo_content_wave2.php'))->up();

        $this->assertSame(45, PublishQueueItem::query()->pending()->count());
        $this->get('/parbriz-auto/renault/megane-2')->assertOk();
        $this->get('/blog/parbriz-iarna-fisuri')->assertOk();
        $this->assertSame(10, VehiclePage::query()->models()->published()->count());
    }

    public function test_content_fits_mysql_column_lengths(): void
    {
        // SQLite (teste) nu verifică lungimea coloanelor; MySQL (producție) da.
        foreach (require database_path('data/vehicle-models.php') as $m) {
            $this->assertLessThanOrEqual(190, mb_strlen($m['years']), $m['slug']);
            $this->assertLessThanOrEqual(190, mb_strlen($m['bodies']), $m['slug']);
            $this->assertLessThanOrEqual(120, mb_strlen($m['primary']), $m['slug']);
            $this->assertLessThanOrEqual(120, mb_strlen($m['name']), $m['slug']);
            $this->assertLessThanOrEqual(120, mb_strlen($m['image'] ?? ''), $m['slug']);
        }
        foreach (require database_path('data/blog-posts-2.php') as $p) {
            $this->assertLessThanOrEqual(190, mb_strlen($p['seo_title']), $p['slug']);
            $this->assertLessThanOrEqual(320, mb_strlen($p['meta_description']), $p['slug']);
            $this->assertLessThanOrEqual(120, mb_strlen($p['primary_keyword']), $p['slug']);
            $this->assertLessThanOrEqual(120, mb_strlen($p['related_service']), $p['slug']);
            $this->assertLessThanOrEqual(255, mb_strlen($p['title']), $p['slug']);
        }
    }

    public function test_sitemap_has_priority_and_changefreq_by_page_type(): void
    {
        $this->seed();
        $xml = simplexml_load_string($this->get('/sitemap.xml')->assertOk()->getContent());
        $map = [];
        foreach ($xml->url as $u) {
            $this->assertNotSame('', (string) $u->priority, (string) $u->loc);
            $this->assertNotSame('', (string) $u->changefreq, (string) $u->loc);
            $map[(string) $u->loc] = (string) $u->priority;
        }
        $base = 'https://inlocuireparbriz.ro';
        $this->assertSame('1.0', $map[$base.'/'] ?? $map[$base]);
        $this->assertSame('0.9', $map[$base.'/reparatie-parbriz']);
        $this->assertSame('0.9', $map[$base.'/inlocuire-parbriz-bucuresti']);
        $this->assertSame('0.7', $map[$base.'/inlocuire-parbriz-bucuresti/sector-1']);
        $this->assertSame('0.7', $map[$base.'/parbriz-auto/volkswagen/passat-b6']);
        $this->assertSame('0.6', $map[$base.'/blog/parbriz-iarna-fisuri']);
        $this->assertSame('0.3', $map[$base.'/politica-de-confidentialitate']);
    }

    public function test_internal_links_to_unpublished_content_are_rendered_as_text(): void
    {
        $this->seed();
        $polish = Post::query()->where('slug', 'polish-parbriz-zgarieturi')->firstOrFail();
        $polish->forceFill(['is_published' => true, 'published_at' => now()])->save();

        $html = $this->get('/blog/polish-parbriz-zgarieturi')->assertOk()->getContent();
        $this->assertStringNotContainsString('href="/blog/tratament-hidrofob-parbriz"', $html);
        $this->assertStringContainsString('href="/reparatie-parbriz"', $html);
    }
}
