<?php

namespace App\Filament\Admin\Resources\Posts;

use App\Filament\Admin\Resources\Posts\Pages\ManagePosts;
use App\Models\Post;
use App\Support\SeoOverlap;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO & Conținut';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'articol';

    protected static ?string $pluralModelLabel = 'articole';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('articol')->columnSpanFull()->tabs([
                Tab::make('Conținut')->schema([
                    TextInput::make('title')->label('Titlu (H1)')->required()->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                    TextInput::make('slug')->label('Slug (URL: /blog/{slug})')->required()->maxLength(255)->unique(ignoreRecord: true)
                        ->regex('/^[a-z0-9-]+$/'),
                    Textarea::make('excerpt')->label('Rezumat (apare în listă și sub titlu)')->rows(3)->maxLength(500),
                    MarkdownEditor::make('body')->label('Text articol')
                        ->helperText('Folosește „## Titlu” pentru secțiuni (apar în cuprins). Linkuri interne: [text](/reparatie-parbriz).')
                        ->columnSpanFull(),
                    Repeater::make('faq')->label('Întrebări frecvente')
                        ->schema([
                            TextInput::make('q')->label('Întrebare')->required(),
                            Textarea::make('a')->label('Răspuns')->rows(3)->required(),
                        ])->collapsible()->itemLabel(fn (array $state) => $state['q'] ?? null),
                ]),
                Tab::make('SEO')->columns(2)->schema([
                    TextInput::make('primary_keyword')->label('Cuvânt-cheie principal')->maxLength(120)
                        ->live(onBlur: true)
                        ->helperText(fn (Get $get, ?Post $record) => SeoOverlap::warning((string) $get('primary_keyword'), 'post', $record?->id) ?? 'Un singur cuvânt-cheie principal pe pagină — sistemul te avertizează dacă îl mai folosește altă pagină.'),
                    TextInput::make('search_volume')->label('Volum lunar (DataForSEO)')->numeric(),
                    TagsInput::make('secondary_keywords')->label('Cuvinte secundare')->columnSpanFull(),
                    TextInput::make('seo_title')->label('Titlu SEO (opțional)')->maxLength(190)->helperText('Gol = titlul articolului. Recomandat: 50–60 de caractere.')->columnSpanFull(),
                    Textarea::make('meta_description')->label('Meta descriere')->rows(2)->maxLength(320)->helperText('Recomandat: 140–160 de caractere.')->columnSpanFull(),
                    TextInput::make('related_service')->label('Pagina de serviciu legată')->placeholder('/reparatie-parbriz')
                        ->helperText('Articolul trimite cititorul spre această pagină.'),
                ]),
                Tab::make('Publicare')->columns(2)->schema([
                    Select::make('category')->label('Categorie')->options(Post::CATEGORIES)->default('ghiduri')->required(),
                    TextInput::make('author')->label('Autor')->default('Echipa inlocuireparbriz.ro'),
                    Toggle::make('is_published')->label('Publicat')->default(false),
                    DateTimePicker::make('published_at')->label('Data publicării')->default(now())
                        ->helperText('O dată din viitor programează articolul.'),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('title')->label('Titlu')->searchable()->limit(60)->wrap(),
                TextColumn::make('category')->label('Categorie')->badge()->formatStateUsing(fn ($s) => Post::CATEGORIES[$s] ?? $s),
                TextColumn::make('primary_keyword')->label('Cuvânt-cheie')->searchable()->toggleable(),
                TextColumn::make('search_volume')->label('Volum')->numeric()->sortable()->toggleable(),
                IconColumn::make('is_published')->label('Publicat')->boolean(),
                TextColumn::make('published_at')->label('Data')->date('d.m.Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')->label('Categorie')->options(Post::CATEGORIES),
                TernaryFilter::make('is_published')->label('Publicat'),
            ])
            ->recordActions([
                Action::make('view')->label('Vezi')->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn (Post $record) => $record->url(), shouldOpenInNewTab: true)
                    ->visible(fn (Post $record) => $record->is_published),
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
            'index' => ManagePosts::route('/'),
        ];
    }
}
