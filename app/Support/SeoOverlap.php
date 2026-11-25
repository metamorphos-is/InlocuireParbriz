<?php

namespace App\Support;

use App\Models\City;
use App\Models\Post;
use Illuminate\Support\Str;
use Throwable;

/**
 * Verificare anti-canibalizare: strânge cuvintele-cheie ale tuturor paginilor (hartă fixă, orașe, blog)
 * și arată unde același cuvânt e țintit de mai multe URL-uri.
 */
final class SeoOverlap
{
    public static function normalize(?string $keyword): string
    {
        $k = Str::lower(Str::ascii(trim((string) $keyword)));

        return preg_replace('/\s+/', ' ', $k);
    }

    /** @return array<int,array{keyword:string,original:string,url:string,label:string,type:string,id:?int,role:string}> */
    public static function registry(): array
    {
        $rows = [];
        $add = function (?string $kw, string $url, string $label, string $type, ?int $id, string $role) use (&$rows) {
            if (blank($kw)) {
                return;
            }
            $rows[] = ['keyword' => self::normalize($kw), 'original' => trim($kw), 'url' => $url, 'label' => $label, 'type' => $type, 'id' => $id, 'role' => $role];
        };

        foreach (config('seo-map', []) as $url => $page) {
            $add($page['primary'] ?? null, $url, $page['label'], 'page', null, 'principal');
            foreach ($page['secondary'] ?? [] as $kw) {
                $add($kw, $url, $page['label'], 'page', null, 'secundar');
            }
        }

        try {
            foreach (City::query()->withPublicPage()->get(['id', 'name', 'slug', 'primary_keyword', 'secondary_keywords']) as $c) {
                $url = '/inlocuire-parbriz-'.$c->slug;
                $add($c->primary_keyword, $url, 'Oraș: '.$c->name, 'city', $c->id, 'principal');
                foreach ((array) $c->secondary_keywords as $kw) {
                    $add($kw, $url, 'Oraș: '.$c->name, 'city', $c->id, 'secundar');
                }
            }
            foreach (Post::query()->get(['id', 'title', 'slug', 'primary_keyword', 'secondary_keywords']) as $p) {
                $url = '/blog/'.$p->slug;
                $add($p->primary_keyword, $url, 'Blog: '.$p->title, 'post', $p->id, 'principal');
                foreach ((array) $p->secondary_keywords as $kw) {
                    $add($kw, $url, 'Blog: '.$p->title, 'post', $p->id, 'secundar');
                }
            }
            foreach (\App\Models\VehiclePage::query()->get() as $v) {
                $add($v->primary_keyword, $v->path(), 'Auto: '.$v->fullName(), 'vehicle', $v->id, 'principal');
                foreach ((array) $v->secondary_keywords as $kw) {
                    $add($kw, $v->path(), 'Auto: '.$v->fullName(), 'vehicle', $v->id, 'secundar');
                }
            }
        } catch (Throwable) {
            // Tabelele pot lipsi înainte de migrări.
        }

        return $rows;
    }

    /**
     * Cuvinte folosite de cel puțin două URL-uri diferite, unde măcar unul îl are ca principal.
     *
     * @return array<string,array<int,array<string,mixed>>>
     */
    public static function conflicts(): array
    {
        $byKeyword = collect(self::registry())->groupBy('keyword');

        return $byKeyword
            ->filter(fn ($rows) => $rows->pluck('url')->unique()->count() > 1 && $rows->contains('role', 'principal'))
            ->map(fn ($rows) => $rows->values()->all())
            ->sortKeys()
            ->all();
    }

    /** Avertisment pentru formularele din admin; null dacă nu există suprapunere. */
    public static function warning(string $keyword, string $type, ?int $id): ?string
    {
        $k = self::normalize($keyword);
        if ($k === '') {
            return null;
        }

        $others = collect(self::registry())
            ->filter(fn ($r) => $r['keyword'] === $k && ! ($r['type'] === $type && $r['id'] === $id))
            ->map(fn ($r) => "{$r['label']} ({$r['url']}, {$r['role']})")
            ->unique()->values();

        return $others->isEmpty() ? null : '⚠ Cuvântul e folosit deja de: '.$others->implode('; ').'. Alege alt cuvânt principal sau leagă pagina de cea existentă.';
    }
}
