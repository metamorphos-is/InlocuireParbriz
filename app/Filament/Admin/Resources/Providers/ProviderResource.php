<?php

namespace App\Filament\Admin\Resources\Providers;

use App\Filament\Admin\Resources\Providers\Pages\ManageProviders;
use App\Models\Provider;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static string|\UnitEnum|null $navigationGroup = 'Parteneri';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'prestator';

    protected static ?string $pluralModelLabel = 'prestatori';

    protected static ?string $navigationLabel = 'Prestatori';

    protected static ?string $recordTitleAttribute = 'company_name';

    public static function statusOptions(): array
    {
        return [
            'pending' => 'În așteptare',
            'active' => 'Activ',
            'suspended' => 'Suspendat',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Cont utilizator (login portal)')
                    ->relationship('user', 'name', fn ($query) => $query->where('role', User::ROLE_PROVIDER))
                    ->getOptionLabelFromRecordUsing(fn (User $record) => "{$record->name} ({$record->email})")
                    ->searchable(['name', 'email'])
                    ->preload()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('company_name')->label('Companie')->required()->maxLength(255),
                TextInput::make('cui')->label('CUI')->maxLength(255),
                TextInput::make('contact_name')->label('Persoană de contact')->maxLength(255),
                TextInput::make('email')->label('Email')->email()->required()->maxLength(255),
                TextInput::make('phone')->label('Telefon')->tel()->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->options(static::statusOptions())
                    ->default('pending')
                    ->required(),
                Select::make('categories')
                    ->label('Categorii deservite')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                Repeater::make('coverage')
                    ->label('Acoperire (oraș / sector)')
                    ->relationship('coverage')
                    ->schema([
                        Select::make('city_id')
                            ->label('Oraș')
                            ->relationship('city', 'name')
                            ->required()
                            ->live()
                            ->preload(),
                        Select::make('sector_id')
                            ->label('Sector (opțional)')
                            ->relationship('sector', 'name', fn ($query, $get) => $query->where('city_id', $get('city_id')))
                            ->preload()
                            ->placeholder('Tot orașul'),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->addActionLabel('Adaugă zonă')
                    ->columnSpanFull(),
                Textarea::make('notes')->label('Note interne')->rows(3)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')->label('Companie')->searchable()->sortable(),
                TextColumn::make('contact_name')->label('Contact')->searchable()->toggleable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('Telefon')->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'active' => 'success',
                        'suspended' => 'danger',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state) => static::statusOptions()[$state] ?? $state),
                TextColumn::make('leads_count')->label('Lead-uri')->counts('leads')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(static::statusOptions()),
                SelectFilter::make('categories')->label('Categorie')->relationship('categories', 'name'),
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
            'index' => ManageProviders::route('/'),
        ];
    }
}
