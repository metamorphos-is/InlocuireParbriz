<?php

/*
 * Planul de cercetare națională DataForSEO (România, limba română).
 * Editabil fără cod nou: adaugă cuvinte de pornire sau orașe și rulează din nou planul din admin.
 */

return [
    'location_code' => 2642, // România
    'language_code' => 'ro',

    // Cuvinte de pornire (cu și fără diacritice — oamenii caută des fără).
    'seeds' => [
        'înlocuire parbriz', 'inlocuire parbriz', 'schimbare parbriz', 'schimb parbriz', 'montaj parbriz',
        'parbriz', 'parbrize', 'parbrize auto', 'parbriz auto', 'service parbrize', 'service parbriz',
        'reparatie parbriz', 'reparatii parbriz', 'reparație parbriz', 'ciobitura parbriz', 'fisura parbriz',
        'parbriz fisurat', 'parbriz spart', 'reparatie ciobitura parbriz',
        'inlocuire luneta', 'schimbare luneta', 'luneta auto',
        'inlocuire geam lateral', 'geam lateral auto', 'geam portiera', 'inlocuire geam auto', 'geamuri auto', 'sticla auto',
        'parbriz la domiciliu', 'inlocuire parbriz la domiciliu', 'parbriz cu deplasare', 'montaj parbriz la domiciliu',
        'parbriz cu senzor ploaie', 'inlocuire parbriz cu senzori', 'parbriz cu camera',
        'calibrare adas', 'calibrare camera parbriz', 'calibrare camera adas',
        'pret parbriz', 'pret inlocuire parbriz', 'cat costa un parbriz', 'cat costa schimbarea parbrizului', 'parbriz ieftin',
        'parbriz casco', 'inlocuire parbriz casco', 'schimbare parbriz casco', 'parbriz asigurare',
        'parbriz original', 'parbriz aftermarket', 'parbriz incalzit',
    ],

    // Cuvinte pentru care cerem sugestii și cuvinte înrudite (extind baza de date).
    'expand_seeds' => [
        'inlocuire parbriz', 'schimbare parbriz', 'parbrize auto', 'reparatie parbriz',
        'inlocuire luneta', 'geam lateral auto', 'parbriz la domiciliu', 'pret parbriz', 'calibrare adas',
    ],

    // Cuvinte pentru care analizăm SERP-ul (top 10) — de aici ies competitorii.
    'serp_keywords' => [
        'inlocuire parbriz', 'schimbare parbriz', 'parbrize auto', 'montaj parbriz', 'reparatie parbriz',
        'pret parbriz', 'parbriz la domiciliu', 'inlocuire luneta', 'calibrare adas',
        'inlocuire parbriz bucuresti', 'parbriz cluj', 'parbriz timisoara', 'parbriz iasi', 'parbriz constanta',
    ],

    // Câți competitori analizăm în profunzime (cuvintele pe care se poziționează).
    'competitors_to_analyze' => 6,
    'competitor_keywords_limit' => 400,
    'expand_limit' => 300,

    // Toate reședințele de județ + câteva localități mari. Cheia = forma folosită în căutări (fără diacritice).
    'cities' => [
        'bucuresti' => 'București', 'cluj' => 'Cluj-Napoca', 'timisoara' => 'Timișoara', 'iasi' => 'Iași',
        'constanta' => 'Constanța', 'brasov' => 'Brașov', 'craiova' => 'Craiova', 'oradea' => 'Oradea',
        'sibiu' => 'Sibiu', 'ploiesti' => 'Ploiești', 'galati' => 'Galați', 'braila' => 'Brăila',
        'arad' => 'Arad', 'pitesti' => 'Pitești', 'bacau' => 'Bacău', 'targu mures' => 'Târgu Mureș',
        'baia mare' => 'Baia Mare', 'suceava' => 'Suceava', 'buzau' => 'Buzău', 'ramnicu valcea' => 'Râmnicu Vâlcea',
        'satu mare' => 'Satu Mare', 'botosani' => 'Botoșani', 'piatra neamt' => 'Piatra Neamț', 'focsani' => 'Focșani',
        'bistrita' => 'Bistrița', 'deva' => 'Deva', 'alba iulia' => 'Alba Iulia', 'targoviste' => 'Târgoviște',
        'targu jiu' => 'Târgu Jiu', 'drobeta turnu severin' => 'Drobeta-Turnu Severin', 'slatina' => 'Slatina',
        'tulcea' => 'Tulcea', 'resita' => 'Reșița', 'zalau' => 'Zalău', 'vaslui' => 'Vaslui', 'giurgiu' => 'Giurgiu',
        'calarasi' => 'Călărași', 'slobozia' => 'Slobozia', 'alexandria' => 'Alexandria', 'miercurea ciuc' => 'Miercurea Ciuc',
        'sfantu gheorghe' => 'Sfântu Gheorghe', 'hunedoara' => 'Hunedoara', 'medias' => 'Mediaș', 'voluntari' => 'Voluntari',
        'ilfov' => 'Ilfov',
    ],

    // Tipare de căutare locală, aplicate fiecărui oraș.
    'city_patterns' => [
        'parbriz {city}', 'parbrize {city}', 'inlocuire parbriz {city}', 'schimbare parbriz {city}',
    ],

    'sector_patterns' => [
        'parbriz sector {n}', 'inlocuire parbriz sector {n}',
    ],
];
