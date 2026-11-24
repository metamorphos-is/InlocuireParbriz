<?php

namespace App\Filament\Admin\Resources\Cities;

use App\Filament\Admin\Resources\Cities\Pages\ManageCities;
use App\Models\City;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = 'Catalog & Zone';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'oraș';

    protected static ?string $pluralModelLabel = 'orașe';

    protected static ?string $navigationLabel = 'Orașe';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('oras')->columnSpanFull()->tabs([
                Tab::make('General')->columns(2)->schema([
                    TextInput::make('name')
                        ->label('Denumire')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                    TextInput::make('slug')->label('Slug (URL: /inlocuire-parbriz-{slug})')->required()->maxLength(255)->unique(ignoreRecord: true),
                    TextInput::make('county')->label('Județ')->maxLength(255),
                    Select::make('region')->label('Regiune (grupare în meniu)')->options(City::REGIONS),
                    Select::make('coverage')->label('Acoperire')->options(City::COVERAGE)->default('on_request')
                        ->helperText('„Confirmată” doar dacă ai ateliere partenere active aici — pagina promite atunci montaj.'),
                    TextInput::make('sort_order')->label('Ordine')->numeric()->default(100),
                    Toggle::make('is_active')->label('Activ (acceptă cereri)')->default(true),
                    Toggle::make('is_published')->label('Pagină publicată pe site')->default(false),
                ]),
                Tab::make('SEO')->columns(2)->schema([
                    TextInput::make('primary_keyword')->label('Cuvânt-cheie principal')->maxLength(120),
                    TextInput::make('search_volume')->label('Volum lunar (DataForSEO)')->numeric(),
                    TagsInput::make('secondary_keywords')->label('Cuvinte secundare')->columnSpanFull(),
                    TextInput::make('seo_title')->label('Titlu SEO')->maxLength(190)->helperText('Recomandat: 50–60 de caractere.')->columnSpanFull(),
                    Textarea::make('meta_description')->label('Meta descriere')->rows(2)->maxLength(320)->helperText('Recomandat: 140–160 de caractere.')->columnSpanFull(),
                    TextInput::make('h1')->label('Titlu H1')->maxLength(190)->columnSpanFull(),
                ]),
                Tab::make('Conținut')->schema([
                    Textarea::make('intro')->label('Introducere (sub H1)')->rows(4),
                    TagsInput::make('areas')->label('Cartiere / localități din jur'),
                    Repeater::make('sections')->label('Secțiuni de conținut local')
                        ->schema([
                            TextInput::make('heading')->label('Titlu (H2)')->required(),
                            Textarea::make('body')->label('Text')->rows(4)->required(),
                        ])->collapsible()->itemLabel(fn (array $state) => $state['heading'] ?? null),
                    Repeater::make('faq')->label('Întrebări frecvente locale')
                        ->schema([
                            TextInput::make('q')->label('Întrebare')->required(),
                            Textarea::make('a')->label('Răspuns')->rows(3)->required(),
                        ])->collapsible()->itemLabel(fn (array $state) => $state['q'] ?? null),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Denumire')->searchable()->sortable(),
                TextColumn::make('county')->label('Județ')->sortable(),
                TextColumn::make('region')->label('Regiune')->formatStateUsing(fn ($s) => City::REGIONS[$s] ?? $s)->toggleable(),
                TextColumn::make('search_volume')->label('Volum')->numeric()->sortable(),
                TextColumn::make('coverage')->label('Acoperire')->badge()->formatStateUsing(fn ($s) => $s === 'active' ? 'Confirmată' : 'La cerere')->color(fn ($s) => $s === 'active' ? 'success' : 'warning'),
                IconColumn::make('is_published')->label('Publicat')->boolean(),
                TextColumn::make('slug')->label('Slug')->toggleable(),
                TextColumn::make('sectors_count')->label('Sectoare')->counts('sectors'),
                IconColumn::make('is_active')->label('Activ')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Activ'),
                TernaryFilter::make('is_published')->label('Publicat'),
            ])
            ->recordActions([
                EditAction::make()->label('Editează'),
                DeleteAction::make()->label('Șterge'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Șterge selecția'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCities::route('/'),
        ];
    }
}
