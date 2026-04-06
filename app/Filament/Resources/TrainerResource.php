<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainerResource\Pages;
use App\Models\Trainer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TrainerResource extends Resource
{
    protected static ?string $model = Trainer::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Тренеры';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('user_id')
                ->label('Пользователь')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            TextInput::make('display_name')
                ->label('Отображаемое имя')
                ->required()
                ->maxLength(120)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(120)
                ->unique(ignoreRecord: true),

            FileUpload::make('photo_path')
                ->label('Фото')
                ->image()
                ->directory('trainers/photos')
                ->columnSpanFull(),

            Textarea::make('bio')
                ->label('Биография')
                ->rows(4)
                ->columnSpanFull(),

            TextInput::make('experience_years')
                ->label('Опыт (лет)')
                ->numeric()
                ->default(0),

            TextInput::make('rating')
                ->label('Рейтинг')
                ->numeric()
                ->default(0),

            Select::make('directions')
                ->label('Направления')
                ->relationship('directions', 'name')
                ->multiple()
                ->preload()
                ->columnSpanFull(),

            Toggle::make('is_active')
                ->label('Активен')
                ->default(true),

            TextInput::make('sort_order')
                ->label('Порядок')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')->label('Фото')->circular(),
                TextColumn::make('display_name')->label('Имя')->searchable()->sortable(),
                TextColumn::make('directions.name')->label('Направления')->badge()->separator(','),
                TextColumn::make('experience_years')->label('Опыт, лет')->sortable(),
                TextColumn::make('rating')->label('Рейтинг')->sortable(),
                IconColumn::make('is_active')->label('Активен')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainers::route('/'),
            'create' => Pages\CreateTrainer::route('/create'),
            'edit' => Pages\EditTrainer::route('/{record}/edit'),
        ];
    }
}
