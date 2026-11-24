<?php

namespace App\Filament\Admin\Resources\NotificationTemplates;

use App\Filament\Admin\Resources\NotificationTemplates\Pages\ManageNotificationTemplates;
use App\Models\NotificationTemplate;
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
use Filament\Tables\Table;

class NotificationTemplateResource extends Resource
{
    protected static ?string $model = NotificationTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'șablon notificare';

    protected static ?string $pluralModelLabel = 'șabloane notificări';

    protected static ?string $navigationLabel = 'Șabloane notificări';

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Cheie (ex: lead.admin_email)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('channel')
                    ->label('Canal')
                    ->options(['email' => 'Email', 'sms' => 'SMS'])
                    ->required()
                    ->live(),
                TextInput::make('subject')
                    ->label('Subiect (doar email)')
                    ->maxLength(255)
                    ->visible(fn ($get) => $get('channel') === 'email')
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->label('Conținut')
                    ->helperText('Variabile: {reference}, {customer_name}, {phone}, {category}, {description}')
                    ->required()
                    ->rows(6)
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Activ')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->label('Cheie')->searchable()->sortable(),
                TextColumn::make('channel')->label('Canal')->badge()->formatStateUsing(fn (string $state) => strtoupper($state)),
                TextColumn::make('subject')->label('Subiect')->limit(40)->placeholder('—'),
                IconColumn::make('is_active')->label('Activ')->boolean(),
                TextColumn::make('updated_at')->label('Actualizat')->since()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('channel')->label('Canal')->options(['email' => 'Email', 'sms' => 'SMS']),
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
            'index' => ManageNotificationTemplates::route('/'),
        ];
    }
}
