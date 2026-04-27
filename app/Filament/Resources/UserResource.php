<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Пользователи';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Пользователь';

    protected static ?string $pluralModelLabel = 'Пользователи';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Имя')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('phone')
                ->label('Телефон')
                ->tel()
                ->maxLength(20),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label('Роль')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'admin'   => 'danger',
                        'trainer' => 'warning',
                        default   => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Дата регистрации')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->actions([EditAction::make()->label('Редактировать')]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit'  => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
