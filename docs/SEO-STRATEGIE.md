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
| blog (etapa următoare) | parbriz fisurat, ciobitură parbriz, kit reparație parbriz (informațional) | — |
