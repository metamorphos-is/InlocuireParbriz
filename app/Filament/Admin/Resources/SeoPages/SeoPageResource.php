<?php

namespace App\Filament\Admin\Resources\SeoPages;

use App\Filament\Admin\Resources\SeoPages\Pages\ManageSeoPages;
use App\Models\SeoPage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SeoPageResource extends Resource
{
    protected static ?string $model = SeoPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'pagină SEO';

    protected static ?string $pluralModelLabel = 'pagini SEO';

    protected static ?string $navigationLabel = 'Pagini SEO';

    protected static ?string $recordTitleAttribute = 'path';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('path')
                    ->label('Cale (ex: /inlocuire-parbriz-bucuresti)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                TextInput::make('title')->label('Title tag')->required()->maxLength(255)->columnSpanFull(),
                Textarea::make('meta_description')->label('Meta description')->maxLength(320)->rows(2)->columnSpanFull(),
                TextInput::make('h1')->label('H1')->maxLength(255)->columnSpanFull(),
                Select::make('robots')
                    ->label('Robots')
                    ->options([
                        'noindex' => 'noindex',
                        'index' => 'index',
                        'noindex,nofollow' => 'noindex,nofollow',
                        'index,follow' => 'index,follow',
                    ])
                    ->default('noindex')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options(['draft' => 'Ciornă', 'published' => 'Publicat'])
                    ->default('draft')
                    ->required(),
                Select::make('city_id')->label('Oraș')->relationship('city', 'name')->searchable()->preload(),
                Select::make('sector_id')->label('Sector')->relationship('sector', 'name')->searchable()->preload(),
                Select::make('category_id')->label('Categorie')->relationship('category', 'name')->searchable()->preload(),
                Textarea::make('body')->label('Conținut (HTML/Markdown)')->rows(12)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('path')->label('Cale')->searchable()->sortable(),
                TextColumn::make('title')->label('Title')->limit(50)->searchable(),
                TextColumn::make('robots')->label('Robots')->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => $state === 'published' ? 'success' : 'gray')
                    ->formatStateUsing(fn (string $state) => $state === 'published' ? 'Publicat' : 'Ciornă'),
                TextColumn::make('city.name')->label('Oraș')->toggleable(),
                TextColumn::make('category.name')->label('Categorie')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(['draft' => 'Ciornă', 'published' => 'Publicat']),
                SelectFilter::make('category_id')->label('Categorie')->relationship('category', 'name'),
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
            'index' => ManageSeoPages::route('/'),
        ];
    }
}
