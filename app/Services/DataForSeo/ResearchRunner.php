<?php

namespace App\Services\DataForSeo;

use App\Models\DataForSeoRequest;
use App\Models\SeoKeyword;
use App\Models\SeoResearchRun;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Throwable;

/**
 * Execută o rulare de cercetare (SeoResearchRun) și exportă rezultatul în
 * storage/app/seo-research/run-{id}.json (pentru analiză și pentru documentația proiectului).
 */
class ResearchRunner
{
    public function run(SeoResearchRun $run): SeoResearchRun
    {
        $run->update(['status' => 'running', 'started_at' => now(), 'error' => null]);
        $research = new KeywordResearch(app(DataForSeoClient::class)->forRun($run->id));

        try {
            $summary = match ($run->type) {
                'national_plan' => $this->nationalPlan($research, $run),
                'search_volume' => $this->simpleVolume($research, $run),
                'suggestions' => $this->simpleExpand($research, $run, 'suggestions'),
                'related' => $this->simpleExpand($research, $run, 'related'),
                'serp' => ['serp' => [$run->params['keyword'] => $research->serp($run->params['keyword'])]],
                'competitor' => $this->competitor($research, $run),
                'competitors_plan' => $this->competitorsPlan($research),
                default => throw new \InvalidArgumentException("Tip necunoscut: {$run->type}"),
            };

            $cost = (float) DataForSeoRequest::query()->where('research_run_id', $run->id)->sum('cost');
            $summary['cost_usd'] = round($cost, 4);
            $this->export($run, $summary);

            $run->update([
                'status' => 'done',
                'summary' => Arr::only($summary, ['keywords_saved', 'cost_usd', 'competitors', 'notes']),
                'cost' => $cost,
                'finished_at' => now(),
            ]);
        } catch (Throwable $e) {
            $run->update([
                'status' => 'failed',
                'error' => mb_substr($e->getMessage(), 0, 2000),
                'cost' => (float) DataForSeoRequest::query()->where('research_run_id', $run->id)->sum('cost'),
                'finished_at' => now(),
            ]);
        }

        return $run->fresh();
    }

