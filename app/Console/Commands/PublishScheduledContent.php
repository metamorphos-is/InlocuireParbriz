<?php

namespace App\Console\Commands;

use App\Models\PublishQueueItem;
use App\Services\ContentPublisher;
use Illuminate\Console\Command;

class PublishScheduledContent extends Command
{
    protected $signature = 'content:publish-next {--per-day=1 : Câte elemente se publică pe zi} {--list : Doar afișează coada}';

    protected $description = 'Publică următoarea pagină/articol din coada de publicare (cel mult --per-day pe zi).';

    public function handle(ContentPublisher $publisher): int
    {
        if ($this->option('list')) {
            $rows = PublishQueueItem::query()->pending()->orderBy('position')->orderBy('id')->get()
                ->map(fn ($i) => [$i->position, $i->typeLabel(), $i->title(), optional($i->not_before)->toDateString()]);
            $this->table(['Poz.', 'Tip', 'Titlu', 'Nu înainte de'], $rows);

            return self::SUCCESS;
        }

        $item = $publisher->publishDue(max(1, (int) $this->option('per-day')));
        $this->info($item ? 'Publicat: '.$item->typeLabel().' — '.$item->title() : 'Nimic de publicat acum.');

        return self::SUCCESS;
    }
}
