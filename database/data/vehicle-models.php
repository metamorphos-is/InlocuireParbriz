<?php

/*
 * Pagini de model (/parbriz-auto/{marca}/{model}). Volumele: DataForSEO, Google Ads, România (rulările #1 și #2, 24.11.2026),
 * însumate pe variantele de căutare ale modelului („parbriz X”, „parbriz X pret”, „... cu senzori pret”).
 * `now` = publicat la lansarea structurii; restul intră în coada de publicare zilnică (ordinea din `queue`).
 * Reguli: fără prețuri inventate; afirmațiile despre dotări sunt prudente („la unele versiuni”), varianta exactă se verifică după VIN.
 */

return [
    // ——— Volkswagen ———
    [
        'brand' => 'volkswagen', 'slug' => 'passat-b6', 'name' => 'Passat B6', 'years' => '2005–2010', 'bodies' => 'berlină și break (Variant)',
        'adas' => 'none', 'volume' => 750, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz passat b6', 'secondary' => ['parbriz passat b6 pret', 'inlocuire parbriz passat b6 pret', 'pret parbriz vw passat b6 cu senzori'],
        'intro' => 'Passat B6 este cel mai căutat model când vine vorba de parbriz nou, cu peste 700 de căutări pe lună. Majoritatea exemplarelor au senzor de ploaie, iar diferențele dintre parbrize stau în suportul senzorului și în banda colorată de sus.',
        'variants' => ['Parbriz simplu, fără senzori, cu tentă verde', 'Cu suport pentru senzor de ploaie și lumină (cea mai frecventă variantă)', 'Cu bandă colorată (degrade) în partea de sus', 'Variante cu strat reflectorizant pentru căldură, la unele exemplare bine echipate'],
        'sections' => [
            ['Passat B6 berlină sau Variant: contează?', 'Berlina și breakul Variant folosesc în general același parbriz, deci caroseria nu schimbă de obicei sticla. Contează însă dotările: un B6 cu senzor de ploaie are nevoie de parbriz cu suport pentru senzor. Passat CC, deși derivat din B6, are alt parbriz, cu altă formă.'],
            ['Ce verifici la un B6 cumpărat second-hand', 'Mulți B6 au fost aduși din alte țări, cu echipări diferite. Dacă parbrizul a mai fost schimbat, e posibil ca varianta actuală să nu fie cea din fabrică. Seria de șasiu ne arată echiparea originală, iar o fotografie cu zona oglinzii ne arată ce e montat acum.'],
        ],
        'faq' => [
            ['Parbrizul de Passat B6 se potrivește la B7?', 'B7 este o modernizare a lui B6, cu parbriz asemănător, dar dotările diferă (B7 poate avea cameră și încălzire). Verificăm compatibilitatea după seria de șasiu, nu după generație.'],
        ],
        'image' => 'montaj-parbriz-nou-autoturism-alb',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'golf-4', 'name' => 'Golf 4', 'years' => '1997–2006', 'bodies' => 'hatchback 3 și 5 uși, break (Variant)',
        'adas' => 'none', 'volume' => 560, 'now' => true, 'sort' => 2,
        'primary' => 'parbriz golf 4', 'secondary' => ['parbriz golf 4 pret', 'schimbare parbriz golf 4 pret', 'parbriz golf 4 1.9 tdi pret'],
        'intro' => 'Golf 4 este încă foarte prezent pe drumurile din România, iar parbrizul lui e căutat de sute de ori pe lună. Cele mai multe exemplare au parbriz simplu, dar există și variante cu senzor de ploaie.',
        'variants' => ['Parbriz simplu, cu tentă verde (cea mai frecventă variantă)', 'Cu bandă colorată în partea de sus', 'Cu suport pentru senzor de ploaie, la versiunile mai bine echipate'],
        'sections' => [
            ['Motorizarea nu contează pentru parbriz', 'Mulți caută „parbriz Golf 4 1.9 TDI”, dar motorul nu influențează parbrizul. Contează caroseria, anul și dotările — mai ales dacă există senzor de ploaie. Pentru un Golf 4 cu parbriz simplu, identificarea e rapidă.'],
            ['Merită reparată o ciobitură la o mașină mai veche?', 'Da, de multe ori. La un Golf 4, o reparație de ciobitură reușită păstrează parbrizul original și costă mai puțin decât o înlocuire. Dacă fisura e însă lungă sau în câmpul vizual, înlocuirea e varianta sigură, inclusiv pentru ITP.'],
        ],
        'faq' => [
            ['Bora are același parbriz ca Golf 4?', 'Bora e construită pe aceeași platformă, iar parbrizul este în general comun, dar verificăm întotdeauna după seria de șasiu și dotări.'],
        ],
        'image' => 'ciobitura-parbriz-autoturism',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'golf-5', 'name' => 'Golf 5', 'years' => '2003–2008', 'bodies' => 'hatchback 3 și 5 uși, break (Variant)',
        'adas' => 'none', 'volume' => 160, 'queue' => 11,
        'primary' => 'parbriz golf 5', 'secondary' => ['parbriz golf 5 pret', 'schimbare parbriz golf 5 pret', 'parbriz golf 5 cu senzori pret'],
        'intro' => 'Pentru Golf 5 se caută des „parbriz cu senzori”: multe exemplare au senzor de ploaie și lumină. Varianta corectă depinde de dotări, iar Golf Plus are parbriz propriu.',
        'variants' => ['Parbriz simplu, fără senzori', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus', 'Variante cu strat reflectorizant, la unele exemplare'],
        'sections' => [
            ['Golf 5, Golf Plus și Jetta', 'Golf Plus, mai înalt, are alt parbriz decât Golf 5. Jetta din aceeași perioadă e o berlină derivată, iar compatibilitatea parbrizului se verifică după seria de șasiu. Nu comanda „după poză”: diferențele mici de formă contează la etanșare.'],
        ],
        'faq' => [
            ['Ce înseamnă „parbriz Golf 5 cu senzori”?', 'Un parbriz cu suport lipit pentru senzorul de ploaie și lumină, în spatele oglinzii. Dacă mașina ta are ștergătoare automate, ai nevoie de această variantă.'],
        ],
        'image' => 'parbriz-ploaie-senzor',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'golf-6', 'name' => 'Golf 6', 'years' => '2008–2012', 'bodies' => 'hatchback 3 și 5 uși, break (Variant)',
        'adas' => 'none', 'volume' => 110, 'queue' => 19,
        'primary' => 'parbriz golf 6', 'secondary' => ['parbriz golf 6 pret', 'parbriz golf 6 cu senzori pret', 'parbriz golf 6 original pret'],
        'intro' => 'Golf 6 are forme foarte apropiate de Golf 5, dar parbrizul se alege după dotări: senzor de ploaie, bandă colorată sau strat acustic la unele versiuni. Cele mai multe căutări sunt pentru varianta cu senzori.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus', 'Acustic sau reflectorizant, la unele versiuni'],
        'sections' => [
            ['Original sau echivalent pentru Golf 6?', 'Pentru Golf 6 există atât parbrize originale, cât și echivalente de calitate, omologate. Diferența stă în producător, nu în siguranță, dacă sticla e omologată. În ofertă vezi clar ce variantă ți se propune.'],
        ],
        'faq' => [
            ['Golf 6 Variant are alt parbriz?', 'În general, breakul folosește același parbriz ca hatchback-ul, dar seria de șasiu confirmă varianta.'],
        ],
        'image' => 'montaj-parbriz-ventuze',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'golf-7', 'name' => 'Golf 7', 'years' => '2012–2020', 'bodies' => 'hatchback, break (Variant)',
        'adas' => 'common', 'volume' => 250, 'queue' => 3,
        'primary' => 'parbriz golf 7', 'secondary' => ['parbriz golf 7 pret', 'parbriz golf 7 cu senzor ploaie pret', 'parbriz golf 7 pilkington pret'],
        'intro' => 'Golf 7 este primul Golf la care camera de pe parbriz a devenit frecventă. Parbrizul poate avea suport de cameră, senzor de ploaie, încălzire sau strat acustic — și de aceea două oferte pot diferi mult.',
        'variants' => ['Cu senzor de ploaie și lumină, fără cameră', 'Cu suport pentru camera de asistență (Lane Assist, recunoașterea indicatoarelor)', 'Încălzit, la unele versiuni', 'Acustic, la unele versiuni', 'Cu bandă colorată sus'],
        'sections' => [
            ['Golf 7 cu cameră: ce înseamnă la înlocuire', 'Camera din spatele oglinzii citește marcajele și indicatoarele prin parbriz. După montajul unei sticle noi, poziția camerei se schimbă cu fracțiuni de grad, iar sistemul trebuie calibrat. Calibrarea apare separat în ofertă, ca să știi exact ce plătești.'],
            ['Pilkington, Saint-Gobain sau original?', 'Pentru Golf 7 există parbrize de la mai mulți producători. Important e ca varianta să aibă aceleași suporturi și zone optice ca originalul, mai ales pentru cameră.'],
        ],
        'faq' => [
            ['Pot conduce fără calibrarea camerei?', 'Mașina merge, dar sistemele de asistență pot funcționa greșit sau se pot dezactiva. Recomandăm calibrarea imediat după montaj.'],
        ],
        'image' => 'montaj-parbriz-nou-doi-tehnicieni',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'passat-b7', 'name' => 'Passat B7', 'years' => '2010–2015', 'bodies' => 'berlină și break (Variant)',
        'adas' => 'optional', 'volume' => 70, 'queue' => 27,
        'primary' => 'parbriz passat b7', 'secondary' => ['parbriz passat b7 cu senzori pret', 'parbriz passat b7 pret', 'parbriz incalzit passat b7 pret'],
        'intro' => 'Passat B7 seamănă mult cu B6, dar poate avea dotări în plus pe parbriz: cameră pentru asistență la condus și, la unele versiuni, încălzire. Varianta corectă se stabilește după seria de șasiu.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Cu suport pentru cameră (asistență la menținerea benzii, faza lungă automată), la unele versiuni', 'Încălzit, la unele versiuni', 'Cu bandă colorată sus'],
        'sections' => [
            ['B7 încălzit: cum îl recunoști', 'Un parbriz încălzit are fire foarte fine, vizibile în lumină, și un buton separat de încălzire. Dacă B7-ul tău îl are, parbrizul nou trebuie să fie tot încălzit, altfel funcția se pierde.'],
        ],
        'faq' => [
            ['Am Passat B7 Alltrack. Parbrizul diferă?', 'Alltrack se bazează pe Variant, deci parbrizul este în general comun, cu variante după dotări. Verificăm după VIN.'],
        ],
        'image' => 'curatare-parbriz-dupa-montaj',
    ],
    [
        'brand' => 'volkswagen', 'slug' => 'passat-b8', 'name' => 'Passat B8', 'years' => '2014–2023', 'bodies' => 'berlină și break (Variant)',
        'adas' => 'common', 'volume' => 190, 'queue' => 7,
        'primary' => 'parbriz passat b8', 'secondary' => ['parbriz passat b8 pret', 'parbriz incalzit passat b8 pret'],
        'intro' => 'La Passat B8, aproape orice parbriz are suport de cameră, iar multe exemplare au și încălzire sau head-up display. E un parbriz tehnic, la care identificarea exactă și calibrarea camerei sunt obligatorii.',
        'variants' => ['Cu suport pentru camera frontală și senzor de ploaie (cea mai frecventă variantă)', 'Încălzit, fără fire vizibile, la unele versiuni', 'Compatibil cu head-up display, la unele versiuni', 'Acustic, la unele versiuni'],
        'sections' => [
            ['Head-up display pe Passat B8', 'Dacă B8-ul tău proiectează viteza pe parbriz sau pe un ecran mic care se ridică din bord, spune-ne exact ce sistem ai. Parbrizele pentru proiecția pe sticlă au o folie specială; o variantă greșită produce imagine dublă.'],
            ['Calibrarea după montaj', 'Camera B8 servește mai multor sisteme: menținerea benzii, recunoașterea indicatoarelor, faza lungă automată și, la unele versiuni, frânarea de urgență. După montaj, calibrarea este parte din lucrare.'],
        ],
        'faq' => [
            ['B8 facelift are alt parbriz?', 'Modernizarea din 2019 a adus dotări noi; parbrizul se verifică după seria de șasiu, nu doar după an.'],
        ],
        'image' => 'reparatie-ciobitura-parbriz-tehnician',
    ],

    // ——— Skoda ———
    [
        'brand' => 'skoda', 'slug' => 'octavia-2', 'name' => 'Octavia 2', 'years' => '2004–2013', 'bodies' => 'liftback și break (Combi)',
        'adas' => 'none', 'volume' => 460, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz skoda octavia 2', 'secondary' => ['parbriz skoda octavia 2 pret', 'parbriz skoda octavia 2 cu senzori pret'],
        'intro' => 'Octavia 2 este una dintre cele mai răspândite mașini din România, iar parbrizul ei se caută des, mai ales în varianta cu senzori. Liftback-ul și Combi folosesc în general același parbriz.',
        'variants' => ['Parbriz simplu, cu tentă verde', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus', 'Variante pentru versiunea modernizată (2009–2013), cu dotări diferite'],
        'sections' => [
            ['Octavia 2 sau Octavia 2 facelift', 'Modernizarea din 2009 a schimbat farurile și bara, dar parbrizul rămâne apropiat ca formă. Diferențele apar la dotări. Seria de șasiu ne spune exact ce variantă a venit din fabrică.'],
            ['Octavia de taxi sau de flotă', 'Octaviile care rulează mult au și mai multe impacturi. Dacă ai o ciobitură mică și recentă, o reparație te poate scuti de înlocuire; pentru flote, putem centraliza cererile.'],
        ],
        'faq' => [
            ['Octavia 2 RS are alt parbriz?', 'Versiunea RS folosește aceeași caroserie, deci în general același parbriz, cu variante după dotări.'],
        ],
        'image' => 'inlocuire-parbriz-fisurat-tehnician',
    ],
    [
        'brand' => 'skoda', 'slug' => 'octavia-3', 'name' => 'Octavia 3', 'years' => '2012–2020', 'bodies' => 'liftback și break (Combi)',
        'adas' => 'optional', 'volume' => 310, 'queue' => 2,
        'primary' => 'parbriz skoda octavia 3', 'secondary' => ['parbriz skoda octavia 3 cu senzori pret', 'parbriz skoda octavia 3 pret'],
        'intro' => 'La Octavia 3, parbrizul poate avea senzor de ploaie, suport de cameră pentru asistență la condus și, la unele versiuni, încălzire. „Cu senzori” e cea mai frecventă căutare, dar camera schimbă și mai mult varianta.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Cu suport pentru cameră (Lane Assist, recunoașterea indicatoarelor), la unele versiuni', 'Încălzit, la unele versiuni', 'Cu bandă colorată sus'],
        'sections' => [
            ['Cameră sau radar?', 'Asistența la frânare a Octaviei 3 poate folosi un radar din grila față, care nu ține de parbriz. Camera pentru menținerea benzii, însă, stă pe parbriz. Dacă ai carcasa mare în spatele oglinzii, parbrizul trebuie să aibă suportul ei, iar camera se calibrează după montaj.'],
        ],
        'faq' => [
            ['Octavia 3 facelift (2017) are alt parbriz?', 'Forma e aceeași, dar dotările pot diferi. Verificăm după seria de șasiu.'],
        ],
        'image' => 'parbriz-ploaie-senzor',
    ],
    [
        'brand' => 'skoda', 'slug' => 'octavia-1', 'name' => 'Octavia 1', 'years' => '1996–2010 (inclusiv Octavia Tour)', 'bodies' => 'liftback și break (Combi)',
        'adas' => 'none', 'volume' => 160, 'queue' => 23,
        'primary' => 'parbriz skoda octavia 1', 'secondary' => ['parbriz skoda octavia 1 pret', 'parbriz octavia tour'],
        'intro' => 'Prima Octavia, vândută mult timp și ca Octavia Tour, are de cele mai multe ori un parbriz simplu, ușor de identificat. Senzorul de ploaie apare doar la unele exemplare.',
        'variants' => ['Parbriz simplu, cu tentă verde (cea mai frecventă variantă)', 'Cu bandă colorată sus', 'Cu suport pentru senzor de ploaie, la puține versiuni'],
        'sections' => [
            ['Reparație sau parbriz nou la o mașină mai veche', 'La o Octavia 1, o ciobitură mică se repară de obicei mai ieftin decât o înlocuire și păstrează parbrizul original. Dacă însă fisura trece prin câmpul vizual al șoferului, înlocuirea e varianta corectă, inclusiv pentru ITP.'],
        ],
        'faq' => [
            ['Octavia Tour e tot Octavia 1?', 'Da, Octavia Tour este continuarea primei generații, vândută în paralel cu Octavia 2.'],
        ],
        'image' => 'reparatie-ciobitura-parbriz-aplicator',
    ],
    [
        'brand' => 'skoda', 'slug' => 'fabia-1', 'name' => 'Fabia 1', 'years' => '1999–2007', 'bodies' => 'hatchback, berlină (Sedan) și break (Combi)',
        'adas' => 'none', 'volume' => 140, 'queue' => 31,
        'primary' => 'parbriz skoda fabia 1', 'secondary' => ['parbriz skoda fabia 1 pret', 'parbriz skoda fabia 1.4 16v pret'],
        'intro' => 'Fabia 1 are în general un parbriz simplu, comun pentru hatchback, Sedan și Combi. E unul dintre cele mai ușor de identificat parbrize, iar oferta vine repede.',
        'variants' => ['Parbriz simplu, cu tentă verde', 'Cu bandă colorată sus', 'Cu suport pentru senzor de ploaie, la puține versiuni'],
        'sections' => [
            ['Motorul nu contează', 'Căutări ca „parbriz Fabia 1.4 16V” sunt frecvente, dar motorizarea nu schimbă parbrizul. Ne ajută anul, caroseria și o fotografie a zonei din spatele oglinzii.'],
        ],
        'faq' => [
            ['Fabia 2 are același parbriz ca Fabia 1?', 'Nu, Fabia 2 (2007–2014) are caroserie și parbriz diferite.'],
        ],
        'image' => 'parbriz-spart-autoturism-parcat',
    ],

    // ——— Audi ———
    [
        'brand' => 'audi', 'slug' => 'a4-b8', 'name' => 'A4 B8', 'years' => '2007–2015', 'bodies' => 'berlină, break (Avant), allroad',
        'adas' => 'optional', 'volume' => 560, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz audi a4 b8', 'secondary' => ['parbriz audi a4 b8 cu senzori pret', 'parbriz audi a4 b8 pret', 'pret parbriz audi a4 b8'],
        'intro' => 'Audi A4 B8 este cel mai căutat Audi la capitolul parbriz. Aproape toate exemplarele au senzor de ploaie, iar unele au strat acustic, reflectorizant sau cameră pentru asistență, mai ales după modernizarea din 2011–2012.',
        'variants' => ['Cu senzor de ploaie și lumină (cea mai frecventă variantă)', 'Acustic, la unele versiuni', 'Cu strat reflectorizant pentru căldură, la unele versiuni', 'Cu suport pentru cameră, la unele versiuni modernizate', 'Cu bandă colorată sus'],
        'sections' => [
            ['B8 sau B8.5 (facelift)', 'Versiunea modernizată, numită adesea B8.5, poate avea cameră pe parbriz pentru asistența la menținerea benzii. Dacă vezi o carcasă mare în spatele oglinzii, spune-ne: parbrizul trebuie să aibă suportul ei, iar camera se calibrează.'],
            ['De ce contează stratul reflectorizant', 'Parbrizele cu strat reflectorizant țin căldura afară vara. Ele pot însă bloca semnalul unor dispozitive (tag de taxare, GPS) în afara zonei marcate pentru ele. Dacă mașina a venit cu un astfel de parbriz, e bine să rămână la fel.'],
        ],
        'faq' => [
            ['A5 are același parbriz ca A4 B8?', 'Nu, A5 are caroserie diferită și alt parbriz.'],
        ],
        'image' => 'montaj-parbriz-nou-doi-tehnicieni',
    ],
    [
        'brand' => 'audi', 'slug' => 'a6-c6', 'name' => 'A6 C6', 'years' => '2004–2011', 'bodies' => 'berlină, break (Avant), allroad',
        'adas' => 'none', 'volume' => 130, 'queue' => 15,
        'primary' => 'parbriz audi a6 c6', 'secondary' => ['parbriz audi a6 c6 pret'],
        'intro' => 'Pentru Audi A6 C6, parbrizul are aproape mereu senzor de ploaie și, la multe exemplare, strat acustic sau reflectorizant. Pentru o ofertă corectă, contează exact aceste detalii.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Acustic, la unele versiuni', 'Cu strat reflectorizant, la unele versiuni', 'Cu bandă colorată sus'],
        'sections' => [
            ['Cum recunoști stratul reflectorizant', 'Privit din exterior, sub un anumit unghi, parbrizul are o nuanță ușor violet sau aurie. Lângă oglindă există adesea o zonă fără strat, pentru tag-uri sau dispozitive. Spune-ne ce vezi, sau trimite o fotografie.'],
        ],
        'faq' => [
            ['A6 allroad are alt parbriz?', 'allroad se bazează pe Avant, iar parbrizul este în general comun, cu variante după dotări.'],
        ],
        'image' => 'curatare-parbriz-dupa-montaj',
    ],
    [
        'brand' => 'audi', 'slug' => 'a6-c7', 'name' => 'A6 C7', 'years' => '2011–2018', 'bodies' => 'berlină, break (Avant), allroad',
        'adas' => 'common', 'volume' => 110, 'queue' => 29,
        'primary' => 'parbriz audi a6 c7', 'secondary' => ['parbriz audi a6 c7 pret'],
        'intro' => 'A6 C7 este un Audi cu multă tehnologie pe parbriz: cameră pentru asistență, senzor de ploaie, strat acustic și, la unele versiuni, compatibilitate cu head-up display. Identificarea exactă este esențială.',
        'variants' => ['Cu senzor de ploaie și suport pentru cameră', 'Compatibil cu head-up display, la unele versiuni', 'Acustic', 'Încălzit, la unele versiuni'],
        'sections' => [
            ['Head-up display pe A6 C7', 'Dacă mașina proiectează viteza și navigația pe parbriz, ai nevoie de un parbriz cu folie specială pentru HUD. Un parbriz obișnuit ar produce imagine dublă. Spune-ne în cerere dacă ai această funcție.'],
        ],
        'faq' => [
            ['După montaj e nevoie de calibrare?', 'Da, dacă mașina are cameră pe parbriz. Calibrarea apare în ofertă.'],
        ],
        'image' => 'montaj-parbriz-ventuze',
    ],

    // ——— BMW ———
    [
        'brand' => 'bmw', 'slug' => 'seria-3-e90', 'name' => 'Seria 3 E90', 'years' => '2005–2012', 'bodies' => 'berlină (E90) și Touring (E91)',
        'adas' => 'none', 'volume' => 540, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz bmw e90', 'secondary' => ['parbriz bmw e90 cu senzor pret', 'parbriz bmw e90 pret', 'parbriz bmw seria 3 pret', 'cheder parbriz bmw e90'],
        'intro' => 'BMW E90 este cel mai căutat BMW la capitolul parbriz. Majoritatea exemplarelor au senzor de ploaie, iar unele au bandă colorată sau strat acustic. Coupé-ul E92 și cabrioletul E93 au parbriz diferit.',
        'variants' => ['Cu senzor de ploaie și lumină (cea mai frecventă variantă)', 'Cu bandă colorată sus', 'Acustic, la unele versiuni', 'Parbriz fără senzor, la versiunile de bază'],
        'sections' => [
            ['Chederul parbrizului la E90', 'Mulți caută și „cheder parbriz BMW E90”. La montajul unui parbriz nou, garniturile și ornamentele din jurul sticlei se verifică și, dacă sunt deteriorate sau lipite din fabrică pe parbriz, se înlocuiesc. Spune-ne dacă ai observat infiltrații sau zgomote de vânt.'],
            ['E90, E91, E92, E93', 'Berlina și breakul Touring folosesc în general același parbriz. Coupé (E92) și cabrio (E93) au alt parbriz, cu altă formă. Codul caroseriei apare în talon sau se află din seria de șasiu.'],
        ],
        'faq' => [
            ['LCI (facelift) are alt parbriz?', 'Modernizarea din 2008 nu a schimbat forma parbrizului la berlină; diferențele țin de dotări.'],
        ],
        'image' => 'inlocuire-parbriz-fisurat-tehnician',
    ],
    [
        'brand' => 'bmw', 'slug' => 'seria-3-f30', 'name' => 'Seria 3 F30', 'years' => '2011–2019', 'bodies' => 'berlină (F30) și Touring (F31)',
        'adas' => 'common', 'volume' => 110, 'queue' => 9,
        'primary' => 'parbriz bmw f30', 'secondary' => ['parbriz bmw f30 pret', 'parbriz bmw f30 head up display'],
        'intro' => 'La BMW F30, parbrizul are frecvent cameră pentru asistență (KAFAS) și, la unele versiuni, compatibilitate cu head-up display. Gran Turismo (F34) are parbriz propriu.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Cu suport pentru camera KAFAS (avertizare la părăsirea benzii, recunoașterea indicatoarelor)', 'Compatibil cu head-up display, la unele versiuni', 'Acustic, la unele versiuni'],
        'sections' => [
            ['Camera KAFAS', 'Camera din spatele oglinzii se ocupă de avertizarea la părăsirea benzii, faza lungă automată și recunoașterea indicatoarelor. După montaj, se calibrează. Dacă luminile de avertizare apar după schimbarea parbrizului, de obicei e semn că a lipsit calibrarea.'],
        ],
        'faq' => [
            ['Seria 4 are același parbriz ca F30?', 'Nu, Seria 4 (coupé, cabrio, Gran Coupé) are parbriz diferit.'],
        ],
        'image' => 'reparatie-ciobitura-parbriz-tehnician',
    ],
    [
        'brand' => 'bmw', 'slug' => 'x1', 'name' => 'X1', 'years' => 'E84: 2009–2015; F48: 2015–2022', 'bodies' => 'SUV compact',
        'adas' => 'optional', 'volume' => 120, 'queue' => 21,
        'primary' => 'parbriz bmw x1', 'secondary' => ['parbriz bmw x1 pret'],
        'intro' => 'BMW X1 are două generații frecvente în România, E84 și F48, cu parbrize complet diferite. La F48, camera și head-up display-ul sunt mai des întâlnite.',
        'variants' => ['E84: cu senzor de ploaie, cu sau fără bandă colorată', 'F48: cu senzor de ploaie și, la unele versiuni, suport pentru cameră', 'F48: compatibil cu head-up display, la unele versiuni'],
        'sections' => [
            ['Cum afli generația', 'E84 a fost produs până în 2015, F48 din 2015. Dacă mașina ta e din 2015, seria de șasiu clarifică generația. Parbrizele nu sunt interschimbabile.'],
        ],
        'faq' => [
            ['X1 F48 cu cameră necesită calibrare?', 'Da, după montajul parbrizului nou, camera se calibrează.'],
        ],
        'image' => 'montaj-parbriz-nou-autoturism-alb',
    ],
    [
        'brand' => 'bmw', 'slug' => 'x3', 'name' => 'X3', 'years' => 'E83: 2003–2010; F25: 2010–2017', 'bodies' => 'SUV',
        'adas' => 'optional', 'volume' => 160, 'queue' => 25,
        'primary' => 'parbriz bmw x3', 'secondary' => ['parbriz bmw x3 pret', 'parbriz bmw x3 e83 pret', 'parbriz bmw x3 f25 pret'],
        'intro' => 'Pentru BMW X3 se caută parbriz atât pentru E83, cât și pentru F25. Sunt parbrize diferite, iar la F25 pot apărea camera pentru asistență și head-up display.',
        'variants' => ['E83: cu senzor de ploaie, cu sau fără bandă colorată', 'F25: cu senzor de ploaie și, la unele versiuni, suport pentru cameră', 'F25: compatibil cu head-up display, la unele versiuni', 'Acustic, la unele versiuni'],
        'sections' => [
            ['Parbriz mare, montaj atent', 'La un SUV, parbrizul este mai mare și mai greu, iar montajul se face cu doi tehnicieni sau cu dispozitive de poziționare. Dacă alegi montaj la adresă, e nevoie de spațiu în jurul mașinii.'],
        ],
        'faq' => [
            ['X3 E83 și F25 au același parbriz?', 'Nu, sunt generații diferite, cu parbrize diferite.'],
        ],
        'image' => 'montaj-parbriz-ventuze',
    ],

    // ——— Ford ———
    [
        'brand' => 'ford', 'slug' => 'focus-2', 'name' => 'Focus 2', 'years' => '2004–2011', 'bodies' => 'hatchback, berlină, break, coupé-cabriolet',
        'adas' => 'none', 'volume' => 600, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz ford focus 2', 'secondary' => ['parbriz ford focus 2 cu incalzire pret', 'parbriz ford focus 2 pret', 'pret parbriz ford focus 2', 'inlocuire parbriz ford focus 2'],
        'intro' => 'Ford Focus 2 este printre cele mai căutate mașini pentru parbriz nou, iar o bună parte dintre căutări sunt pentru varianta cu încălzire. Diferența dintre un parbriz simplu și unul încălzit este mare, atât ca funcție, cât și ca preț.',
        'variants' => ['Parbriz simplu, fără încălzire', 'Încălzit (Quickclear), cu fire foarte fine în sticlă', 'Cu suport pentru senzor de ploaie, la unele versiuni', 'Cu bandă colorată sus'],
        'sections' => [
            ['Focus 2 cu parbriz încălzit', 'Parbrizul încălzit are fire subțiri în toată suprafața și un buton separat pe bord. Iarna, dezgheață sticla în câteva minute, fără răzuitoare. Dacă mașina ta îl are, recomandăm tot un parbriz încălzit: un parbriz simplu se montează, dar pierzi funcția.'],
            ['Focus 2 coupé-cabriolet și C-Max', 'Focus CC (coupé-cabriolet) are alt parbriz decât hatchback-ul, iar C-Max, deși înrudit, are caroserie și parbriz proprii. Hatchback-ul, berlina și breakul folosesc în general același parbriz.'],
        ],
        'faq' => [
            ['Facelift-ul din 2008 are alt parbriz?', 'Forma parbrizului rămâne aceeași la hatchback, berlină și break; diferențele țin de dotări.'],
        ],
        'image' => 'fisura-parbriz-in-trafic',
    ],
    [
        'brand' => 'ford', 'slug' => 'focus-3', 'name' => 'Focus 3', 'years' => '2011–2018', 'bodies' => 'hatchback, berlină, break',
        'adas' => 'optional', 'volume' => 160, 'queue' => 5,
        'primary' => 'parbriz ford focus 3', 'secondary' => ['parbriz ford focus mk3 cu incalzire pret', 'parbriz incalzit ford focus 3 pret'],
        'intro' => 'Focus 3 poate avea parbriz încălzit, senzor de ploaie, cameră pentru menținerea benzii și senzorul sistemului de frânare la viteză mică (Active City Stop), montat sus pe parbriz.',
        'variants' => ['Parbriz simplu', 'Încălzit (Quickclear)', 'Cu suport pentru senzor de ploaie', 'Cu suport pentru cameră și/sau senzorul Active City Stop, la unele versiuni'],
        'sections' => [
            ['Active City Stop', 'Sistemul care frânează automat la viteză mică folosește un senzor montat în partea de sus a parbrizului, lângă oglindă. Parbrizul nou trebuie să aibă suportul potrivit, iar sistemul se verifică după montaj.'],
        ],
        'faq' => [
            ['Focus 3 facelift (2014) are alt parbriz?', 'Forma e aceeași; dotările pot diferi. Verificăm după seria de șasiu.'],
        ],
        'image' => 'parbriz-ploaie-senzor',
    ],
    [
        'brand' => 'ford', 'slug' => 'mondeo-mk4', 'name' => 'Mondeo Mk4', 'years' => '2007–2014', 'bodies' => 'hatchback, berlină, break',
        'adas' => 'optional', 'volume' => 100, 'queue' => 17,
        'primary' => 'parbriz ford mondeo mk4', 'secondary' => ['parbriz incalzit ford mondeo mk4 pret'],
        'intro' => 'Mondeo Mk4 are frecvent parbriz încălzit și senzor de ploaie, iar versiunile mai noi pot avea cameră pentru asistență. E un parbriz mare, care se montează atent.',
        'variants' => ['Parbriz simplu', 'Încălzit (Quickclear)', 'Cu suport pentru senzor de ploaie', 'Cu suport pentru cameră, la unele versiuni'],
        'sections' => [
            ['Mondeo, Galaxy și S-Max', 'Deși folosesc o platformă comună, Galaxy și S-Max au alte parbrize decât Mondeo. Spune-ne exact modelul și caroseria.'],
        ],
        'faq' => [
            ['Merită parbrizul încălzit?', 'Dacă mașina îl are din fabrică, da: iarna economisești timp și eviți zgârierea sticlei cu răzuitoare.'],
        ],
        'image' => 'montaj-parbriz-nou-doi-tehnicieni',
    ],
    [
        'brand' => 'ford', 'slug' => 'kuga', 'name' => 'Kuga', 'years' => 'Mk1: 2008–2012; Mk2: 2012–2019', 'bodies' => 'SUV compact',
        'adas' => 'optional', 'volume' => 80, 'queue' => 33,
        'primary' => 'parbriz ford kuga', 'secondary' => ['parbriz ford kuga cu incalzire pret', 'parbriz incalzit ford kuga pret'],
        'intro' => 'Pentru Ford Kuga se caută mai ales parbriz cu încălzire, o dotare frecventă la acest SUV. Prima și a doua generație au parbrize diferite.',
        'variants' => ['Încălzit (Quickclear)', 'Parbriz simplu', 'Cu suport pentru senzor de ploaie', 'Mk2: cu suport pentru cameră sau senzorul Active City Stop, la unele versiuni'],
        'sections' => [
            ['Kuga Mk1 sau Mk2', 'Prima generație a fost produsă până în 2012, a doua din 2012. Parbrizele nu sunt interschimbabile, iar la Mk2 apar mai des senzorii de asistență pe parbriz.'],
        ],
        'faq' => [
            ['Escape și Kuga au același parbriz?', 'Kuga Mk2 este înrudit cu Escape din America de Nord, dar pentru mașinile din Europa verificăm după seria de șasiu.'],
        ],
        'image' => 'parbriz-spart-vedere-interior',
    ],

    // ——— Opel ———
    [
        'brand' => 'opel', 'slug' => 'astra-h', 'name' => 'Astra H', 'years' => '2004–2010 (berlina până în 2014)', 'bodies' => 'hatchback, berlină, break, GTC, TwinTop',
        'adas' => 'none', 'volume' => 340, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz opel astra h', 'secondary' => ['parbriz opel astra h pret', 'pret parbriz opel astra h', 'parbriz opel astra h cu senzor ploaie pret'],
        'intro' => 'Opel Astra H este unul dintre cele mai căutate modele pentru parbriz. Hatchback-ul cu 5 uși, berlina și breakul folosesc în general același parbriz, dar GTC poate avea parbriz panoramic, iar TwinTop are sticlă proprie.',
        'variants' => ['Parbriz simplu, cu tentă verde', 'Cu suport pentru senzor de ploaie', 'Cu bandă colorată sus', 'GTC: parbriz panoramic (opțional), care urcă spre plafon', 'TwinTop: parbriz specific cabrioletei'],
        'sections' => [
            ['Parbrizul panoramic de la Astra GTC', 'Astra H GTC putea fi comandată cu parbriz panoramic, care continuă mult în plafon. E un parbriz special, mare, cu montaj mai complex. Dacă ai GTC, spune-ne dacă parbrizul tău e normal sau panoramic.'],
            ['Senzorul de ploaie', 'Versiunile mai bine echipate au senzor de ploaie lipit pe parbriz. Dacă ai ștergătoare automate, parbrizul nou trebuie să aibă suportul pentru senzor.'],
        ],
        'faq' => [
            ['Astra H Classic are alt parbriz?', 'Berlina vândută ca Astra Classic până în 2014 folosește parbrizul Astra H obișnuit, cu variante după dotări.'],
        ],
        'image' => 'ciobitura-parbriz-impact-piatra',
    ],
    [
        'brand' => 'opel', 'slug' => 'astra-j', 'name' => 'Astra J', 'years' => '2009–2015', 'bodies' => 'hatchback, berlină, break (Sports Tourer), GTC',
        'adas' => 'optional', 'volume' => 50, 'queue' => 35,
        'primary' => 'parbriz opel astra j', 'secondary' => ['parbriz opel astra j pret', 'parbriz opel astra j sport tourer pret'],
        'intro' => 'Astra J poate avea camera Opel Eye pe parbriz, senzor de ploaie și, la unele versiuni, încălzire. GTC are parbriz propriu, diferit de hatchback și Sports Tourer.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Cu suport pentru camera Opel Eye, la unele versiuni', 'Încălzit, la unele versiuni', 'GTC: parbriz specific'],
        'sections' => [
            ['Opel Eye pe Astra J', 'Camera frontală Opel Eye recunoaște indicatoarele și avertizează la părăsirea benzii. Dacă mașina ta o are, parbrizul nou trebuie să aibă suportul ei, iar camera se calibrează după montaj.'],
        ],
        'faq' => [
            ['Sports Tourer are alt parbriz decât hatchback-ul?', 'În general nu, dar dotările se verifică după seria de șasiu.'],
        ],
        'image' => 'reparatie-fisura-parbriz-rasina',
    ],
    [
        'brand' => 'opel', 'slug' => 'corsa-d', 'name' => 'Corsa D', 'years' => '2006–2014', 'bodies' => 'hatchback 3 și 5 uși',
        'adas' => 'none', 'volume' => 110, 'queue' => 13,
        'primary' => 'parbriz opel corsa d', 'secondary' => ['parbriz opel corsa d pret', 'parbriz opel corsa c pret'],
        'intro' => 'Corsa D are de obicei un parbriz simplu, comun pentru versiunile cu 3 și 5 uși. Senzorul de ploaie apare la unele versiuni mai bine echipate.',
        'variants' => ['Parbriz simplu (cea mai frecventă variantă)', 'Cu bandă colorată sus', 'Cu suport pentru senzor de ploaie, la unele versiuni'],
        'sections' => [
            ['Corsa C sau Corsa D?', 'Corsa C a fost produsă până în 2006, Corsa D din 2006. Parbrizele diferă. Dacă ai o Corsa C, trimite anul și modelul în cerere — identificăm și pentru ea varianta corectă.'],
        ],
        'faq' => [
            ['Corsa D Van are același parbriz?', 'Versiunea utilitară folosește caroseria de 3 uși, deci în general același parbriz.'],
        ],
        'image' => 'parbriz-spart-trafic-oras',
    ],

    // ——— Dacia ———
    [
        'brand' => 'dacia', 'slug' => 'logan-1', 'name' => 'Logan 1', 'years' => '2004–2012', 'bodies' => 'berlină, MCV, Van, Pick-up',
        'adas' => 'none', 'volume' => 590, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz logan 1', 'secondary' => ['parbriz logan 1.4 pret', 'parbriz logan original pret', 'parbriz logan 1 pret', 'pret parbriz logan 2008', 'inlocuire parbriz logan pret'],
        'intro' => 'Logan 1 este una dintre cele mai răspândite mașini din România, iar „parbriz Logan” e o căutare foarte frecventă. Parbrizul este în general simplu și comun pentru berlină, MCV, Van și Pick-up, ceea ce face identificarea rapidă.',
        'variants' => ['Parbriz simplu, cu tentă verde (cea mai frecventă variantă)', 'Cu bandă colorată sus, la unele exemplare', 'Parbriz original Dacia sau echivalent omologat'],
        'sections' => [
            ['Original sau echivalent?', 'Pentru Logan 1 se găsesc atât parbrize originale, cât și echivalente omologate de la alți producători. Ambele sunt sigure dacă poartă marcajul de omologare. Diferența ține de producător și de preț, iar în ofertă vezi clar ce variantă primești.'],
            ['Motorizarea nu contează', 'Căutări ca „parbriz Logan 1.4” sau „Logan 1.5 dCi” sunt frecvente, dar motorul nu schimbă parbrizul. Contează generația și caroseria. Sandero din aceeași perioadă are parbriz diferit.'],
        ],
        'faq' => [
            ['Logan 1 facelift (2008) are alt parbriz?', 'Nu, forma parbrizului a rămas aceeași; s-au schimbat bara, farurile și interiorul.'],
            ['Merită reparată o ciobitură la Logan?', 'Dacă impactul e mic și recent, da: reparația păstrează parbrizul original. Pentru fisuri lungi, înlocuirea e varianta corectă.'],
        ],
        'image' => 'parbriz-spart-autoturism-parcat',
    ],
    [
        'brand' => 'dacia', 'slug' => 'logan-2', 'name' => 'Logan 2', 'years' => '2012–2020', 'bodies' => 'berlină, MCV',
        'adas' => 'none', 'volume' => 50, 'queue' => 37,
        'primary' => 'parbriz logan 2', 'secondary' => ['parbriz logan 2 pret', 'parbriz logan 2019 pret'],
        'intro' => 'Logan 2 are un parbriz diferit de prima generație. Cele mai multe exemplare au parbriz simplu, iar senzorul de ploaie și lumină apare la versiunile mai bine echipate, după modernizarea din 2016.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină, la unele versiuni', 'Cu bandă colorată sus, la unele exemplare'],
        'sections' => [
            ['Logan 2 și Sandero 2', 'Cele două modele împart platforma și multe piese. Parbrizul se verifică după seria de șasiu, ca să eviți o comandă greșită pe baza asemănării.'],
        ],
        'faq' => [
            ['Logan MCV 2 are același parbriz ca berlina?', 'În general da, partea din față fiind comună; dotările se verifică după VIN.'],
        ],
        'image' => 'curatare-parbriz-dupa-montaj',
    ],
    [
        'brand' => 'dacia', 'slug' => 'logan-3', 'name' => 'Logan 3', 'years' => 'din 2020', 'bodies' => 'berlină',
        'adas' => 'optional', 'volume' => 250, 'queue' => 1,
        'primary' => 'parbriz logan 3', 'secondary' => ['parbriz logan 3 pret'],
        'intro' => 'Logan 3 este o mașină nouă, cu parbriz complet diferit de generațiile anterioare. Versiunile mai bine echipate au senzor de ploaie și lumină, iar mașinile înmatriculate după iulie 2024 au, de regulă, și cameră pe parbriz.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină', 'Cu suport pentru cameră frontală, la unele versiuni (mai ales cele recente)'],
        'sections' => [
            ['Logan 3 în garanție', 'Dacă mașina e încă în garanție, verifică în carnetul de service ce condiții se aplică pentru înlocuirea parbrizului. Îți putem oferi o ofertă scrisă cu varianta de sticlă propusă, pe care o poți compara.'],
            ['Camera de pe parbriz', 'Regulile europene de siguranță obligă mașinile noi la sisteme ca avertizarea la părăsirea benzii și recunoașterea limitei de viteză, care folosesc o cameră pe parbriz. Dacă ai o carcasă în spatele oglinzii, parbrizul trebuie să aibă suportul potrivit, iar camera se calibrează după montaj.'],
        ],
        'faq' => [
            ['Logan 3 și Sandero 3 au același parbriz?', 'Sunt modele înrudite, dar compatibilitatea parbrizului se verifică după seria de șasiu.'],
        ],
        'image' => 'montaj-parbriz-nou-autoturism-alb',
    ],
    [
        'brand' => 'dacia', 'slug' => 'sandero', 'name' => 'Sandero', 'years' => 'Sandero 1: 2008–2012; Sandero 2: 2012–2020; Sandero 3: din 2020', 'bodies' => 'hatchback, Stepway',
        'adas' => 'optional', 'volume' => 90, 'queue' => 8,
        'primary' => 'parbriz dacia sandero', 'secondary' => ['parbriz dacia sandero pret', 'parbriz dacia sandero stepway pret'],
        'intro' => 'Dacia Sandero are trei generații, fiecare cu parbriz propriu. Stepway, versiunea cu aspect de crossover, folosește în general parbrizul Sandero din aceeași generație.',
        'variants' => ['Sandero 1 și 2: parbriz simplu sau cu senzor de ploaie, la unele versiuni', 'Sandero 3: cu senzor de ploaie și lumină la versiunile mai bine echipate', 'Sandero 3: cu suport pentru cameră frontală, la unele versiuni recente'],
        'sections' => [
            ['Ce generație ai?', 'Anul din talon te ajută: până în 2012 e prima generație, până în 2020 a doua, apoi a treia. La mașinile fabricate în anii de schimbare, seria de șasiu clarifică.'],
        ],
        'faq' => [
            ['Stepway are alt parbriz decât Sandero?', 'În general nu, în cadrul aceleiași generații; dotările se verifică după VIN.'],
        ],
        'image' => 'ciobitura-parbriz-autoturism',
    ],
    [
        'brand' => 'dacia', 'slug' => 'duster', 'name' => 'Duster', 'years' => 'Duster 1: 2010–2017; Duster 2: 2017–2024; Duster 3: din 2024', 'bodies' => 'SUV',
        'adas' => 'optional', 'volume' => 90, 'queue' => 4,
        'primary' => 'parbriz dacia duster', 'secondary' => ['pret parbriz duster original', 'parbriz duster pret', 'parbriz duster original pret'],
        'intro' => 'Dacia Duster are trei generații cu parbrize complet diferite. Duster 2 are parbriz mai înclinat decât primul, iar Duster 3 are, de regulă, cameră pe parbriz pentru sistemele de asistență.',
        'variants' => ['Duster 1: parbriz simplu, la unele versiuni cu senzor de ploaie', 'Duster 2: simplu sau cu senzor de ploaie și lumină; la unele versiuni cu suport pentru cameră', 'Duster 3: cu suport pentru cameră frontală (sisteme de asistență obligatorii)'],
        'sections' => [
            ['Duster pe drumuri de țară', 'Mulți Dusteri circulă pe drumuri pietruite, unde impacturile sunt frecvente. O ciobitură mică, tratată repede, se poate repara; lăsată în frig și vibrații, devine fisură.'],
            ['Parbriz original Dacia sau echivalent', 'Pentru Duster există parbrize originale și echivalente omologate. La Duster 3, pentru cameră contează mai ales calitatea optică a zonei din fața obiectivului — de aceea varianta se alege atent.'],
        ],
        'faq' => [
            ['Duster 3 necesită calibrare după schimbarea parbrizului?', 'Da, dacă are cameră pe parbriz. Calibrarea apare în ofertă.'],
        ],
        'image' => 'parbriz-spart-multiple-impacturi',
    ],

    // ——— Renault ———
    [
        'brand' => 'renault', 'slug' => 'megane-2', 'name' => 'Megane 2', 'years' => '2002–2009', 'bodies' => 'hatchback, berlină, break (Grandtour), coupé-cabriolet',
        'adas' => 'none', 'volume' => 200, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz renault megane 2', 'secondary' => ['parbriz renault megane 2 cu senzor pret', 'parbriz renault megane 2 pret', 'inlocuire parbriz megane 2'],
        'intro' => 'Pentru Renault Megane 2, cea mai frecventă întrebare este „parbriz cu senzor”: multe exemplare au senzor de ploaie și lumină. Coupé-cabrioletul are parbriz diferit de celelalte caroserii.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus', 'Coupé-cabriolet: parbriz specific'],
        'sections' => [
            ['Senzorul de ploaie de la Megane 2', 'Senzorul stă pe un suport lipit pe parbriz, în spatele oglinzii. La montajul parbrizului nou se mută, cu un gel optic nou. Fără suportul corect, ștergătoarele automate nu mai funcționează.'],
            ['Scenic are alt parbriz', 'Megane Scenic, monovolumul din aceeași familie, are parbriz cu totul diferit. Spune-ne exact modelul.'],
        ],
        'faq' => [
            ['Megane 2 Grandtour are același parbriz ca hatchback-ul?', 'În general da, în variante după dotări.'],
        ],
        'image' => 'parbriz-ploaie-senzor',
    ],
    [
        'brand' => 'renault', 'slug' => 'megane-3', 'name' => 'Megane 3', 'years' => '2008–2016', 'bodies' => 'hatchback, coupé, break (Grandtour), coupé-cabriolet',
        'adas' => 'none', 'volume' => 180, 'queue' => 6,
        'primary' => 'parbriz megane 3', 'secondary' => ['parbriz megane 3 cu senzor pret', 'parbriz renault megane 3 pret', 'parbriz renault megane 3 cu senzor pret'],
        'intro' => 'Megane 3 are adesea senzor de ploaie, iar parbrizul diferă între hatchback/Grandtour, coupé și coupé-cabriolet. „Parbriz Megane 3 cu senzor” este cea mai frecventă căutare pentru acest model.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus', 'Coupé și coupé-cabriolet: parbrize specifice'],
        'sections' => [
            ['Megane 3 coupé', 'Versiunea coupé are linia plafonului diferită și alt parbriz decât hatchback-ul cu 5 uși. Spune-ne exact caroseria în cerere.'],
        ],
        'faq' => [
            ['Fluence are același parbriz ca Megane 3?', 'Fluence e o berlină înrudită, dar parbrizul se verifică separat, după seria de șasiu.'],
        ],
        'image' => 'reparatie-ciobitura-parbriz-aplicator',
    ],

    // ——— Nissan ———
    [
        'brand' => 'nissan', 'slug' => 'qashqai-j10', 'name' => 'Qashqai J10', 'years' => '2007–2013', 'bodies' => 'SUV compact, Qashqai+2 (7 locuri)',
        'adas' => 'none', 'volume' => 120, 'now' => true, 'sort' => 1,
        'primary' => 'parbriz nissan qashqai j10', 'secondary' => ['parbriz nissan qashqai j10 pret', 'parbriz nissan qashqai pret'],
        'intro' => 'Prima generație Qashqai (J10) are un parbriz comun cu Qashqai+2. Diferențele dintre variante țin de senzorul de ploaie și de banda colorată.',
        'variants' => ['Parbriz simplu', 'Cu suport pentru senzor de ploaie și lumină', 'Cu bandă colorată sus'],
        'sections' => [
            ['Qashqai J10 facelift (2010)', 'Modernizarea din 2010 a schimbat partea din față, dar parbrizul a rămas apropiat ca formă. Dotările se verifică după seria de șasiu.'],
        ],
        'faq' => [
            ['Qashqai+2 are același parbriz?', 'Da, în general, partea din față fiind comună; dotările se verifică după VIN.'],
        ],
        'image' => 'inlocuire-parbriz-fisurat-tehnician',
    ],
    [
        'brand' => 'nissan', 'slug' => 'qashqai-j11', 'name' => 'Qashqai J11', 'years' => '2014–2021', 'bodies' => 'SUV compact',
        'adas' => 'optional', 'volume' => 50, 'queue' => 39,
        'primary' => 'parbriz nissan qashqai j11', 'secondary' => ['parbriz nissan qashqai j11 pret'],
        'intro' => 'Qashqai J11 poate avea cameră pe parbriz pentru recunoașterea indicatoarelor, avertizarea la părăsirea benzii și frânarea automată. Varianta de parbriz se alege după aceste dotări.',
        'variants' => ['Cu senzor de ploaie și lumină', 'Cu suport pentru cameră frontală, la versiunile cu pachet de siguranță', 'Cu bandă colorată sus'],
        'sections' => [
            ['Calibrarea camerei', 'Dacă mașina are cameră pe parbriz, după montajul unei sticle noi camera se calibrează. Fără calibrare, sistemele pot afișa erori sau pot funcționa greșit.'],
        ],
        'faq' => [
            ['Qashqai J11 facelift (2017) are alt parbriz?', 'Forma e aceeași; dotările pot diferi. Verificăm după seria de șasiu.'],
        ],
        'image' => 'montaj-parbriz-nou-doi-tehnicieni',
    ],
];
