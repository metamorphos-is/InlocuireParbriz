{{-- Schema fără telefon, rating, CUI sau sedii inventate. --}}
@php
    $orgId = url('/').'#organization';
    $bizId = url('/').'#localbusiness';
    $graph = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $orgId,
                'name' => 'Înlocuire Parbriz',
                'url' => url('/'),
                'logo' => asset('assets/img/favicon.svg'),
            ],
            [
                '@type' => 'LocalBusiness',
                '@id' => $bizId,
                'name' => 'Înlocuire Parbriz',
                'url' => url('/'),
                'description' => 'Înlocuire și reparații parbrize în București — montaj la domiciliu când condițiile permit, lunetă, geamuri laterale și oferte clare.',
                'areaServed' => [
                    ['@type' => 'City', 'name' => 'București'],
                    ['@type' => 'AdministrativeArea', 'name' => 'Ilfov'],
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'București',
                    'addressCountry' => 'RO',
                ],
                'parentOrganization' => ['@id' => $orgId],
                'knowsLanguage' => 'ro',
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/').'#website',
                'url' => url('/'),
                'name' => 'Înlocuire Parbriz',
                'publisher' => ['@id' => $orgId],
                'inLanguage' => 'ro-RO',
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
