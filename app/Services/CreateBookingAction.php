<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Trainer;
use App\Models\TrainerSchedule;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Carbon\Carbon;
use RuntimeException;

class CreateBookingAction
{
    public function __construct(private readonly SlotGenerator $slots) {}

    public function execute(
        User $user,
        Trainer $trainer,
        Carbon $scheduledAt,
        ?int $directionId = null,
        ?string $notes = null,
    ): Booking {
        $available = $this->slots->generate($trainer, $scheduledAt->copy()->startOfDay());
        $timeStr = $scheduledAt->format('H:i');

        if ($available->firstWhere('time', $timeStr) === null) {
            throw new RuntimeException('Выбранный слот недоступен');
        }

        $schedule = TrainerSchedule::where('trainer_id', $trainer->id)
            ->where('day_of_week', $scheduledAt->dayOfWeek)
            ->where('is_active', true)
            ->value('slot_minutes') ?? 60;

        $booking = Booking::create([
            'user_id' => $user->id,
            'trainer_id' => $trainer->id,
            'training_direction_id' => $directionId,
            'scheduled_at' => $scheduledAt,
            'duration_minutes' => $schedule,
            'status' => BookingStatus::Pending,
            'notes' => $notes,
            'price' => 0,
        ]);

        $user->notify(new BookingCreatedNotification($booking));

        return $booking;
    }
}
