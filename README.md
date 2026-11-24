# InlocuireParbriz.ro

Site de prezentare pentru înlocuire parbriz și, în spate, un marketplace care colectează cererile clienților și le trimite colaboratorilor (parteneri).

## Stack
- Laravel 13 + Filament 4, PHP 8.3+, MySQL
- `/admin`: panou Super Admin (cereri, parteneri, orașe/sectoare, categorii, SEO, setări SMTP/SMSO)
- `/portal`: portalul partenerilor (cererile alocate, statusuri)
- Site public: pagini SEO + formular `/cerere-oferta`

## Găzduire
- Hostinger, domeniul `inlocuireparbriz.ro`. Rădăcina documentelor e rădăcina proiectului; `.htaccess` trimite cererile spre `public/`.
- Credențialele de producție stau **doar pe server** (`.env` / `bootstrap/production-settings.php`) și nu se pun niciodată în Git.
- `vendor/` nu e în Git: se instalează pe server cu `composer install`, care rulează și `php artisan filament:upgrade` (publică asset-urile Filament).

## Dezvoltare locală
```sh
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed   # setează ADMIN_INITIAL_PASSWORD în .env înainte
php artisan serve
```

## Reguli
- Nu se urcă pe server scripturi de instalare cu token în clar (`setup-once.php` etc.).
- Site-ul rămâne `noindex` până la lansare (`public/robots.txt` + middleware-ul `ForceNoIndex`).
