<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking->load(['trainer', 'direction']);
        $trainer = $booking->trainer;
        $scheduledAt = $booking->scheduled_at->format('d.m.Y H:i');

        return (new MailMessage)
            ->subject('Запись подтверждена — Sport Division')
            ->greeting('Здравствуйте!')
            ->line("Ваша запись к тренеру **{$trainer->display_name}** оформлена.")
            ->line("**Дата и время:** {$scheduledAt}")
            ->when($booking->direction, fn ($m) => $m->line("**Направление:** {$booking->direction->name}"))
            ->when($booking->notes, fn ($m) => $m->line("**Заметки:** {$booking->notes}"))
            ->action('Посмотреть запись', route('bookings.show', $booking))
            ->line('Если планы изменились — отмените запись заранее.');
    }
}
