<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPaidNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Заказ').' '.$this->order->number.' — '.__('оплачен'))
            ->greeting(__('Здравствуйте,').' '.$notifiable->name.'!')
            ->line(__('Ваш заказ').' **'.$this->order->number.'** '.__('успешно оплачен.'))
            ->line(__('Сумма').': '.number_format((float) $this->order->total, 0, '.', ' ').' ₽')
            ->action(__('Перейти к заказу'), route('account.orders.show', $this->order))
            ->line(__('Спасибо за покупку в GymHub!'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->number,
        ];
    }
}
