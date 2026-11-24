<?php

namespace App\Support;

use App\Models\SiteSetting;
use Throwable;

/**
 * Datele firmei afișate pe site (footer, contact, Schema.org). Editabile din admin → Setări site.
 * Cât timp `is_test` e activ, datele se afișează (ca să vezi aspectul), dar NU intră în Schema.org.
 */
final class Company
{
    public const DEFAULTS = [
        'brand' => 'Înlocuire Parbriz',
        'legal_name' => 'Firma Exemplu SRL',
        'cui' => 'RO00000000',
        'reg_com' => 'J40/0000/2026',
        'phone' => '0700 000 000',
        'whatsapp' => '',
        'email' => 'contact@inlocuireparbriz.ro',
        'address' => 'București',
        'hours' => 'Luni – Vineri, 09:00 – 18:00',
        'is_test' => true,
    ];

    /** @return array<string,mixed> */
    public static function all(): array
    {
        try {
            $stored = (array) SiteSetting::getValue('company', []);
        } catch (Throwable) {
            $stored = [];
        }

        return array_merge(self::DEFAULTS, array_filter($stored, fn ($v) => $v !== null));
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function isTest(): bool
    {
        return (bool) self::get('is_test', true);
    }

    /** Telefon în format E.164 pentru link-uri tel: (ex. +40700000000). */
    public static function phoneHref(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) self::get('phone'));
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            $digits = '40'.substr($digits, 1);
        }

        return '+'.$digits;
    }
}
