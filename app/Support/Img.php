<?php

namespace App\Support;

use App\Models\City;
use App\Models\Post;

/** Fotografiile optimizate din config/images.php: alegerea pe pagină și URL-urile variantelor. */
final class Img
{
    public const DEFAULT = 'montaj-parbriz-ventuze';

    public static function exists(?string $slug): bool
    {
        return $slug !== null && isset(config('images.library')[$slug]);
    }

    /** @return array{slug:string,alt:string,w:int,h:int,src:string,src720:string,og:string}|null */
    public static function get(?string $slug): ?array
    {
        if (! self::exists($slug)) {
            return null;
        }
        $i = config('images.library')[$slug];
        $base = '/assets/img/foto/'.$slug;

        return [
            'slug' => $slug,
            'alt' => $i['alt'],
            'w' => 1280,
            'h' => (int) ($i['h'] ?? 853),
            'src' => asset($base.'-1280.webp'),
            'src720' => asset($base.'-720.webp'),
            'og' => asset($base.'-og.jpg'),
        ];
    }

    /** @return string[] */
    public static function forPath(string $path): array
    {
        return config('images.pages')['/'.ltrim($path, '/')] ?? [];
    }

    /** @return array{0:string,1:string} [hero, imagine secundară] */
    public static function forCity(City $city, int $position = 0): array
    {
        $heroes = config('images.city_heroes');
        $second = config('images.city_secondary');
        $hero = self::exists($city->image ?? null) ? $city->image : $heroes[$position % count($heroes)];
        $alt = $second[$position % count($second)];

        return [$hero, $alt === $hero ? $second[($position + 1) % count($second)] : $alt];
    }

    public static function forPost(Post $post): string
    {
        if (self::exists($post->image ?? null)) {
            return $post->image;
        }

        return config('images.posts')[$post->slug] ?? 'sticla-parbriz-sparta-detaliu';
    }

    /** Opțiuni pentru câmpurile de alegere din admin. */
    public static function options(): array
    {
        return collect(config('images.library'))->mapWithKeys(fn ($i, $slug) => [$slug => $i['alt']])->all();
    }
}
