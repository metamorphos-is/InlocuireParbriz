<?php

namespace App\Filament\Admin\Resources\PublishQueue;

use App\Filament\Admin\Resources\PublishQueue\Pages\ManagePublishQueue;
use App\Models\PublishQueueItem;
use App\Services\ContentPublisher;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/** Coada de publicare zilnică: ce pagini/articole urmează și în ce ordine. Publicarea automată: routes/console.php. */
class PublishQueueResource extends Resource
{
    protected static ?string $model = PublishQueueItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'element din coadă';

    protected static ?string $pluralModelLabel = 'coada de publicare';

    protected static ?string $navigationLabel = 'Coadă de publicare';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('position')->label('Poziție (mai mic = mai devreme)')->numeric()->required(),
            DatePicker::make('not_before')->label('Nu mai devreme de')->helperText('Opțional: pentru articole de sezon.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $q) => $q->with('publishable'))
            ->defaultSort('position')
            ->description('Scheduler-ul publică automat câte un element pe zi (între 9:00 și 20:00), în ordinea poziției. Sitemap-ul le preia imediat.')
            ->columns([
                TextColumn::make('position')->label('Poz.')->sortable(),
                TextColumn::make('type')->label('Tip')->state(fn (PublishQueueItem $r) => $r->typeLabel())->badge(),
                TextColumn::make('title')->label('Pagina')->state(fn (PublishQueueItem $r) => $r->title())->wrap(),
                TextColumn::make('estimated')->label('Estimat')->state(function (PublishQueueItem $r) {
                    if ($r->published_at) {
                        return null;
                    }
                    $ahead = PublishQueueItem::query()->pending()->where(fn ($q) => $q->where('position', '<', $r->position)->orWhere(fn ($q) => $q->where('position', $r->position)->where('id', '<', $r->id)))->count();
                    $start = app(ContentPublisher::class)->publishedToday() > 0 ? 1 : 0;

                    return now(ContentPublisher::TZ)->addDays($ahead + $start)->format('d.m.Y');
                }),
                TextColumn::make('published_at')->label('Publicat la')->dateTime('d.m.Y H:i')->placeholder('în așteptare'),
            ])
            ->filters([
                TernaryFilter::make('published')->label('Publicat')
                    ->queries(true: fn ($q) => $q->whereNotNull('published_at'), false: fn ($q) => $q->whereNull('published_at'))
                    ->default(false),
            ])
            ->recordActions([
                Action::make('publishNow')->label('Publică acum')->icon(Heroicon::OutlinedRocketLaunch)
                    ->visible(fn (PublishQueueItem $r) => ! $r->published_at)
                    ->requiresConfirmation()
                    ->action(function (PublishQueueItem $r) {
                        app(ContentPublisher::class)->publish($r, manual: true);
                        Notification::make()->title('Publicat: '.$r->title())->success()->send();
                    }),
                Action::make('view')->label('Vezi')->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (PublishQueueItem $r) => $r->url(), shouldOpenInNewTab: true)
                    ->visible(fn (PublishQueueItem $r) => (bool) $r->published_at),
                EditAction::make()->label('Mută'),
                DeleteAction::make()->label('Scoate din coadă'),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManagePublishQueue::route('/')];
    }
}
