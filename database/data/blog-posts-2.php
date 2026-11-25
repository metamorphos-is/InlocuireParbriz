<?php

/*
 * Calendarul editorial, etapa 2 (25.11.2026). Subiecte din exporturile DataForSEO (rulările #1 și #2) și din întrebările clienților.
 * `now` = publicat imediat; restul intră în coada de publicare zilnică (`queue` = poziția).
 * Fiecare articol țintește o întrebare informațională și trimite spre o pagină de serviciu, fără să concureze cu ea.
 */

return [
    [
        'slug' => 'parbriz-iarna-fisuri', 'now' => true,
        'title' => 'Parbrizul iarna: cum eviți fisurile când dezgheți mașina',
        'category' => 'ghiduri', 'primary_keyword' => 'protectie parbriz iarna', 'search_volume' => 390,
        'secondary_keywords' => ['dezaburitor parbriz', 'parbriz inghetat', 'parbriz crapat de frig'],
        'related_service' => '/reparatie-parbriz', 'image' => 'fisura-lunga-parbriz',
        'seo_title' => 'Parbrizul iarna: cum eviți fisurile | inlocuireparbriz.ro',
        'meta_description' => 'De ce crapă parbrizul iarna și cum îl dezgheți corect: apa caldă, răzuitorul, dezaburitorul și ce faci dacă ai deja o ciobitură înainte de ger.',
        'excerpt' => 'Iarna, cele mai multe parbrize nu se sparg din cauza pietrelor, ci din cauza diferențelor de temperatură. Câteva obiceiuri simple te scutesc de o fisură și de un parbriz nou.',
        'body' => <<<'MD'
Dimineața, la minus zece grade, tentația e să torni apă caldă pe parbriz sau să pornești aerul cald la maximum. Sunt exact gesturile care transformă o ciobitură mică într-o fisură care traversează sticla. Iată de ce se întâmplă și cum eviți asta.

## De ce crapă parbrizul iarna

Parbrizul este o sticlă laminată: două foi de sticlă lipite cu o folie intermediară. Când o parte a sticlei se încălzește brusc, iar restul rămâne rece, apar tensiuni. O sticlă intactă le suportă de obicei, dar o ciobitură — chiar una pe care n-ai observat-o — este un punct slab de unde fisura pornește. De aceea, multe parbrize „crapă singure” în primele zile cu ger.

## Ce să nu faci

- **Nu turna apă caldă sau fierbinte pe parbriz.** Șocul termic e cel mai rapid mod de a crăpa o sticlă deja ciobită.
- **Nu îndrepta aerul cald la maximum direct pe sticla înghețată.** Pornește ventilația pe treapta mică și las-o să încălzească treptat.
- **Nu folosi obiecte metalice sau cardul bancar pentru gheață.** Zgârieturile fine rămân și se văd noaptea, în lumina farurilor.
- **Nu porni ștergătoarele pe parbrizul înghețat.** Lamele se rup, iar motorul ștergătoarelor se poate defecta.

## Cum dezgheți corect

1. Pornește motorul și ventilația spre parbriz pe o treaptă mică, cu recircularea oprită.
2. Folosește un spray de degivrare și un răzuitor din plastic, cu mișcări fără presiune mare.
3. Dacă ai **dezaburitor** sau parbriz încălzit, folosește-l — e făcut exact pentru asta și încălzește sticla uniform.
4. Seara, o husă de protecție pe parbriz te scutește de răzuit dimineața. Este cea mai simplă protecție pentru parbriz iarna.

Pentru aburul din interior, aerul condiționat pornit odată cu încălzirea usucă aerul și curăță parbrizul mai repede.

## Ai deja o ciobitură? Rezolv-o înainte de ger

O ciobitură mică, recentă și departe de margine se poate repara de multe ori fără să schimbi parbrizul. Reparația umple impactul cu rășină și oprește extinderea. Odată ce fisura a pornit, varianta sigură devine înlocuirea. Dacă vezi un impact, lipește o bandă transparentă peste el, evită dezghețarea bruscă și cere o [evaluare pentru reparație](/reparatie-parbriz).

## Se poate schimba parbrizul iarna?

Da, dar într-un spațiu acoperit. Adezivul are nevoie de o anumită temperatură și de timp ca să se întărească, așa că iarna montajul se face de preferință în atelier. Află mai multe în articolul despre [cât durează schimbarea parbrizului](/blog/cat-dureaza-schimbarea-parbrizului).
MD,
        'faq' => [
            ['q' => 'De ce a crăpat parbrizul peste noapte, deși nu l-a lovit nimic?', 'a' => 'Cel mai probabil exista deja o ciobitură mică, iar diferența de temperatură a extins-o. Uneori impactul e atât de mic încât nu se observă până nu pornește fisura.'],
            ['q' => 'Ajută lichidul de parbriz de iarnă?', 'a' => 'Da, pentru că nu îngheață pe sticlă și în rezervor. Nu repară însă o ciobitură și nu previne fisurile de la șoc termic.'],
        ],
    ],
    [
        'slug' => 'parbriz-spart-ce-faci', 'queue' => 10,
        'title' => 'Parbriz spart pe drum: ce faci în primele minute',
        'category' => 'reparatii', 'primary_keyword' => 'parbriz spart', 'search_volume' => 170,
        'secondary_keywords' => ['parbriz crapat', 'parbriz spart ce faci', 'reparatie parbriz spart'],
        'related_service' => '/', 'image' => 'parbriz-spart-trafic-oras',
        'seo_title' => 'Parbriz spart pe drum: ce faci în primele minute | inlocuireparbriz.ro',
        'meta_description' => 'Ți s-a spart parbrizul în mers? Ce faci în siguranță, dacă poți continua drumul, ce documente îți trebuie pentru asigurare și cum ceri un parbriz nou.',
        'excerpt' => 'Un impact puternic, o fisură care se întinde sub ochii tăi — primul instinct e să frânezi. Iată pașii care te țin în siguranță și te ajută și la dosarul de asigurare.',
        'body' => <<<'MD'
Un parbriz modern nu „cade” în habitaclu: sticla laminată ține bucățile lipite de folia intermediară. Asta îți dă timp să reacționezi calm, chiar dacă impactul e puternic și sticla e plină de fisuri.

## Primele minute

- **Nu frâna brusc.** Semnalizează, redu viteza și oprește într-un loc sigur.
- **Verifică dacă vezi bine.** Dacă fisurile îți acoperă câmpul vizual sau sticla e înfundată, nu continua drumul.
- **Fotografiază parbrizul și locul**, inclusiv numărul de înmatriculare al vehiculului din față, dacă impactul a venit de la o piatră ridicată de el. Fotografiile ajută la asigurare.
- **Acoperă impactul cu bandă transparentă** dacă trebuie să mai conduci puțin, ca să nu intre apă și praf.

## Pot continua drumul?

Dacă e doar o ciobitură sau o fisură scurtă în afara câmpului vizual al șoferului, de obicei poți ajunge acasă, conducând mai încet și evitând gropile. Dacă fisura trece prin fața șoferului, sticla e înfundată sau ai mai multe impacturi, cheamă tractarea. Un parbriz slăbit nu mai susține plafonul la fel de bine și poate afecta funcționarea airbagului pasagerului.

## Asigurare: CASCO sau RCA

Dacă ai CASCO cu acoperire pentru geamuri, anunță asigurătorul cât mai repede și întreabă ce documente cere. Dacă paguba a fost produsă de un vehicul identificat, poate intra pe RCA-ul acelui vehicul, dar ai nevoie de dovezi. Detalii în ghidul nostru despre [parbriz prin CASCO](/parbriz-pe-casco).

## Parbriz nou: ce ne trimiți

Marca, modelul, anul și seria de șasiu (VIN), plus o fotografie cu zona din spatele oglinzii. Așa identificăm parbrizul corect — cu senzori, cameră sau încălzire — și primești [oferta pentru înlocuirea parbrizului](/cerere-oferta) prin atelierele partenere verificate din orașul tău.
MD,
        'faq' => [
            ['q' => 'Poate un parbriz spart să cadă peste mine?', 'a' => 'Foarte rar. Parbrizul este laminat, iar folia intermediară ține bucățile împreună. Cu toate acestea, un parbriz grav deteriorat nu trebuie folosit.'],
            ['q' => 'Primesc amendă pentru parbrizul crăpat?', 'a' => 'O sticlă care îți limitează vizibilitatea poate fi sancționată la un control în trafic și poate pica ITP-ul. Cel mai sigur e să o rezolvi cât mai repede.'],
        ],
    ],
    [
        'slug' => 'senzor-ploaie-dupa-schimbarea-parbrizului', 'queue' => 12,
        'title' => 'Senzorul de ploaie după schimbarea parbrizului: ce trebuie să știi',
        'category' => 'sticla-auto', 'primary_keyword' => 'senzor ploaie parbriz', 'search_volume' => 140,
        'secondary_keywords' => ['parbriz cu senzor ploaie', 'senzor ploaie nu functioneaza dupa schimbare parbriz'],
        'related_service' => '/calibrare-adas', 'image' => 'parbriz-ploaie-senzor',
        'seo_title' => 'Senzorul de ploaie după schimbarea parbrizului | inlocuireparbriz.ro',
        'meta_description' => 'Cum funcționează senzorul de ploaie, de ce parbrizul nou trebuie să aibă suportul potrivit și ce faci dacă ștergătoarele automate nu mai merg după montaj.',
        'excerpt' => 'Senzorul de ploaie e mic, dar are nevoie de un parbriz potrivit și de un montaj atent. Iată ce se întâmplă cu el când schimbi parbrizul.',
        'body' => <<<'MD'
Senzorul de ploaie stă în spatele oglinzii retrovizoare, lipit de parbriz. El trimite lumină infraroșie prin sticlă și măsoară cât se întoarce: picăturile de apă schimbă reflexia, iar mașina pornește ștergătoarele. De multe ori, același senzor măsoară și lumina, pentru farurile automate.

## Parbrizul trebuie să aibă suportul potrivit

Pe parbrizele pentru mașinile cu senzor, din fabrică este lipit un suport (o ramă) în care se prinde senzorul, iar zona din dreptul lui este clară optic. Un parbriz fără suport sau cu suport pentru alt tip de senzor nu funcționează corect. De aceea, la cererea de ofertă, e important să spui dacă ai ștergătoare automate.

## Ce se întâmplă la montaj

Senzorul se desprinde de pe parbrizul vechi și se montează pe cel nou. Între senzor și sticlă există un gel sau un pad optic transparent, care trebuie înlocuit: unul vechi, cu bule de aer, face ca senzorul să „vadă” greșit.

## Ștergătoarele nu mai merg bine după montaj

Cauzele obișnuite:

- padul optic nu a fost schimbat sau are bule de aer;
- parbrizul nu are zona optică potrivită pentru senzorul tău;
- senzorul nu e prins complet în suport;
- la unele mașini, sensibilitatea senzorului trebuie resetată din meniul mașinii sau cu un tester.

Dacă ștergătoarele pornesc singure pe vreme uscată sau nu pornesc deloc pe ploaie, cere verificarea montajului.

## Senzor de ploaie și cameră

Pe multe mașini noi, senzorul de ploaie stă lângă camera pentru asistență la condus. Camera, spre deosebire de senzor, are nevoie de calibrare după montaj. Detalii pe pagina [calibrare ADAS](/calibrare-adas).
MD,
        'faq' => [
            ['q' => 'Pot pune un parbriz fără senzor dacă mașina are senzor?', 'a' => 'Tehnic se poate monta, dar pierzi ștergătoarele și farurile automate, iar pe bord pot apărea erori. Recomandăm varianta cu suport.'],
            ['q' => 'Trebuie calibrat senzorul de ploaie?', 'a' => 'De obicei nu ca o cameră, dar la unele mașini se resetează sau se verifică funcționarea după montaj.'],
        ],
    ],
    [
        'slug' => 'silicon-parbriz-cu-ce-se-lipeste', 'queue' => 14,
        'title' => 'Silicon pentru parbriz? Cu ce se lipește, de fapt, un parbriz',
        'category' => 'sticla-auto', 'primary_keyword' => 'silicon parbriz', 'search_volume' => 720,
        'secondary_keywords' => ['lipit parbriz', 'silicon lipit parbriz', 'silicon parbriz auto', 'adeziv parbriz'],
        'related_service' => '/', 'image' => 'montaj-parbriz-nou-doi-tehnicieni',
        'seo_title' => 'Silicon parbriz? Cu ce se lipește, de fapt | inlocuireparbriz.ro',
        'meta_description' => 'Parbrizul nu se lipește cu silicon, ci cu adeziv poliuretanic. De ce contează, de ce nu e o lucrare de casă și ce faci la infiltrații.',
        'excerpt' => 'Mulți caută „silicon pentru parbriz”, dar parbrizul unei mașini nu se lipește cu silicon. Iată ce adeziv se folosește și de ce contează pentru siguranța ta.',
        'body' => <<<'MD'
În limbaj obișnuit, orice pastă care lipește și etanșează e numită „silicon”. La parbriz, însă, diferența dintre silicon și adezivul corect este o chestiune de siguranță.

## Parbrizul se lipește cu adeziv poliuretanic

Parbrizele moderne se montează cu un **adeziv poliuretanic** special pentru sticla auto. După întărire, el leagă sticla de caroserie atât de puternic încât parbrizul devine parte din structura mașinii: susține plafonul la răsturnare și oferă sprijin airbagului pasagerului, care se deschide spre parbriz.

Siliconul obișnuit nu are această rezistență. Poate etanșa o vreme împotriva apei, dar nu ține parbrizul pe loc la un impact.

## De ce nu e o lucrare „de casă”

Pentru un montaj corect, e nevoie de:

- tăierea și curățarea adezivului vechi, fără să zgârii vopseaua canalului;
- primer pe sticlă și pe caroserie, acolo unde producătorul adezivului îl cere;
- un cordon de adeziv uniform, cu grosimea potrivită;
- poziționarea exactă a parbrizului, de regulă cu două persoane sau un dispozitiv;
- respectarea timpului minim până la condus, care depinde de adeziv și de temperatură.

Un parbriz lipit greșit poate avea infiltrații, zgomote de vânt sau, mai grav, se poate desprinde la un accident.

## Ai infiltrații la un parbriz existent?

Nu încerca să „astupi” cu silicon din exterior. Infiltrațiile vin de obicei dintr-o zonă unde adezivul nu face contact sau din garnituri. Siliconul pus peste ascunde problema și îngreunează o reparație corectă. Mai bine cere o verificare.

## Cât timp nu conduci după montaj

Depinde de adeziv și de vreme — de la o oră la câteva ore. Detalii în articolul [cât durează schimbarea parbrizului](/blog/cat-dureaza-schimbarea-parbrizului). Dacă ai nevoie de parbriz nou, [cere o ofertă](/cerere-oferta): montajul se face de ateliere partenere verificate, cu adeziv omologat.
MD,
        'faq' => [
            ['q' => 'Pot lipi singur un parbriz cu adeziv cumpărat din magazin?', 'a' => 'Nu recomandăm. Pe lângă adeziv, contează pregătirea suprafețelor, primerul, poziționarea și timpul de întărire. Un montaj greșit afectează siguranța la accident.'],
            ['q' => 'Cât rezistă adezivul de parbriz?', 'a' => 'Un montaj corect ține pe toată durata de viață a parbrizului. Problemele apar de obicei din pregătirea greșită a suprafețelor, nu din îmbătrânirea adezivului.'],
        ],
    ],
    [
        'slug' => 'itp-cu-parbriz-fisurat', 'queue' => 16,
        'title' => 'Treci ITP-ul cu parbrizul fisurat sau ciobit?',
        'category' => 'costuri', 'primary_keyword' => 'itp parbriz fisurat', 'search_volume' => null,
        'secondary_keywords' => ['itp parbriz ciobit', 'itp cu parbriz crapat'],
        'related_service' => '/reparatie-parbriz', 'image' => 'fisura-parbriz-in-trafic',
        'seo_title' => 'ITP cu parbriz fisurat sau ciobit: treci sau nu? | inlocuireparbriz.ro',
        'meta_description' => 'Ce contează la ITP când ai parbrizul fisurat sau ciobit: zona din fața șoferului, mărimea deteriorării și când e mai simplu să repari înainte de inspecție.',
        'excerpt' => 'Răspunsul scurt: depinde unde e fisura și cât de mare este. Iată ce verifică inspectorul și cum te pregătești ca să nu pierzi o programare.',
        'body' => <<<'MD'
La inspecția tehnică periodică, parbrizul se verifică pentru un singur lucru esențial: dacă îi permite șoferului să vadă bine drumul. Decizia finală aparține inspectorului, dar regulile urmăresc câteva criterii clare.

## Ce contează: zona și mărimea

- **Zona din fața șoferului**, curățată de ștergătoare, este cea mai importantă. O fisură sau o ciobitură aici este, de regulă, considerată deficiență.
- **Mărimea deteriorării.** Un impact mic în afara câmpului vizual are alt tratament decât o fisură lungă.
- **Obiectele care obstrucționează vederea** — abțibilduri mari, folii nepermise — sunt verificate la fel.

Pe scurt, o ciobitură mică spre marginea din dreapta nu e același lucru cu o fisură care trece prin fața șoferului.

## Ce faci înainte de ITP

1. **Fotografiază deteriorarea** și uită-te din scaunul șoferului: o vezi în fața ochilor când conduci?
2. **Dacă e o ciobitură mică și recentă**, o [reparație de parbriz](/reparatie-parbriz) o poate stabiliza și reduce vizibil, uneori suficient pentru ca problema să dispară.
3. **Dacă e o fisură în câmpul vizual**, cel mai sigur e să schimbi parbrizul înainte de programare, ca să nu pierzi timp cu o reinspecție.

## Și în trafic?

Și la un control în trafic, o sticlă care limitează vizibilitatea poate fi sancționată. Iar dincolo de reguli, o fisură în fața ochilor obosește vederea, mai ales noaptea, în lumina farurilor.

## Cât durează să rezolvi

O reparație de ciobitură durează de obicei sub o oră. O înlocuire se face, în general, în aceeași zi, plus timpul de întărire a adezivului. Dacă ai programare la ITP în curând, spune-ne în [cererea de ofertă](/cerere-oferta).
MD,
        'faq' => [
            ['q' => 'Trec ITP-ul cu o ciobitură mică?', 'a' => 'Dacă este mică și nu se află în zona din fața șoferului, de obicei nu este o problemă. Decizia aparține inspectorului.'],
            ['q' => 'Merită reparată ciobitura doar pentru ITP?', 'a' => 'Da, dacă e reparabilă: costă mai puțin decât un parbriz nou și oprește extinderea.'],
        ],
    ],
    [
        'slug' => 'parbriz-incalzit-cum-il-recunosti', 'queue' => 18,
        'title' => 'Parbriz încălzit: cum îl recunoști și ce înseamnă la înlocuire',
        'category' => 'sticla-auto', 'primary_keyword' => 'parbriz incalzit', 'search_volume' => 110,
        'secondary_keywords' => ['parbriz cu incalzire', 'parbriz cu rezistenta', 'reparatie parbriz incalzit'],
        'related_service' => '/parbriz-auto/ford', 'image' => 'parbriz-spart-vedere-interior',
        'seo_title' => 'Parbriz încălzit: cum îl recunoști | inlocuireparbriz.ro',
        'meta_description' => 'Cum îți dai seama dacă mașina are parbriz încălzit, ce tipuri există (cu fire sau fără fire vizibile) și de ce parbrizul nou trebuie să fie tot încălzit.',
        'excerpt' => 'Parbrizul încălzit dezgheață sticla în câteva minute, dar costă mai mult la înlocuire. Iată cum îl recunoști și ce întrebi înainte de comandă.',
        'body' => <<<'MD'
Parbrizul încălzit are în interior un element care se încălzește electric și topește gheața sau aburul fără să aștepți motorul. E frecvent la Ford, unde se numește Quickclear, dar apare și la alte mărci, ca opțiune.

## Cum îl recunoști

- **Fire foarte fine în sticlă.** Privit în lumină, mai ales noaptea, parbrizul are linii subțiri, ondulate sau drepte, pe toată suprafața.
- **Buton separat pe bord**, cu simbolul unui parbriz și săgeți ondulate (diferit de cel pentru lunetă, care e dreptunghiular).
- **Fără fire vizibile:** unele mașini mai noi au un strat metalic transparent în sticlă, care face aceeași treabă. Le recunoști după buton și după o nuanță ușor diferită a sticlei.
- **Doar zona ștergătoarelor încălzită:** unele mașini au fire doar jos, unde stau ștergătoarele în repaus. Nu e același lucru cu parbrizul încălzit complet.

## De ce contează la înlocuire

Un parbriz încălzit are conectori electrici și un cost mai mare. Poți monta unul simplu în locul lui, dar pierzi funcția, iar conectorii rămân liberi. Pe de altă parte, nu are sens să comanzi varianta încălzită pentru o mașină care nu are instalația. De aceea varianta se confirmă după seria de șasiu.

## Firele deranjează vederea?

Firele sunt foarte subțiri și, ziua, aproape că nu se văd. Noaptea, în lumina farurilor care vin din față, unii șoferi observă o ușoară strălucire. Este normal.

## Se poate repara un parbriz încălzit?

O ciobitură mică poate fi reparată și la un parbriz încălzit, dacă nu a afectat firele. Dacă impactul a rupt rezistența, zona respectivă nu se mai încălzește, iar soluția e înlocuirea. Vezi exemple pe paginile [Ford Focus 2](/parbriz-auto/ford/focus-2) și [Ford](/parbriz-auto/ford).
MD,
        'faq' => [
            ['q' => 'Parbrizul încălzit consumă mult curent?', 'a' => 'Consumă mult cât funcționează, de aceea mașina îl oprește automat după câteva minute. Se folosește doar cu motorul pornit.'],
            ['q' => 'Pot monta un parbriz încălzit pe o mașină care nu l-a avut?', 'a' => 'Nu fără instalația electrică și comanda potrivite. În general nu merită.'],
        ],
    ],
    [
        'slug' => 'polish-parbriz-zgarieturi', 'queue' => 20,
        'title' => 'Polish pe parbriz: ce zgârieturi se pot scoate și care nu',
        'category' => 'sticla-auto', 'primary_keyword' => 'polish parbriz', 'search_volume' => 880,
        'secondary_keywords' => ['polish parbriz zgarieturi', 'zgarieturi parbriz stergatoare', 'lustruire parbriz'],
        'related_service' => '/', 'image' => 'curatare-parbriz-dupa-montaj',
        'seo_title' => 'Polish pe parbriz: ce zgârieturi se pot scoate | inlocuireparbriz.ro',
        'meta_description' => 'Ce poate face un polish pe parbriz, ce zgârieturi rămân, ce riscuri are lustruirea sticlei și când un parbriz nou este soluția corectă.',
        'excerpt' => 'Zgârieturile fine de la ștergătoare se văd mai ales noaptea. Unele se pot atenua prin polish, altele nu. Iată cum le deosebești.',
        'body' => <<<'MD'
Sticla e mult mai dură decât vopseaua, așa că polishul pe parbriz nu funcționează ca la caroserie. Se poate face, dar cu limite clare și cu un risc pe care puțini îl menționează.

## Ce zgârieturi se pot atenua

- **Urmele fine lăsate de ștergătoare** în arc de cerc, vizibile mai ales în lumina farurilor.
- **Ceața ușoară** de pe parbrizele vechi, din spălări repetate cu nisip și praf.
- **Urmele de depuneri** (calcar, rășini, insecte) care nu ies la spălare.

Pentru sticlă se folosesc paste speciale, de obicei pe bază de oxid de ceriu, aplicate cu o mașină de lustruit la turație mică.

## Ce nu se poate scoate

Testul simplu: **trece unghia peste zgârietură. Dacă se agață, zgârietura este prea adâncă** pentru polish. La fel, ciobiturile și fisurile nu dispar prin lustruire — ele au nevoie de [reparație](/reparatie-parbriz) sau de înlocuire.

## Riscul pe care îl ignoră mulți

Ca să „scoți” o zgârietură, trebuie să subțiezi sticla din jurul ei. Pe o suprafață mare, asta poate crea o zonă care deformează imaginea, ca o lentilă slabă. În câmpul vizual al șoferului, efectul obosește ochii, iar la mașinile cu cameră de asistență poate afecta modul în care camera vede drumul. De aceea, polishul pe parbriz trebuie făcut moderat, nu agresiv.

## Când e mai bine un parbriz nou

Dacă zgârieturile sunt adânci, acoperă câmpul vizual sau parbrizul are și impacturi, un parbriz nou rezolvă definitiv problema. Iar după montaj, ștergătoarele noi și un [tratament hidrofob](/blog/tratament-hidrofob-parbriz) ajută sticla să rămână curată mai mult timp.

## Cum previi zgârieturile

Schimbă lamelele ștergătoarelor cel puțin o dată pe an, nu porni ștergătoarele pe sticla uscată și prăfuită și folosește lichid de parbriz suficient.
MD,
        'faq' => [
            ['q' => 'Pot face polish pe parbriz acasă?', 'a' => 'Pentru urme foarte fine, da, cu produse dedicate sticlei și răbdare. Pentru zgârieturi vizibile, rezultatul e de obicei slab, iar riscul de deformare crește.'],
            ['q' => 'Polishul scoate ciobiturile?', 'a' => 'Nu. O ciobitură se repară cu rășină sau, dacă nu se poate, se schimbă parbrizul.'],
        ],
    ],
    [
        'slug' => 'infiltratii-zgomot-dupa-montaj-parbriz', 'queue' => 22,
        'title' => 'Infiltrații sau zgomot de vânt după montajul parbrizului: cauze și soluții',
        'category' => 'ghiduri', 'primary_keyword' => 'infiltratii parbriz', 'search_volume' => null,
        'secondary_keywords' => ['parbriz curge apa', 'zgomot vant parbriz', 'parbriz aburit dupa montaj'],
        'related_service' => '/', 'image' => 'parbriz-ploaie-senzor',
        'seo_title' => 'Infiltrații sau zgomot după montajul parbrizului | inlocuireparbriz.ro',
        'meta_description' => 'Intră apă pe lângă parbriz sau auzi vântul după montaj? Cauzele obișnuite, cum le verifici și de ce nu e bine să astupi singur cu silicon.',
        'excerpt' => 'Un parbriz montat corect nu lasă să treacă apa și nu face zgomot. Dacă apar astfel de probleme, de obicei au o cauză clară, care se poate remedia.',
        'body' => <<<'MD'
Dacă după schimbarea parbrizului vezi apă pe bord, pe stâlpi sau pe covorașe, ori auzi un șuierat la viteză mare, nu e ceva cu care trebuie să te obișnuiești. Iată ce poate fi.

## Cauze obișnuite pentru infiltrații

- **O zonă unde adezivul nu face contact complet**, de obicei într-un colț sau sus, lângă plafon.
- **Garnituri sau ornamente montate greșit** ori refolosite deși erau deteriorate.
- **Canalul caroseriei ruginit** sub vechiul parbriz, nereparat înainte de montaj.
- **Scurgerile din zona ștergătoarelor (grilajul de sub parbriz) înfundate** — apa se adună și pare că vine din parbriz.

## Zgomot de vânt

Un șuierat apare când ornamentele laterale sau de sus nu stau lipite de caroserie ori când parbrizul nu e așezat perfect în canal. De multe ori, ajustarea ornamentelor rezolvă problema.

## Cum verifici

1. Cu mașina oprită, udă parbrizul cu un furtun la presiune mică, pe rând, pe fiecare latură. O a doua persoană urmărește din interior unde apare apa.
2. Verifică dacă scurgerile de sub grilajul ștergătoarelor sunt libere.
3. Notează la ce viteză apare zgomotul și din ce parte.

## Nu astupa cu silicon

Siliconul pus din exterior ascunde problema, dar nu o rezolvă, iar mai târziu face mai grea o remediere corectă. Explicăm de ce în articolul [cu ce se lipește un parbriz](/blog/silicon-parbriz-cu-ce-se-lipeste).

## Parbriz aburit după montaj

Câteva zile după montaj, mai ales dacă mașina a stat cu ușile deschise pe ploaie, geamurile se pot aburi mai ușor. Dacă aburul persistă și covorașele sunt ude, caută o infiltrație. Pentru orice problemă după o lucrare făcută prin noi, scrie-ne pe pagina de [contact](/contact).
MD,
        'faq' => [
            ['q' => 'E normal să intre puțină apă în primele zile?', 'a' => 'Nu. Un parbriz montat corect este etanș de la început. Apa care intră înseamnă că ceva trebuie verificat.'],
            ['q' => 'Se poate remedia fără parbriz nou?', 'a' => 'De cele mai multe ori da: se corectează zona de etanșare sau garniturile. Rar, e nevoie de remontare.'],
        ],
    ],
    [
        'slug' => 'luneta-sparta-ce-faci', 'queue' => 24,
        'title' => 'Lunetă spartă: ce faci până la montajul uneia noi',
        'category' => 'reparatii', 'primary_keyword' => 'luneta sparta', 'search_volume' => null,
        'secondary_keywords' => ['luneta masina sparta', 'geam spate spart', 'luneta sparta ce faci'],
        'related_service' => '/inlocuire-luneta-si-geamuri-laterale', 'image' => 'parbriz-spart-multiple-impacturi',
        'seo_title' => 'Lunetă spartă: ce faci până la montaj | inlocuireparbriz.ro',
        'meta_description' => 'Luneta spartă se face mii de bucăți: cum strângi cioburile în siguranță, cum acoperi provizoriu geamul și ce date trimiți pentru o lunetă nouă.',
        'excerpt' => 'Spre deosebire de parbriz, luneta se sparge în mii de bucăți mici. Iată cum strângi cioburile, cum protejezi mașina și ce ne trimiți pentru oferta de lunetă nouă.',
        'body' => <<<'MD'
Luneta și geamurile laterale sunt de obicei din **sticlă securizată**, nu laminată ca parbrizul. La un impact, ea se sparge în mii de bucăți mici, fără muchii tăioase mari. E mai sigur la accident, dar înseamnă cioburi peste tot în portbagaj.

## Primele lucruri de făcut

- **Fotografiază mașina și locul**, mai ales dacă e vorba de vandalism sau de un accident — ai nevoie de poze pentru asigurare sau poliție.
- **Strânge cioburile cu mănuși** și cu un aspirator, nu cu mâna. Verifică garniturile și canalul geamului: acolo rămân multe bucăți mici.
- **Acoperă provizoriu deschiderea** cu folie de plastic groasă, prinsă cu bandă de ambalat pe caroserie, nu pe vopsea delicată sau pe ornamente cromate.

## Pot circula fără lunetă?

Pe distanțe scurte și cu folia bine prinsă, de obicei se poate ajunge până acasă sau la atelier. Ai grijă la gazele de eșapament, care pot intra în habitaclu prin deschiderea din spate — ține geamurile din față puțin deschise.

## Ce date trimiți pentru o lunetă nouă

- marca, modelul, anul și caroseria (hatchback, break, berlină);
- seria de șasiu (VIN), dacă o ai;
- dacă luneta are rezistență de încălzire (aproape toate au), ștergător spate sau antenă integrată în sticlă.

Luneta se comandă pe varianta exactă, așa că aceste detalii contează pentru ofertă.

## Cât durează înlocuirea

O lunetă se montează de obicei în mai puțin timp decât un parbriz, dar contează curățarea cioburilor din uși, garnituri și portbagaj. Detalii pe pagina [înlocuire lunetă și geamuri laterale](/inlocuire-luneta-si-geamuri-laterale).
MD,
        'faq' => [
            ['q' => 'De ce s-a spart luneta singură?', 'a' => 'Rar, dar se întâmplă: o tensiune internă a sticlei, o lovitură mai veche sau un șoc termic pot sparge sticla securizată fără un impact vizibil.'],
            ['q' => 'Se poate repara o lunetă?', 'a' => 'Nu. Sticla securizată nu se repară; luneta se înlocuiește.'],
        ],
    ],
    [
        'slug' => 'tratament-hidrofob-parbriz', 'queue' => 26,
        'title' => 'Tratament hidrofob pe parbriz: merită și când îl aplici',
        'category' => 'sticla-auto', 'primary_keyword' => 'tratament hidrofob parbriz', 'search_volume' => 260,
        'secondary_keywords' => ['solutie hidrofoba parbriz', 'parbriz invizibil'],
        'related_service' => '/', 'image' => 'parbriz-ploaie-senzor',
        'seo_title' => 'Tratament hidrofob pe parbriz: merită? | inlocuireparbriz.ro',
        'meta_description' => 'Ce face un tratament hidrofob pe parbriz, cât ține, cum se aplică corect și când trebuie să aștepți după montajul unui parbriz nou.',
        'excerpt' => 'Picăturile care alunecă singure de pe parbriz la viteză arată spectaculos. Iată ce face, de fapt, un tratament hidrofob și când are sens.',
        'body' => <<<'MD'
Un tratament hidrofob este un strat foarte subțire care face ca apa să formeze picături rotunde și să alunece de pe sticlă. La viteze de peste 60–80 km/h, picăturile sunt duse de aer chiar fără ștergătoare.

## Ce avantaje are

- vizibilitate mai bună pe ploaie, mai ales noaptea;
- gheața și insectele se curăță mai ușor;
- ștergătoarele lucrează mai puțin și mai silențios.

## Ce nu face

Nu repară zgârieturi, ciobituri sau fisuri. Nu înlocuiește ștergătoarele bune. Și nu ține la nesfârșit: în funcție de produs și de cât folosești ștergătoarele, efectul durează de la câteva săptămâni la câteva luni.

## Cum se aplică corect

1. Spală parbrizul și degresează-l (de exemplu cu alcool izopropilic).
2. Aplică produsul în strat subțire, cu mișcări în cruce, pe sticla uscată și rece, nu în soare.
3. Lasă-l să acționeze cât spune producătorul, apoi șterge excesul cu o lavetă curată.
4. Nu porni ștergătoarele câteva ore.

## Parbriz nou? Așteaptă puțin

După montajul unui parbriz nou, lasă adezivul să se întărească înainte de spălări intense. Tratamentul se aplică doar pe exterior, nu pe zona interioară a camerei sau a senzorului de ploaie. Pe zona din fața senzorului, unele tratamente pot schimba sensibilitatea ștergătoarelor automate — verifică recomandările producătorului.

## Merită?

Pentru cine conduce mult pe autostradă și pe ploaie, da. Pentru un parbriz plin de [zgârieturi de la ștergătoare](/blog/polish-parbriz-zgarieturi), rezultatul va fi slab: problema de bază e sticla, nu apa.
MD,
        'faq' => [
            ['q' => 'Afectează tratamentul hidrofob senzorul de ploaie?', 'a' => 'Uneori ștergătoarele automate pornesc mai rar, pentru că apa se scurge mai repede. Senzorul în sine nu se defectează.'],
            ['q' => 'Se poate aplica pe un parbriz încălzit?', 'a' => 'Da, pe exterior, ca pe orice parbriz.'],
        ],
    ],
    [
        'slug' => 'stergatoare-parbriz-cand-le-schimbi', 'queue' => 28,
        'title' => 'Ștergătoare de parbriz: când le schimbi și cum îți protejează sticla',
        'category' => 'ghiduri', 'primary_keyword' => 'stergatoare parbriz', 'search_volume' => 4400,
        'secondary_keywords' => ['lamele stergator', 'stergatoare parbriz cand se schimba', 'stergator parbriz zgarie'],
        'related_service' => '/', 'image' => 'fisura-parbriz-in-trafic',
        'seo_title' => 'Ștergătoare de parbriz: când le schimbi și de ce | inlocuireparbriz.ro',
        'meta_description' => 'Semnele că ștergătoarele trebuie schimbate, cât rezistă lamelele, cum zgârie un ștergător uzat parbrizul și cum alegi tipul potrivit pentru mașina ta.',
        'excerpt' => 'Un ștergător uzat nu doar curăță prost: în timp, zgârie parbrizul. Iată semnele de uzură și cum îți protejezi sticla.',
        'body' => <<<'MD'
Ștergătoarele sunt printre cele mai ieftine piese ale mașinii, dar au legătură directă cu viața parbrizului. O lamelă uzată, plină de nisip, lasă urme fine care se adună an de an.

## Semne că ștergătoarele trebuie schimbate

- lasă dungi sau zone neșterse;
- sar sau vibrează pe sticlă;
- scârțâie, chiar și pe sticla udă;
- cauciucul e crăpat, întărit sau rupt la capete;
- vezi zgârieturi fine, în arc, pe parbriz.

## Cât rezistă

În general, lamelele se schimbă o dată pe an. Soarele puternic vara și gerul iarna întăresc cauciucul mai repede. Dacă mașina stă afară tot anul, verifică-le de două ori pe an, înainte de iarnă și după.

## Cum zgârie un ștergător parbrizul

Praful și nisipul rămân prinse în lamelă. Când pornești ștergătoarele pe sticla uscată sau cu puțin lichid, ele freacă particulele de parbriz. Cu o lamelă întărită, presiunea e și mai mare. Rezultatul: urme fine care se văd noaptea, în lumina farurilor. Unele se pot atenua prin [polish pe parbriz](/blog/polish-parbriz-zgarieturi), cele adânci nu.

## Ce tip alegi

- **Clasice, cu cadru metalic** — pentru mașini mai vechi.
- **Plate (flat)** — se lipesc uniform de sticlă, sunt mai silențioase și se descurcă mai bine iarna.
- **Hibride** — un compromis între cele două.

Respectă lungimea indicată pentru mașina ta. O lamelă prea lungă poate atinge garnitura, una prea scurtă lasă zone neșterse.

## După schimbarea parbrizului

Un parbriz nou merită ștergătoare noi. Lamelele vechi, cu nisip în cauciuc, îl pot zgâria din primele săptămâni. Dacă ai nevoie de [parbriz nou](/cerere-oferta), spune-ne și dacă vrei să verifici ștergătoarele la montaj.
MD,
        'faq' => [
            ['q' => 'Pot ridica ștergătoarele iarna, peste noapte?', 'a' => 'Da, ca să nu înghețe lamela de sticlă. Ai grijă ca brațul să nu cadă brusc pe parbriz când îl cobori.'],
            ['q' => 'Ștergătoarele scumpe țin mai mult?', 'a' => 'De obicei au un cauciuc mai bun și se lipesc mai uniform de sticlă, dar și ele trebuie schimbate periodic.'],
        ],
    ],
    [
        'slug' => 'parbriz-head-up-display', 'queue' => 30,
        'title' => 'Parbriz pentru head-up display: de ce e diferit și ce verifici',
        'category' => 'sticla-auto', 'primary_keyword' => 'parbriz head up display', 'search_volume' => null,
        'secondary_keywords' => ['parbriz hud', 'imagine dubla head up display parbriz'],
        'related_service' => '/calibrare-adas', 'image' => 'montaj-parbriz-nou-autoturism-alb',
        'seo_title' => 'Parbriz pentru head-up display (HUD) | inlocuireparbriz.ro',
        'meta_description' => 'De ce un parbriz pentru head-up display are folie specială, de ce un parbriz obișnuit produce imagine dublă și ce date trimiți pentru oferta corectă.',
        'excerpt' => 'Dacă mașina ta proiectează viteza pe parbriz, nu orice parbriz se potrivește. Iată de ce și cum eviți imaginea dublă după înlocuire.',
        'body' => <<<'MD'
Head-up display-ul (HUD) proiectează informații — viteza, navigația, avertizările — pe parbriz, în câmpul vizual al șoferului. Ca imaginea să fie clară, parbrizul trebuie construit special pentru asta.

## De ce apare imaginea dublă

Lumina proiectorului se reflectă de ambele fețe ale sticlei: de cea interioară și de cea exterioară. Pe un parbriz obișnuit, cele două reflexii se văd ușor decalat — imaginea apare dublă sau „fantomă”. Parbrizul pentru HUD are o **folie intermediară în formă de pană**, puțin mai groasă sus decât jos, care suprapune cele două reflexii într-o singură imagine clară.

## HUD pe parbriz sau pe ecran separat?

Unele mașini proiectează pe o mică placă transparentă care se ridică din bord. Acestea nu au nevoie de parbriz special. Altele proiectează direct pe parbriz — acolo e obligatoriu parbrizul potrivit. Spune-ne exact ce sistem ai.

## Ce verifici la ofertă

- parbrizul propus este marcat ca fiind pentru HUD;
- are și celelalte dotări ale mașinii (senzor de ploaie, cameră, acustic, încălzire);
- după montaj, imaginea HUD se verifică și, la nevoie, se reglează poziția ei din meniul mașinii.

## Și camera de pe parbriz

Mașinile cu HUD au adesea și cameră pentru asistență la condus. După montaj, camera trebuie [calibrată](/calibrare-adas). Exemple de modele cu HUD opțional găsești pe paginile [BMW](/parbriz-auto/bmw) și [Audi](/parbriz-auto/audi).
MD,
        'faq' => [
            ['q' => 'Pot pune un parbriz obișnuit și să nu folosesc HUD-ul?', 'a' => 'Se poate, dar pierzi funcția și, dacă o pornești, imaginea va fi dublă. Nu recomandăm.'],
            ['q' => 'Parbrizul pentru HUD e mult mai scump?', 'a' => 'Costă de obicei mai mult decât varianta fără HUD a aceluiași model. Oferta îți arată exact diferența.'],
        ],
    ],
    [
        'slug' => 'cum-alegi-atelier-parbrize', 'queue' => 32,
        'title' => 'Cum alegi un atelier de parbrize: 8 întrebări înainte de programare',
        'category' => 'ghiduri', 'primary_keyword' => 'atelier parbrize', 'search_volume' => null,
        'secondary_keywords' => ['service parbrize auto', 'centru de parbrize', 'service parbrize'],
        'related_service' => '/', 'image' => 'montaj-parbriz-nou-doi-tehnicieni',
        'seo_title' => 'Cum alegi un atelier de parbrize | inlocuireparbriz.ro',
        'meta_description' => 'Opt întrebări de pus unui atelier sau service de parbrize înainte de programare: sticla propusă, adezivul, timpul până la condus, calibrarea și garanția.',
        'excerpt' => 'Prețul nu e singurul criteriu. Iată opt întrebări care îți arată dacă un atelier de parbrize lucrează corect, înainte să lași mașina.',
        'body' => <<<'MD'
Un parbriz montat bine nu se observă. Unul montat greșit se vede în infiltrații, zgomot, erori pe bord sau, mai grav, la un accident. Iată ce întrebi înainte de programare.

## 1. Ce parbriz îmi propuneți, exact?

Cere producătorul și varianta: cu senzor, cu suport de cameră, încălzit, acustic. O ofertă serioasă le spune clar. Vezi și [parbriz original sau aftermarket](/blog/parbriz-original-oem-aftermarket).

## 2. Ați verificat varianta după seria de șasiu?

Mai ales la mașinile cu multe dotări, VIN-ul evită comanda unui parbriz care „pare la fel”.

## 3. Ce adeziv folosiți și după cât timp pot conduce?

Răspunsul trebuie să fie concret: un adeziv omologat pentru sticla auto și un timp minim până la condus, în funcție de temperatură.

## 4. Unde se face montajul?

La atelier sau la adresa ta? Pentru montajul la domiciliu e nevoie de un loc ferit de ploaie și vânt și de o temperatură potrivită. Detalii pe pagina [montaj la domiciliu](/inlocuire-parbriz-la-domiciliu).

## 5. Mașina mea are nevoie de calibrare?

Dacă ai cameră pe parbriz, răspunsul e de regulă da. Întreabă dacă este inclusă sau separată în ofertă. Vezi [calibrare ADAS](/calibrare-adas).

## 6. Ce se întâmplă cu senzorii, rovinieta electronică și tag-urile?

Senzorul de ploaie se mută pe parbrizul nou cu pad optic nou. Tag-urile și accesoriile lipite trebuie discutate înainte.

## 7. Ce garanție oferiți la montaj?

Întreabă ce acoperă: infiltrații, zgomot, desprinderea ornamentelor.

## 8. Primesc oferta în scris?

O ofertă scrisă, cu varianta de sticlă și ce include, evită surprizele. Prin [cererea de ofertă](/cerere-oferta) primești oferta de la un atelier partener verificat din orașul tău, înainte de orice programare.
MD,
        'faq' => [
            ['q' => 'Cel mai ieftin atelier e o alegere proastă?', 'a' => 'Nu neapărat, dar compară ofertele pe aceeași variantă de sticlă și cu aceleași servicii incluse (calibrare, garnituri, montaj).'],
            ['q' => 'Contează dacă atelierul vine la mine?', 'a' => 'Montajul mobil e comod, dar se face corect doar când locul și vremea permit lipirea în siguranță.'],
        ],
    ],
    [
        'slug' => 'parbriz-spart-casco-sau-rca', 'queue' => 34,
        'title' => 'Parbriz spart: îl plătește CASCO sau RCA?',
        'category' => 'costuri', 'primary_keyword' => 'parbriz spart rca', 'search_volume' => null,
        'secondary_keywords' => ['schimbare parbriz pe rca', 'parbriz spart de piatra asigurare'],
        'related_service' => '/parbriz-pe-casco', 'image' => 'parbriz-deteriorat-dupa-accident',
        'seo_title' => 'Parbriz spart: îl plătește CASCO sau RCA? | inlocuireparbriz.ro',
        'meta_description' => 'Când poate fi schimbat parbrizul pe RCA-ul altcuiva, când intră pe CASCO și ce documente pregătești. Ghid practic, fără promisiuni în numele asigurătorilor.',
        'excerpt' => 'O piatră aruncată de un camion, un accident sau vandalism — cine plătește parbrizul depinde de cum s-a produs paguba și de ce asigurare ai.',
        'body' => <<<'MD'
Fiecare asigurător are condițiile lui, iar decizia finală îi aparține. Există însă câteva situații tipice care te ajută să știi la ce să te aștepți.

## Când poate intra pe RCA

RCA-ul acoperă pagubele produse altora de șoferul asigurat. Dacă parbrizul tău a fost spart de un **vehicul identificat** — de exemplu, într-un accident sau de o încărcătură căzută dintr-un camion al cărui număr îl ai — paguba poate fi cerută din RCA-ul acelui vehicul. Ai nevoie de dovezi: constatare amiabilă, proces-verbal sau alte documente cerute de asigurător.

## Piatra „de la mașina din față”

Este cel mai frecvent caz și cel mai greu de dovedit. Fără numărul vehiculului și fără dovezi că de la el a venit piatra, o despăgubire pe RCA-ul altcuiva este, de regulă, dificilă. Aici contează dacă ai CASCO.

## Când intră pe CASCO

Dacă polița ta CASCO acoperă geamurile, poți declara dauna indiferent cine a produs-o. Verifică dacă există franșiză, dacă asigurătorul cere constatare înainte de reparație și dacă are o listă de unități agreate. Detalii practice în ghidul [parbriz prin CASCO](/parbriz-pe-casco).

## Ce documente pregătești

- fotografii ale parbrizului și ale locului;
- datele celuilalt vehicul și documentele accidentului, dacă e cazul;
- polița de asigurare;
- o ofertă scrisă pentru înlocuire, dacă asigurătorul o cere.

## Dacă plătești singur

Uneori, pentru un parbriz simplu, o daună CASCO nu merită din cauza franșizei sau a efectului asupra reînnoirii. Compară costul cu [oferta pentru parbriz nou](/cerere-oferta) înainte să decizi.
MD,
        'faq' => [
            ['q' => 'Trebuie să anunț poliția pentru un parbriz spart?', 'a' => 'Depinde de situație și de cerințele asigurătorului. În caz de vandalism sau accident cu altă persoană implicată, documentele oficiale pot fi necesare.'],
            ['q' => 'Puteți lucra direct cu asigurătorul meu?', 'a' => 'Nu pretindem parteneriate cu asigurători. Îți dăm o ofertă clară, pe care o poți folosi în relația cu asigurătorul.'],
        ],
    ],
];
