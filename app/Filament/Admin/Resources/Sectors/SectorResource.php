<?php

namespace App\Filament\Admin\Resources\Sectors;

use App\Filament\Admin\Resources\Sectors\Pages\ManageSectors;
use App\Models\CitySector;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SectorResource extends Resource
{
    protected static ?string $model = CitySector::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string|\UnitEnum|null $navigationGroup = 'Catalog & Zone';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'sector';

    protected static ?string $pluralModelLabel = 'sectoare';

    protected static ?string $navigationLabel = 'Sectoare';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('city_id')
                    ->label('Oraș')
                    ->relationship('city', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('name')
                    ->label('Denumire')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                TextInput::make('slug')->label('Slug (URL)')->required()->maxLength(255),
                Toggle::make('is_active')->label('Activ')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('city.name')->label('Oraș')->sortable(),
                TextColumn::make('name')->label('Sector')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(),
                IconColumn::make('is_active')->label('Activ')->boolean(),
            ])
            ->filters([
                SelectFilter::make('city_id')->label('Oraș')->relationship('city', 'name'),
                TernaryFilter::make('is_active')->label('Activ'),
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
            'index' => ManageSectors::route('/'),
        ];
    }
}
