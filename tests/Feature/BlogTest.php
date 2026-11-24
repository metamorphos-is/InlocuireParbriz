<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Support\SeoOverlap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_and_posts_render_with_schema_and_internal_links(): void
    {
        $this->seed();
        $posts = Post::query()->published()->get();
        $this->assertGreaterThanOrEqual(6, $posts->count());

        $index = $this->get('/blog')->assertOk()->getContent();
        foreach ($posts as $p) {
            $this->assertStringContainsString($p->url(), $index);
            $html = $this->get('/blog/'.$p->slug)->assertOk()->getContent();
            $this->assertStringContainsString('"BlogPosting"', $html);
            $this->assertStringContainsString('href="'.$p->related_service.'"', $html);
            $this->assertStringNotContainsString('marketplace', strtolower($html));
        }

        $this->get('/blog?categorie=reparatii')->assertOk()->assertSee('Reparații și avarii');
        $this->get('/sitemap.xml')->assertOk()->assertSee('/blog/'.$posts->first()->slug);
    }

    public function test_unpublished_and_future_posts_are_hidden(): void
    {
        $this->seed();
        Post::query()->where('slug', 'kit-reparatie-parbriz-merita')->update(['is_published' => false]);
        Post::query()->where('slug', 'parbriz-fisurat-reparatie-sau-inlocuire')->update(['published_at' => now()->addDay()]);

        $this->get('/blog/kit-reparatie-parbriz-merita')->assertNotFound();
        $this->get('/blog/parbriz-fisurat-reparatie-sau-inlocuire')->assertNotFound();
        $this->get('/blog')->assertDontSee('kit-reparatie-parbriz-merita');
    }

    public function test_markdown_strips_raw_html(): void
    {
        $post = new Post(['body' => "## Titlu\n\n<script>alert(1)</script> text [link](/reparatie-parbriz)"]);
        $html = $post->html();
        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('<h2 id="titlu">', $html);
    }

    public function test_seeded_content_has_no_keyword_cannibalization(): void
    {
        $this->seed();
        $this->assertSame([], SeoOverlap::conflicts());

        Post::query()->first()->update(['primary_keyword' => 'Reparație parbriz']);
        $this->assertArrayHasKey('reparatie parbriz', SeoOverlap::conflicts());
        $this->assertNotNull(SeoOverlap::warning('reparatie parbriz', 'post', 999));
    }

    public function test_admin_blog_and_seo_check_pages_load(): void
    {
        $this->seed();
        $admin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $this->actingAs($admin)->get('/admin/posts')->assertOk();
        $this->actingAs($admin)->get('/admin/verificare-seo')->assertOk()->assertSee('Nicio suprapunere');
    }
}
