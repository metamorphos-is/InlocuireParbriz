<?php

namespace App\Filament\Admin\Resources\Users;

use App\Filament\Admin\Resources\Users\Pages\ManageUsers;
use App\Models\User;
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
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Parteneri';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'utilizator';

    protected static ?string $pluralModelLabel = 'utilizatori';

    protected static ?string $navigationLabel = 'Utilizatori';

    protected static ?string $recordTitleAttribute = 'name';

    public static function roleOptions(): array
    {
        return [
            User::ROLE_SUPER_ADMIN => 'Super Admin',
            User::ROLE_PROVIDER => 'Prestator',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nume')->required()->maxLength(255),
                TextInput::make('email')->label('Email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('phone')->label('Telefon')->tel()->maxLength(255),
                TextInput::make('company_name')->label('Companie')->maxLength(255),
                Select::make('role')
                    ->label('Rol')
                    ->options(static::roleOptions())
                    ->default(User::ROLE_PROVIDER)
                    ->required(),
                Toggle::make('is_active')->label('Activ')->default(true),
                TextInput::make('password')
                    ->label('Parolă')
                    ->password()
                    ->revealable()
                    ->minLength(10)
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrated(fn (?string $state) => filled($state))
                    ->helperText('La editare, lasă gol pentru a păstra parola actuală.'),
                Textarea::make('notes')->label('Note interne')->rows(3)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nume')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('role')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state) => $state === User::ROLE_SUPER_ADMIN ? 'danger' : 'info')
                    ->formatStateUsing(fn (string $state) => static::roleOptions()[$state] ?? $state),
                TextColumn::make('phone')->label('Telefon')->toggleable(),
                IconColumn::make('is_active')->label('Activ')->boolean(),
                TextColumn::make('created_at')->label('Creat')->dateTime('d.m.Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')->label('Rol')->options(static::roleOptions()),
                TernaryFilter::make('is_active')->label('Activ'),
            ])
            ->recordActions([
                EditAction::make()->label('Editează'),
                DeleteAction::make()->label('Șterge')
                    ->hidden(fn (User $record) => $record->is(auth()->user())),
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
            'index' => ManageUsers::route('/'),
        ];
    }
}
