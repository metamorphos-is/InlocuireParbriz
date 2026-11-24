<?php

namespace App\Filament\Admin\Resources\Leads;

use App\Filament\Admin\Resources\Leads\Pages\CreateLead;
use App\Filament\Admin\Resources\Leads\Pages\EditLead;
use App\Filament\Admin\Resources\Leads\Pages\ListLeads;
use App\Filament\Admin\Resources\Leads\RelationManagers\NotesRelationManager;
use App\Models\Lead;
use App\Models\Provider;
use App\Services\LeadWorkflow;
use App\Support\LeadStatus;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static string|\UnitEnum|null $navigationGroup = 'Lead-uri';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'lead';

    protected static ?string $pluralModelLabel = 'lead-uri';

    protected static ?string $navigationLabel = 'Lead-uri';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function getNavigationBadge(): ?string
    {
        $count = Lead::query()->where('status', 'noua')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'danger';
    }

    public static function getEloquentQuery(): Builder
    {
        // Doar super_admin ajunge aici (panou /admin) și vede toate lead-urile.
        return parent::getEloquentQuery()->with(['category', 'city', 'sector', 'assignedProvider']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client')
                    ->columns(2)
                    ->schema([
                        TextInput::make('reference')
                            ->label('Referință')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Se generează automat'),
                        TextInput::make('customer_name')->label('Nume client')->required()->maxLength(255),
                        TextInput::make('phone')->label('Telefon')->tel()->required()->maxLength(255),
                        TextInput::make('email')->label('Email')->email()->maxLength(255),
                        TextInput::make('address_text')->label('Adresă')->maxLength(255)->columnSpanFull(),
                    ]),
                Section::make('Solicitare')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')->label('Categorie')->relationship('category', 'name')->searchable()->preload(),
                        Select::make('city_id')->label('Oraș')->relationship('city', 'name')->searchable()->preload()->live(),
                        Select::make('sector_id')
                            ->label('Sector')
                            ->relationship('sector', 'name', fn (Builder $query, $get) => $get('city_id') ? $query->where('city_id', $get('city_id')) : $query)
                            ->searchable()
                            ->preload(),
                        TextInput::make('preferred_schedule')->label('Program preferat')->maxLength(255),
                        Toggle::make('urgency')->label('Urgent'),
                        Textarea::make('description')->label('Descriere')->rows(4)->columnSpanFull(),
                    ]),
                Section::make('Gestionare')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(LeadStatus::options())
                            ->default('noua')
                            ->required(),
                        Select::make('assigned_provider_id')
                            ->label('Prestator atribuit')
                            ->relationship('assignedProvider', 'company_name', fn (Builder $query) => $query->where('status', 'active'))
                            ->searchable()
                            ->preload()
                            ->placeholder('— neatribuit —'),
                        TextInput::make('agreed_amount')
                            ->label('Sumă agreată')
                            ->numeric()
                            ->minValue(0)
                            ->suffix('RON'),
                        TextInput::make('source')->label('Sursă')->maxLength(255)->disabled()->dehydrated(false),
                        TextInput::make('landing_path')->label('Pagină de intrare')->maxLength(255)->disabled()->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Ref.')->searchable()->sortable()->copyable(),
                TextColumn::make('created_at')->label('Primit')->dateTime('d.m.Y H:i')->sortable(),
                TextColumn::make('customer_name')->label('Client')->searchable(),
                TextColumn::make('phone')->label('Telefon')->searchable()->copyable(),
                TextColumn::make('category.name')->label('Categorie')->toggleable(),
                TextColumn::make('sector.name')->label('Sector')->toggleable(),
                IconColumn::make('urgency')->label('Urgent')->boolean()
                    ->trueIcon(Heroicon::OutlinedExclamationTriangle)->trueColor('danger')
                    ->falseIcon(Heroicon::OutlinedMinus)->falseColor('gray'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => LeadStatus::color($state))
                    ->formatStateUsing(fn (string $state) => LeadStatus::label($state))
                    ->sortable(),
                TextColumn::make('assignedProvider.company_name')->label('Prestator')->placeholder('Neatribuit')->sortable(),
                TextColumn::make('agreed_amount')->label('Sumă agreată')->money('RON')->placeholder('—')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->label('Status')->options(LeadStatus::options())->multiple(),
                TernaryFilter::make('urgency')->label('Urgent'),
                Filter::make('unassigned')
                    ->label('Neatribuite')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->whereNull('assigned_provider_id')),
                SelectFilter::make('assigned_provider_id')->label('Prestator')->relationship('assignedProvider', 'company_name'),
                SelectFilter::make('category_id')->label('Categorie')->relationship('category', 'name'),
                SelectFilter::make('sector_id')->label('Sector')->relationship('sector', 'name'),
            ])
            ->recordActions([
                static::assignAction(),
                EditAction::make()->label('Deschide'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('assign_bulk')
                        ->label('Atribuie prestator')
                        ->icon(Heroicon::OutlinedUserPlus)
                        ->schema([
                            Select::make('provider_id')->label('Prestator')->options(static::providerOptions())->searchable()->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $workflow = app(LeadWorkflow::class);
                            foreach ($records as $lead) {
                                $workflow->assign($lead, (int) $data['provider_id'], auth()->id());
                            }
                            Notification::make()->title('Lead-uri atribuite')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make()->label('Șterge selecția'),
                ]),
            ]);
    }

    public static function assignAction(): Action
    {
        return Action::make('assign')
            ->label('Atribuie')
            ->icon(Heroicon::OutlinedUserPlus)
            ->schema([
                Select::make('provider_id')
                    ->label('Prestator')
                    ->options(static::providerOptions())
                    ->searchable()
                    ->required(),
            ])
            ->fillForm(fn (Lead $record) => ['provider_id' => $record->assigned_provider_id])
            ->action(function (Lead $record, array $data) {
                app(LeadWorkflow::class)->assign($record, (int) $data['provider_id'], auth()->id());
                Notification::make()->title('Lead atribuit')->success()->send();
            });
    }

    /** @return array<int,string> */
    public static function providerOptions(): array
    {
        return Provider::query()->where('status', 'active')->orderBy('company_name')->pluck('company_name', 'id')->all();
    }

    public static function getRelations(): array
    {
        return [
            NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeads::route('/'),
            'create' => CreateLead::route('/create'),
            'edit' => EditLead::route('/{record}/edit'),
        ];
    }
}