    protected function nationalPlan(KeywordResearch $r, SeoResearchRun $run): array
    {
        $cfg = config('seo-research');
        $notes = [];

        // 1) Volume Google Ads: cuvinte generice + oraș × tipar + sectoare.
        $local = [];
        $cityOf = [];
        foreach ($cfg['cities'] as $short => $name) {
            foreach ($cfg['city_patterns'] as $p) {
                $kw = str_replace('{city}', $short, $p);
                $local[] = $kw;
                $cityOf[$kw] = $short;
            }
        }
        foreach (range(1, 6) as $n) {
            foreach ($cfg['sector_patterns'] as $p) {
                $kw = str_replace('{n}', (string) $n, $p);
                $local[] = $kw;
                $cityOf[$kw] = 'bucuresti';
            }
        }

        $volumes = $r->searchVolume(array_merge($cfg['seeds'], $local));
        foreach ($volumes as &$row) {
            $row['city_slug'] = $cityOf[$row['keyword']] ?? null;
        }
        unset($row);
        $saved = $r->store($volumes);

        // 2) Extindere: sugestii + înrudite.
        $expanded = [];
        foreach ($cfg['expand_seeds'] as $seed) {
            $expanded = array_merge($expanded, $r->suggestions($seed, $cfg['expand_limit']), $r->related($seed, $cfg['expand_limit']));
        }
        $saved += $r->store($expanded);

        // 3) SERP-uri → competitori.
        $serps = [];
        $domainScore = [];
        foreach ($cfg['serp_keywords'] as $kw) {
            try {
                $serps[$kw] = $r->serp($kw);
                foreach ($serps[$kw]['organic'] as $o) {
                    $d = preg_replace('/^www\./', '', $o['domain']);
                    $domainScore[$d] = ($domainScore[$d] ?? 0) + (11 - min(10, max(1, $o['position'])));
                }
            } catch (Throwable $e) {
                $notes[] = "SERP eșuat pentru „{$kw}”: ".$e->getMessage();
            }
        }
        arsort($domainScore);

        // Excludem platformele generaliste — nu sunt competitori comparabili.
        $generic = $this->genericDomains();
        $competitors = array_slice(array_filter(
            array_keys($domainScore),
            fn ($d) => ! in_array($d, $generic, true) && ! str_contains($d, 'inlocuireparbriz')
        ), 0, $cfg['competitors_to_analyze']);

        // 4) Cuvintele competitorilor → gap-uri.
        $competitorData = [];
        foreach ($competitors as $domain) {
            try {
                $ranked = $r->rankedKeywords($domain, $cfg['competitor_keywords_limit']);
                $competitorData[$domain] = [
                    'serp_score' => $domainScore[$domain],
                    'ranked_count' => count($ranked),
                    'top' => array_slice(array_map(fn ($k) => Arr::only($k, ['keyword', 'search_volume', 'position', 'url']), $ranked), 0, 60),
                ];
                // Doar cuvintele relevante pentru nișă intră în baza de date.
                $saved += $r->store(array_filter($ranked, fn ($k) => $this->isRelevant($k['keyword'])));
            } catch (Throwable $e) {
                $notes[] = "Competitor {$domain}: ".$e->getMessage();
            }
        }

        // 5) Dificultate + intenție pentru cele mai căutate cuvinte relevante.
        $top = SeoKeyword::query()->whereNotNull('search_volume')->orderByDesc('search_volume')->limit(700)->pluck('keyword')->all();
        $kd = $r->difficulty($top);
        $intents = $r->intents($top);
        foreach ($top as $kw) {
            $upd = array_filter(['keyword_difficulty' => $kd[$kw] ?? null, 'intent' => $intents[$kw] ?? null], fn ($v) => $v !== null);
            if ($upd) {
                SeoKeyword::query()->where('keyword', $kw)->update($upd);
            }
        }

        return [
            'keywords_saved' => $saved,
            'top_keywords' => $this->topKeywords(40),
            'competitors' => array_map(fn ($d) => ['domain' => $d, 'score' => $domainScore[$d]], $competitors),
            'serp' => $serps,
            'competitor_detail' => $competitorData,
            'domain_scores' => array_slice($domainScore, 0, 40, true),
            'city_demand' => $this->cityDemand(),
            'all_keywords' => $this->allKeywords(),
            'notes' => $notes,
        ];
    }

    /** Competitori din baza Labs (pe cuvintele noastre cele mai valoroase) + cuvintele lor → gap-uri. */
    protected function competitorsPlan(KeywordResearch $r): array
    {
        $cfg = config('seo-research');
        $seedKeywords = SeoKeyword::query()->where('search_volume', '>', 0)
            ->orderByDesc('search_volume')->limit(150)->pluck('keyword')->all();
        $seedKeywords = array_values(array_unique(array_merge($cfg['serp_keywords'], $seedKeywords)));

        $all = $r->serpCompetitors($seedKeywords, 60);
        $generic = $this->genericDomains();
        $competitors = array_values(array_filter($all, fn ($c) => $c['domain'] !== '' && ! in_array($c['domain'], $generic, true)
            && ! str_contains($c['domain'], 'inlocuireparbriz') && ! preg_match('/(google|youtube|facebook|wikipedia|olx|emag|reddit)\./', $c['domain'])));

        $detail = [];
        $saved = 0;
        foreach (array_slice($competitors, 0, $cfg['competitors_to_analyze']) as $c) {
            $ranked = $r->rankedKeywords($c['domain'], $cfg['competitor_keywords_limit']);
            $relevant = array_values(array_filter($ranked, fn ($k) => $this->isRelevant($k['keyword'])));
            $saved += $r->store($relevant);
            $detail[$c['domain']] = $c + [
                'ranked_count' => count($ranked),
                'relevant_count' => count($relevant),
                'top' => array_slice(array_map(fn ($k) => Arr::only($k, ['keyword', 'search_volume', 'position', 'url']), $relevant), 0, 80),
            ];
        }

        return [
            'keywords_saved' => $saved,
            'competitors' => array_slice($competitors, 0, 25),
            'competitor_detail' => $detail,
            'top_keywords' => $this->topKeywords(60),
            'all_keywords' => $this->allKeywords(),
        ];
    }

