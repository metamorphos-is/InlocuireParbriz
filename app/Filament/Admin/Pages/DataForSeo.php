<?php

namespace App\Filament\Admin\Pages;

use App\Models\SeoResearchRun;
use App\Services\DataForSeo\DataForSeoClient;
use App\Services\DataForSeo\KeywordResearch;
use App\Services\DataForSeo\ResearchRunner;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Throwable;

/**
 * Integrarea DataForSEO: stare cont, buget, pornire cercetări, istoric rulări.
 * Apelurile API se fac DOAR pe server; credențialele nu ajung în browser.
 */
class DataForSeo extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlassCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Cercetare DataForSEO';

    protected static ?string $title = 'Cercetare DataForSEO';

    protected static ?string $slug = 'dataforseo';

    protected string $view = 'filament.admin.pages.dataforseo';

    public function getViewData(): array
    {
        return [
            'configured' => DataForSeoClient::isConfigured(),
            'spent' => DataForSeoClient::spentThisMonth(),
            'budget' => DataForSeoClient::monthlyBudget(),
            'account' => Cache::get('dataforseo:account'),
            'schedulerAlive' => Cache::get('scheduler:heartbeat'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newRun')
                ->label('Pornește o cercetare')
                ->icon(Heroicon::OutlinedPlay)
                ->disabled(fn () => ! DataForSeoClient::isConfigured())
                ->schema([
                    Select::make('type')->label('Tip')->options(SeoResearchRun::TYPES)->required()->live()->default('national_plan'),
                    TextInput::make('keyword')->label('Cuvânt-cheie')
                        ->visible(fn (Get $get) => in_array($get('type'), ['suggestions', 'related', 'serp'], true))
                        ->required(fn (Get $get) => in_array($get('type'), ['suggestions', 'related', 'serp'], true)),
                    TextInput::make('domain')->label('Domeniu (ex: exemplu.ro)')
                        ->visible(fn (Get $get) => $get('type') === 'competitor')
                        ->required(fn (Get $get) => $get('type') === 'competitor'),
                    Textarea::make('keywords')->label('Cuvinte (unul pe rând, max 1000)')->rows(8)
                        ->visible(fn (Get $get) => $get('type') === 'search_volume')
                        ->required(fn (Get $get) => $get('type') === 'search_volume'),
                ])
                ->action(function (array $data) {
                    $params = match ($data['type']) {
                        'search_volume' => ['keywords' => array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $data['keywords']))))],
                        'competitor' => ['domain' => strtolower(preg_replace('#^https?://(www\.)?#', '', trim((string) $data['domain'], '/ ')))],
                        'national_plan' => [],
                        default => ['keyword' => trim((string) $data['keyword'])],
                    };
                    SeoResearchRun::query()->create([
                        'type' => $data['type'],
                        'params' => $params,
                        'requested_by' => auth()->id(),
                    ]);
                    Notification::make()->title('Cercetare pusă în coadă')
                        ->body('Rulează automat în cel mult un minut (sau apasă „Rulează acum” în tabel).')
                        ->success()->send();
                }),
            Action::make('refreshAccount')
                ->label('Verifică soldul')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('gray')
                ->disabled(fn () => ! DataForSeoClient::isConfigured())
                ->action(function () {
                    try {
                        Cache::put('dataforseo:account', app(KeywordResearch::class)->account() + ['at' => now()->toDateTimeString()], now()->addDay());
                        Notification::make()->title('Sold actualizat')->success()->send();
                    } catch (Throwable $e) {
                        Notification::make()->title('Eroare DataForSEO')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(SeoResearchRun::query()->latest('id'))
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('type')->label('Tip')->formatStateUsing(fn ($state) => SeoResearchRun::TYPES[$state] ?? $state)->wrap(),
                TextColumn::make('params')->label('Parametri')
                    ->formatStateUsing(fn ($state) => collect((array) $state)->map(fn ($v, $k) => is_array($v) ? $k.': '.count($v).' cuvinte' : "{$k}: {$v}")->implode(', ') ?: '—')
                    ->wrap(),
                TextColumn::make('status')->label('Stare')->badge()->color(fn ($state) => match ($state) {
                    'done' => 'success', 'failed' => 'danger', 'running' => 'warning', default => 'gray',
                }),
                TextColumn::make('summary.keywords_saved')->label('Cuvinte salvate')->numeric(),
                TextColumn::make('cost')->label('Cost (USD)')->numeric(4),
                TextColumn::make('error')->label('Eroare')->limit(80)->toggleable(),
                TextColumn::make('created_at')->label('Creat')->dateTime('d.m.Y H:i'),
                TextColumn::make('finished_at')->label('Terminat')->dateTime('d.m.Y H:i'),
            ])
            ->recordActions([
                Action::make('runNow')
                    ->label('Rulează acum')
                    ->icon(Heroicon::OutlinedBolt)
                    ->visible(fn (SeoResearchRun $record) => in_array($record->status, ['pending', 'failed'], true))
                    ->requiresConfirmation()
                    ->modalDescription('Rularea poate dura câteva minute și consumă credit DataForSEO (rezultatele din ultimele 30 de zile sunt refolosite din cache).')
                    ->action(function (SeoResearchRun $record) {
                        @set_time_limit(470);
                        $run = app(ResearchRunner::class)->run($record);
                        $run->status === 'done'
                            ? Notification::make()->title('Cercetare terminată')->body("Cost: {$run->cost} USD")->success()->send()
                            : Notification::make()->title('Cercetare eșuată')->body((string) $run->error)->danger()->send();
                    }),
                Action::make('download')
                    ->label('JSON')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->visible(fn (SeoResearchRun $record) => File::exists(storage_path("app/seo-research/run-{$record->id}.json")))
                    ->action(fn (SeoResearchRun $record) => response()->download(storage_path("app/seo-research/run-{$record->id}.json"))),
            ])
            ->poll('10s');
    }
}
