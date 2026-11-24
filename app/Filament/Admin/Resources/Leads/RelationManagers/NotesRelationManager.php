<?php

namespace App\Filament\Admin\Resources\Leads\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'Note';

    protected static ?string $modelLabel = 'notă';

    protected static ?string $pluralModelLabel = 'note';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('body')->label('Notă')->required()->rows(4)->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('body')
            ->columns([
                TextColumn::make('created_at')->label('Data')->dateTime('d.m.Y H:i')->sortable(),
                TextColumn::make('user.name')->label('Autor')->placeholder('—'),
                TextColumn::make('body')->label('Notă')->wrap(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('Adaugă notă')
                    ->mutateDataUsing(fn (array $data) => $data + ['user_id' => auth()->id()]),
            ])
            ->recordActions([
                DeleteAction::make()->label('Șterge'),
            ]);
    }
}
