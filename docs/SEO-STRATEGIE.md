# Strategia SEO națională — inlocuireparbriz.ro

_Date reale DataForSEO, Google România, limba română · 24.11.2026 · rulările #1 (plan național, 1.138 cuvinte, 0,63 USD) și #2 (competitori, 0,25 USD)._
Datele complete sunt în admin: **SEO & Conținut → Cuvinte-cheie** și exportul `storage/app/seo-research/run-*.json` de pe server.

## 1. Validarea cuvântului din domeniu
| Cuvânt | Volum/lună | Intenție | KD |
|---|---|---|---|
| parbriz | 2.900 | mixtă (produs + serviciu) | 12 |
| parbrize | 2.400 | mixtă | 11 |
| parbriz / parbrize București | 1.900 | locală | 6 |
| reparații parbrize / reparație parbriz | 1.600 / 1.300 | tranzacțională | 0–7 |
| schimbare parbriz | 390 | tranzacțională | 11 |
| montaj parbriz | 390 | tranzacțională | 1 |
| parbrize auto | 390 | mixtă | 21 |
| **înlocuire parbriz** | **260** (+390 „înlocuire parbriz preț”) | tranzacțională | 5 |

**Concluzie:** „înlocuire parbriz” are volum modest, dar intenție curată de serviciu și dificultate mică. Termenii mari („parbriz”, „parbrize”) au intenție amestecată, iar o parte din cei care caută vor să cumpere produsul. **Păstrăm domeniul.** Homepage-ul țintește clusterul de serviciu **înlocuire / schimbare / montaj parbriz** (~1.300/lună împreună) și „parbrize auto” ca termen secundar. Termenii „parbriz [oraș]” merg pe paginile de oraș, ca să nu se canibalizeze cu homepage-ul.

## 2. Clustere (volum total/lună) și pagina țintă
| Cluster | Volum | Pagina țintă | Prioritate |
|---|---|---|---|
| Local: „parbriz(e) [oraș]” (~20 orașe cu 400–900/lună fiecare) | ~25.000 | `/inlocuire-parbriz-{oras}` | **Mare** |
| Reparații: reparație/reparații parbriz, fisură, ciobitură | ~12.900 (din care ~1.700 „kit” = DIY) | `/reparatie-parbriz` + articole | **Mare** |
| La domiciliu: montaj/schimbare parbriz la domiciliu | ~3.500 | `/inlocuire-parbriz-la-domiciliu` | **Mare** |
| Preț: preț parbriz, înlocuire parbriz preț, parbrize ieftine | ~6.600 (cu modele) | `/pret-inlocuire-parbriz` | Mare |
| Modele auto: „parbriz passat b6”, „parbriz logan pret”, „… cu senzori pret” | sute de cuvinte, 30–590 fiecare | viitoare pagini `/parbriz/{marca}/{model}` | Medie (etapa următoare) |
| București + sectoare | 1.900 + ~1.000 („reparații parbrize București”) | `/inlocuire-parbriz-bucuresti` + `/sector-{n}` | Mare |
| ADAS / senzori | ~600 | `/calibrare-adas` | Mică |
| Lunetă / geamuri | ~350 (+1.000 „lunetă mașină”) | `/inlocuire-luneta-si-geamuri-laterale` | Mică |
| CASCO | ~0 (fără volum măsurabil) | `/parbriz-pe-casco` (păstrată pentru conversie, nu pentru trafic) | Mică |
| Branduri (Pilkington ~4.700) | navigațional spre alte firme | **nu țintim** | — |

## 3. Competitori (DataForSEO Labs)
| Domeniu | Poziție medie | Ce face bine |
|---|---|---|
| parbrize.ro | 5,8 | rețea de pagini pe județe (`/judete-retea/parbrize-auto-{oras}`), locul 1 pe „parbrize [oraș]”; pagini pe modele auto (`/parbriz-auto/vw/passat-b6/`) |
| clinicadeparbrize.ro | 16,3 | pagini pe județe, unelte și produse |
| parbrizeacasa.ro | 11,8 | locul 1 pe „parbrize la domiciliu” și „montaj parbrize”; pagini pe mărci și modele |
| preturi-parbrize.ro | 21,8 | catalog de prețuri pe modele |
| austroglass.ro, autoglassfix.ro | ~17 | trafic estimat mare |

