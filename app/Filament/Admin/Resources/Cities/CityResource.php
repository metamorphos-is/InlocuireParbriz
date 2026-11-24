<?php

namespace App\Filament\Admin\Resources\Cities;

use App\Filament\Admin\Resources\Cities\Pages\ManageCities;
use App\Models\City;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
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
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Denumire')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                TextInput::make('slug')->label('Slug (URL)')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('county')->label('Județ')->maxLength(255),
                Toggle::make('is_active')->label('Activ')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Denumire')->searchable()->sortable(),
                TextColumn::make('county')->label('Județ')->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(),
                TextColumn::make('sectors_count')->label('Sectoare')->counts('sectors'),
                IconColumn::make('is_active')->label('Activ')->boolean(),
            ])
            ->filters([
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
            'index' => ManageCities::route('/'),
        ];
    }
}
