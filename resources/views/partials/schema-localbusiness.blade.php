{{-- Schema.org: o singură organizație (@id stabil). Fără rating, recenzii, program sau adrese inventate.
     Datele de contact intră în schema DOAR când în admin „Date de test” e dezactivat. --}}
@php
    $company = \App\Support\Company::all();
    $real = ! \App\Support\Company::isTest();
    $orgId = url('/').'#organization';

    $org = [
        '@type' => 'Organization',
        '@id' => $orgId,
        'name' => $company['brand'],
        'url' => url('/'),
        'logo' => asset('assets/img/favicon.svg'),
        'description' => 'Platformă pentru înlocuirea și repararea parbrizelor, lunetelor și geamurilor auto: cererea ta ajunge la un atelier partener verificat din zona ta.',
    ];
    if ($real) {
        $org = array_merge($org, array_filter([
            'legalName' => $company['legal_name'] ?: null,
            'vatID' => $company['cui'] ?: null,
            'email' => $company['email'] ?: null,
            'telephone' => \App\Support\Company::phoneHref(),
        ]));
        if (filled($company['phone'] ?? null)) {
            $org['contactPoint'] = [[
                '@type' => 'ContactPoint',
                'telephone' => \App\Support\Company::phoneHref(),
                'contactType' => 'customer service',
                'areaServed' => 'RO',
                'availableLanguage' => 'ro',
            ]];
        }
    }

    $graph = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $org,
            [
                '@type' => 'WebSite',
                '@id' => url('/').'#website',
                'url' => url('/'),
                'name' => $company['brand'],
                'publisher' => ['@id' => $orgId],
                'inLanguage' => 'ro-RO',
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
