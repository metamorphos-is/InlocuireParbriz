<?php

namespace App\Services\DataForSeo;

use App\Models\SeoKeyword;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Operații de cercetare peste DataForSEO + salvarea rezultatelor în `seo_keywords`.
 * Fiecare metodă întoarce date normalizate (array simplu), ca să poată fi afișate în admin
 * sau exportate în JSON.
 */
class KeywordResearch
{
    public function __construct(protected DataForSeoClient $client) {}

    protected function loc(): int
    {
        return (int) config('seo-research.location_code', DataForSeoClient::ROMANIA);
    }

    protected function lang(): string
    {
        return (string) config('seo-research.language_code', 'ro');
    }

    /**
     * Volume Google Ads (sursa cea mai fiabilă pentru volum/CPC). Max 1000 cuvinte per task.
     *
     * @param  array<int,string>  $keywords
     * @return array<int,array<string,mixed>>
     */
    public function searchVolume(array $keywords): array
    {
        $keywords = array_values(array_unique(array_filter(array_map(
            fn ($k) => SeoKeyword::normalize($k),
            $keywords
        ), fn ($k) => $k !== '' && mb_strlen($k) <= 80 && count(explode(' ', $k)) <= 10)));

        $rows = [];
        foreach (array_chunk($keywords, 1000) as $chunk) {
            $tasks = $this->client->post('/v3/keywords_data/google_ads/search_volume/live', [[
                'keywords' => $chunk,
                'location_code' => $this->loc(),
                'language_code' => $this->lang(),
            ]]);

            foreach (DataForSeoClient::firstResult($tasks) as $item) {
                $rows[] = [
                    'keyword' => $item['keyword'],
                    'search_volume' => $item['search_volume'] ?? null,
                    'cpc' => $item['cpc'] ?? null,
                    'competition' => isset($item['competition_index']) ? $item['competition_index'] / 100 : null,
                    'competition_level' => isset($item['competition']) ? strtolower((string) $item['competition']) : null,
                    'monthly_searches' => $item['monthly_searches'] ?? null,
                    'source' => 'search_volume',
                ];
            }
        }

        return $rows;
    }

    /**
     * Sugestii (DataForSEO Labs). Dacă Labs nu acoperă piața, cade pe Google Ads keywords_for_keywords.
     *
     * @return array<int,array<string,mixed>>
     */
    public function suggestions(string $seed, int $limit = 300): array
    {
        try {
            $tasks = $this->client->post('/v3/dataforseo_labs/google/keyword_suggestions/live', [[
                'keyword' => $seed,
                'location_code' => $this->loc(),
                'language_code' => $this->lang(),
                'limit' => $limit,
                'include_seed_keyword' => true,
            ]]);
            $items = DataForSeoClient::firstResult($tasks)[0]['items'] ?? [];
            if ($items) {
                return array_map(fn ($i) => $this->fromLabsItem($i, 'suggestions'), $items);
            }
        } catch (Throwable $e) {
            Log::warning('Labs keyword_suggestions a eșuat, trec pe Google Ads', ['seed' => $seed, 'error' => $e->getMessage()]);
        }

        return $this->keywordsForKeywords([$seed]);
    }

    /** @return array<int,array<string,mixed>> */
    public function related(string $seed, int $limit = 300): array
    {
        try {
            $tasks = $this->client->post('/v3/dataforseo_labs/google/related_keywords/live', [[
                'keyword' => $seed,
                'location_code' => $this->loc(),
                'language_code' => $this->lang(),
                'depth' => 2,
                'limit' => $limit,
            ]]);

            return array_map(
                fn ($i) => $this->fromLabsItem($i['keyword_data'] ?? [], 'related'),
                DataForSeoClient::firstResult($tasks)[0]['items'] ?? []
            );
        } catch (Throwable $e) {
            Log::warning('Labs related_keywords a eșuat', ['seed' => $seed, 'error' => $e->getMessage()]);

            return [];
        }
    }

    /**
     * Fallback Google Ads: idei de cuvinte pornind de la o listă (max 20).
     *
     * @param  array<int,string>  $seeds
     * @return array<int,array<string,mixed>>
     */
    public function keywordsForKeywords(array $seeds): array
    {
        $tasks = $this->client->post('/v3/keywords_data/google_ads/keywords_for_keywords/live', [[
            'keywords' => array_slice($seeds, 0, 20),
            'location_code' => $this->loc(),
            'language_code' => $this->lang(),
        ]]);

        return array_map(fn ($item) => [
            'keyword' => $item['keyword'],
            'search_volume' => $item['search_volume'] ?? null,
            'cpc' => $item['cpc'] ?? null,
            'competition' => isset($item['competition_index']) ? $item['competition_index'] / 100 : null,
            'competition_level' => isset($item['competition']) ? strtolower((string) $item['competition']) : null,
            'monthly_searches' => $item['monthly_searches'] ?? null,
            'source' => 'keywords_for_keywords',
        ], DataForSeoClient::firstResult($tasks));
    }

