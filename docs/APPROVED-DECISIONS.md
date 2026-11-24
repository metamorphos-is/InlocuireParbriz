# Decizii — auto-aprobate 2026-11-23

Client: „nu cere aprobarea mea, termină proiectul” + cutover pe domeniu + site prezentare (marketplace ascuns).

| # | Decizie | Valoare |
|---|---|---|
| 1 | Stack | Laravel 13 + Filament 4 + MySQL |
| 2 | Mediu | Direct pe `inlocuireparbriz.ro` |
| 3 | Placeholder | Șters / înlocuit (backup există) |
| 4 | Geo MVP | București S1–S6 + hub Ilfov |
| 5 | Fațadă publică | **Site de prezentare / brand** — ZERO mențiuni marketplace, rețea de prestatori, alocare lead |
| 6 | Backend | Super Admin + portal prestatori + lead + SMSO + SMTP (invizibil public) |
| 7 | Homepage | **≥ 6000 cuvinte**, SEO profund, conversie |
| 8 | Indexare | `noindex` până la mesaj „lansare” (sau index dacă e nevoie pentru test — default noindex) |
| 9 | ADAS / CASCO / flote | Pagini cu formulări prudente, fără parteneriate inventate |
| 10 | Culori | DESIGN-TOKENS.md (ink + glass blue + CTA orange) |
| 11 | SEO URL | Conform `url-architecture.md` (Home brand-led; money page București separată) |
| 12 | Aprobări | **Ticker automat — fără pause pe confirmări** |

## Ticker automat (ordine)

1. DB Hostinger
2. Scaffold Laravel (fork EE)
3. Schema automotive + seed București
4. Filament admin + portal
5. Site public prezentare + form ofertă
6. Homepage 6000+ cuvinte
7. Landing-uri V1
8. SMSO/SMTP adapters + template-uri
9. Deploy producție + noindex
10. Smoke test workflow lead
