<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexingTest extends TestCase
{
    use RefreshDatabase;

    private function launch(): void
    {
        $this->seed();
        SiteSetting::setValue('seo', ['noindex' => false, 'google_verification' => '<meta name="google-site-verification" content="abcDEF123_xyz-987654" />']);
    }

    public function test_launched_site_is_indexable_with_clean_canonicals(): void
    {
        $this->launch();

        $res = $this->get('/inlocuire-parbriz-brasov?v=5&utm_source=x');
        $res->assertOk()->assertHeaderMissing('X-Robots-Tag');
        $html = $res->getContent();
        $this->assertStringContainsString('<meta name="robots" content="index, follow, max-image-preview:large', $html);
        $this->assertStringContainsString('<link rel="canonical" href="https://inlocuireparbriz.ro/inlocuire-parbriz-brasov">', $html);
        $this->assertStringContainsString('<meta name="google-site-verification" content="abcDEF123_xyz-987654">', $html);

        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap: ')->assertDontSee("Disallow: /\n", false)->assertSee('Disallow: /admin');
        $this->get('/admin/login')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertStringContainsString('content="noindex, nofollow"', $this->get('/cerere-oferta/multumim')->getContent());
    }

    public function test_sitemap_pages_have_unique_titles_and_descriptions(): void
    {
        $this->launch();
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();
        $this->assertStringContainsString('<lastmod>', $xml);
        preg_match_all('#<loc>(.*?)</loc>#', $xml, $m);
        $this->assertGreaterThan(40, count($m[1]));

        $titles = $descs = [];
        foreach ($m[1] as $loc) {
            $this->assertStringStartsWith('https://inlocuireparbriz.ro/', $loc);
            $path = parse_url($loc, PHP_URL_PATH) ?: '/';
            $html = $this->get($path)->assertOk()->getContent();
            preg_match('#<title>(.*?)</title>#s', $html, $t);
            preg_match('#<meta name="description" content="([^"]*)"#', $html, $d);
            $this->assertNotEmpty($d[1] ?? '', $path.' fără descriere');
            $titles[$t[1]][] = $path;
            $descs[$d[1]][] = $path;
            $this->assertSame(1, preg_match_all('#<h1[\s>]#', $html), $path.' trebuie să aibă exact un H1');
        }
        $this->assertSame([], array_filter($titles, fn ($p) => count($p) > 1), 'Titluri duplicate');
        $this->assertSame([], array_filter($descs, fn ($p) => count($p) > 1), 'Descrieri duplicate');
    }

    public function test_test_company_phone_is_hidden_on_public_site(): void
    {
        $this->launch();
        $this->get('/contact')->assertDontSee('0700 000 000')->assertDontSee('Firma Exemplu');
    }
}