    /**
     * Top rezultate organice Google pentru un cuvânt.
     *
     * @return array<int,array{position:int,domain:string,url:string,title:?string,type:string}>
     */
    public function serp(string $keyword, int $depth = 10): array
    {
        $tasks = $this->client->post('/v3/serp/google/organic/live/advanced', [[
            'keyword' => $keyword,
            'location_code' => $this->loc(),
            'language_code' => $this->lang(),
            'device' => 'desktop',
            'depth' => $depth,
        ]]);

        $result = DataForSeoClient::firstResult($tasks)[0] ?? [];
        $features = array_values(array_unique(array_filter(Arr::pluck($result['items'] ?? [], 'type'), fn ($t) => $t !== 'organic')));

        $organic = [];
        foreach ($result['items'] ?? [] as $item) {
            if (($item['type'] ?? '') !== 'organic') {
                continue;
            }
            $organic[] = [
                'position' => (int) ($item['rank_group'] ?? 0),
                'domain' => $this->realDomain($item),
                'website_name' => $item['website_name'] ?? null,
                'url' => (string) ($item['url'] ?? ''),
                'title' => $item['title'] ?? null,
                'type' => 'organic',
            ];
        }

        return ['organic' => $organic, 'features' => $features];
    }

    /**
     * Google întoarce uneori linkuri „google.com/goto?...” — luăm domeniul real din breadcrumb.
     *
     * @param  array<string,mixed>  $item
     */
    protected function realDomain(array $item): string
    {
        $domain = (string) ($item['domain'] ?? '');
        if ($domain !== '' && ! str_contains($domain, 'google.')) {
            return $domain;
        }
        foreach (['breadcrumb', 'url'] as $field) {
            $value = (string) ($item[$field] ?? '');
            if (preg_match('#https?://([^/\s›]+)#u', $value, $m) && ! str_contains($m[1], 'google.')) {
                return strtolower($m[1]);
            }
        }

        return $domain;
    }

    /**
     * Domeniile care apar cel mai des în top pentru o listă de cuvinte (Labs, fără scraping live).
     *
     * @param  array<int,string>  $keywords
     * @return array<int,array<string,mixed>>
     */
    public function serpCompetitors(array $keywords, int $limit = 40): array
    {
        $tasks = $this->client->post('/v3/dataforseo_labs/google/serp_competitors/live', [[
            'keywords' => array_values(array_slice(array_unique($keywords), 0, 200)),
            'location_code' => $this->loc(),
            'language_code' => $this->lang(),
            'item_types' => ['organic'],
            'limit' => $limit,
        ]]);

        return array_map(fn ($i) => [
            'domain' => preg_replace('/^www\./', '', (string) ($i['domain'] ?? '')),
            'avg_position' => $i['avg_position'] ?? null,
            'median_position' => $i['median_position'] ?? null,
            'keywords_count' => $i['keywords_count'] ?? null,
            'etv' => $i['etv'] ?? null,
            'visibility' => $i['visibility'] ?? null,
            'rating' => $i['rating'] ?? null,
        ], DataForSeoClient::firstResult($tasks)[0]['items'] ?? []);
    }

    /**
     * Cuvintele pentru care se poziționează un domeniu (Labs).
     *
     * @return array<int,array<string,mixed>>
     */
    public function rankedKeywords(string $domain, int $limit = 400): array
    {
        $tasks = $this->client->post('/v3/dataforseo_labs/google/ranked_keywords/live', [[
            'target' => $domain,
            'location_code' => $this->loc(),
            'language_code' => $this->lang(),
            'limit' => $limit,
            'order_by' => ['keyword_data.keyword_info.search_volume,desc'],
        ]]);

        return array_map(function ($i) {
            $row = $this->fromLabsItem($i['keyword_data'] ?? [], 'ranked');
            $serp = $i['ranked_serp_element']['serp_item'] ?? [];
            $row['position'] = $serp['rank_group'] ?? null;
            $row['url'] = $serp['url'] ?? null;

            return $row;
        }, DataForSeoClient::firstResult($tasks)[0]['items'] ?? []);
    }

