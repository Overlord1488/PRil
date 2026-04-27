<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string|\UnitEnum|null $navigationGroup = 'Продажи';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Заказ';

    protected static ?string $pluralModelLabel = 'Заказы';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Placeholder::make('number')
                ->label('Номер заказа')
                ->content(fn (Order $record) => $record->number),

            Placeholder::make('user')
                ->label('Покупатель')
                ->content(fn (Order $record) => $record->user->name.' ('.$record->user->email.')'),

            Select::make('status')
                ->label('Статус')
                ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                ->required(),

            Placeholder::make('total')
                ->label('Сумма')
                ->content(fn (Order $record) => number_format($record->total, 0, '.', ' ').' ₽'),

            Placeholder::make('created_at')
                ->label('Дата')
                ->content(fn (Order $record) => $record->created_at->format('d.m.Y H:i')),

            Placeholder::make('shipping')
                ->label('Доставка')
                ->content(fn (Order $record) => $record->shipping_name
                    ? implode(', ', array_filter([$record->shipping_name, $record->shipping_phone, $record->shipping_city, $record->shipping_address]))
                    : '—'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('number')
                    ->label('Номер')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Покупатель')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof OrderStatus ? $state->label() : $state)
                    ->color(fn ($state) => match ($state instanceof OrderStatus ? $state->value : $state) {
                        'pending_payment' => 'warning',
                        'paid'            => 'success',
                        'cancelled'       => 'danger',
                        default           => 'gray',
                    }),

                TextColumn::make('total')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
            ])
            ->actions([EditAction::make()->label('Изменить статус')]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
