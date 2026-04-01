<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::PendingPayment => __('Ожидает оплаты'),
            self::Paid => __('Оплачен'),
            self::Processing => __('В обработке'),
            self::Shipped => __('Отправлен'),
            self::Completed => __('Выполнен'),
            self::Cancelled => __('Отменён'),
            self::Refunded => __('Возвращён'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PendingPayment => 'warning',
            self::Paid => 'success',
            self::Processing => 'info',
            self::Shipped => 'info',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::Refunded => 'danger',
        };
    }
}