    /**
     * Dificultate (0–100) pentru max 1000 cuvinte.
     *
     * @param  array<int,string>  $keywords
     * @return array<string,int>
     */
    public function difficulty(array $keywords): array
    {
        $out = [];
        foreach (array_chunk(array_values(array_unique($keywords)), 1000) as $chunk) {
            try {
                $tasks = $this->client->post('/v3/dataforseo_labs/google/bulk_keyword_difficulty/live', [[
                    'keywords' => $chunk,
                    'location_code' => $this->loc(),
                    'language_code' => $this->lang(),
                ]]);
                foreach (DataForSeoClient::firstResult($tasks)[0]['items'] ?? [] as $i) {
                    if (isset($i['keyword_difficulty'])) {
                        $out[$i['keyword']] = (int) $i['keyword_difficulty'];
                    }
                }
            } catch (Throwable $e) {
                Log::warning('bulk_keyword_difficulty a eșuat', ['error' => $e->getMessage()]);
            }
        }

        return $out;
    }

    /**
     * Intenția principală de căutare (Labs) pentru max 1000 cuvinte.
     *
     * @param  array<int,string>  $keywords
     * @return array<string,string>
     */
    public function intents(array $keywords): array
    {
        $out = [];
        foreach (array_chunk(array_values(array_unique($keywords)), 1000) as $chunk) {
            try {
                $tasks = $this->client->post('/v3/dataforseo_labs/google/search_intent/live', [[
                    'keywords' => $chunk,
                    'language_code' => $this->lang(),
                ]]);
                foreach (DataForSeoClient::firstResult($tasks)[0]['items'] ?? [] as $i) {
                    if ($label = $i['keyword_intent']['label'] ?? null) {
                        $out[$i['keyword']] = $label;
                    }
                }
            } catch (Throwable $e) {
                Log::warning('search_intent a eșuat', ['error' => $e->getMessage()]);
            }
        }

        return $out;
    }

    /** Sold și limite ale contului. */
    public function account(): array
    {
        $tasks = $this->client->get('/v3/appendix/user_data');
        $r = DataForSeoClient::firstResult($tasks)[0] ?? [];

        return [
            'login' => $r['login'] ?? null,
            'balance' => $r['money']['balance'] ?? null,
            'total_spent' => $r['money']['total'] ?? null,
        ];
    }

    /**
     * Salvează/actualizează rânduri în `seo_keywords`, fără să șteargă alocările făcute manual
     * (cluster, pagină, rol, prioritate rămân neatinse dacă există).
     *
     * @param  array<int,array<string,mixed>>  $rows
     */
    public function store(array $rows): int
    {
        $count = 0;
        foreach ($rows as $row) {
            if (blank($row['keyword'] ?? null)) {
                continue;
            }
            $kw = SeoKeyword::normalize($row['keyword']);
            $model = SeoKeyword::query()->firstOrNew([
                'keyword' => $kw,
                'location_code' => $this->loc(),
                'language_code' => $this->lang(),
            ]);

            foreach (['search_volume', 'cpc', 'competition', 'competition_level', 'keyword_difficulty', 'intent', 'monthly_searches'] as $field) {
                if (array_key_exists($field, $row) && $row[$field] !== null) {
                    // Volumul Google Ads are prioritate față de estimările Labs.
                    if ($field === 'search_volume' && $model->exists && $model->source === 'search_volume' && ($row['source'] ?? '') !== 'search_volume') {
                        continue;
                    }
                    $model->{$field} = $row[$field];
                }
            }
            if (! $model->exists || ($row['source'] ?? null) === 'search_volume') {
                $model->source = $row['source'] ?? $model->source;
            }
            if (isset($row['city_slug']) && blank($model->city_slug)) {
                $model->city_slug = $row['city_slug'];
            }
            $model->fetched_at = now();
            $model->save();
            $count++;
        }

        return $count;
    }

    /** @param  array<string,mixed>  $data */
    protected function fromLabsItem(array $data, string $source): array
    {
        $info = $data['keyword_info'] ?? [];

        return [
            'keyword' => $data['keyword'] ?? '',
            'search_volume' => $info['search_volume'] ?? null,
            'cpc' => $info['cpc'] ?? null,
            'competition' => $info['competition'] ?? null,
            'competition_level' => isset($info['competition_level']) ? strtolower((string) $info['competition_level']) : null,
            'monthly_searches' => $info['monthly_searches'] ?? null,
            'keyword_difficulty' => $data['keyword_properties']['keyword_difficulty'] ?? null,
            'intent' => $data['search_intent_info']['main_intent'] ?? null,
            'source' => $source,
        ];
    }
}
