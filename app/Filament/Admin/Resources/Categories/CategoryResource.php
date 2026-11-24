<?php

namespace App\Filament\Admin\Resources\Categories;

use App\Filament\Admin\Resources\Categories\Pages\ManageCategories;
use App\Models\Category;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = 'Catalog & Zone';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'categorie';

    protected static ?string $pluralModelLabel = 'categorii';

    protected static ?string $navigationLabel = 'Categorii';

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
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('parent_id')
                    ->label('Categorie părinte')
                    ->relationship('parent', 'name', fn ($query) => $query->whereNull('parent_id'))
                    ->searchable()
                    ->preload()
                    ->placeholder('— categorie principală —'),
                TextInput::make('icon')->label('Pictogramă')->maxLength(255),
                TextInput::make('sort_order')->label('Ordine')->numeric()->default(0),
                Toggle::make('is_active')->label('Activă')->default(true),
                Textarea::make('description')->label('Descriere')->columnSpanFull()->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Denumire')->searchable()->sortable(),
                TextColumn::make('parent.name')->label('Părinte')->placeholder('—')->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(),
                TextColumn::make('sort_order')->label('Ordine')->sortable(),
                IconColumn::make('is_active')->label('Activă')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_active')->label('Activă'),
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
            'index' => ManageCategories::route('/'),
        ];
    }
}
