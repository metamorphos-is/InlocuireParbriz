<?php

namespace App\Filament\Admin\Resources\VehiclePages;

use App\Filament\Admin\Resources\VehiclePages\Pages\ManageVehiclePages;
use App\Models\VehiclePage;
use App\Support\SeoOverlap;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class VehiclePageResource extends Resource
{
    protected static ?string $model = VehiclePage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'pagină auto';

    protected static ?string $pluralModelLabel = 'mărci și modele auto';

    protected static ?string $navigationLabel = 'Mărci și modele auto';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('auto')->columnSpanFull()->tabs([
                Tab::make('Mașina')->columns(2)->schema([
                    Select::make('kind')->label('Tip')->options(['brand' => 'Marcă', 'model' => 'Model'])->default('model')->required()->live(),
                    TextInput::make('brand_slug')->label('Slug marcă (URL)')->required()->regex('/^[a-z0-9-]+$/')->maxLength(60),
                    TextInput::make('brand_name')->label('Marcă')->required()->maxLength(80),
                    TextInput::make('model_slug')->label('Slug model (URL)')->regex('/^[a-z0-9-]+$/')->maxLength(80)
                        ->required(fn (Get $get) => $get('kind') === 'model')->visible(fn (Get $get) => $get('kind') === 'model'),
                    TextInput::make('model_name')->label('Model')->maxLength(120)
                        ->required(fn (Get $get) => $get('kind') === 'model')->visible(fn (Get $get) => $get('kind') === 'model'),
                    TextInput::make('years')->label('Ani de fabricație')->maxLength(60),
                    TextInput::make('bodies')->label('Caroserii')->maxLength(190),
                    Select::make('adas')->label('Cameră pe parbriz')->options(VehiclePage::ADAS)->default('none'),
                    TextInput::make('sort_order')->label('Ordine')->numeric()->default(100),
                ]),
                Tab::make('Conținut')->schema([
                    TextInput::make('h1')->label('Titlu H1')->maxLength(190),
                    Textarea::make('intro')->label('Introducere')->rows(3),
                    TagsInput::make('variants')->label('Variante de parbriz')->helperText('Câte o variantă pe etichetă.'),
                    Repeater::make('sections')->label('Secțiuni')->schema([
                        TextInput::make('heading')->label('Titlu H2')->required(),
                        Textarea::make('body')->label('Text')->rows(4)->required(),
                    ])->collapsible()->itemLabel(fn (array $state) => $state['heading'] ?? null),
                    Repeater::make('faq')->label('Întrebări frecvente')->schema([
                        TextInput::make('q')->label('Întrebare')->required(),
                        Textarea::make('a')->label('Răspuns')->rows(3)->required(),
                    ])->collapsible()->itemLabel(fn (array $state) => $state['q'] ?? null),
                ]),
                Tab::make('SEO')->columns(2)->schema([
                    TextInput::make('primary_keyword')->label('Cuvânt-cheie principal')->maxLength(120)->live(onBlur: true)
                        ->helperText(fn (Get $get, ?VehiclePage $record) => SeoOverlap::warning((string) $get('primary_keyword'), 'vehicle', $record?->id) ?? 'Un singur cuvânt-cheie principal pe pagină.'),
                    TextInput::make('search_volume')->label('Volum lunar (DataForSEO)')->numeric(),
                    TagsInput::make('secondary_keywords')->label('Cuvinte secundare')->columnSpanFull(),
                    TextInput::make('seo_title')->label('Titlu SEO')->maxLength(190)->columnSpanFull(),
                    Textarea::make('meta_description')->label('Meta descriere')->rows(2)->maxLength(320)->columnSpanFull(),
                ]),
                Tab::make('Publicare')->columns(2)->schema([
                    Select::make('image')->label('Imagine principală')->options(fn () => \App\Support\Img::options())->searchable()->placeholder('Automat'),
                    Toggle::make('is_published')->label('Publicat')->helperText('Paginile din coada de publicare se publică automat, câte una pe zi.'),
                    DateTimePicker::make('published_at')->label('Data publicării'),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('brand_slug')
            ->columns([
                TextColumn::make('brand_name')->label('Marcă')->searchable()->sortable(),
                TextColumn::make('model_name')->label('Model')->searchable()->placeholder('— pagina mărcii —'),
                TextColumn::make('primary_keyword')->label('Cuvânt-cheie')->searchable()->toggleable(),
                TextColumn::make('search_volume')->label('Volum')->numeric()->sortable(),
                IconColumn::make('is_published')->label('Publicat')->boolean(),
                TextColumn::make('published_at')->label('Data')->date('d.m.Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('kind')->label('Tip')->options(['brand' => 'Mărci', 'model' => 'Modele']),
                TernaryFilter::make('is_published')->label('Publicat'),
            ])
            ->recordActions([
                Action::make('view')->label('Vezi')->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (VehiclePage $record) => $record->url(), shouldOpenInNewTab: true)
                    ->visible(fn (VehiclePage $record) => $record->is_published),
                EditAction::make()->label('Editează'),
                DeleteAction::make()->label('Șterge'),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageVehiclePages::route('/')];
    }
}
