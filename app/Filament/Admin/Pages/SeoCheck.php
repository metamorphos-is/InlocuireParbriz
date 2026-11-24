<?php

namespace App\Filament\Admin\Pages;

use App\Models\City;
use App\Models\Post;
use App\Support\SeoOverlap;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Throwable;

/** Verificare SEO: canibalizare între pagini, titluri/descrieri lipsă sau prea lungi, linkuri interne. */
class SeoCheck extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Verificare SEO';

    protected static ?string $title = 'Verificare SEO';

    protected static ?string $slug = 'verificare-seo';

    protected string $view = 'filament.admin.pages.seo-check';

    public function getViewData(): array
    {
        $issues = [];
        $check = function (string $label, string $url, ?string $primary, ?string $title, ?string $meta, bool $titleIsH1 = false) use (&$issues) {
            if (blank($primary)) {
                $issues[] = [$label, $url, 'Fără cuvânt-cheie principal'];
            }
            $len = mb_strlen((string) $title);
            if (! $titleIsH1 && $len === 0) {
                $issues[] = [$label, $url, 'Fără titlu SEO (se folosește cel implicit)'];
            } elseif ($len > 70) {
                $issues[] = [$label, $url, "Titlu SEO lung ({$len} caractere, ideal ≤ 60)"];
            }
            $m = mb_strlen((string) $meta);
            if ($m === 0) {
                $issues[] = [$label, $url, 'Fără meta descriere'];
            } elseif ($m < 70 || $m > 170) {
                $issues[] = [$label, $url, "Meta descriere de {$m} caractere (ideal 140–160)"];
            }
        };

        $links = [];
        try {
            foreach (City::query()->withPublicPage()->orderBy('sort_order')->get() as $c) {
                $check('Oraș: '.$c->name, '/inlocuire-parbriz-'.$c->slug, $c->primary_keyword, $c->seo_title, $c->meta_description);
            }
            foreach (Post::query()->orderByDesc('published_at')->get() as $p) {
                $url = '/blog/'.$p->slug;
                $check('Blog: '.$p->title, $url, $p->primary_keyword, $p->seo_title ?: $p->title, $p->meta_description, true);
                $body = (string) $p->body;
                if (! preg_match('/\]\(\/[a-z0-9]/', $body)) {
                    $links[] = ['Blog: '.$p->title, $url, 'Nu are niciun link intern în text. Adaugă un link spre '.($p->related_service ?: 'pagina de serviciu potrivită').'.'];
                } elseif ($p->related_service && ! str_contains($body, ']('.$p->related_service.')')) {
                    $links[] = ['Blog: '.$p->title, $url, "Nu trimite în text spre pagina legată ({$p->related_service})."];
                }
            }
        } catch (Throwable) {
            // Tabele lipsă înainte de migrări.
        }

        return [
            'conflicts' => SeoOverlap::conflicts(),
            'issues' => $issues,
            'links' => $links,
            'total' => count(SeoOverlap::registry()),
        ];
    }
}
