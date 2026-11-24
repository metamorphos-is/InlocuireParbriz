<?php

namespace App\Support;

use App\Models\SiteSetting;
use Throwable;

/** Comutatorul de lansare: cât timp e activ „noindex” (Setări site → SEO), site-ul nu se indexează. */
final class Seo
{
    public static function noindex(): bool
    {
        try {
            return (bool) (((array) SiteSetting::getValue('seo', []))['noindex'] ?? true);
        } catch (Throwable) {
            return true;
        }
    }

    /** URL canonic pentru o cale: mereu https://inlocuireparbriz.ro/..., fără parametri (în afară de ?page=N > 1). */
    public static function canonical(?string $path = null): string
    {
        $base = rtrim((string) config('inlocuireparbriz.canonical_url', config('app.url')), '/');
        $path = trim($path ?? request()->path(), '/');
        $url = $base.($path === '' ? '/' : '/'.$path);
        $page = (int) request()->query('page', 1);
        $cat = request()->query('categorie');
        $q = array_filter(['categorie' => is_string($cat) && $path === 'blog' ? $cat : null, 'page' => $page > 1 ? $page : null]);

        return $q ? $url.'?'.http_build_query($q) : $url;
    }

    /** Codul de verificare Google Search Console (doar codul din meta tag), setat din admin → Setări site → SEO. */
    public static function googleVerification(): ?string
    {
        try {
            $v = trim((string) (((array) SiteSetting::getValue('seo', []))['google_verification'] ?? ''));
        } catch (Throwable) {
            return null;
        }
        if (preg_match('/content="([^"]+)"/', $v, $m)) {
            $v = $m[1];
        }

        return preg_match('/^[A-Za-z0-9_\-]{10,100}$/', $v) ? $v : null;
    }

    /** ID Google Analytics 4 (G-XXXX), gol = fără tracking. Se încarcă doar după acordul pentru cookie-uri. */
    public static function ga4(): ?string
    {
        try {
            $id = trim((string) (((array) SiteSetting::getValue('tracking', []))['ga4_id'] ?? ''));
        } catch (Throwable) {
            return null;
        }

        return preg_match('/^G-[A-Z0-9]{4,16}$/', $id) ? $id : null;
    }
}
