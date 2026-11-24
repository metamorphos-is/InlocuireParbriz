# Starea proiectului

_Actualizat: 24.11.2026_

## Ce există
- **Site public**: București (sectoarele 1–6) + Ilfov; 10 pagini SEO cu slug-uri fixe în `routes/web.php`; formularul `/cerere-oferta` (throttle 6/min, honeypot, CSRF).
- **`/admin`** (role `super_admin`): cereri (lead-uri), parteneri, utilizatori, orașe, sectoare, categorii, pagini SEO, șabloane de notificări, setări (SMTP, SMSO), statistici.
- **`/portal`** (role `provider`): cererile alocate partenerului, schimbare status, statistici.
- **Fluxul unei cereri**: formular → status `noua` → adminul alocă manual un partener (`LeadWorkflow::assign`) → partenerul primește email/SMS (`LeadNotifier`, `SmsoClient`) → partenerul actualizează statusul în portal. Istoricul se păstrează în `lead_assignments`, `lead_events` și `lead_notes`.
- **Statusuri**: noua → in_analiza → atribuita → contactat → programata → in_desfasurare → finalizata / refuzata / anulata / arhivata.
- **Parteneri**: firmă, CUI, categorii de servicii, acoperire pe oraș/sector (`provider_coverage`).

## Ce lipsește pentru varianta națională
- Pagini de oraș generate dinamic (acum doar București, cu slug-uri hardcodate).
- Alocarea automată a cererilor după acoperirea partenerului.
- Înscrierea partenerilor (onboarding) și, eventual, taxarea pe cerere.
- SMTP și SMSO configurate (acum sunt dezactivate din setări).
- Un mecanism sigur pentru migrări pe server (fără scripturi cu token în clar).

## Istoric
- 23.11.2026: MVP construit cu Cursor (fork din proiectul ExpertElectric), publicat pe Hostinger.
- 24.11.2026: Codul a fost mutat în GitHub; au fost șterse scripturile de instalare rămase pe server; parola de admin a fost scoasă din seeder; publicarea se face din Git în `public_html/site/`.
