<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Trainer;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Пользователи', User::count())
                ->description('Всего зарегистрировано')
                ->color('primary'),

            Stat::make('Тренеры', Trainer::active()->count())
                ->description('Активных тренеров')
                ->color('success'),

            Stat::make('Бронирования', Booking::count())
                ->description('Всего записей')
                ->color('warning'),

            Stat::make('Бронирования сегодня', Booking::whereDate('scheduled_at', today())->count())
                ->description('Запланировано на сегодня')
                ->color('info'),
        ];
    }
}
