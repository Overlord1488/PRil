<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Cancelled = 'cancelled';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => __('Ожидает'),
            self::Succeeded => __('Успешно'),
            self::Cancelled => __('Отменён'),
            self::Failed => __('Ошибка'),
            self::Refunded => __('Возврат'),
        };
    }
}
