<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case NoShow = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Ожидает',
            self::Confirmed => 'Подтверждена',
            self::Cancelled => 'Отменена',
            self::Completed => 'Завершена',
            self::NoShow => 'Не явился',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Cancelled => 'danger',
            self::Completed => 'gray',
            self::NoShow => 'danger',
        };
    }

    public function isCancellable(): bool
    {
        return in_array($this, [self::Pending, self::Confirmed]);
    }
}
