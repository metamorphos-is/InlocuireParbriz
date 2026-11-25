<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public const CATEGORIES = [
        'ghiduri' => 'Ghiduri',
        'reparatii' => 'Reparații și avarii',
        'sticla-auto' => 'Despre sticla auto',
        'costuri' => 'Costuri și asigurări',
    ];

    protected $fillable = [
        'title', 'slug', 'category', 'excerpt', 'body', 'primary_keyword', 'secondary_keywords',
        'search_volume', 'seo_title', 'meta_description', 'faq', 'related_service', 'author', 'image',
        'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'secondary_keywords' => 'array',
            'faq' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'search_volume' => 'integer',
        ];
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('is_published', true)->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function url(): string
    {
        return url('/blog/'.$this->slug);
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? Str::headline((string) $this->category);
    }

    /** Corpul articolului (Markdown) → HTML; HTML-ul brut din text e eliminat. */
    public function html(): string
    {
        $html = Str::markdown((string) $this->body, ['html_input' => 'strip', 'allow_unsafe_links' => false]);

        // Linkurile interne spre articole sau modele încă nepublicate (coada zilnică) devin text simplu, ca să nu ducă la 404.
        $html = preg_replace_callback('#<a href="(/(?:blog|parbriz-auto)/[a-z0-9/-]+)">(.*?)</a>#s', fn ($m) => self::internalLinkLive($m[1]) ? $m[0] : $m[2], $html);

        return preg_replace_callback('/<h2>(.*?)<\/h2>/s', fn ($m) => '<h2 id="'.Str::slug(html_entity_decode(strip_tags($m[1]))).'">'.$m[1].'</h2>', $html);
    }

    public static function internalLinkLive(string $path): bool
    {
        $live = once(fn () => array_merge(
            self::query()->published()->pluck('slug')->map(fn ($s) => '/blog/'.$s)->all(),
            VehiclePage::query()->published()->get()->map->path()->all(),
        ));

        return in_array(rtrim($path, '/'), $live, true);
    }

    /** Titlurile H2 din articol, pentru cuprins. */
    public function headings(): array
    {
        preg_match_all('/^##\s+(.+)$/m', (string) $this->body, $m);

        return array_map(fn ($h) => ['text' => trim($h), 'id' => Str::slug(trim($h))], $m[1]);
    }

    public function readingMinutes(): int
    {
        return max(1, (int) round(count(preg_split('/\s+/u', trim(strip_tags((string) $this->body)))) / 200));
    }
}