**Ce urmează din asta:** (1) pagini de oraș cu conținut local real, ca să intrăm pe clusterul de ~25.000 de căutări/lună; (2) homepage și pagină de domiciliu solide; (3) pagini pe mărci și modele, în etapa următoare. Nu copiem competitorii: avem un formular mai bun, mai multă transparență și conținut util pe fiecare pagină.

## 4. Orașe aprobate pentru pagini dedicate (volum „parbriz(e) / înlocuire / schimbare + oraș”)
Timișoara 1.600 · Brașov 1.580 · Ploiești 1.550 · Craiova 1.490 · Suceava 1.480 · Cluj-Napoca 1.250 · Bacău 1.200 · Pitești 1.190 · Constanța 1.000 · Sibiu 990 · Buzău 980 · Iași 830 · Arad 820 · Baia Mare 790 · Galați 790 · Brăila 780 · Oradea 780 · Bistrița 640.
Sub 600/lună (Botoșani, Focșani, Satu Mare etc.): deocamdată fără pagină dedicată. Le acoperă formularul „Alt oraș” și le adăugăm din admin când există parteneri sau cerere reală.

**Regulă de acoperire:** orașele fără parteneri confirmați au statusul „la cerere”. Pagina spune clar „trimite cererea, îți confirmăm disponibilitatea” și nu promite montaj.

## 5. Harta cuvânt → URL (anti-canibalizare)
| URL | Cuvânt principal | Secundare |
|---|---|---|
| `/` | înlocuire parbriz | schimbare parbriz, montaj parbriz, parbrize auto, înlocuire parbriz preț |
| `/inlocuire-parbriz-bucuresti` | parbrize București | înlocuire parbriz București, reparații parbrize București |
| `/inlocuire-parbriz-{oras}` | parbrize {oraș} | parbriz {oraș}, înlocuire / schimbare parbriz {oraș} |
| `/inlocuire-parbriz-bucuresti/sector-{n}` | înlocuire parbriz sector {n} | parbriz sector {n} |
| `/reparatie-parbriz` | reparație parbriz | reparații parbrize, reparație fisură / ciobitură parbriz |
| `/inlocuire-parbriz-la-domiciliu` | parbrize la domiciliu | montaj / schimbare parbriz la domiciliu |
| `/pret-inlocuire-parbriz` | preț parbriz | înlocuire parbriz preț, preturi parbrize, parbrize ieftine |
| `/calibrare-adas` | calibrare ADAS | calibrare cameră parbriz, parbriz cu senzori |
| `/inlocuire-luneta-si-geamuri-laterale` | lunetă auto | înlocuire lunetă, geamuri auto |
| `/parbriz-pe-casco` | parbriz CASCO | înlocuire parbriz CASCO |
| `/parbrize-flote-firme` | parbrize flote | parbrize firme |
| `/blog/ciobitura-parbriz-ce-faci` | ciobitură parbriz (590) | ciobitură în parbriz, piatră în parbriz |
| `/blog/parbriz-fisurat-reparatie-sau-inlocuire` | parbriz fisurat | fisură parbriz |
| `/blog/kit-reparatie-parbriz-merita` | kit reparație parbriz (1.000) | kit reparație ciobitură |
| `/blog/parbriz-original-oem-aftermarket` | parbriz original sau aftermarket | parbriz OEM, producători parbrize |
| `/blog/cat-dureaza-schimbarea-parbrizului` | cât durează schimbarea parbrizului | timp uscare adeziv |
| `/blog/calibrare-adas-dupa-schimbarea-parbrizului` | calibrare ADAS după schimbare parbriz | — |

Harta paginilor fixe e în `config/seo-map.php`; orașele și articolele își țin cuvintele în baza de date. **Admin → SEO & Conținut → Verificare SEO** arată orice cuvânt țintit de două pagini, titlurile/descrierile cu probleme și articolele fără link intern. Formularele de oraș și articol avertizează direct la câmpul „Cuvânt-cheie principal”.

