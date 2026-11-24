<?php

namespace Tests\Feature;

use App\Models\DataForSeoRequest;
use App\Models\SeoKeyword;
use App\Models\SeoResearchRun;
use App\Models\User;
use App\Services\DataForSeo\DataForSeoClient;
use App\Services\DataForSeo\KeywordResearch;
use App\Services\DataForSeo\ResearchRunner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class DataForSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.dataforseo.login' => 'test-login',
            'services.dataforseo.password' => 'test-pass',
            'services.dataforseo.monthly_budget' => 5,
        ]);
    }

    private function ok(array $result, float $cost = 0.01): array
    {
        return ['status_code' => 20000, 'status_message' => 'Ok.', 'cost' => $cost,
            'tasks' => [['status_code' => 20000, 'result' => $result]]];
    }

    private function fakeApi(): void
    {
        Http::fake([
            '*/keywords_data/google_ads/search_volume/live' => Http::response($this->ok([
                ['keyword' => 'inlocuire parbriz', 'search_volume' => 2900, 'cpc' => 0.55, 'competition' => 'HIGH', 'competition_index' => 80, 'monthly_searches' => []],
                ['keyword' => 'parbriz cluj', 'search_volume' => 390, 'cpc' => 0.4, 'competition' => 'MEDIUM', 'competition_index' => 50],
            ], 0.075)),
            '*/dataforseo_labs/google/keyword_suggestions/live' => Http::response($this->ok([['items' => [
                ['keyword' => 'inlocuire parbriz pret', 'keyword_info' => ['search_volume' => 320, 'cpc' => 0.6, 'competition_level' => 'HIGH'], 'keyword_properties' => ['keyword_difficulty' => 12], 'search_intent_info' => ['main_intent' => 'commercial']],
            ]]])),
            '*/dataforseo_labs/google/related_keywords/live' => Http::response($this->ok([['items' => [
                ['keyword_data' => ['keyword' => 'schimbare parbriz', 'keyword_info' => ['search_volume' => 1300]]],
            ]]])),
            '*/serp/google/organic/live/advanced' => Http::response($this->ok([['items' => [
                ['type' => 'organic', 'rank_group' => 1, 'domain' => 'www.competitor-parbrize.ro', 'url' => 'https://www.competitor-parbrize.ro/', 'title' => 'Parbrize'],
                ['type' => 'organic', 'rank_group' => 2, 'domain' => 'olx.ro', 'url' => 'https://olx.ro/x', 'title' => 'OLX'],
                ['type' => 'local_pack', 'rank_group' => 1],
            ]]], 0.002)),
            '*/dataforseo_labs/google/ranked_keywords/live' => Http::response($this->ok([['items' => [
                ['keyword_data' => ['keyword' => 'parbriz bmw', 'keyword_info' => ['search_volume' => 210]], 'ranked_serp_element' => ['serp_item' => ['rank_group' => 3, 'url' => 'https://competitor-parbrize.ro/bmw']]],
                ['keyword_data' => ['keyword' => 'anvelope iarna', 'keyword_info' => ['search_volume' => 9000]], 'ranked_serp_element' => ['serp_item' => ['rank_group' => 9]]],
            ]]])),
            '*/dataforseo_labs/google/bulk_keyword_difficulty/live' => Http::response($this->ok([['items' => [['keyword' => 'inlocuire parbriz', 'keyword_difficulty' => 18]]]])),
            '*/dataforseo_labs/google/search_intent/live' => Http::response($this->ok([['items' => [['keyword' => 'inlocuire parbriz', 'keyword_intent' => ['label' => 'commercial', 'probability' => 0.9]]]]])),
            '*/appendix/user_data' => Http::response($this->ok([['login' => 'test-login', 'money' => ['balance' => 49.5, 'total' => 0.5]]], 0)),
        ]);
    }

    public function test_search_volume_is_saved_and_cached(): void
    {
        $this->fakeApi();
        $r = app(KeywordResearch::class);

        $r->store($r->searchVolume(['Înlocuire  Parbriz', 'parbriz cluj']));
        $r->searchVolume(['Înlocuire  Parbriz', 'parbriz cluj']); // al doilea apel = cache

        Http::assertSentCount(1);
        $this->assertSame(2900, SeoKeyword::query()->where('keyword', 'inlocuire parbriz')->value('search_volume'));
        $this->assertSame(1, DataForSeoRequest::query()->count());
    }

    public function test_budget_cap_blocks_new_calls(): void
    {
        $this->fakeApi();
        DataForSeoRequest::query()->create(['endpoint' => '/x', 'payload_hash' => str_repeat('a', 64), 'payload' => [], 'cost' => 5.0, 'status' => 'ok']);

        $this->expectException(RuntimeException::class);
        app(KeywordResearch::class)->searchVolume(['parbriz']);
    }

    public function test_unconfigured_client_refuses(): void
    {
        config(['services.dataforseo.login' => null, 'services.dataforseo.password' => null]);
        $this->assertFalse(DataForSeoClient::isConfigured());
        $this->expectException(RuntimeException::class);
        app(DataForSeoClient::class)->post('/v3/x', [[]]);
    }

    public function test_national_plan_runs_end_to_end_and_exports_json(): void
    {
        $this->fakeApi();
        config(['seo-research.expand_seeds' => ['inlocuire parbriz'], 'seo-research.serp_keywords' => ['inlocuire parbriz'], 'seo-research.competitors_to_analyze' => 2]);
        $run = SeoResearchRun::query()->create(['type' => 'national_plan', 'params' => []]);

        $run = app(ResearchRunner::class)->run($run);

        $this->assertSame('done', $run->status, (string) $run->error);
        $this->assertGreaterThan(0, (float) $run->cost);
        $this->assertTrue(SeoKeyword::query()->where('keyword', 'parbriz bmw')->exists(), 'cuvânt relevant de la competitor');
        $this->assertFalse(SeoKeyword::query()->where('keyword', 'anvelope iarna')->exists(), 'cuvânt irelevant filtrat');
        $this->assertSame(18, SeoKeyword::query()->where('keyword', 'inlocuire parbriz')->value('keyword_difficulty'));
        $this->assertSame('cluj', SeoKeyword::query()->where('keyword', 'parbriz cluj')->value('city_slug'));
        $this->assertSame([['domain' => 'competitor-parbrize.ro', 'score' => 10]], $run->summary['competitors']);
        $this->assertFileExists(storage_path("app/seo-research/run-{$run->id}.json"));
    }

    public function test_admin_pages_render_for_super_admin_only(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($admin)->get('/admin/dataforseo')->assertOk()->assertSee('Configurat');
        $this->actingAs($admin)->get('/admin/seo-keywords')->assertOk();
        $this->actingAs($admin)->get('/admin/intretinere')->assertOk();

        $provider = User::factory()->create(['role' => User::ROLE_PROVIDER, 'is_active' => true]);
        $this->actingAs($provider)->get('/admin/dataforseo')->assertForbidden();
    }

    public function test_credentials_never_rendered_in_admin_html(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($admin)->get('/admin/setari-site')->assertOk()->assertDontSee('test-pass');
        $this->actingAs($admin)->get('/admin/dataforseo')->assertDontSee('test-pass');
    }
}
