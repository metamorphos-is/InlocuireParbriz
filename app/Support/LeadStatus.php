<?php

namespace App\Support;

/**
 * Etichete RO + grupări de status pentru lead-uri (folosite de panourile Filament).
 */
final class LeadStatus
{
    /** @var array<string,string> */
    public const LABELS = [
        'noua' => 'Nouă',
        'in_analiza' => 'În analiză',
        'atribuita' => 'Atribuită',
        'contactat' => 'Contactat',
        'programata' => 'Programată',
        'in_desfasurare' => 'În desfășurare',
        'finalizata' => 'Finalizată',
        'refuzata' => 'Refuzată',
        'anulata' => 'Anulată',
        'arhivata' => 'Arhivată',
    ];

    /** Lead-uri considerate „deschise” (nerezolvate). */
    public const OPEN = ['noua', 'in_analiza', 'atribuita', 'contactat', 'programata', 'in_desfasurare'];

    /** Prestatorul: lead primit, nepreluat încă. */
    public const PROVIDER_RECEIVED = ['atribuita'];

    /** Prestatorul: lucrări în curs. */
    public const PROVIDER_IN_PROGRESS = ['contactat', 'programata', 'in_desfasurare'];

    /** Prestatorul: încheiate. */
    public const PROVIDER_COMPLETED = ['finalizata', 'refuzata'];

    /** Statusurile pe care prestatorul le poate seta. */
    public const PROVIDER_SETTABLE = ['contactat', 'programata', 'in_desfasurare', 'finalizata', 'refuzata'];

    public static function label(?string $status): string
    {
        return self::LABELS[$status] ?? (string) $status;
    }

    public static function color(?string $status): string
    {
        return match ($status) {
            'noua' => 'danger',
            'in_analiza', 'atribuita' => 'warning',
            'contactat', 'programata', 'in_desfasurare' => 'info',
            'finalizata' => 'success',
            default => 'gray',
        };
    }

    /** @return array<string,string> */
    public static function options(?array $only = null): array
    {
        return $only === null
            ? self::LABELS
            : array_intersect_key(self::LABELS, array_flip($only));
    }
}
