<?php

namespace Tests\Feature;

use App\Support\Img;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_library_image_has_all_optimized_variants_under_size_limits(): void
    {
        foreach (array_keys(config('images.library')) as $slug) {
            foreach (['-720.webp' => 120_000, '-1280.webp' => 260_000, '-og.jpg' => 200_000] as $suffix => $max) {
                $file = public_path('assets/img/foto/'.$slug.$suffix);
                $this->assertFileExists($file);
                $this->assertLessThan($max, filesize($file), $slug.$suffix.' e prea mare');
            }
        }
        foreach (array_merge(...array_values(config('images.pages'))) as $slug) {
            $this->assertTrue(Img::exists($slug), $slug);
        }
    }

    public function test_pages_have_og_image_alt_text_and_sitemap_images(): void
    {
        $this->seed();
        foreach (['/', '/inlocuire-parbriz-brasov', '/reparatie-parbriz', '/inlocuire-parbriz-bucuresti/sector-3', '/blog/kit-reparatie-parbriz-merita'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertMatchesRegularExpression('#<meta property="og:image" content="[^"]+-og\.jpg">#', $html, $path);
            $this->assertStringContainsString('twitter:card', $html);
            $this->assertDoesNotMatchRegularExpression('#<img(?![^>]*\balt="[^"]+")[^>]*>#', $html, $path.' are imagine fără alt');
        }
        $this->get('/inlocuire-parbriz-brasov')->assertDontSee('ip-coverage__icon', false)->assertSee('ip-photo--hero', false);
        $this->get('/sitemap.xml')->assertSee('<image:loc>', false);
    }
}
