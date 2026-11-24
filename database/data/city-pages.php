<?php

/*
 * Conținutul inițial al paginilor de oraș (aprobate în docs/SEO-STRATEGIE.md, pe baza volumelor DataForSEO).
 * Se încarcă o singură dată în tabelul `cities`; după aceea se editează din admin (Catalog & Zone → Orașe).
 * Reguli: conținut local real (drumuri, climă, cartiere, unde se poate face montajul), fără promisiuni de
 * acoperire — toate orașele în afară de București pornesc cu acoperire „la cerere”.
 */

return [
    [
        'slug' => 'timisoara', 'name' => 'Timișoara', 'county' => 'Timiș', 'region' => 'banat-crisana', 'volume' => 1600, 'sort' => 10,
        'intro' => 'Ai parbrizul fisurat sau spart în Timișoara? Trimite marca, modelul și anul mașinii și îți confirmăm ce sticlă se potrivește, cât costă și dacă un atelier partener din zona ta poate face montajul — la atelier sau la adresa ta.',
        'areas' => ['Fabric', 'Iosefin', 'Elisabetin', 'Complexul Studențesc', 'Calea Aradului', 'Dumbrăvița', 'Giroc'],
        'sections' => [
            ['De ce se deteriorează parbrizele în zona Timișoarei', 'Cei mai mulți șoferi din Timișoara intră zilnic pe A1, pe centură sau pe drumurile spre Dumbrăvița, Giroc și Ghiroda, unde camioanele și lucrările ridică pietriș. O piatră mică la viteză de autostradă lasă un impact care, vara, cu diferențele mari de temperatură dintre habitaclu și exterior, se transformă repede într-o fisură. Dacă impactul e mic și recent, merită evaluat pentru reparație înainte să se extindă.'],
            ['Montaj la atelier sau la tine acasă', 'În cartierele noi din jurul orașului, cu parcări private sau curți, montajul la adresă e de obicei posibil. În zonele cu parcare pe stradă — Fabric, Iosefin, Elisabetin — avem nevoie de un loc plan, cu spațiu pentru deschiderea ușilor, iar pe ploaie sau vânt puternic recomandăm un spațiu acoperit. Îți spunem dinainte ce variantă se potrivește, ca să nu pierzi timp.'],
        ],
        'faq' => [
            ['Faceți montaj și în Dumbrăvița sau Giroc?', 'Trimite localitatea exactă în cerere. Disponibilitatea în localitățile din jurul Timișoarei se confirmă odată cu oferta, în funcție de atelierul partener din zonă.'],
            ['Pot circula pe A1 cu parbrizul fisurat?', 'O fisură care intră în câmpul vizual al șoferului îți poate aduce probleme la ITP și la un control în trafic, iar la viteză mare sticla slăbită se poate extinde brusc. Recomandăm evaluarea cât mai repede.'],
        ],
    ],
    [
        'slug' => 'brasov', 'name' => 'Brașov', 'county' => 'Brașov', 'region' => 'transilvania', 'volume' => 1580, 'sort' => 11,
        'intro' => 'Înlocuire parbriz în Brașov, pentru mașini care urcă zilnic pe drumuri de munte și trec prin ierni grele. Trimite detaliile mașinii și îți spunem ce parbriz se potrivește — inclusiv variantele cu încălzire, senzor de ploaie sau cameră — și dacă montajul se poate face la tine.',
        'areas' => ['Tractorul', 'Astra', 'Răcădău', 'Schei', 'Bartolomeu', 'Noua', 'Săcele', 'Ghimbav'],
        'sections' => [
            ['Iarna, pietrișul și diferențele de temperatură', 'Pe DN1 spre Valea Prahovei, pe drumul spre Poiana Brașov sau pe DN73 spre Rucăr–Bran, iarna se împrăștie mult material antiderapant, iar pietrișul lovește constant parbrizul. Un impact mic se poate transforma peste noapte într-o fisură lungă când pornești dezghețarea pe sticla rece. Dacă observi o ciobitură, nu o încălzi brusc și cere o evaluare cât mai repede.'],
            ['Montajul pe vreme rece', 'Adezivul de parbriz are nevoie de anumite temperaturi și de timp de întărire. În sezonul rece din Brașov, montajul la adresă se face doar dacă există un spațiu acoperit sau o zi potrivită; altfel recomandăm atelierul partener. Îți comunicăm dinainte timpul după care poți conduce în siguranță.'],
        ],
        'faq' => [
            ['Aveți parbrize cu încălzire pentru mașina mea?', 'Multe modele au variante cu rezistențe încălzite sau cu zonă încălzită pentru ștergătoare. Trimite seria de șasiu (VIN) în cerere și verificăm exact varianta montată din fabrică.'],
            ['Se poate monta parbrizul iarna?', 'Da, cu condiția unui spațiu acoperit și a respectării timpului de întărire al adezivului. De aceea, iarna, recomandăm de obicei montajul în atelier.'],
        ],
    ],
    [
        'slug' => 'ploiesti', 'name' => 'Ploiești', 'county' => 'Prahova', 'region' => 'muntenia', 'volume' => 1550, 'sort' => 12,
        'intro' => 'Cauți parbrize în Ploiești? Trimite marca, modelul și anul mașinii și primești o ofertă pe tipul corect de sticlă. Cererea ajunge la un atelier partener verificat din zonă, iar noi îți confirmăm disponibilitatea înainte de programare.',
        'areas' => ['Nord', 'Vest', 'Malu Roșu', 'Bariera Bucov', 'Mihai Bravu', 'Blejoi', 'Păulești'],
        'sections' => [
            ['Drumurile care pun parbrizul la încercare', 'Ploieștiul e nod rutier: A3 spre București, DN1 spre Valea Prahovei și DN1A spre Vălenii de Munte. Traficul greu din zona industrială și drumurile de munte din nordul județului înseamnă multe pietre ridicate de roți. Navetiștii care fac zilnic drumul spre București sunt cei mai expuși la impacturi pe autostradă.'],
            ['Navetist? Programăm în funcție de program', 'Dacă lucrezi în București și locuiești în Ploiești sau invers, poți alege locul de montaj care îți convine — la domiciliu, la birou sau la atelier. Spune-ne în cerere unde e mai simplu pentru tine, iar disponibilitatea se confirmă în ofertă.'],
        ],
        'faq' => [
            ['Pot face montajul la birou, în București, deși locuiesc în Ploiești?', 'Da, specifică în cerere adresa unde preferi montajul. Contează locul mașinii, nu adresa de domiciliu.'],
            ['Cât timp nu pot folosi mașina după montaj?', 'Depinde de adeziv și de temperatură — de regulă, câteva ore. Îți spunem exact odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'craiova', 'name' => 'Craiova', 'county' => 'Dolj', 'region' => 'oltenia', 'volume' => 1490, 'sort' => 13,
        'intro' => 'Înlocuire și reparație parbriz în Craiova. Ne spui mașina și ce s-a întâmplat cu geamul, iar noi verificăm sticla potrivită și trimitem cererea la un atelier partener din zonă, care îți face oferta și montajul.',
        'areas' => ['Rovine', 'Brazda lui Novac', 'Craiovița Nouă', 'Valea Roșie', 'Lăpuș', '1 Mai', 'Bariera Vâlcii'],
        'sections' => [
            ['Vara fierbinte și fisurile care „fug”', 'Verile din Oltenia sunt printre cele mai calde din țară. Un parbriz ciobit, expus la soare și apoi răcit brusc de aerul condiționat, este candidatul ideal pentru o fisură care se întinde pe toată lățimea. Pe Drumul Expres Craiova–Pitești și pe DN6 spre Caracal sau Filiași, impacturile de piatră sunt frecvente; un impact tratat repede poate fi uneori reparat.'],
            ['Ce ne trimiți pentru o ofertă corectă', 'Marca, modelul, anul și, ideal, seria de șasiu. Spune-ne și dacă ai senzor de ploaie, cameră pe parbriz sau parbriz încălzit — două parbrize care par identice pot diferi tocmai la aceste dotări, iar prețul diferă la fel.'],
        ],
        'faq' => [
            ['Se poate repara o fisură apărută de la căldură?', 'Fisurile scurte, recente și departe de margine pot fi uneori stabilizate. Fisurile lungi sau care pornesc de la marginea sticlei necesită de regulă înlocuire.'],
            ['Faceți montaj și în afara Craiovei, în Dolj?', 'Trimite localitatea în cerere; disponibilitatea se confirmă în funcție de atelierul partener din zonă.'],
        ],
    ],
    [
        'slug' => 'suceava', 'name' => 'Suceava', 'county' => 'Suceava', 'region' => 'moldova', 'volume' => 1480, 'sort' => 14,
        'intro' => 'Parbriz nou în Suceava, potrivit exact pentru mașina ta. Trimite datele mașinii și îți spunem ce variantă de sticlă e corectă și dacă un atelier partener din zonă poate prelua lucrarea — îți confirmăm disponibilitatea înainte de orice angajament.',
        'areas' => ['Burdujeni', 'Obcini', 'George Enescu', 'Ițcani', 'Zamca', 'Șcheia', 'Ipotești'],
        'sections' => [
            ['Ierni lungi, drumuri de munte', 'Pe E85 spre Fălticeni și Siret sau pe DN17 spre Gura Humorului și Vatra Dornei, iarna aduce zăpadă, material antiderapant și diferențe mari de temperatură între zi și noapte. Sticla rece și dezghețarea agresivă transformă rapid un impact mic într-o fisură. Folosește treptat climatizarea și cere evaluarea cât mai repede.'],
            ['Parbriz cu încălzire, senzor sau cameră', 'Multe mașini din zonă au parbriz încălzit sau senzori pentru ploaie și lumină. La comandă contează exact aceste dotări; dacă nu ești sigur ce ai, trimite o fotografie cu zona oglinzii retrovizoare (din interior) și seria de șasiu.'],
        ],
        'faq' => [
            ['Ce fac dacă fisura apare în timpul iernii?', 'Evită să pornești dezghețarea la maximum direct pe sticlă și nu turna apă caldă. Acoperă impactul cu bandă transparentă și trimite cererea.'],
            ['Faceți montaj și în Rădăuți sau Fălticeni?', 'Scrie localitatea în cerere — îți confirmăm disponibilitatea în zona respectivă odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'cluj-napoca', 'name' => 'Cluj-Napoca', 'county' => 'Cluj', 'region' => 'transilvania', 'volume' => 1250, 'sort' => 15,
        'intro' => 'Înlocuire parbriz în Cluj-Napoca, cu ofertă pe datele reale ale mașinii. Trimite marca, modelul și anul, iar cererea ajunge la un atelier partener verificat din zonă. Îți confirmăm disponibilitatea și locul de montaj înainte de programare.',
        'areas' => ['Mănăștur', 'Mărăști', 'Gheorgheni', 'Zorilor', 'Grigorescu', 'Bună Ziua', 'Florești', 'Baciu'],
        'sections' => [
            ['Trafic aglomerat, șantiere, Feleac', 'Clujul are mult trafic de navetă dinspre Florești și Baciu și multe șantiere în oraș și în jurul lui. Pe A3, pe Feleac spre Turda sau pe drumurile de centură, camioanele și lucrările ridică pietriș. Un impact pe parbriz nu doare imediat, dar în sezonul rece se poate extinde rapid.'],
            ['Unde se poate face montajul', 'În cartierele cu blocuri — Mănăștur, Mărăști, Gheorgheni — locurile de parcare sunt strâmte; montajul la adresă e posibil doar cu spațiu suficient pentru deschiderea ușilor și fără ploaie. În Florești și Baciu, cu parcări private, varianta la domiciliu e de obicei mai simplă. Îți spunem dinainte ce recomandăm.'],
        ],
        'faq' => [
            ['Mașina mea are cameră pe parbriz. Trebuie calibrată?', 'La multe modele cu sisteme ADAS, după înlocuirea parbrizului e necesară calibrarea camerei. Verificăm pe modelul tău și îți spunem în ofertă dacă și unde se face.'],
            ['Pot trimite cererea dacă sunt în Florești?', 'Da. Alege „Alt oraș” sau Cluj și scrie localitatea exactă; disponibilitatea se confirmă în ofertă.'],
        ],
    ],
    [
        'slug' => 'bacau', 'name' => 'Bacău', 'county' => 'Bacău', 'region' => 'moldova', 'volume' => 1200, 'sort' => 16,
        'intro' => 'Ai nevoie de parbriz nou în Bacău? Trimite detaliile mașinii și primești oferta prin atelierele partenere verificate din zonă. Verificăm întâi sticla potrivită — cu senzori, cameră sau încălzire — ca să nu primești un parbriz „aproape bun”.',
        'areas' => ['Miorița', 'Cornișa', 'Bistrița Lac', 'CFR', 'Republicii', 'Gherăiești', 'Mărgineni'],
        'sections' => [
            ['E85 și DN11: drumuri cu mult trafic greu', 'Bacăul stă pe E85, unul dintre cele mai circulate drumuri din Moldova, și pe DN11 spre Onești și Brașov. Traficul greu și drumurile reparate des înseamnă pietre ridicate de roți la fiecare deplasare mai lungă. Un impact apărut pe drum se poate evalua pentru reparație dacă e mic și recent.'],
            ['Ofertă înainte de programare', 'Nu pornim nicio lucrare fără să știi ce primești: tipul de sticlă, prețul și locul montajului. Dacă variantele diferă ca preț (de exemplu, parbriz original sau echivalent), îți spunem diferențele pe înțeles.'],
        ],
        'faq' => [
            ['Care e diferența dintre parbriz original și echivalent?', 'Originalul poartă sigla producătorului mașinii; echivalentul e produs la aceleași specificații de alți producători omologați. Diferă prețul, nu și obligativitatea omologării.'],
            ['Faceți montaj și în Onești sau Moinești?', 'Scrie localitatea în cerere; confirmăm disponibilitatea în funcție de atelierul partener din zonă.'],
        ],
    ],
    [
        'slug' => 'pitesti', 'name' => 'Pitești', 'county' => 'Argeș', 'region' => 'muntenia', 'volume' => 1190, 'sort' => 17,
        'intro' => 'Înlocuire parbriz în Pitești: trimite marca, modelul și anul mașinii, iar cererea ajunge la un atelier partener din Argeș. Primești ofertă pe tipul corect de sticlă și îți confirmăm unde se poate face montajul.',
        'areas' => ['Trivale', 'Războieni', 'Craiovei', 'Prundu', 'Găvana', 'Exercițiu', 'Mărăcineni', 'Ștefănești'],
        'sections' => [
            ['A1, DN7 și drumurile spre munte', 'Piteștiul e legat de București prin A1 și de Râmnicu Vâlcea prin DN7, iar spre nord drumurile urcă spre Câmpulung și Curtea de Argeș. Autostrada aduce impacturi la viteză mare, iar drumurile de munte — pietriș și diferențe de temperatură. Mulți șoferi lucrează în zona industrială de la Mioveni și parchează zilnic în aer liber.'],
            ['Dacia și nu numai', 'În zonă circulă foarte multe mașini Dacia, pentru care există de regulă mai multe variante de parbriz — cu sau fără senzor, cu sau fără încălzire. Trimite anul și seria de șasiu, ca să primești oferta pe varianta exactă.'],
        ],
        'faq' => [
            ['Aveți parbriz pentru Logan sau Duster?', 'Pentru modelele Dacia există de obicei mai multe variante. Spune-ne anul și dotările (senzor, cameră, încălzire) și verificăm exact.'],
            ['Pot face montajul la locul de muncă, la Mioveni?', 'Scrie în cerere adresa unde preferi montajul; confirmăm dacă locația permite lucrarea.'],
        ],
    ],
    [
        'slug' => 'constanta', 'name' => 'Constanța', 'county' => 'Constanța', 'region' => 'dobrogea', 'volume' => 1000, 'sort' => 18,
        'intro' => 'Parbrize în Constanța și pe litoral: trimite detaliile mașinii și primești oferta prin atelierele partenere verificate din zonă. Verificăm sticla potrivită și îți confirmăm unde și când se poate face montajul.',
        'areas' => ['Tomis Nord', 'Tomis III', 'Faleză Nord', 'Inel II', 'Km 4–5', 'Coiciu', 'Mamaia', 'Năvodari'],
        'sections' => [
            ['Vânt, nisip și aer sărat', 'Pe litoral, vântul ridică nisip care, în timp, zgârie și mătuiește parbrizul — mai ales vizibil noaptea, la farurile din sens opus. Pe A2, A4 și pe DN39 spre Mangalia, impacturile de piatră sunt la fel de frecvente ca în restul țării. Dacă vezi greu noaptea din cauza zgârieturilor, înlocuirea e de obicei singura soluție corectă.'],
            ['Montaj pe vreme cu vânt', 'Vântul puternic și umezeala afectează lipirea corectă a parbrizului. Pe litoral recomandăm adesea un spațiu acoperit sau atelierul partener; montajul la adresă se programează într-o zi potrivită.'],
        ],
        'faq' => [
            ['Parbrizul meu e mătuit de nisip. Se poate lustrui?', 'Zgârieturile fine se pot uneori atenua, dar dacă afectează vizibilitatea în câmpul șoferului, recomandăm înlocuirea. Trimite o fotografie și îți spunem.'],
            ['Faceți montaj și în Mamaia sau Năvodari?', 'Scrie localitatea; disponibilitatea se confirmă odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'sibiu', 'name' => 'Sibiu', 'county' => 'Sibiu', 'region' => 'transilvania', 'volume' => 990, 'sort' => 19,
        'intro' => 'Înlocuire parbriz în Sibiu, pentru mașini care trec des pe Valea Oltului sau pe drumuri de munte. Trimite datele mașinii și îți confirmăm sticla potrivită, prețul și disponibilitatea unui atelier partener din zonă.',
        'areas' => ['Hipodrom', 'Vasile Aaron', 'Ștrand', 'Turnișor', 'Terezian', 'Cisnădie', 'Șelimbăr'],
        'sections' => [
            ['Valea Oltului și Transfăgărășanul', 'DN7 pe Valea Oltului e unul dintre cele mai solicitante drumuri pentru parbriz: trafic greu, șantiere, pietriș. La fel A1 spre Deva și DN1 spre Făgăraș, plus drumurile de munte spre Păltiniș sau Transfăgărășan vara. Impacturile mici de pe aceste drumuri merită evaluate repede, înainte să se extindă.'],
            ['Pregătirea pentru montaj', 'Golește bordul și zona din spatele oglinzii retrovizoare, notează dacă ai cameră, senzor sau tag de taxă pe parbriz și spune-ne unde stă mașina. Ne ajută să confirmăm rapid dacă montajul se poate face la tine.'],
        ],
        'faq' => [
            ['Am vignetă sau tag de taxă lipit pe parbriz. Ce se întâmplă cu el?', 'Tag-urile lipite se pierd de obicei odată cu parbrizul vechi. Verifică la emitent cum se înlocuiesc înainte de montaj.'],
            ['Faceți montaj în Cisnădie sau Șelimbăr?', 'Scrie localitatea în cerere; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'buzau', 'name' => 'Buzău', 'county' => 'Buzău', 'region' => 'muntenia', 'volume' => 980, 'sort' => 20,
        'intro' => 'Cauți parbriz în Buzău? Ne spui mașina și avaria, iar noi verificăm sticla corectă și trimitem cererea unui atelier partener verificat din zonă. Primești oferta și îți confirmăm disponibilitatea înainte de programare.',
        'areas' => ['Micro XIV', 'Dorobanți', 'Unirea', 'Simileasca', 'Broșteni', 'Centru'],
        'sections' => [
            ['Între E85 și drumul spre Ploiești', 'Buzăul e traversat de E85, cu trafic greu spre Moldova, și de DN1B spre Ploiești. Pe aceste drumuri, camioanele și lucrările frecvente ridică pietriș; un impact mic apărut în drum spre serviciu se poate extinde în câteva zile, mai ales iarna.'],
            ['Reparație sau înlocuire?', 'Un impact mic, recent, departe de margine și în afara câmpului principal de vizibilitate poate fi uneori reparat, mai ieftin decât un parbriz nou. Trimite o fotografie din interior și una din exterior, iar recomandarea vine odată cu oferta.'],
        ],
        'faq' => [
            ['Cât costă un parbriz nou în Buzău?', 'Prețul depinde de model, an și dotări (senzor, cameră, încălzire). Trimite datele mașinii și primești oferta pe varianta exactă.'],
            ['Faceți montaj și în Râmnicu Sărat?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'iasi', 'name' => 'Iași', 'county' => 'Iași', 'region' => 'moldova', 'volume' => 830, 'sort' => 21,
        'intro' => 'Înlocuire parbriz în Iași, cu ofertă pe datele reale ale mașinii. Trimite marca, modelul și anul, iar cererea ajunge la un atelier partener verificat din zonă. Îți confirmăm locul și momentul montajului înainte de orice angajament.',
        'areas' => ['Copou', 'Tătărași', 'Nicolina', 'Alexandru cel Bun', 'Păcurari', 'Podu Roș', 'Galata', 'Valea Lupului'],
        'sections' => [
            ['Pante, trafic și ierni moldovenești', 'Iașul e un oraș cu pante și trafic intens pe axele principale, iar iarna drumurile se presară cu material antiderapant. Pe E583 spre Târgu Frumos sau pe DN24 spre Vaslui, impacturile de piatră sunt frecvente. O ciobitură se poate extinde repede la primul ger, când dezgheți parbrizul.'],
            ['Montaj în cartiere cu blocuri', 'În Nicolina, Tătărași sau Alexandru cel Bun, parcările dintre blocuri sunt adesea înguste. Montajul la adresă e posibil dacă există spațiu de lucru și vreme bună; altfel recomandăm atelierul partener. Spune-ne în cerere cum arată locul de parcare.'],
        ],
        'faq' => [
            ['Se poate face montajul în parcarea blocului?', 'Dacă locul e plan, are spațiu pentru deschiderea ușilor și nu plouă, de obicei da. Îți confirmăm înainte de programare.'],
            ['Faceți montaj și în Valea Lupului?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'arad', 'name' => 'Arad', 'county' => 'Arad', 'region' => 'banat-crisana', 'volume' => 820, 'sort' => 22,
        'intro' => 'Parbriz nou în Arad, pe tipul corect de sticlă pentru mașina ta. Trimite datele mașinii, iar cererea ajunge la un atelier partener verificat din zonă. Primești oferta și confirmarea disponibilității înainte de programare.',
        'areas' => ['Micălaca', 'Aurel Vlaicu', 'Grădiște', 'Pârneava', 'Gai', 'Bujac', 'Vladimirescu'],
        'sections' => [
            ['A1 și traficul spre frontieră', 'Aradul e legat de Timișoara și de vama Nădlac prin A1, cu trafic greu internațional. La viteze de autostradă, o piatră ridicată de un camion lasă un impact care, vara, se poate transforma repede într-o fisură. Pe DN7 spre Deva, drumul mai îngust și lucrările frecvente adaugă riscul pietrișului.'],
            ['Ce verificăm înainte de ofertă', 'Varianta exactă de parbriz: cu sau fără senzor de ploaie, cameră ADAS, încălzire, strat acustic sau HUD. La multe modele moderne, aceste dotări schimbă complet codul piesei — și prețul.'],
        ],
        'faq' => [
            ['Mașina e înmatriculată în străinătate. Puteți face oferta?', 'Da, trimite marca, modelul, anul și seria de șasiu (VIN) — identificarea sticlei se face după aceste date.'],
            ['Faceți montaj în Vladimirescu?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'baia-mare', 'name' => 'Baia Mare', 'county' => 'Maramureș', 'region' => 'transilvania', 'volume' => 790, 'sort' => 23,
        'intro' => 'Înlocuire parbriz în Baia Mare și Maramureș. Trimite detaliile mașinii și îți spunem ce sticlă se potrivește și dacă un atelier partener din zonă poate face lucrarea — îți confirmăm disponibilitatea înainte de orice angajament.',
        'areas' => ['Vasile Alecsandri', 'Republicii', 'Săsar', 'Ferneziu', 'Valea Roșie', 'Tăuții-Măgherăuș'],
        'sections' => [
            ['Drumuri de munte și ierni grele', 'Din Baia Mare, drumurile spre Sighet urcă prin Pasul Gutâi (DN18), iar iarna ninge mult și se folosește intens material antiderapant. Pe DN1C spre Dej și Cluj traficul e intens. Pentru parbriz, combinația de pietriș și ger e cea mai periculoasă: impacturile mici se extind la dezghețare.'],
            ['Programare în funcție de vreme', 'Montajul corect cere temperaturi potrivite pentru adeziv și un loc ferit de precipitații. Iarna recomandăm de obicei atelierul partener; vara, montajul la adresă e adesea posibil.'],
        ],
        'faq' => [
            ['Faceți montaj și în Sighetu Marmației?', 'Scrie localitatea în cerere; confirmăm disponibilitatea în zona respectivă odată cu oferta.'],
            ['Cât stă mașina după montaj?', 'Câteva ore, în funcție de adeziv și temperatură. Iarna, timpul poate fi mai lung — îți spunem exact.'],
        ],
    ],
    [
        'slug' => 'galati', 'name' => 'Galați', 'county' => 'Galați', 'region' => 'moldova', 'volume' => 790, 'sort' => 24,
        'intro' => 'Parbrize în Galați: trimite marca, modelul și anul mașinii și primești oferta prin atelierele partenere verificate din zonă. Verificăm întâi varianta corectă de sticlă, apoi îți confirmăm unde se poate face montajul.',
        'areas' => ['Țiglina', 'Micro 19', 'Micro 20', 'Mazepa', 'Centru', 'Dunărea', 'Aerodrom'],
        'sections' => [
            ['Zonă industrială, trafic greu', 'Galațiul are trafic greu legat de port și de zona industrială, iar pe DN25 spre Tecuci și DN2B spre Brăila circulă multe camioane. Asta înseamnă impacturi frecvente de piatră. Un impact mic se poate evalua pentru reparație, dacă e recent și departe de margine.'],
            ['Vânt și praf pe malul Dunării', 'Zilele cu vânt puternic nu sunt potrivite pentru lipirea unui parbriz în aer liber. Pentru montajul la adresă alegem o zi potrivită sau recomandăm atelierul partener.'],
        ],
        'faq' => [
            ['Pot trimite fotografii cu avaria?', 'Da, după ce te contactăm poți trimite fotografii; ne ajută să recomandăm reparație sau înlocuire.'],
            ['Faceți montaj și în Tecuci?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'braila', 'name' => 'Brăila', 'county' => 'Brăila', 'region' => 'muntenia', 'volume' => 780, 'sort' => 25,
        'intro' => 'Înlocuire parbriz în Brăila. Trimite detaliile mașinii, iar cererea ajunge la un atelier partener verificat din zonă, care îți face oferta și montajul. Îți confirmăm disponibilitatea înainte de programare.',
        'areas' => ['Viziru', 'Hipodrom', 'Radu Negru', 'Calea Călărașilor', 'Obor', 'Centru'],
        'sections' => [
            ['Câmpie, vânt și drumuri lungi', 'Pe DN2B spre Galați, DN21 spre Slobozia sau DN22 spre Râmnicu Sărat, drumurile drepte de câmpie invită la viteze mari — iar un impact de piatră la viteză mare lasă de obicei o fisură, nu doar o ciobitură. Vara, căldura accentuează extinderea fisurilor.'],
            ['Ofertă clară, fără surprize', 'Nu începem lucrarea fără să știi tipul de sticlă, prețul și locul montajului. Dacă există variante (original sau echivalent, cu sau fără senzor), îți explicăm diferențele.'],
        ],
        'faq' => [
            ['Cât durează schimbarea parbrizului?', 'Lucrarea propriu-zisă durează de obicei una-două ore, plus timpul de întărire a adezivului înainte să conduci.'],
            ['Faceți montaj la domiciliu în Brăila?', 'Dacă locul permite (plan, cu spațiu de lucru, fără ploaie sau vânt puternic), de obicei da — confirmăm în ofertă.'],
        ],
    ],
    [
        'slug' => 'oradea', 'name' => 'Oradea', 'county' => 'Bihor', 'region' => 'banat-crisana', 'volume' => 780, 'sort' => 26,
        'intro' => 'Parbriz nou în Oradea, potrivit modelului și dotărilor mașinii tale. Trimite datele mașinii și îți spunem varianta corectă, prețul și dacă un atelier partener din Bihor poate prelua lucrarea.',
        'areas' => ['Rogerius', 'Nufărul', 'Ioșia', 'Velența', 'Iosia Nord', 'Episcopia Bihor', 'Sânmartin'],
        'sections' => [
            ['Trafic spre graniță și spre Cluj', 'Pe DN1/E60 spre Cluj, prin Valea Crișului Repede, și pe drumurile spre vama Borș circulă mult trafic greu. Porțiunile sinuoase și lucrările frecvente ridică pietriș. Un impact pe parbriz trebuie evaluat repede, mai ales înainte de sezonul rece.'],
            ['Dotările care schimbă parbrizul', 'Senzor de ploaie și lumină, cameră pentru asistența la menținerea benzii, încălzire, HUD — fiecare poate însemna alt cod de piesă. Trimite seria de șasiu pentru identificare exactă.'],
        ],
        'faq' => [
            ['Ce fac cu camera de pe parbriz după înlocuire?', 'La multe modele e necesară calibrarea camerei. Îți spunem în ofertă dacă modelul tău o cere și unde se face.'],
            ['Faceți montaj în Sânmartin sau Băile Felix?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
    [
        'slug' => 'bistrita', 'name' => 'Bistrița', 'county' => 'Bistrița-Năsăud', 'region' => 'transilvania', 'volume' => 640, 'sort' => 27,
        'intro' => 'Înlocuire parbriz în Bistrița și Bistrița-Năsăud. Trimite detaliile mașinii și primești oferta prin atelierele partenere verificate din zonă. Îți confirmăm disponibilitatea și locul montajului înainte de orice angajament.',
        'areas' => ['Ștefan cel Mare', 'Viișoara', 'Subcetate', 'Unirea', 'Independenței', 'Sigmir'],
        'sections' => [
            ['Pasul Tihuța și iernile de munte', 'DN17 spre Vatra Dornei, prin Pasul Tihuța, e un drum de munte cu ierni grele, zăpadă și mult material antiderapant. Pentru parbriz asta înseamnă impacturi frecvente și fisuri care se extind la ger. Dacă faci des drumul, verifică parbrizul după fiecare deplasare lungă.'],
            ['Montaj adaptat sezonului', 'Iarna recomandăm atelierul partener sau un spațiu acoperit, pentru ca adezivul să se întărească corect. În sezonul cald, montajul la adresă e de obicei posibil.'],
        ],
        'faq' => [
            ['Pot conduce cu o ciobitură până la programare?', 'Acoperă impactul cu bandă transparentă, evită spălătoriile cu presiune și diferențele bruște de temperatură în habitaclu. Cere evaluarea cât mai repede.'],
            ['Faceți montaj și în Năsăud?', 'Scrie localitatea; confirmăm disponibilitatea odată cu oferta.'],
        ],
    ],
];
