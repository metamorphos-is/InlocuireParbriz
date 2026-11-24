# Instrucțiuni pentru agenți AI (Claude, Cursor etc.)

Proiectul e lucrat de mai mulți asistenți AI. Ca să nu ne călcăm pe picioare, toți respectăm regulile de mai jos.

## 1. Sursa adevărului = GitHub
- Repo: https://github.com/metamorphos-is/InlocuireParbriz, ramura `main`.
- Orice modificare de cod se face **în repo** (commit + push pe `main`). Nu edita fișiere direct pe server.
- Înainte să începi lucrul: `git pull`. După ce termini: commit cu mesaj clar (în română) + `git push`.
- Pe calculatorul proprietarului, copia de lucru e `E:\CursorProjects\Site-uri\InlocuireParbriz\app\` (un clone al repo-ului). Folderele `deploy-git/`, `deploy-laravel/` și arhivele zip sunt **vechi** — nu le mai folosi.

## 2. Publicarea pe server (Hostinger)
- Cont `u422988064`, domeniul `inlocuireparbriz.ro`.
- Codul rulează din `public_html/site/` (clone Git). `public_html/.htaccess` trimite cererile către `site/public/`.
- Publicarea se face cu operația Hostinger **`hosting_git_deploy-website-repository`** (repo-ul de mai sus, ramura `main`, directorul `site`). Ea face `git pull` + `composer install` și **păstrează** `.env` și `vendor/`.
- **NU folosi `hosting_deploy`** și nici încărcarea de arhive: suprascriu tot site-ul și șterg `.env` și `vendor/`.
- Pachetele PHP se instalează **doar** prin `composer install` (Packagist). Nu urca `vendor/` din alte surse (catbox, tmpfiles etc.).

## 3. Secrete
- Nu pune niciodată în Git: `.env`, `bootstrap/production-settings.php`, `secrets/`, parole, chei API, token-uri.
- Credențialele de producție există doar pe server (`site/.env`).
- Parola de admin nu se scrie în cod. Seeder-ul folosește `ADMIN_INITIAL_PASSWORD` din `.env`.

## 4. Interzis pe server
- Scripturi „one-shot” cu token în clar în `public/` (`setup-once.php`, `install-vendor.php`, `cleanup-temp.php` etc.). Dacă e nevoie de migrări sau comenzi artisan, discută întâi cu proprietarul o soluție sigură.

## 5. Despre proiect
- Laravel 13 + Filament 4 + MySQL. `/admin` (Super Admin), `/portal` (parteneri), site public cu pagini SEO și formularul `/cerere-oferta`.
- Fațada publică e un site de prezentare: **fără** mențiuni despre marketplace, rețea de parteneri sau alocarea cererilor.
- Site-ul e `noindex` până când proprietarul spune „lansare”.
- Starea proiectului și deciziile: vezi `docs/` din repo.
