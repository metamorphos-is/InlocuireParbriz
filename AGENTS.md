# Instrucțiuni pentru agenți AI (Claude, Cursor etc.)

Proiectul e lucrat de mai mulți asistenți AI. Ca să nu ne călcăm pe picioare, toți respectăm regulile de mai jos.

## 1. Sursa adevărului = GitHub
- Repo: https://github.com/metamorphos-is/InlocuireParbriz, ramura `main`.
- Orice modificare de cod se face **în repo** (commit + push pe `main`). Nu edita fișiere direct pe server.
- Înainte să începi lucrul: `git pull`. După ce termini: commit cu mesaj clar (în română) + `git push`.
- Pe calculatorul proprietarului, copia de lucru e `E:\CursorProjects\Site-uri\InlocuireParbriz\app\`. Folderele `deploy-git/`, `deploy-laravel/` și arhivele zip sunt **vechi** — nu le mai folosi.
- Dacă `app\` nu e încă legat de Git (nu are folderul `.git`), leagă-l o singură dată, din `app\`:
  ```sh
  git init -b main
  git remote add origin https://github.com/metamorphos-is/InlocuireParbriz.git
  git fetch origin
  git reset --mixed origin/main   # păstrează fișierele locale (.env, vendor), aliniază istoricul
  git status                      # verifică diferențele înainte de orice commit
  ```
- Claude lucrează din cloud: face commit + push direct în GitHub și copiază aceleași fișiere în `app\`. Dacă vezi fișiere modificate pe care nu le-ai atins tu, rulează `git status` / `git pull` înainte să suprascrii ceva.

## 2. Publicarea pe server (Hostinger)
- Cont `u422988064`, domeniul `inlocuireparbriz.ro`.
- Codul rulează din `public_html/site/` (clone Git). `public_html/.htaccess` trimite cererile către `site/public/`.
- Publicarea se face cu operația Hostinger **`hosting_git_deploy-website-repository`** (repo-ul de mai sus, ramura `main`, directorul `site`). Ea face `git pull` + `composer install` și **păstrează** `.env` și `vendor/`.
- **NU folosi `hosting_deploy`** și nici încărcarea de arhive: suprascriu tot site-ul și șterg `.env` și `vendor/`.
- Pachetele PHP se instalează **doar** prin `composer install` (Packagist). Nu urca `vendor/` din alte surse (catbox, tmpfiles etc.).
- Hostinger **nu rulează scripturile composer** (`post-autoload-dump`). De aceea asset-urile Filament (`public/js|css|fonts/filament`) sunt ținute în Git. După un upgrade Filament: `php artisan filament:assets` local, apoi commit.
- `composer.json` fixează platforma la PHP 8.3 (`config.platform`), ca pe server. Nu o schimba fără să schimbi și versiunea PHP din hPanel.
- Operația de deploy poate întoarce HTTP 500 (timeout) deși reușește pe server: așteaptă ~1 minut și verifică fișierele în `site/` înainte s-o repeți.
- Deploy-ul raportează `is_success: false` cu „You are running 8.2.36”: Composer-ul Hostinger rulează în CLI pe PHP 8.2, iar scripturile `post-autoload-dump` (artisan) cad. **Codul și `vendor/` se actualizează totuși** (site-ul rulează pe PHP 8.3). Verifică fișierele, nu te baza pe acel flag. Comenzile artisan în cron folosesc explicit `/opt/alt/php83/usr/bin/php` și calea completă către `artisan`, **fără `cd` și fără `&&`** (Hostinger escapează caracterele speciale și comanda nu mai rulează; max 255 caractere). Cron-ul activ: `/opt/alt/php83/usr/bin/php /home/u422988064/domains/inlocuireparbriz.ro/public_html/site/artisan schedule:run`.
- **Migrările** rulează automat după deploy prin `app:post-deploy` (scheduler, cron Hostinger `* * * * * php artisan schedule:run`), sau manual din admin → Sistem → **Întreținere** → „Rulează migrările acum”. Migrările trebuie să fie **doar aditive** (fără drop/rename pe coloane cu date) — altfel discută întâi cu proprietarul.
- Tot ce rulează periodic se definește în `routes/console.php` (versionat), nu direct în cron-ul Hostinger.
- Pe Hostinger `proc_open`, `exec`, `popen`, `shell_exec` sunt **dezactivate**: în scheduler folosește doar `Schedule::call(fn () => Artisan::call(...))`, niciodată `Schedule::command()` sau `runInBackground()`. Nici `Process`/`Symfony Process` în cod.

## 3. Secrete
- Nu pune niciodată în Git: `.env`, `bootstrap/production-settings.php`, `secrets/`, parole, chei API, token-uri.
- Credențialele de producție există doar pe server, în `public_html/.env` (aplicația din `site/` îl citește automat din folderul părinte — vezi `bootstrap/app.php`).
- Parola de admin nu se scrie în cod. Seeder-ul folosește `ADMIN_INITIAL_PASSWORD` din `.env`.

## 4. Interzis pe server
- Scripturi „one-shot” cu token în clar în `public/` (`setup-once.php`, `install-vendor.php`, `cleanup-temp.php` etc.). Dacă e nevoie de migrări sau comenzi artisan, discută întâi cu proprietarul o soluție sigură.

## 5. DataForSEO
- Credențiale DOAR pe server: `DATAFORSEO_LOGIN` / `DATAFORSEO_PASSWORD` în `public_html/.env` (sau Setări site → DataForSEO, criptat). Niciodată în cod, Git sau frontend.
- Cod: `app/Services/DataForSeo/*` (client cu cache 30 zile, plafon lunar, jurnal în `dataforseo_requests`). Planul național: `config/seo-research.php`.
- Rulare: admin → SEO & Conținut → **Cercetare DataForSEO**, sau `php artisan seo:research --plan=national`. Rezultatele: tabel `seo_keywords` + export `storage/app/seo-research/run-{id}.json`.
- Nu rula cercetări inutil — costă bani. Verifică întâi cache-ul / rulările existente.

## 6. Despre proiect
- Laravel 13 + Filament 4 + MySQL. `/admin` (Super Admin), `/portal` (parteneri), site public cu pagini SEO și formularul `/cerere-oferta`.
- Prezentarea publică (decizia proprietarului, 24.11.2026): onestă și discretă — „Primești oferta și montajul prin atelierele partenere verificate din orașul tău”. Nu folosi cuvântul „marketplace” și nu detalia alocarea internă; nu nega existența partenerilor.
- Orașe fără acoperire confirmată: „Trimite cererea, îți confirmăm disponibilitatea în zona ta” — nu promite montaj acolo.
- Datele firmei se editează din admin (Setări site → Date firmă, `App\Support\Company`). Cât timp „Date de test” e activ, nu intră în Schema.org.
- Site-ul e `noindex` până când proprietarul spune „lansare”.
- Starea proiectului și deciziile: vezi `docs/` din repo.

## 7. Scriere (decizia proprietarului, 24.11.2026)
- Titluri, H1–H4, meniuri, butoane: **ca în română** — majusculă doar la începutul propoziției, la nume proprii (orașe, cartiere, județe) și la acronime (ADAS, CASCO). Fără „Title Case” și fără `text-transform: uppercase`.
- Numele site-ului se scrie `inlocuireparbriz.ro` (titluri: „… | inlocuireparbriz.ro”). Testul `tests/Feature/TitleCaseTest.php` verifică automat.
- Favicon: `public/assets/img/favicon.svg` + `public/favicon.ico` (parbriz portocaliu pe fond închis).
- Indexarea se pornește dintr-un singur loc: admin → Setări site → SEO → „noindex” (meta, `X-Robots-Tag` și `/robots.txt` urmează comutatorul). Redirecționările stau în tabela `redirects` (middleware `HandleRedirects`).
