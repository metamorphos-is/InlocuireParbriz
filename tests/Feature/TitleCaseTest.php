<?php

namespace Tests\Feature;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Titlurile (<title>, H1) se scriu ca în română: majusculă doar la începutul propoziției,
 * la nume proprii (orașe, sectoare) și la acronime (ADAS, CASCO). Fără „Title Case”.
 */
class TitleCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_titles_and_h1_are_sentence_case(): void
    {
        $this->seed();

        $allowed = ['București', 'Ilfov', 'Sector', 'Sectorul', 'România'];
        foreach (City::query()->get(['name', 'county']) as $c) {
            array_push($allowed, $c->name, ...preg_split('/[\s-]+/u', $c->name), ...preg_split('/[\s-]+/u', (string) $c->county));
        }

        foreach (\App\Models\VehiclePage::query()->get(['brand_name', 'model_name']) as $v) {
            array_push($allowed, ...preg_split('/[\s-]+/u', trim($v->brand_name.' '.$v->model_name)));
        }
        array_push($allowed, 'VW', 'Quickclear', 'Opel', 'Eye', 'Stepway');

        preg_match_all('#<loc>(.*?)</loc>#', $this->get('/sitemap.xml')->getContent(), $m);
        $paths = array_merge(array_map(fn ($u) => parse_url($u, PHP_URL_PATH) ?: '/', $m[1]), ['/cerere-oferta', '/pagina-inexistenta']);

        $bad = [];
        foreach (array_unique($paths) as $path) {
            $html = $this->get($path)->getContent();
            preg_match('#<title>(.*?)</title>#s', $html, $t);
            preg_match('#<h1[^>]*>(.*?)</h1>#s', $html, $h);
            foreach ([$t[1] ?? '', strip_tags($h[1] ?? '')] as $text) {
                $text = html_entity_decode(trim($text));
                foreach (preg_split('/\s*[|:?!.–—]\s*/u', $text) as $segment) {
                    $words = preg_split('/[\s,()]+/u', trim($segment), -1, PREG_SPLIT_NO_EMPTY);
                    foreach (array_slice($words, 1) as $w) {
                        if (preg_match('/^\p{Lu}\p{Ll}/u', $w) && ! in_array($w, $allowed, true)) {
                            $bad[] = "{$path}: „{$text}” ({$w})";
                        }
                    }
                }
            }
        }

        $this->assertSame([], array_values(array_unique($bad)));
    }
}
