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
