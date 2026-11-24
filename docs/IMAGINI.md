# Imagini

- Originalele (zeci de MB fiecare) stau la proprietar: `E:\CursorProjects\Site-uri\InlocuireParbriz\Images`. **Nu intră în Git.**
- Pe site ajung doar variantele optimizate din `public/assets/img/foto/`:
  - `{slug}-720.webp` (mobil, ~30–100 KB), `{slug}-1280.webp` (desktop), `{slug}-og.jpg` (1200×630, thumbnail pentru Google/Facebook).
- Numele fișierelor sunt descriptive, în română (`montaj-parbriz-ventuze`), iar textul `alt` e în `config/images.php`.
- Ce imagine apare unde: `config/images.php` (`pages`, `city_heroes`, `posts`). Orașele și articolele pot primi altă imagine din admin (câmpul „Imagine principală”).
- O imagine nouă: optimizează-o cu ImageMagick, apoi adaug-o în `library`:
  ```sh
  convert original.jpg -auto-orient -strip -resize 1280x -quality 74 slug-1280.webp
  convert original.jpg -auto-orient -strip -resize 720x  -quality 72 slug-720.webp
  convert original.jpg -auto-orient -strip -resize 1200x630^ -gravity center -extent 1200x630 -interlace JPEG -quality 78 slug-og.jpg
  ```
- `tests/Feature/ImagesTest.php` verifică variantele, dimensiunile maxime, `og:image` și `alt` pe pagini.
