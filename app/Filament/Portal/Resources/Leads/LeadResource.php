<?php

namespace App\Filament\Portal\Resources\Leads;

use App\Filament\Portal\Resources\Leads\Pages\ListLeads;
use App\Filament\Portal\Resources\Leads\Pages\ViewLead;
use App\Models\Lead;
use App\Services\LeadWorkflow;
use App\Support\LeadStatus;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Lead-urile prestatorului autentificat: doar cele atribuite lui
 * (assigned_provider_id = providerul userului). Poate doar vizualiza
 * detaliile și actualiza statusul.
 */
class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static ?string $modelLabel = 'lead';

    protected static ?string $pluralModelLabel = 'lead-uri';

    protected static ?string $navigationLabel = 'Lead-urile mele';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function getEloquentQuery(): Builder
    {
        $providerId = auth()->user()?->provider?->id;

        // Fără profil de prestator => niciun rezultat (nu ocolește scoping-ul).
        return parent::getEloquentQuery()
            ->with(['category', 'city', 'sector'])
            ->where('assigned_provider_id', $providerId ?? 0);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalii lead')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('reference')->label('Referință')->copyable(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state) => LeadStatus::color($state))
                            ->formatStateUsing(fn (string $state) => LeadStatus::label($state)),
                        TextEntry::make('urgency')
                            ->label('Urgență')
                            ->badge()
                            ->color(fn (bool $state) => $state ? 'danger' : 'gray')
                            ->formatStateUsing(fn (bool $state) => $state ? 'URGENT' : 'Normal'),
                        TextEntry::make('agreed_amount')->label('Sumă agreată')->money('RON')->placeholder('Neprecizată'),
                        TextEntry::make('created_at')->label('Primit la')->dateTime('d.m.Y H:i'),
                        TextEntry::make('preferred_schedule')->label('Program preferat')->placeholder('—'),
                    ]),
                Section::make('Client')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('customer_name')->label('Nume'),
                        TextEntry::make('phone')->label('Telefon')->copyable(),
                        TextEntry::make('email')->label('Email')->placeholder('—')->copyable(),
                        TextEntry::make('address_text')->label('Adresă')->placeholder('—')->columnSpanFull(),
                    ]),
                Section::make('Solicitare')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('category.name')->label('Categorie')->placeholder('—'),
                        TextEntry::make('city.name')->label('Oraș')->placeholder('—'),
                        TextEntry::make('sector.name')->label('Sector')->placeholder('—'),
                        TextEntry::make('description')->label('Descriere')->placeholder('—')->columnSpanFull(),
                    ]),
                Section::make('Note')
                    ->schema([
                        // Doar notele proprii; notele interne ale administratorului nu sunt expuse.
                        TextEntry::make('own_notes')
                            ->label('Notele mele')
                            ->state(fn (Lead $record) => $record->notes()->where('user_id', auth()->id())->latest()->pluck('body')->all())
                            ->listWithLineBreaks()
                            ->placeholder('Nicio notă'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->label('Ref.')->searchable()->sortable(),
                TextColumn::make('created_at')->label('Primit')->dateTime('d.m.Y H:i')->sortable(),
                TextColumn::make('customer_name')->label('Client')->searchable(),
                TextColumn::make('phone')->label('Telefon')->copyable(),
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
                TextColumn::make('agreed_amount')->label('Sumă agreată')->money('RON')->placeholder('—')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->label('Status')->options(LeadStatus::options())->multiple(),
                TernaryFilter::make('urgency')->label('Urgent'),
            ])
            ->recordActions([
                ViewAction::make()->label('Detalii'),
                static::statusAction(),
            ]);
    }

    public static function statusAction(): Action
    {
        return Action::make('update_status')
            ->label('Actualizează status')
            ->icon(Heroicon::OutlinedArrowPath)
            ->schema([
                Select::make('status')
                    ->label('Status nou')
                    ->options(LeadStatus::options(LeadStatus::PROVIDER_SETTABLE))
                    ->required(),
                Textarea::make('note')->label('Notă (opțional)')->rows(3),
            ])
            ->fillForm(fn (Lead $record) => [
                'status' => in_array($record->status, LeadStatus::PROVIDER_SETTABLE, true) ? $record->status : null,
            ])
            ->authorize('update')
            ->action(function (Lead $record, array $data) {
                // Politica garantează că lead-ul e atribuit prestatorului curent;
                // se actualizează DOAR statusul (+ notă), nu și suma sau datele clientului.
                app(LeadWorkflow::class)->changeStatus($record, $data['status'], auth()->id(), $data['note'] ?? null);
                Notification::make()->title('Status actualizat')->success()->send();
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeads::route('/'),
            'view' => ViewLead::route('/{record}'),
        ];
    }
}
