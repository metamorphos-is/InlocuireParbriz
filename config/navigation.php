<?php

/*
 * Meniul principal (mega-menu). Regulă: fiecare link duce la o pagină publicată.
 * Când se publică pagini noi (orașe, servicii, blog), se adaugă aici.
 */

return [
    'servicii' => [
        'label' => 'Servicii',
        'icon' => 'wrench',
        'title' => 'Servicii pentru sticlă auto',
        'description' => 'Înlocuire și reparație parbriz, lunetă și geamuri laterale — pe tipul corect de sticlă pentru mașina ta.',
        'all' => ['label' => 'Toate serviciile', 'url' => '/servicii'],
        'groups' => [
            [
                'title' => 'Înlocuire',
                'items' => [
                    ['icon' => 'windshield', 'label' => 'Înlocuire parbriz', 'hint' => 'Parbriz nou, potrivit modelului și dotărilor', 'url' => '/inlocuire-parbriz-bucuresti'],
                    ['icon' => 'rear', 'label' => 'Lunetă și geamuri laterale', 'hint' => 'Geam spate, portieră sau geam fix', 'url' => '/inlocuire-luneta-si-geamuri-laterale'],
                    ['icon' => 'home', 'label' => 'Montaj la domiciliu', 'hint' => 'La tine acasă sau la birou, când condițiile permit', 'url' => '/inlocuire-parbriz-la-domiciliu'],
                ],
            ],
            [
                'title' => 'Reparații și tehnic',
                'items' => [
                    ['icon' => 'chip', 'label' => 'Reparație ciobitură', 'hint' => 'Evaluăm dacă se poate repara în loc de înlocuire', 'url' => '/reparatie-parbriz'],
                    ['icon' => 'camera', 'label' => 'Calibrare ADAS', 'hint' => 'Camera și senzorii după schimbarea parbrizului', 'url' => '/calibrare-adas'],
                ],
            ],
            [
                'title' => 'Plată și situații speciale',
                'items' => [
                    ['icon' => 'doc', 'label' => 'Parbriz prin CASCO', 'hint' => 'Ofertă și documente pentru dosarul de daună', 'url' => '/parbriz-pe-casco'],
                    ['icon' => 'truck', 'label' => 'Firme și flote', 'hint' => 'Cereri pentru mai multe vehicule', 'url' => '/parbrize-flote-firme'],
                    ['icon' => 'tag', 'label' => 'Prețuri', 'hint' => 'Ce influențează costul unui parbriz', 'url' => '/pret-inlocuire-parbriz'],
                ],
            ],
        ],
        'footer' => ['text' => 'Nu știi ce geam ai nevoie? Trimite datele mașinii și identificăm noi sticla potrivită.', 'cta' => 'Cere ofertă', 'url' => '/cerere-oferta'],
    ],

    'locatii' => [
        'label' => 'Locații',
        'icon' => 'pin',
        'regions' => [
            [
                'key' => 'bucuresti',
                'label' => 'București',
                'icon' => 'building',
                'title' => 'Înlocuire parbriz în București',
                'description' => 'Toate cele 6 sectoare, inclusiv montaj la adresă.',
                'main' => ['label' => 'Înlocuire parbriz București', 'url' => '/inlocuire-parbriz-bucuresti'],
                'items' => [
                    ['label' => 'Sector 1', 'hint' => 'Dorobanți, Aviatorilor, Băneasa', 'url' => '/inlocuire-parbriz-bucuresti/sector-1'],
                    ['label' => 'Sector 2', 'hint' => 'Colentina, Obor, Tei, Floreasca', 'url' => '/inlocuire-parbriz-bucuresti/sector-2'],
                    ['label' => 'Sector 3', 'hint' => 'Titan, Dristor, Vitan', 'url' => '/inlocuire-parbriz-bucuresti/sector-3'],
                    ['label' => 'Sector 4', 'hint' => 'Berceni, Tineretului, Olteniței', 'url' => '/inlocuire-parbriz-bucuresti/sector-4'],
                    ['label' => 'Sector 5', 'hint' => 'Cotroceni, Rahova, 13 Septembrie', 'url' => '/inlocuire-parbriz-bucuresti/sector-5'],
                    ['label' => 'Sector 6', 'hint' => 'Drumul Taberei, Militari, Giulești', 'url' => '/inlocuire-parbriz-bucuresti/sector-6'],
                ],
            ],
            [
                'key' => 'ilfov',
                'label' => 'Ilfov',
                'icon' => 'map',
                'title' => 'Înlocuire parbriz în Ilfov',
                'description' => 'Voluntari, Otopeni, Pipera, Chiajna, Bragadiru și alte localități — disponibilitatea se confirmă după adresă.',
                'main' => ['label' => 'Înlocuire parbriz Ilfov', 'url' => '/inlocuire-parbriz-ilfov'],
                'items' => [],
            ],
            [
                'key' => 'alte',
                'label' => 'Alte orașe',
                'icon' => 'grid',
                'title' => 'Alte orașe din România',
                'description' => 'Lucrăm cu ateliere partenere verificate în tot mai multe orașe. Trimite cererea și îți confirmăm disponibilitatea în zona ta.',
                'main' => ['label' => 'Trimite cererea pentru orașul tău', 'url' => '/cerere-oferta?zona=alt_oras'],
                'items' => [],
            ],
        ],
        'card' => ['kicker' => 'Zone deservite', 'title' => 'București, Ilfov și în curs de extindere', 'url' => '/inlocuire-parbriz-bucuresti'],
    ],

    'simple' => [
        ['label' => 'Prețuri', 'icon' => 'tag', 'url' => '/pret-inlocuire-parbriz'],
        ['label' => 'Despre noi', 'icon' => 'info', 'url' => '/despre-noi'],
        ['label' => 'Contact', 'icon' => 'mail', 'url' => '/contact'],
    ],
];
