<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingDirectionResource\Pages;
use App\Models\TrainingDirection;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TrainingDirectionResource extends Resource
{
    protected static ?string $model = TrainingDirection::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    protected static string|\UnitEnum|null $navigationGroup = 'Тренеры';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(120)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(120)
                ->unique(ignoreRecord: true),

            TextInput::make('icon')
                ->label('Иконка (эмодзи)')
                ->maxLength(60),

            TextInput::make('sort_order')
                ->label('Порядок')
                ->numeric()
                ->default(0),

            Textarea::make('description')
                ->label('Краткое описание')
                ->rows(3)
                ->columnSpanFull(),

            RichEditor::make('body')
                ->label('Полное описание')
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->label('Активно')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icon')->label('')->sortable(false),
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sort_order')->label('Порядок')->sortable(),
                TextColumn::make('trainers_count')->label('Тренеры')->counts('trainers')->sortable(),
                IconColumn::make('is_active')->label('Активно')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingDirections::route('/'),
            'create' => Pages\CreateTrainingDirection::route('/create'),
            'edit' => Pages\EditTrainingDirection::route('/{record}/edit'),
        ];
    }
}
