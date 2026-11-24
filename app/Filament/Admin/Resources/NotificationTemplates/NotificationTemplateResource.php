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
use Filament\Schemas\Components\Html;
use Filament\Schemas\Schema;
use App\Services\Notifications\LeadNotifier;
use Illuminate\Support\HtmlString;
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
                    ->live(debounce: 600)
                    ->visible(fn ($get) => $get('channel') === 'email')
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->label(fn ($get) => $get('channel') === 'email' ? 'Textul de introducere din email' : 'Textul SMS-ului')
                    ->helperText(fn ($get) => $get('channel') === 'email'
                        ? 'Scrii doar textul de la început. Designul (logo, culori), tabelul cu detaliile cererii și butoanele (Deschide cererea, Sună clientul, WhatsApp) se adaugă automat — vezi previzualizarea de mai jos. Variabile: {reference}, {customer_name}, {phone}, {vehicle_brand}, {vehicle_model}, {vehicle_year}, {city}, {provider_name}.'
                        : 'Variabile: {reference}, {customer_name}, {phone}, {category}. Un SMS are 160 de caractere (fără diacritice) — textele mai lungi se trimit în mai multe bucăți.')
                    ->required()
                    ->rows(5)
                    ->live(debounce: 600)
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Activ')->default(true),
                Html::make(function ($get) {
                    if ($get('channel') !== 'email') {
                        return null;
                    }
                    $html = app(LeadNotifier::class)->previewHtml((string) $get('key'), (string) $get('subject'), (string) $get('body'));

                    return new HtmlString(
                        '<div style="margin-top:.5rem"><p style="font-size:.85rem;font-weight:600;margin:0 0 .5rem">Previzualizare (date de exemplu)</p>'
                        .'<iframe title="Previzualizare email" sandbox="" style="width:100%;height:760px;border:1px solid #e5e7eb;border-radius:12px;background:#EEF1F6" srcdoc="'.e($html).'"></iframe></div>'
                    );
                })->columnSpanFull(),
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
                EditAction::make()->label('Editează')->modalWidth('5xl'),
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