    /** @return array<int,string> */
    protected function genericDomains(): array
    {
        return ['olx.ro', 'emag.ro', 'facebook.com', 'youtube.com', 'wikipedia.org', 'ro.wikipedia.org', 'autovit.ro', 'google.com', 'tiktok.com', 'instagram.com', 'reddit.com', 'publi24.ro', 'lajumate.ro', 'cylex.ro', 'paginiaurii.ro', 'infocif.ro', 'listafirme.ro', 'termene.ro', 'romdata.ro', 'firme.info', 'risco.ro', 'totalfirme.ro', 'anuntul.ro', 'autoblog.md', '999.md'];
    }

    protected function simpleVolume(KeywordResearch $r, SeoResearchRun $run): array
    {
        $rows = $r->searchVolume((array) ($run->params['keywords'] ?? []));

        return ['keywords_saved' => $r->store($rows), 'top_keywords' => array_slice($rows, 0, 50)];
    }

    protected function simpleExpand(KeywordResearch $r, SeoResearchRun $run, string $mode): array
    {
        $seed = (string) $run->params['keyword'];
        $rows = $mode === 'related' ? $r->related($seed) : $r->suggestions($seed);

        return ['keywords_saved' => $r->store($rows), 'top_keywords' => array_slice($rows, 0, 50)];
    }

    protected function competitor(KeywordResearch $r, SeoResearchRun $run): array
    {
        $domain = (string) $run->params['domain'];
        $rows = $r->rankedKeywords($domain, (int) ($run->params['limit'] ?? 400));
        $relevant = array_values(array_filter($rows, fn ($k) => $this->isRelevant($k['keyword'])));

        return [
            'keywords_saved' => $r->store($relevant),
            'top_keywords' => array_slice($relevant, 0, 50),
            'competitors' => [['domain' => $domain, 'score' => count($rows)]],
        ];
    }

    /** Filtru de nișă: parbriz, lunetă, geam/sticlă auto, ADAS etc. */
    public function isRelevant(string $keyword): bool
    {
        return (bool) preg_match('/parbriz|lunet|geam|sticl|adas|windshield|calibr|ciobitur|fisur/iu', $keyword);
    }

    protected function topKeywords(int $n): array
    {
        return SeoKeyword::query()->orderByDesc('search_volume')->limit($n)
            ->get(['keyword', 'search_volume', 'cpc', 'keyword_difficulty', 'intent'])->toArray();
    }

    protected function allKeywords(): array
    {
        return SeoKeyword::query()->orderByDesc('search_volume')
            ->get(['keyword', 'search_volume', 'cpc', 'competition_level', 'keyword_difficulty', 'intent', 'city_slug', 'source'])
            ->toArray();
    }

    /** Cerere locală însumată pe oraș (din tiparele oraș × cuvânt). */
    protected function cityDemand(): array
    {
        return SeoKeyword::query()->whereNotNull('city_slug')
            ->selectRaw('city_slug, SUM(COALESCE(search_volume,0)) as volume, COUNT(*) as keywords')
            ->groupBy('city_slug')->orderByDesc('volume')->get()->toArray();
    }

    protected function export(SeoResearchRun $run, array $summary): void
    {
        $dir = storage_path('app/seo-research');
        File::ensureDirectoryExists($dir);
        File::put("{$dir}/run-{$run->id}.json", json_encode([
            'run' => ['id' => $run->id, 'type' => $run->type, 'params' => $run->params, 'at' => now()->toIso8601String()],
            'data' => $summary,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        File::put("{$dir}/latest.json", File::get("{$dir}/run-{$run->id}.json"));
    }
}
