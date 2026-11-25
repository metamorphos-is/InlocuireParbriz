<?php

namespace App\Services;

use App\Models\City;
use App\Models\Post;
use App\Models\PublishQueueItem;
use App\Models\VehiclePage;
use App\Support\Navigation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Publicarea zilnică: scoate din coadă următorul element (ordinea = `position`) și îl publică.
 * Idempotent: cel mult `perDay` elemente pe zi (ora României), oricât de des ar rula scheduler-ul.
 * Sitemap-ul le preia automat (lastmod = momentul publicării).
 */
class ContentPublisher
{
    public const TZ = 'Europe/Bucharest';

    public function publishedToday(): int
    {
        $start = Carbon::now(self::TZ)->startOfDay()->utc();

        return PublishQueueItem::query()->whereNotNull('published_at')->where('published_at', '>=', $start)
            ->where(fn ($q) => $q->whereNull('note')->orWhere('note', '!=', 'manual'))->count();
    }

    public function next(): ?PublishQueueItem
    {
        $today = Carbon::now(self::TZ)->toDateString();

        return PublishQueueItem::query()->pending()
            ->where(fn ($q) => $q->whereNull('not_before')->orWhereDate('not_before', '<=', $today))
            ->orderBy('position')->orderBy('id')
            ->first();
    }

    /** Rulat de scheduler. Întoarce elementul publicat sau null (nimic de făcut azi). */
    public function publishDue(int $perDay = 1): ?PublishQueueItem
    {
        if ($this->publishedToday() >= $perDay) {
            return null;
        }

        // Un element fără conținut (șters între timp) e marcat și sărim la următorul.
        for ($i = 0; $i < 5; $i++) {
            $item = $this->next();
            if (! $item) {
                return null;
            }
            if ($this->publish($item)) {
                return $item;
            }
        }

        return null;
    }

    public function publish(PublishQueueItem $item, bool $manual = false): bool
    {
        $model = $item->publishable;
        $now = now();

        if (! $model) {
            $item->update(['published_at' => $now, 'note' => 'manual']);

            return false;
        }

        match (true) {
            $model instanceof Post, $model instanceof VehiclePage => $model->forceFill(['is_published' => true, 'published_at' => $now])->save(),
            $model instanceof City => $model->forceFill(['is_published' => true, 'is_active' => true])->save(),
            default => null,
        };

        // Pagina de marcă devine vizibilă odată cu primul ei model.
        if ($model instanceof VehiclePage && ! $model->isBrand()) {
            VehiclePage::query()->brands()->where('brand_slug', $model->brand_slug)->where('is_published', false)
                ->update(['is_published' => true, 'published_at' => $now, 'updated_at' => $now]);
        }

        $item->update(['published_at' => $now, 'note' => $manual ? 'manual' : $item->note]);
        Navigation::forget();
        Cache::forget('home:vehicles:v1');
        Log::info('Publicare automată: '.$item->typeLabel().' — '.$item->title());

        return true;
    }
}
