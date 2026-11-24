<?php

namespace App\Filament\Admin\Resources\SeoKeywords;

use App\Filament\Admin\Resources\SeoKeywords\Pages\ManageSeoKeywords;
use App\Models\SeoKeyword;
use BackedEnum;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Baza de date de cuvinte-cheie (din DataForSEO) + harta cuvânt → URL.
 */
class SeoKeywordResource extends Resource
{
    protected static ?string $model = SeoKeyword::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 21;

    protected static ?string $modelLabel = 'cuvânt-cheie';

    protected static ?string $pluralModelLabel = 'cuvinte-cheie';

    protected static ?string $navigationLabel = 'Cuvinte-cheie';

    public const ROLES = ['primary' => 'Principal', 'secondary' => 'Secundar'];

    public const PRIORITIES = ['high' => 'Mare', 'medium' => 'Medie', 'low' => 'Mică'];

    public const CONTENT_TYPES = ['service' => 'Serviciu', 'city' => 'Oraș', 'sector' => 'Sector', 'article' => 'Articol', 'static' => 'Static', 'home' => 'Homepage', 'skip' => 'Nu țintim'];

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(2)->components([
            TextInput::make('keyword')->label('Cuvânt')->disabled()->columnSpanFull(),
            TextInput::make('cluster')->label('Cluster')->maxLength(64),
            TextInput::make('assigned_path')->label('Pagina țintă (URL, ex. /inlocuire-parbriz)')->maxLength(191),
            Select::make('role')->label('Rol')->options(self::ROLES),
            Select::make('priority')->label('Prioritate')->options(self::PRIORITIES),
            Select::make('intent')->label('Intenție')->options(SeoKeyword::INTENTS),
            Select::make('content_type')->label('Tip conținut')->options(self::CONTENT_TYPES),
            Textarea::make('notes')->label('Note')->rows(3)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('search_volume', 'desc')
            ->columns([
                TextColumn::make('keyword')->label('Cuvânt')->searchable()->sortable()->wrap(),
                TextColumn::make('search_volume')->label('Volum/lună')->numeric()->sortable(),
                TextColumn::make('cpc')->label('CPC')->money('USD')->sortable()->toggleable(),
                TextColumn::make('keyword_difficulty')->label('KD')->sortable()->toggleable(),
                TextColumn::make('intent')->label('Intenție')->formatStateUsing(fn ($s) => SeoKeyword::INTENTS[$s] ?? $s)->badge()->toggleable(),
                TextColumn::make('cluster')->label('Cluster')->searchable()->sortable()->toggleable(),
                TextColumn::make('city_slug')->label('Oraș')->sortable()->toggleable(),
                TextColumn::make('assigned_path')->label('Pagina țintă')->searchable()->toggleable(),
                TextColumn::make('role')->label('Rol')->formatStateUsing(fn ($s) => self::ROLES[$s] ?? $s)->toggleable(),
                TextColumn::make('priority')->label('Prioritate')->formatStateUsing(fn ($s) => self::PRIORITIES[$s] ?? $s)->toggleable(),
                TextColumn::make('source')->label('Sursă')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('fetched_at')->label('Actualizat')->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('intent')->label('Intenție')->options(SeoKeyword::INTENTS),
                SelectFilter::make('cluster')->label('Cluster')->options(fn () => SeoKeyword::query()->whereNotNull('cluster')->distinct()->orderBy('cluster')->pluck('cluster', 'cluster')->all()),
                SelectFilter::make('city_slug')->label('Oraș')->options(fn () => SeoKeyword::query()->whereNotNull('city_slug')->distinct()->orderBy('city_slug')->pluck('city_slug', 'city_slug')->all()),
                Filter::make('unassigned')->label('Fără pagină țintă')->query(fn (Builder $q) => $q->whereNull('assigned_path')),
                Filter::make('with_volume')->label('Doar cu volum > 0')->query(fn (Builder $q) => $q->where('search_volume', '>', 0)),
            ])
            ->recordActions([
                EditAction::make()->label('Editează'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('assign')
                        ->label('Alocă unei pagini / cluster')
                        ->schema([
                            TextInput::make('assigned_path')->label('Pagina țintă (URL)'),
                            TextInput::make('cluster')->label('Cluster'),
                            Select::make('role')->label('Rol')->options(self::ROLES),
                        ])
                        ->action(fn (Collection $records, array $data) => $records->each->update(array_filter($data, fn ($v) => filled($v)))),
                    DeleteBulkAction::make()->label('Șterge selecția'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageSeoKeywords::route('/')];
    }
}
