<?php

/*
 * Biblioteca de fotografii (public/assets/img/foto). Fiecare imagine are 3 variante optimizate:
 *   {slug}-720.webp (mobil), {slug}-1280.webp (desktop), {slug}-og.jpg (1200×630, pentru Google/Facebook).
 * Originalele (zeci de MB) NU intră în Git; se re-generează cu ImageMagick (vezi docs/IMAGINI.md).
 * `alt` = descriere reală a imaginii, în română, fără înșiruire de cuvinte-cheie.
 */

return [
    'library' => [
        'montaj-parbriz-ventuze' => ['alt' => 'Doi tehnicieni așază un parbriz nou cu ventuze pe un autoturism', 'h' => 853],
        'montaj-parbriz-nou-autoturism-alb' => ['alt' => 'Montaj de parbriz nou pe un autoturism alb', 'h' => 853],
        'montaj-parbriz-nou-doi-tehnicieni' => ['alt' => 'Tehnicieni care potrivesc parbrizul nou în ramă', 'h' => 853],
        'inlocuire-parbriz-fisurat-tehnician' => ['alt' => 'Tehnician cu mănuși care scoate un parbriz fisurat', 'h' => 853],
        'curatare-parbriz-dupa-montaj' => ['alt' => 'Parbriz curățat după montaj, gata de drum', 'h' => 854],
        'reparatie-ciobitura-parbriz-aplicator' => ['alt' => 'Reparație de ciobitură în parbriz cu aplicator de rășină', 'h' => 853],
        'reparatie-ciobitura-parbriz-tehnician' => ['alt' => 'Tehnician care repară o ciobitură în parbriz, văzut din habitaclu', 'h' => 853],
        'reparatie-fisura-parbriz-rasina' => ['alt' => 'Rășină aplicată de aproape pe o fisură din parbriz', 'h' => 853],
        'kit-reparatie-parbriz-aplicator' => ['alt' => 'Aplicator de rășină montat pe parbriz pentru reparația unei ciobituri', 'h' => 853],
        'ciobitura-parbriz-impact-piatra' => ['alt' => 'Ciobitură de piatră în parbriz, cu fisuri scurte în jur', 'h' => 853],
        'ciobitura-parbriz-autoturism' => ['alt' => 'Ciobitură mică pe parbrizul unui autoturism parcat', 'h' => 853],
        'fisura-lunga-parbriz' => ['alt' => 'Fisură lungă care traversează parbrizul', 'h' => 854],
        'fisura-parbriz-in-trafic' => ['alt' => 'Fisură în parbriz văzută de la volan, în trafic', 'h' => 853],
        'parbriz-ploaie-senzor' => ['alt' => 'Parbriz cu picături de ploaie, zona senzorului de ploaie', 'h' => 853],
        'parbriz-spart-autoturism-parcat' => ['alt' => 'Parbriz spart pe un autoturism parcat în fața casei', 'h' => 853],
        'parbriz-fisurat-panza-de-paianjen' => ['alt' => 'Parbriz fisurat în formă de pânză de păianjen', 'h' => 840],
        'parbriz-spart-impact-prim-plan' => ['alt' => 'Parbriz spart după un impact puternic, prim-plan', 'h' => 853],
        'parbriz-spart-trafic-oras' => ['alt' => 'Parbriz spart cu impact central, cu orașul în fundal', 'h' => 853],
        'parbriz-spart-vedere-interior' => ['alt' => 'Parbriz spart văzut din interiorul mașinii', 'h' => 853],
        'parbriz-spart-multiple-impacturi' => ['alt' => 'Parbriz cu mai multe impacturi, care trebuie înlocuit', 'h' => 960],
        'parbriz-deteriorat-dupa-accident' => ['alt' => 'Parbriz deteriorat după un accident rutier', 'h' => 853],
        'sticla-parbriz-sparta-detaliu' => ['alt' => 'Detaliu de sticlă laminată spartă, cu fisuri ramificate', 'h' => 853],
    ],

    // Paginile fixe: [imagine principală (hero + thumbnail Google), imagini în conținut].
    'pages' => [
        '/' => ['montaj-parbriz-ventuze', 'ciobitura-parbriz-impact-piatra', 'parbriz-ploaie-senzor'],
        '/servicii' => ['montaj-parbriz-nou-doi-tehnicieni'],
        '/inlocuire-parbriz-bucuresti' => ['montaj-parbriz-nou-autoturism-alb', 'ciobitura-parbriz-autoturism', 'inlocuire-parbriz-fisurat-tehnician'],
        '/inlocuire-parbriz-la-domiciliu' => ['curatare-parbriz-dupa-montaj', 'montaj-parbriz-nou-doi-tehnicieni'],
        '/reparatie-parbriz' => ['reparatie-ciobitura-parbriz-aplicator', 'reparatie-fisura-parbriz-rasina', 'ciobitura-parbriz-impact-piatra'],
        '/inlocuire-luneta-si-geamuri-laterale' => ['parbriz-spart-vedere-interior', 'montaj-parbriz-ventuze'],
        '/calibrare-adas' => ['reparatie-ciobitura-parbriz-tehnician', 'parbriz-ploaie-senzor'],
        '/parbrize-flote-firme' => ['montaj-parbriz-nou-doi-tehnicieni', 'montaj-parbriz-ventuze'],
        '/parbriz-pe-casco' => ['parbriz-deteriorat-dupa-accident', 'inlocuire-parbriz-fisurat-tehnician'],
        '/pret-inlocuire-parbriz' => ['inlocuire-parbriz-fisurat-tehnician', 'parbriz-ploaie-senzor'],
        '/inlocuire-parbriz-ilfov' => ['parbriz-spart-autoturism-parcat', 'curatare-parbriz-dupa-montaj'],
        '/despre-noi' => ['montaj-parbriz-ventuze'],
        '/contact' => ['montaj-parbriz-nou-autoturism-alb'],
        '/cerere-oferta' => ['montaj-parbriz-ventuze'],
        '/blog' => ['sticla-parbriz-sparta-detaliu'],
    ],

    // Orașe și sectoare: hero ales după poziție, ca două pagini vecine să nu aibă aceeași imagine.
    'city_heroes' => [
        'parbriz-spart-trafic-oras', 'montaj-parbriz-nou-autoturism-alb', 'parbriz-fisurat-panza-de-paianjen', 'fisura-parbriz-in-trafic',
        'montaj-parbriz-ventuze', 'parbriz-spart-impact-prim-plan', 'ciobitura-parbriz-autoturism', 'montaj-parbriz-nou-doi-tehnicieni',
        'fisura-lunga-parbriz', 'parbriz-spart-autoturism-parcat', 'inlocuire-parbriz-fisurat-tehnician', 'parbriz-spart-multiple-impacturi',
        'ciobitura-parbriz-impact-piatra', 'curatare-parbriz-dupa-montaj', 'parbriz-spart-vedere-interior', 'reparatie-ciobitura-parbriz-aplicator',
        'sticla-parbriz-sparta-detaliu', 'parbriz-ploaie-senzor',
    ],
    'city_secondary' => [
        'montaj-parbriz-nou-doi-tehnicieni', 'reparatie-ciobitura-parbriz-aplicator', 'curatare-parbriz-dupa-montaj', 'montaj-parbriz-ventuze',
        'inlocuire-parbriz-fisurat-tehnician', 'reparatie-fisura-parbriz-rasina', 'montaj-parbriz-nou-autoturism-alb', 'kit-reparatie-parbriz-aplicator',
    ],

    'posts' => [
        'ciobitura-parbriz-ce-faci' => 'ciobitura-parbriz-impact-piatra',
        'parbriz-fisurat-reparatie-sau-inlocuire' => 'fisura-lunga-parbriz',
        'kit-reparatie-parbriz-merita' => 'kit-reparatie-parbriz-aplicator',
        'parbriz-original-oem-aftermarket' => 'montaj-parbriz-ventuze',
        'cat-dureaza-schimbarea-parbrizului' => 'montaj-parbriz-nou-doi-tehnicieni',
        'calibrare-adas-dupa-schimbarea-parbrizului' => 'reparatie-ciobitura-parbriz-tehnician',
    ],
];
