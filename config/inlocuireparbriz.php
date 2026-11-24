<?php

/*
|--------------------------------------------------------------------------
| inlocuireparbriz.ro — catalog public
|--------------------------------------------------------------------------
| Sursă unică pentru paginile publice: servicii (landing-uri SEO), sectoare,
| opțiuni de formular. Chei = slug-urile din docs/discovery/url-architecture.md.
|
| Reguli de conținut: o singură companie, ton profesional, fără cifre,
| certificări, parteneriate sau recenzii nedovedite. Modelul se prezintă onest
| și discret: „oferta și montajul prin atelierele partenere verificate din zona ta”
| (decizia proprietarului, 24.11.2026). Nu detaliem alocarea internă a cererilor.
*/

return [

    'brand' => 'inlocuireparbriz.ro',
    'domain' => 'inlocuireparbriz.ro',
    'team' => 'Echipa inlocuireparbriz.ro',
    'city' => 'București',
    'city_slug' => 'bucuresti',
    'sectors' => [1, 2, 3, 4, 5, 6],

    /*
    | Opțiuni formular „Trimite detaliile mașinii”.
    */
    'glass_types' => [
        'parbriz' => 'Parbriz',
        'luneta' => 'Lunetă (geam spate)',
        'geam_lateral' => 'Geam lateral',
        'altele' => 'Alt tip de geam / nu știu',
    ],

    'glass_features' => [
        'senzor_ploaie' => 'Senzor de ploaie',
        'senzor_lumina' => 'Senzor de lumină',
        'camera_adas' => 'Cameră / sisteme de asistență (ADAS)',
        'incalzire' => 'Încălzire parbriz',
        'banda_solara' => 'Bandă solară în partea de sus',
        'hud' => 'Proiecție pe parbriz (HUD)',
        'acustic' => 'Sticlă acustică',
        'antena' => 'Antenă integrată',
    ],

    'location_types' => [
        'domiciliu' => 'La domiciliu / la adresa mea',
        'serviciu' => 'La birou / la locul de muncă',
        'service' => 'În service sau spațiu amenajat',
        'nu_stiu' => 'Nu știu încă, aștept recomandarea echipei',
    ],

    /*
    | Pagini de serviciu (landing-uri SEO). Cheia = slug-ul URL.
    | `category_slug` face legătura cu categoriile din baza de date (seeder).
    */
    'services' => [

        'inlocuire-parbriz-bucuresti' => [
            'category_slug' => 'inlocuire-parbriz',
            'name' => 'Înlocuire parbriz București',
            'nav_label' => 'Înlocuire parbriz',
            'icon' => 'windshield',
            'short' => 'Schimbare parbriz pentru autoturisme, în București și în sectoarele 1–6, cu ofertă personalizată după datele mașinii.',
            'h1' => 'Înlocuire parbriz în București',
            'meta' => 'Înlocuire parbriz în București, sectoarele 1–6. Trimiteți detaliile mașinii și primiți o ofertă personalizată pentru sticla potrivită.',
            'intro' => 'Un parbriz crăpat sau lovit nu este doar o problemă estetică, ci un element de siguranță al mașinii. Trimiteți datele autovehiculului, iar echipa noastră verifică sticla potrivită, vă pune întrebările necesare și revine cu o ofertă clară pentru înlocuirea parbrizului în București.',
            'show_sectors' => true,
            'items' => [
                'Înlocuire parbriz pentru autoturisme, în București, sectoarele 1–6',
                'Identificarea sticlei după marca, modelul, anul și dotările mașinii',
                'Variante de sticlă explicate pe înțelesul tuturor, fără presiune de decizie',
                'Montaj la adresa dumneavoastră sau în spațiu amenajat, după caz',
                'Recomandări clare pentru perioada de după montaj',
            ],
            'sections' => [
                ['De ce contează sticla potrivită', 'Parbrizul modern poate avea senzor de ploaie, senzor de lumină, suport pentru cameră, încălzire sau strat acustic. Două sticle care par identice pot fi diferite ca dotări. De aceea pornim de la datele reale ale mașinii și, ori de câte ori este posibil, de la seria de șasiu (VIN) din talon.'],
                ['Cum tratăm montajul', 'Înlocuirea corectă înseamnă pregătirea canalului de lipire, protejarea zonelor din jur, poziționarea exactă a sticlei și respectarea timpului de priză al adezivului. Nu grăbim etapele critice și vă spunem deschis când condițiile din ziua montajului nu permit o lipire corectă.'],
                ['Pentru persoane fizice și companii', 'Solicitările pot veni de la proprietari de autoturisme sau de la firme cu mai multe vehicule. Pentru companii există o pagină dedicată flotelor, iar pentru cei care doresc montaj la adresă, pagina de serviciu la domiciliu.'],
            ],
            'faq' => [
                ['Ce informații îmi trebuie pentru ofertă?', 'Marca, modelul și anul mașinii, tipul de geam și, dacă le aveți, seria de șasiu (VIN) și dotările vizibile ale parbrizului. Formularul vă ghidează pas cu pas.'],
                ['Cum primesc oferta?', 'După trimiterea formularului, echipa analizează vehiculul și sticla potrivită, apoi vă contactează la telefonul indicat, cu oferta și detaliile de programare.'],
                ['Pot alege între mai multe variante de sticlă?', 'Dacă mașina permite mai multe variante, vi le explicăm în ofertă, iar decizia vă aparține. Disponibilitatea unui anumit model se confirmă în ofertă.'],
                ['Sunt obligat să accept oferta?', 'Nu. Oferta este informativă, iar nicio lucrare nu începe fără acordul dumneavoastră.'],
            ],
        ],

        'inlocuire-parbriz-la-domiciliu' => [
            'category_slug' => 'inlocuire-parbriz-la-domiciliu',
            'name' => 'Înlocuire parbriz la domiciliu',
            'nav_label' => 'La domiciliu',
            'icon' => 'truck',
            'short' => 'Serviciu mobil în București: înlocuirea parbrizului la adresa dumneavoastră, atunci când locația și condițiile permit un montaj corect.',
            'h1' => 'Înlocuire parbriz la domiciliu în București',
            'meta' => 'Schimbare parbriz la domiciliu în București: montaj la adresa dumneavoastră, în funcție de locație și condiții meteo. Solicitați oferta.',
            'intro' => 'Nu aveți timp să duceți mașina într-un service sau nu doriți să conduceți cu parbrizul deteriorat? Putem organiza intervenția la adresa indicată, în București, în limitele impuse de siguranță și de calitatea lipirii. Trimiteți detaliile mașinii și locația, iar echipa confirmă dacă montajul mobil este varianta potrivită.',
            'show_sectors' => true,
            'items' => [
                'Montaj la domiciliu, la birou sau în parcări private, atunci când spațiul permite',
                'Evaluare prealabilă a locației pe baza informațiilor trimise',
                'Recomandare sinceră pentru spațiu închis când vremea sau mașina o cer',
                'Reprogramare în loc de compromisuri, dacă ziua montajului nu are condiții bune',
                'Indicații clare despre timpul de așteptare după lipire',
            ],
            'sections' => [
                ['Condiții necesare pentru montaj mobil', 'Este nevoie de un loc plan și stabil, cu spațiu pentru deschiderea portierelor, de acces la mașină și, de preferat, de un loc acoperit. Ploaia puternică, ninsoarea, praful intens sau temperaturile extreme pot afecta lipirea, caz în care recomandăm un spațiu amenajat sau reprogramarea.'],
                ['Ce pregătiți înainte', 'Eliberați bordul și zona parbrizului, demontați camera video, suportul de telefon sau parasolarele lipite pe sticlă și țineți cheile la îndemână pe toată durata lucrării. Pentru parcări subterane sau ansambluri rezidențiale, vă rugăm să ne comunicați regulile de acces înainte de programare.'],
                ['Când nu recomandăm montajul mobil', 'Mașinile cu sisteme complexe, locațiile fără acces facil sau condițiile meteo nefavorabile pot face ca un spațiu închis să fie alegerea mai bună. Vă spunem acest lucru în ofertă, pentru că un montaj corect contează mai mult decât comoditatea de moment.'],
            ],
            'faq' => [
                ['În ce zone se poate face montajul la domiciliu?', 'În București, sectoarele 1–6. Pentru localitățile din Ilfov, disponibilitatea se confirmă în ofertă, în funcție de locație.'],
                ['Cât trebuie să aștept după montaj?', 'Timpul depinde de adezivul folosit, de temperatură și de umiditate. Primiți indicațiile concrete la predare, iar în primele ore se recomandă evitarea șocurilor și a trântirii portierelor.'],
                ['Ce se întâmplă dacă plouă în ziua programată?', 'Vă anunțăm și propunem fie un loc acoperit, fie o nouă programare. Nu facem lipiri în condiții care pot afecta calitatea lucrării.'],
                ['Pot solicita montaj într-o parcare subterană?', 'Uneori da, în funcție de înălțimea accesului, de spațiu și de regulile clădirii. Descrieți situația în formular și vă răspundem cu varianta potrivită.'],
            ],
        ],

        'reparatie-parbriz' => [
            'category_slug' => 'reparatii-parbriz',
            'name' => 'Reparație parbriz',
            'nav_label' => 'Reparații',
            'icon' => 'chip',
            'short' => 'Evaluarea impacturilor și a fisurilor mici și recomandarea corectă între reparație și înlocuire.',
            'h1' => 'Reparație parbriz: impacturi și fisuri mici',
            'meta' => 'Reparație parbriz pentru impacturi mici: cum se alege între reparație și înlocuire. Trimiteți fotografii și detaliile mașinii pentru o evaluare.',
            'intro' => 'Nu orice lovitură înseamnă automat un parbriz nou. Un impact mic, apărut recent, poate fi uneori tratat prin reparație, dacă dimensiunea și locul lui permit. Trimiteți-ne fotografii clare și datele mașinii, iar echipa vă spune ce variantă pare mai potrivită; decizia finală se confirmă la inspecția directă.',
            'items' => [
                'Evaluare pe baza fotografiilor și a descrierii impactului',
                'Recomandare între reparație și înlocuire, explicată pe înțeles',
                'Informații despre ce poate și ce nu poate face o reparație',
                'Trecere simplă la înlocuire, dacă reparația nu este varianta prudentă',
                'Sfaturi de protecție provizorie a impactului până la intervenție',
            ],
            'sections' => [
                ['Când reparația poate fi o variantă', 'De regulă, se ia în discuție reparația atunci când deteriorarea este mică, recentă, departe de marginea sticlei și în afara câmpului principal de vizibilitate al șoferului. Cu cât intervenția vine mai repede după impact, cu atât șansele sunt, în general, mai bune.'],
                ['Când înlocuirea este alegerea prudentă', 'Fisurile lungi sau care se extind, impacturile multiple, deteriorările din apropierea marginii sau a senzorilor și sticla cu straturi afectate indică, de obicei, înlocuirea. Vă recomandăm înlocuirea chiar dacă este varianta mai laborioasă, atunci când este în interesul dumneavoastră.'],
                ['Ce nu promitem', 'O reparație poate reduce vizibilitatea impactului și poate opri extinderea fisurii, dar nu readuce sticla la starea inițială. Pentru conformitatea în fața inspecției tehnice, consultați stația ITP sau sursele oficiale.'],
            ],
            'faq' => [
                ['Pot trimite fotografii pentru evaluare?', 'Da. Fotografiile clare ale impactului, făcute din interior și din exterior, ajută la o părere preliminară. Confirmarea se face la inspecția directă.'],
                ['Ce fac până la intervenție?', 'Puteți acoperi impactul cu o bandă transparentă, pentru a nu intra murdărie, și puteți evita spălarea sub presiune și schimbările bruște de temperatură în habitaclu.'],
                ['Reparația se vede?', 'Reparația reduce vizibilitatea impactului, dar nu îl face să dispară complet. Nu promitem un aspect ca nou.'],
                ['Se poate repara orice impact?', 'Nu. Dimensiunea, locul și vechimea impactului decid. Dacă reparația nu este prudentă, vă recomandăm înlocuirea.'],
            ],
        ],

        'inlocuire-luneta-si-geamuri-laterale' => [
            'category_slug' => 'luneta-geamuri-laterale',
            'name' => 'Înlocuire lunetă și geamuri laterale',
            'nav_label' => 'Lunetă și geamuri laterale',
            'icon' => 'car',
            'short' => 'Înlocuire pentru luneta mașinii și pentru geamurile laterale, după datele vehiculului și tipul de sticlă.',
            'h1' => 'Înlocuire lunetă și geamuri laterale',
            'meta' => 'Înlocuire lunetă și geamuri laterale pentru autoturisme. Trimiteți detaliile mașinii și tipul de geam pentru o ofertă personalizată.',
            'intro' => 'Luneta și geamurile laterale se sparg sau se fisurează din motive diferite față de parbriz, iar înlocuirea lor are alte particularități: încălzire, antenă, geam securizat sau laminat, mecanism de acționare. Trimiteți datele mașinii și precizați ce geam este afectat, iar echipa vă confirmă varianta potrivită.',
            'items' => [
                'Înlocuire lunetă, inclusiv variante cu încălzire sau antenă integrată',
                'Înlocuire geam lateral față sau spate, după modelul mașinii',
                'Verificarea dotărilor care influențează alegerea sticlei',
                'Curățarea zonei de cioburi și a canalelor de lipire sau de ghidare',
                'Informații despre ce se verifică înainte de predare',
            ],
            'sections' => [
                ['Lunetă: ce contează la alegerea sticlei', 'Multe lunete au rezistențe de încălzire sau antenă integrată, iar conectarea lor corectă este importantă. Din acest motiv vă cerem să precizați dotările vizibile și, dacă este posibil, seria de șasiu.'],
                ['Geamuri laterale', 'Geamul lateral poate fi securizat sau laminat, cu sau fără particularități de acționare. Identificăm varianta potrivită pe baza modelului, a anului și a caroseriei. Disponibilitatea pentru fiecare model se confirmă în ofertă.'],
                ['După spargere', 'Dacă geamul s-a spart, curățați cu grijă cioburile din interior și protejați provizoriu deschiderea. Vă putem spune în ofertă ce se recomandă până la intervenție.'],
            ],
            'faq' => [
                ['Se poate înlocui un singur geam lateral?', 'Da. Precizați în formular care geam este afectat (față sau spate, stânga sau dreapta) și datele mașinii.'],
                ['Luneta cu încălzire se poate înlocui?', 'În general da, cu verificarea conexiunilor. Menționați în formular dacă luneta are încălzire sau antenă.'],
                ['Se poate face la domiciliu?', 'În multe cazuri, da, în limitele locației și ale condițiilor meteo. Confirmarea se face în ofertă.'],
                ['Ce documente sau date mă ajută?', 'Marca, modelul, anul mașinii și, dacă le aveți, seria de șasiu și câteva fotografii cu geamul afectat.'],
            ],
        ],

        'calibrare-adas' => [
            'category_slug' => 'calibrare-adas',
            'name' => 'Calibrare ADAS după înlocuirea parbrizului',
            'nav_label' => 'Calibrare ADAS',
            'icon' => 'camera',
            'short' => 'Informații prudente despre sistemele de asistență de pe parbriz și despre situațiile în care poate fi necesară o calibrare.',
            'h1' => 'Calibrare ADAS după înlocuirea parbrizului',
            'meta' => 'Calibrare ADAS după înlocuirea parbrizului: când poate fi necesară și ce informații trebuie să ne trimiteți despre mașina dumneavoastră.',
            'intro' => 'Multe mașini moderne au o cameră montată în spatele parbrizului, folosită de sisteme de asistență la condus (ADAS). După înlocuirea sticlei, producătorul poate cere o verificare sau o calibrare a camerei. Nu orice mașină are nevoie de ea, iar cerințele diferă de la un model la altul. Trimiteți detaliile mașinii, iar echipa vă informează ce se aplică în cazul dumneavoastră.',
            'items' => [
                'Identificarea dotărilor ADAS vizibile pe parbriz și în zona oglinzii',
                'Informare despre situațiile în care producătorul poate cere calibrare',
                'Includerea în ofertă a pașilor necesari pentru mașina dumneavoastră',
                'Coordonarea înlocuirii sticlei cu etapa de verificare, acolo unde este cazul',
                'Explicații clare despre limitele unei estimări făcute doar pe baza datelor trimise',
            ],
            'sections' => [
                ['Ce este ADAS pe un parbriz', 'Sistemele de asistență pot include avertizare la părăsirea benzii, recunoașterea semnelor de circulație sau frânare automată de urgență. Pentru ele, o cameră sau un senzor „privește” prin parbriz, iar poziția lui exactă contează.'],
                ['Când poate fi necesară calibrarea', 'Indicațiile depind de producător și de model. Informațiile oficiale ale constructorului sunt reperul final. În ofertă vă spunem ce a rezultat pe baza datelor primite și ce se confirmă la inspecția mașinii.'],
                ['Ce vă rugăm să ne trimiteți', 'Marca, modelul, anul, seria de șasiu (VIN) și o fotografie a zonei din jurul oglinzii retrovizoare. Dacă mașina a avut lucrări la camere sau la geometria punții, menționați acest lucru în formular.'],
            ],
            'faq' => [
                ['Toate mașinile au nevoie de calibrare după schimbarea parbrizului?', 'Nu. Depinde de dotările și de cerințele producătorului pentru modelul respectiv. Vă informăm ce se aplică după analiza datelor trimise.'],
                ['Se face calibrarea în aceeași zi?', 'Termenele se stabilesc individual și se confirmă în ofertă, în funcție de mașină și de programare. Nu putem promite un termen valabil pentru toate cazurile.'],
                ['De unde știu dacă mașina mea are ADAS?', 'Căutați o cameră în zona oglinzii retrovizoare sau consultați manualul mașinii. Dacă nu sunteți siguri, trimiteți o fotografie și datele mașinii.'],
                ['Ce se întâmplă dacă nu sunt sigur că am nevoie?', 'Bifați opțiunea „Cameră / sisteme de asistență” din formular sau scrieți câteva rânduri; echipa clarifică împreună cu dumneavoastră.'],
            ],
        ],

        'parbrize-flote-firme' => [
            'category_slug' => 'flote-firme',
            'name' => 'Parbrize pentru flote și firme',
            'nav_label' => 'Flote și firme',
            'icon' => 'building',
            'short' => 'Cerere centralizată, informații despre fiecare vehicul și programări coordonate pentru companii cu mai multe mașini.',
            'h1' => 'Parbrize pentru flote auto și firme',
            'meta' => 'Parbrize pentru flote auto și firme din București și Ilfov: cerere centralizată, programări coordonate și un singur punct de contact.',
            'intro' => 'Pentru companiile care administrează mai multe vehicule, înlocuirea sticlei trebuie să se încadreze în programul de lucru. Propunem o abordare organizată: o cerere centralizată, informații despre fiecare vehicul și un singur punct de contact pentru ofertă, programare și documente.',
            'items' => [
                'Cerere centralizată pentru mai multe vehicule',
                'Date de identificare pentru fiecare mașină, pentru sticla corectă',
                'Programări care țin cont de activitatea companiei',
                'Montaj la sediu sau în spațiu amenajat, după locație',
                'Documente pentru evidența contabilă, conform ofertei',
            ],
            'sections' => [
                ['Cum se desfășoară colaborarea', 'Ne trimiteți lista vehiculelor (marcă, model, an, număr de înmatriculare sau VIN) și locațiile unde se află. Analizăm datele, revenim cu o ofertă și stabilim împreună ordinea intervențiilor.'],
                ['Condiții adaptate firmei', 'Termenele, condițiile de plată și eventualele colaborări recurente se discută individual și se confirmă în scris. Nu publicăm tarife generale sau promisiuni care nu pot fi respectate în toate cazurile.'],
                ['Utilitare și vehicule speciale', 'Utilitarele și vehiculele cu parbriz sau geamuri speciale pot necesita verificări suplimentare. Menționați tipul vehiculului în cerere, iar disponibilitatea se confirmă în ofertă.'],
            ],
            'faq' => [
                ['Cum trimit date pentru mai multe vehicule?', 'Puteți completa formularul pentru primul vehicul și menționa în detalii numărul total de mașini; echipa vă contactează pentru lista completă.'],
                ['Pot programa mai multe mașini în aceeași zi?', 'Depinde de locație, de tipul sticlei și de disponibilitate. Planificarea se stabilește în ofertă.'],
                ['Se emit documente pentru contabilitate?', 'Da, documentele se stabilesc și se confirmă în ofertă, conform cerințelor firmei.'],
                ['Acoperiți și Ilfov?', 'Pentru locații din Ilfov, disponibilitatea se confirmă individual în ofertă.'],
            ],
        ],

        'parbriz-pe-casco' => [
            'category_slug' => 'parbriz-casco',
            'name' => 'Parbriz pe CASCO',
            'nav_label' => 'Parbriz pe CASCO',
            'icon' => 'shield',
            'short' => 'Informații orientative despre înlocuirea parbrizului în cazul unei polițe CASCO și despre datele de care aveți nevoie.',
            'h1' => 'Parbriz pe CASCO: ce trebuie să știți',
            'meta' => 'Parbriz pe CASCO: informații orientative despre înlocuire, documente și pașii practici. Condițiile depind de polița dumneavoastră.',
            'intro' => 'Dacă aveți o poliță CASCO, înlocuirea parbrizului poate fi acoperită în anumite condiții. Acoperirea, franșiza și procedura sunt stabilite exclusiv de polița dumneavoastră și de asigurător. Noi vă ajutăm cu partea practică: identificarea sticlei, oferta și documentele pe care le puteți depune la asigurător.',
            'items' => [
                'Oferta personalizată pe care o puteți folosi în relația cu asigurătorul',
                'Identificarea corectă a sticlei, după datele mașinii',
                'Informații generale despre pașii obișnuiți în cazul unei daune la parbriz',
                'Programarea montajului, după confirmarea aspectelor administrative',
                'Transparență privind ce depinde de asigurător și ce depinde de noi',
            ],
            'sections' => [
                ['Ce depinde de poliță', 'Modul în care este tratată o daună la parbriz diferă între polițe: unele includ geamurile, altele au limite sau franșize. Vă rugăm să verificați contractul sau să întrebați asigurătorul înainte de programare.'],
                ['Ce vă ajută să aveți la îndemână', 'Seria de șasiu (VIN), datele poliței, fotografii cu parbrizul deteriorat și, dacă este cazul, informații despre circumstanțele daunei. Echipa vă spune în ofertă ce alte detalii sunt utile.'],
                ['Ce nu afirmăm', 'Nu avem promisiuni generale privind decontarea, rapiditatea sau acceptarea dosarului de către asigurători. Fiecare caz se tratează conform poliței și procedurilor asigurătorului.'],
            ],
            'faq' => [
                ['Se acoperă parbrizul prin CASCO?', 'Depinde de polița dumneavoastră. Verificați condițiile contractuale sau contactați asigurătorul.'],
                ['Pot primi o ofertă pentru asigurător?', 'Da. Trimiteți detaliile mașinii, iar echipa pregătește oferta personalizată, pe care o puteți folosi în dosarul de daună.'],
                ['Ce se întâmplă cu RCA?', 'Condițiile RCA diferă de cele CASCO și depind de circumstanțele evenimentului. Pentru situații concrete, consultați asigurătorul.'],
                ['Cine stabilește franșiza?', 'Franșiza este stabilită prin contractul de asigurare dintre dumneavoastră și asigurător.'],
            ],
        ],

        'pret-inlocuire-parbriz' => [
            'category_slug' => 'inlocuire-parbriz',
            'name' => 'Preț înlocuire parbriz',
            'nav_label' => 'Preț',
            'icon' => 'tag',
            'short' => 'Ce influențează prețul unei înlocuiri de parbriz și de ce oferta se face personalizat, pe baza datelor mașinii.',
            'h1' => 'Preț înlocuire parbriz: de ce depinde de mașină',
            'meta' => 'Preț înlocuire parbriz: factorii care influențează costul și cum primiți o ofertă personalizată pe baza datelor mașinii.',
            'intro' => 'Nu există un preț unic pentru parbriz, pentru că sticla diferă de la un model la altul. Costul depinde de mașină, de dotările parbrizului, de varianta de sticlă și de condițiile de montaj. Pentru a evita estimările la întâmplare, pregătim oferta după ce primim datele mașinii.',
            'items' => [
                'Marca, modelul și anul mașinii',
                'Dotările parbrizului: senzori, cameră, încălzire, bandă solară, HUD',
                'Varianta de sticlă disponibilă pentru modelul respectiv',
                'Locul montajului: la adresă sau în spațiu amenajat',
                'Eventuale lucrări asociate, cum ar fi verificarea sistemelor de asistență',
            ],
            'sections' => [
                ['De ce nu publicăm un tarif general', 'Un preț „de la” pentru toate mașinile ar fi înșelător: aceeași marcă poate avea sticle foarte diferite în funcție de versiune și de dotări. Preferăm să vă dăm o ofertă corectă pentru mașina dumneavoastră.'],
                ['Ce conține oferta', 'Oferta indică varianta de sticlă propusă, condițiile de montaj și informațiile importante pentru mașina dumneavoastră. Termenele și detaliile de livrare se confirmă în ofertă, nu pe această pagină.'],
                ['Cum obțineți oferta mai repede', 'Cu seria de șasiu (VIN), o fotografie a zonei din jurul oglinzii și precizarea dotărilor vizibile, identificarea sticlei este mai rapidă. Nu este obligatoriu să aveți toate datele de la început.'],
            ],
            'faq' => [
                ['Este gratuită solicitarea ofertei?', 'Da. Trimiterea formularului nu implică niciun angajament.'],
                ['Prețul include montajul?', 'Oferta precizează ce este inclus. Detaliile se confirmă în scris, la momentul ofertei.'],
                ['Pot afla un preț prin telefon?', 'Pentru a evita informații greșite, preferăm să analizăm datele mașinii înainte de a comunica un preț. Formularul este cea mai rapidă cale.'],
                ['Se schimbă prețul după ofertă?', 'Oferta se bazează pe datele primite. Dacă la inspecție apar diferențe față de informațiile trimise, vă anunțăm înainte de începerea lucrării.'],
            ],
        ],

        'inlocuire-parbriz-ilfov' => [
            'category_slug' => 'inlocuire-parbriz',
            'name' => 'Înlocuire parbriz Ilfov',
            'nav_label' => 'Ilfov',
            'icon' => 'pin',
            'short' => 'Solicitări pentru localități din jurul Bucureștiului, cu disponibilitate confirmată în ofertă.',
            'h1' => 'Înlocuire parbriz în Ilfov',
            'meta' => 'Înlocuire parbriz în Ilfov: trimiteți localitatea și detaliile mașinii, iar disponibilitatea și condițiile se confirmă în ofertă.',
            'intro' => 'Dacă mașina se află într-o localitate din județul Ilfov, trimiteți-ne localitatea și datele autovehiculului. Verificăm disponibilitatea pentru zona dumneavoastră și vă comunicăm în ofertă dacă și în ce condiții se poate organiza montajul.',
            'items' => [
                'Solicitări pentru localități din jurul Bucureștiului',
                'Confirmarea disponibilității pe baza localității trimise',
                'Aceeași analiză a vehiculului și a sticlei ca pentru București',
                'Montaj la adresă sau în spațiu amenajat, după caz',
                'Condiții și termene clar precizate în ofertă',
            ],
            'sections' => [
                ['Cum funcționează pentru Ilfov', 'Alegeți „Ilfov” în formular și scrieți localitatea în detalii. Nu publicăm o listă fixă de localități: fiecare solicitare este analizată individual.'],
                ['Ce poate influența organizarea', 'Distanța, accesul la adresă, spațiul disponibil și condițiile meteo contează pentru un montaj corect. Dacă nu putem lucra în siguranță la adresa indicată, propunem o alternativă.'],
                ['București și Ilfov', 'Pentru București, serviciul este descris pe pagina de înlocuire parbriz în București și pe paginile pe sectoare. Pentru montaj mobil, consultați pagina dedicată serviciului la domiciliu.'],
            ],
            'faq' => [
                ['Ce localități din Ilfov acoperiți?', 'Fiecare solicitare se verifică individual. Scrieți localitatea în formular, iar răspunsul vine în ofertă.'],
                ['Se aplică aceleași condiții ca în București?', 'Principiile de lucru sunt aceleași. Termenele și condițiile logistice pot diferi și se confirmă în ofertă.'],
                ['Pot comanda montaj la adresă?', 'Posibil, în funcție de locație și condiții. Echipa vă spune în ofertă dacă varianta este potrivită.'],
                ['Ce informații adaug pentru Ilfov?', 'Localitatea, tipul locului (curte, parcare, hală) și accesul auto, pe lângă datele mașinii.'],
            ],
        ],
    ],

    /*
    | Pagini pe sectoare: /inlocuire-parbriz-bucuresti/sector-{n}/
    | Conținut local propriu fiecărui sector (zone cunoscute, particularități
    | practice), pentru unicitate. `indexable` rămâne false până la verificarea
    | unicității (vezi url-architecture.md §6); pre-lansare tot site-ul este noindex.
    */
    'sector_pages' => [
        1 => [
            'areas' => ['Aviatorilor', 'Dorobanți', 'Victoriei', 'Floreasca Nord', 'Băneasa', 'Domenii', 'Herăstrău'],
            'neighbours' => [2, 6],
            'intro' => 'Sectorul 1 reunește zone rezidențiale și de birouri, de la Aviatorilor și Dorobanți până la Băneasa și Domenii. Mulți clienți din această zonă lucrează în clădiri de birouri cu parcări private sau subterane, iar o parte dintre cei care solicită montajul la adresă preferă un loc acoperit.',
            'local' => 'În zonele cu mulți rezidenți și birouri, accesul în parcări și regulile administrației pot influența organizarea. Ne ajută să știm dacă există bariere, limită de înălțime sau nevoie de aprobare prealabilă, ca să stabilim din timp locul potrivit.',
            'indexable' => false,
        ],
        2 => [
            'areas' => ['Floreasca', 'Colentina', 'Obor', 'Tei', 'Iancului', 'Moșilor', 'Andronache'],
            'neighbours' => [1, 3],
            'intro' => 'Sectorul 2 are zone rezidențiale dense, de la Colentina și Obor până la Tei și Floreasca. Aici sunt frecvente blocurile cu parcări amenajate pe teren comun și străzile cu locuri limitate, ceea ce contează pentru un montaj la adresă.',
            'local' => 'Pentru montajul mobil este important să existe un loc în care mașina poate sta nemișcată pe durata lucrării. Dacă locul din fața blocului este greu de eliberat, putem discuta alte variante: parcare privată, curte sau spațiu amenajat.',
            'indexable' => false,
        ],
        3 => [
            'areas' => ['Titan', 'Dristor', 'Vitan', 'Balta Albă', 'Dudești', 'Centrul Civic', 'Muncii'],
            'neighbours' => [2, 4],
            'intro' => 'Sectorul 3 include cartiere rezidențiale mari, precum Titan, Dristor și Balta Albă, dar și zone cu activitate comercială și de depozitare. Este un sector în care multe vehicule sunt folosite zilnic, iar timpul de imobilizare contează.',
            'local' => 'Pentru cei care folosesc mașina zilnic, recomandăm să alegem împreună un interval în care mașina poate rămâne nemișcată după lipire. Pentru firme cu sediul în zonă, poate fi utilă o programare coordonată cu programul de lucru.',
            'indexable' => false,
        ],
        4 => [
            'areas' => ['Berceni', 'Tineretului', 'Timpuri Noi', 'Oltenița', 'Văcărești', 'Giurgiului'],
            'neighbours' => [3, 5],
            'intro' => 'Sectorul 4 are zone rezidențiale precum Berceni și Tineretului, alături de artere circulate precum Oltenița și Giurgiului. Mulți șoferi din zonă fac naveta zilnic, iar un parbriz deteriorat se observă repede pe drumurile aglomerate.',
            'local' => 'În cartierele cu parcări aglomerate poate fi nevoie de un loc stabilit din timp pentru montaj. Dacă mașina stă într-o parcare subterană sau într-un complex rezidențial, vă rugăm să ne spuneți regulile de acces.',
            'indexable' => false,
        ],
        5 => [
            'areas' => ['Rahova', 'Cotroceni', '13 Septembrie', 'Ferentari', 'Panduri', 'Antiaeriană'],
            'neighbours' => [4, 6],
            'intro' => 'Sectorul 5 reunește zone diverse: Cotroceni, cu străzi și parcări restrânse, Rahova și 13 Septembrie, cu ansambluri rezidențiale, și zone în dezvoltare. Particularitățile locației se discută în funcție de adresă.',
            'local' => 'Pe străzile înguste sau în zonele cu spațiu limitat, montajul la adresă poate fi mai dificil. În aceste cazuri propunem fie un loc alternativ, fie un spațiu amenajat, după ce analizăm informațiile trimise.',
            'indexable' => false,
        ],
        6 => [
            'areas' => ['Drumul Taberei', 'Militari', 'Crângași', 'Giulești', 'Ghencea', 'Lujerului', 'Păcii'],
            'neighbours' => [1, 5],
            'intro' => 'Sectorul 6 acoperă cartiere extinse, de la Drumul Taberei și Militari până la Giulești și Ghencea. Distanțele sunt mari, iar multe locații sunt ansambluri rezidențiale cu parcări comune, unde se aplică reguli proprii.',
            'local' => 'Pentru ansamblurile mari, precizarea blocului, a accesului și a locului de parcare ajută la o programare fără surprize. Dacă vremea nu permite montajul în aer liber, vă recomandăm să alegeți un loc acoperit.',
            'indexable' => false,
        ],
    ],
];
