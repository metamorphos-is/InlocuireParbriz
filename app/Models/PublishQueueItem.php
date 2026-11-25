<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/** Un element din coada de publicare zilnică (articol, pagină de model auto sau oraș). */
class PublishQueueItem extends Model
{
    protected $table = 'publish_queue';

    protected $fillable = ['publishable_type', 'publishable_id', 'position', 'not_before', 'published_at', 'note'];

    protected function casts(): array
    {
        return ['not_before' => 'date', 'published_at' => 'datetime', 'position' => 'integer'];
    }

    public function publishable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->whereNull('published_at');
    }

    public function typeLabel(): string
    {
        return match ($this->publishable_type) {
            Post::class => 'Articol',
            VehiclePage::class => 'Model auto',
            City::class => 'Oraș',
            default => class_basename($this->publishable_type),
        };
    }

    public function title(): string
    {
        $p = $this->publishable;

        return match (true) {
            $p instanceof Post => $p->title,
            $p instanceof VehiclePage => $p->label(),
            $p instanceof City => 'Parbrize '.$p->name,
            default => '(șters)',
        };
    }

    public function url(): ?string
    {
        $p = $this->publishable;

        return $p && method_exists($p, 'url') ? $p->url() : null;
    }
}