### Calendar editorial (următoarele articole)
Fiecare articol trimite spre o pagină de serviciu și nu concurează cu ea: parbriz spart pe drum — ce faci; parbriz încălzit — cum îl recunoști; senzor de ploaie după schimbare; ITP cu parbriz fisurat; parbriz aburit/infiltrații după montaj; lunetă spartă — ce faci până la montaj.

## 6. Etapa 2 (25.11.2026): pagini pe modele, întrebări și publicare zilnică

Surse: exporturile DataForSEO `run-1.json` și `run-2.json` (1.046 cuvinte unice, fără cercetări noi). Cel mai mare cluster neacoperit: **„parbriz [model]” / „parbriz [model] preț” / „… cu senzori preț”** (≈ 5.000+ căutări/lună însumate, KD 0).

### Structură nouă
| URL | Ce țintește | Unde e conținutul |
|---|---|---|
| `/parbriz-auto` | hub mărci și modele (linkuri interne) | `pages/vehicles/index` |
| `/parbriz-auto/{marca}` | „parbriz {marcă}” (ex. „parbriz bmw” 90, „parbriz dacia logan”/„parbriz logan” 350) | tabel `vehicle_pages` (kind=brand) |
| `/parbriz-auto/{marca}/{model}` | „parbriz {model}” + variantele „preț”, „cu senzori”, „cu încălzire” | tabel `vehicle_pages` (kind=model), `database/data/vehicle-models.php` |
| `/intrebari-frecvente` | întrebări generale (FAQPage) | `config/faq.php` |
| `/blog/...` (14 articole noi) | întrebări informaționale (vezi mai jos) | `database/data/blog-posts-2.php` |
| `/inlocuire-parbriz-{oras}` (8 orașe noi, 340–540/lună) | „parbrize {oraș}” | `database/data/city-pages-2.php` |

Reguli păstrate: fără prețuri inventate (paginile de model explică variantele și de ce diferă prețul, oferta se face după VIN), afirmații prudente despre dotări („la unele versiuni”), acoperire „la cerere” pentru orașele noi. O pagină de marcă apare doar când are cel puțin un model publicat. Linkurile din articole spre pagini încă nepublicate devin automat text simplu (fără 404).

### Publicarea zilnică
- Tabelul `publish_queue` (admin → SEO & Conținut → **Coadă de publicare**): ordinea = `position`, opțional „nu mai devreme de”. Butoane „Publică acum” și „Mută”.
- `php artisan content:publish-next` (scheduler, la 15 minute între 9:00 și 20:00, ora României) publică **cel mult un element pe zi** (`--list` arată coada). Publicarea manuală din admin nu consumă locul zilnic.
- La publicare: `is_published=1`, `published_at=acum` → pagina intră imediat în `/sitemap.xml` cu `lastmod` actualizat; meniul de orașe se reîmprospătează.
- Pentru a adăuga conținut nou în coadă: creează articolul/pagina nepublicată în admin și adaug-o în `publish_queue` (sau printr-o migrare aditivă, ca `2026_11_25_100100_seed_seo_content_wave2`).

### Ordinea din coadă (≈ 45 de zile de la 26.11.2026)
Modele mai întâi (1–9: Logan 3, Octavia 3, Golf 7, Duster, Focus 3, Megane 3, Passat B8, Sandero, BMW F30), apoi alternativ model / articol (parbriz spart, senzor de ploaie, silicon parbriz, ITP, parbriz încălzit, polish, infiltrații, lunetă spartă, tratament hidrofob, ștergătoare, HUD, cum alegi atelierul, CASCO sau RCA), apoi orașele (Botoșani, Focșani, Satu Mare, Zalău, Alba Iulia, Slobozia, Vaslui, Slatina). Publicate imediat: hub, 9 mărci, 10 modele cu volum mare (Passat B6, Golf 4, Octavia 2, Audi A4 B8, BMW E90, Focus 2, Astra H, Logan 1, Megane 2, Qashqai J10), `/intrebari-frecvente` și articolul de sezon „Parbrizul iarna”.
