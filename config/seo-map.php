<?php

/*
 * Harta cuvânt-cheie → URL pentru paginile fixe (vezi docs/SEO-STRATEGIE.md §5).
 * Paginile de oraș și articolele de blog își au cuvintele în baza de date (admin).
 * Verificarea din admin (SEO & Conținut → Verificare SEO) le compară pe toate ca să nu se canibalizeze.
 */

return [
    '/' => ['label' => 'Prima pagină', 'primary' => 'înlocuire parbriz', 'secondary' => ['schimbare parbriz', 'montaj parbriz', 'parbrize auto', 'înlocuire parbriz preț']],
    '/inlocuire-parbriz-bucuresti' => ['label' => 'București', 'primary' => 'parbrize București', 'secondary' => ['parbriz București', 'înlocuire parbriz București', 'reparații parbrize București']],
    '/reparatie-parbriz' => ['label' => 'Reparație parbriz', 'primary' => 'reparație parbriz', 'secondary' => ['reparații parbrize', 'reparații parbriz', 'reparație fisură parbriz']],
    '/inlocuire-parbriz-la-domiciliu' => ['label' => 'La domiciliu', 'primary' => 'parbrize la domiciliu', 'secondary' => ['montaj parbriz la domiciliu', 'schimbare parbriz la domiciliu']],
    '/pret-inlocuire-parbriz' => ['label' => 'Prețuri', 'primary' => 'preț parbriz', 'secondary' => ['preturi parbrize', 'parbrize ieftine', 'cât costă un parbriz']],
    '/calibrare-adas' => ['label' => 'Calibrare ADAS', 'primary' => 'calibrare ADAS', 'secondary' => ['calibrare cameră parbriz', 'parbriz cu senzori']],
    '/inlocuire-luneta-si-geamuri-laterale' => ['label' => 'Lunetă și geamuri', 'primary' => 'lunetă auto', 'secondary' => ['înlocuire lunetă', 'geamuri auto', 'lunetă mașină']],
    '/parbriz-pe-casco' => ['label' => 'CASCO', 'primary' => 'parbriz CASCO', 'secondary' => ['înlocuire parbriz CASCO']],
    '/parbrize-flote-firme' => ['label' => 'Flote', 'primary' => 'parbrize flote', 'secondary' => ['parbrize firme']],
    '/parbriz-auto' => ['label' => 'Parbriz pe model (hub)', 'primary' => 'parbriz pe model auto', 'secondary' => []],
    '/intrebari-frecvente' => ['label' => 'Întrebări frecvente', 'primary' => 'întrebări parbriz', 'secondary' => []],
    '/inlocuire-parbriz-ilfov' => ['label' => 'Ilfov', 'primary' => 'parbrize Ilfov', 'secondary' => ['înlocuire parbriz Ilfov']],
];
