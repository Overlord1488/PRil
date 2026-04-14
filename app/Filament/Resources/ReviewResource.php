<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\Trainer;
use App\Services\RecalculateRatingAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static string|\UnitEnum|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reviewable_type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state) => class_basename($state))
                    ->badge()
                    ->sortable(),

                TextColumn::make('reviewable_id')
                    ->label('Объект')
                    ->formatStateUsing(function (Review $record) {
                        if ($record->reviewable_type === Trainer::class) {
                            return $record->reviewable?->display_name ?? "#{$record->reviewable_id}";
                        }

                        return $record->reviewable?->name ?? "#{$record->reviewable_id}";
                    }),

                TextColumn::make('user.name')->label('Автор')->searchable(),

                TextColumn::make('rating')
                    ->label('Оценка')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state).str_repeat('☆', 5 - $state))
                    ->sortable(),

                TextColumn::make('body')
                    ->label('Отзыв')
                    ->limit(60)
                    ->wrap(),

                IconColumn::make('is_approved')
                    ->label('Одобрен')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_approved')
                    ->label('Статус')
                    ->options([
                        '0' => 'На модерации',
                        '1' => 'Одобрены',
                    ]),

                SelectFilter::make('reviewable_type')
                    ->label('Тип')
                    ->options([
                        Trainer::class => 'Тренер',
                    ]),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Одобрить')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Review $record) => ! $record->is_approved)
                    ->action(function (Review $record) {
                        $record->update(['is_approved' => true]);

                        if ($record->reviewable_type === Trainer::class && $record->reviewable) {
                            app(RecalculateRatingAction::class)->execute($record->reviewable);
                        }
                    }),

                Action::make('reject')
                    ->label('Отклонить')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Review $record) {
                        $wasApproved = $record->is_approved;
                        $reviewable = $record->reviewable;
                        $type = $record->reviewable_type;

                        $record->delete();

                        if ($wasApproved && $type === Trainer::class && $reviewable) {
                            app(RecalculateRatingAction::class)->execute($reviewable);
                        }
                    }),
            ])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
