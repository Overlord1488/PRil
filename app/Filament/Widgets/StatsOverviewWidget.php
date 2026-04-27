<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Order;
use App\Models\Trainer;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $revenue = Order::where('status', '!=', 'cancelled')->sum('total');

        return [
            Stat::make('Пользователи', User::count())
                ->description('Всего зарегистрировано')
                ->color('primary'),

            Stat::make('Тренеры', Trainer::active()->count())
                ->description('Активных тренеров')
                ->color('success'),

            Stat::make('Заказы', Order::count())
                ->description('Оплачено: '.Order::where('status', 'paid')->count())
                ->color('warning'),

            Stat::make('Выручка', number_format($revenue, 0, '.', ' ').' ₽')
                ->description('Без отменённых заказов')
                ->color('info'),
        ];
    }
}
