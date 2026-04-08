<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Ожидает',
            self::Confirmed => 'Подтверждена',
            self::Cancelled => 'Отменена',
            self::Completed => 'Завершена',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Cancelled => 'danger',
            self::Completed => 'gray',
        };
    }

    public function isCancellable(): bool
    {
        return in_array($this, [self::Pending, self::Confirmed]);
    }
}
