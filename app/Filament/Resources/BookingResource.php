<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Тренеры';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('user_id')
                ->label('Клиент')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Select::make('trainer_id')
                ->label('Тренер')
                ->relationship('trainer', 'display_name')
                ->searchable()
                ->required(),

            Select::make('training_direction_id')
                ->label('Направление')
                ->relationship('direction', 'name')
                ->nullable(),

            Select::make('status')
                ->label('Статус')
                ->options(collect(BookingStatus::cases())->mapWithKeys(
                    fn ($s) => [$s->value => $s->label()]
                ))
                ->required(),

            Textarea::make('notes')
                ->label('Примечания')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Клиент')->searchable()->sortable(),
                TextColumn::make('trainer.display_name')->label('Тренер')->searchable()->sortable(),
                TextColumn::make('direction.name')->label('Направление')->default('—'),
                TextColumn::make('scheduled_at')->label('Дата/время')->dateTime('d.m.Y H:i')->sortable(),
                TextColumn::make('duration_minutes')->label('Длит., мин')->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (BookingStatus $state) => $state->label())
                    ->color(fn (BookingStatus $state) => $state->color()),
            ])
            ->defaultSort('scheduled_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(collect(BookingStatus::cases())->mapWithKeys(
                        fn ($s) => [$s->value => $s->label()]
                    )),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
