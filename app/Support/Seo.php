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
