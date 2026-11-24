# Audit tehnic — inlocuireparbriz.ro

_Etapa 1 · 24.11.2026 · cod la commit `5910a42`_

## 1. Stack și găzduire
| Element | Stare |
|---|---|
| Framework | Laravel 13.43, Filament 4.17, Livewire, PHP 8.3 (server 8.3.37) |
| BD | MySQL `u422988064_parbriz` (producție); SQLite în teste |
| Găzduire | Hostinger shared; cod în `public_html/site/` (clone Git), `.env` în `public_html/` |
| Teste | 12 teste Feature, toate trec (panouri Filament, pagini publice, 404) |
| Cozi | `QUEUE_CONNECTION=database`, dar **nu rulează niciun worker** (lipsește cron) |

## 2. Rute publice existente (URL equity de păstrat)
| URL | Tip | Sursa conținutului |
|---|---|---|
| `/` | Homepage (~7.000 de cuvinte) | `pages/home` + `public/partials/home-long-content` |
| `/inlocuire-parbriz-bucuresti` | Serviciu + oraș | `config/inlocuireparbriz.php` → `services` |
| `/inlocuire-parbriz-la-domiciliu` | Serviciu | idem |
| `/reparatie-parbriz` | Serviciu | idem |
| `/inlocuire-luneta-si-geamuri-laterale` | Serviciu | idem |
| `/calibrare-adas` | Serviciu | idem |
| `/parbrize-flote-firme` | Serviciu B2B | idem |
| `/parbriz-pe-casco` | Serviciu | idem |
| `/pret-inlocuire-parbriz` | Informativ-comercial | idem |
| `/inlocuire-parbriz-ilfov` | Locație | idem |
| `/inlocuire-parbriz-bucuresti/sector-{1..6}` | Sector | `config` → `sector_pages` |
| `/despre-noi` | Static | hardcodat în `SeoPageController` |
| `/contact`, `/politica-de-confidentialitate` | Static | view-uri |
| `/cerere-oferta` (GET/POST), `/cerere-oferta/multumim` | Formular cereri | `LeadController` |
| `/sitemap.xml` | Sitemap | generat din config |
| Redirecturi 301 | `/solicita-oferta` → `/cerere-oferta`, `/politica-confidentialitate` → `/politica-de-confidentialitate` | `routes/web.php` |

Site-ul e **noindex** peste tot (meta, header `X-Robots-Tag`, `robots.txt Disallow: /`), deci **nu există încă URL equity în Google**. Asta ne lasă libertate la restructurare, dar URL-urile de mai sus primesc totuși 301 dacă se schimbă.

## 3. Workflow-ul de cereri (de PĂSTRAT integral)
1. Formularul `/cerere-oferta` are honeypot `website`, CSRF și throttle de 6/min. Câmpuri: nume, telefon, email, serviciu, zonă (București sector / Ilfov localitate), marcă, model, an, VIN, tip geam, dotări (9), tip locație, descriere, urgență, consimțământ.
2. `LeadController::persist` salvează în `leads` (status `noua`, referință `IP-XXXXXX`, `landing_path`, `ip_hash`). Dacă BD pică, cade pe un stub JSONL în `storage/app/leads-stub/`.
3. În admin: `LeadWorkflow::assign` (alocare partener + `lead_assignments` + `lead_events`), `changeStatus` (+ note).
4. `LeadNotifier`: SMS (SMSO) și email pe template-uri din BD, cu log în `notification_logs`.
5. Portal partener: vede doar cererile alocate lui (`LeadPolicy`) și setează statusurile permise.

Tabele: `leads`, `lead_assignments`, `lead_events`, `lead_notes`, `providers`, `provider_category`, `provider_coverage`, `cities`, `city_sectors`, `categories`, `notification_templates`, `notification_logs`, `site_settings`, `seo_pages`, `redirects`, `audit_logs`, `users` (+ rol).

## 4. Probleme găsite
| # | Problemă | Gravitate | Stare |
|---|---|---|---|
| 1 | Orice 404 dădea **eroare 500** (rută `servicii.index` inexistentă în template) | Mare | ✅ Reparat (`5910a42`) |
| 2 | `notifyAdminNewLead` / `notifyCustomerReceived` **nu sunt apelate nicăieri**: adminul nu e anunțat de cererile noi | Mare | De reparat (Etapa 5), fără să schimbe logica |
| 3 | Validarea formularului acceptă doar `bucuresti` / `ilfov`: cererile din alte orașe nu pot fi trimise | Mare pentru varianta națională | De extins (Etapa 5) |
| 4 | Tot conținutul SEO e în `config/*.php`, deci **nu poate fi editat din admin** | Mare | Etapa 5: migrare în BD |
| 5 | Tabelele `seo_pages` și `redirects` există, dar nu sunt folosite de site | Medie | Etapa 5 |
| 6 | FAQ „Sunteți un marketplace? — Nu.” contrazice modelul real (cereri trimise partenerilor) | Mare (E-E-A-T, onestitate) | Aștept decizia proprietarului |
| 7 | Moșteniri ExpertElectric: `expertelectric.css/js`, clase `ee-*`, view-uri moarte | Mică | View-urile moarte au fost șterse; CSS-ul se refactorizează la redesign |
| 8 | Homepage de ~7.000 de cuvinte (cerință veche): prea lung, cu risc de umplutură | Medie | Etapa 4/6 |
| 9 | Meniul are 3 linkuri diferite spre același URL (lunetă/geamuri) | Mică | Etapa 3/4 |
| 10 | Schema: doar `LocalBusiness` parțial, fără adresă sau telefon reale | Medie | Etapa 7 |
| 11 | Nu rulează niciun cron: migrări, coadă și scheduler inexistente | Mare | Aștept aprobarea pentru cron |

## 5. Ce trebuie păstrat neapărat
- Tot fluxul de cereri (punctul 3), datele și relațiile din BD.
- Panourile `/admin` și `/portal` și politica de acces la cereri.
- URL-urile din secțiunea 2 (sau 301 către noile URL-uri).
- Criptarea secretelor în `site_settings` (`SettingSecret`).
