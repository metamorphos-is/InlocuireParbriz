<?php

namespace App\Support;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Secretele din site_settings (parolă SMTP, cheie API SMSO) se salvează criptate
 * cu prefixul "enc:". Cititorii (mailer/SMS) trebuie să folosească reveal().
 *
 * Exemplu: SettingSecret::reveal(SiteSetting::getValue('smtp')['password'] ?? null)
 */
final class SettingSecret
{
    private const PREFIX = 'enc:';

    public static function protect(?string $plain): ?string
    {
        if ($plain === null || $plain === '') {
            return $plain;
        }

        return self::PREFIX.Crypt::encryptString($plain);
    }

    public static function reveal(?string $stored): ?string
    {
        if ($stored === null || $stored === '' || ! str_starts_with($stored, self::PREFIX)) {
            return $stored; // valoare veche necriptată sau goală
        }

        try {
            return Crypt::decryptString(substr($stored, strlen(self::PREFIX)));
        } catch (DecryptException) {
            return null;
        }
    }

    public static function isSet(?string $stored): bool
    {
        return $stored !== null && $stored !== '';
    }
}
