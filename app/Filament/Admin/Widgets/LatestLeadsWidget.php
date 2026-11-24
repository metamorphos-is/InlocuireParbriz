<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Leads\LeadResource;
use App\Models\Lead;
use App\Support\LeadStatus;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestLeadsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Ultimele lead-uri';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Lead::query()->with(['category', 'assignedProvider'])->latest())
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('reference')->label('Ref.'),
                TextColumn::make('created_at')->label('Primit')->dateTime('d.m.Y H:i'),
                TextColumn::make('customer_name')->label('Client'),
                TextColumn::make('category.name')->label('Categorie'),
                IconColumn::make('urgency')->label('Urgent')->boolean(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => LeadStatus::color($state))
                    ->formatStateUsing(fn (string $state) => LeadStatus::label($state)),
                TextColumn::make('assignedProvider.company_name')->label('Prestator')->placeholder('Neatribuit'),
            ])
            ->recordUrl(fn (Lead $record) => LeadResource::getUrl('edit', ['record' => $record]));
    }
}
