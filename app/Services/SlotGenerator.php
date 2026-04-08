<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Trainer;
use App\Models\TrainerSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SlotGenerator
{
    /**
     * Returns available time slots for a trainer on the given date.
     * Each slot: ['time' => 'HH:MM', 'datetime' => 'YYYY-MM-DD HH:MM:SS']
     */
    public function generate(Trainer $trainer, Carbon $date): Collection
    {
        $schedule = TrainerSchedule::where('trainer_id', $trainer->id)
            ->where('day_of_week', $date->dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (! $schedule) {
            return collect();
        }

        $bookedTimes = Booking::where('trainer_id', $trainer->id)
            ->whereDate('scheduled_at', $date->toDateString())
            ->whereNotIn('status', [BookingStatus::Cancelled->value])
            ->pluck('scheduled_at')
            ->map(fn ($dt) => Carbon::parse($dt)->format('H:i'))
            ->all();

        $slots = [];
        $current = Carbon::parse($date->toDateString().' '.$schedule->start_time);
        $end = Carbon::parse($date->toDateString().' '.$schedule->end_time);

        while ($current->copy()->addMinutes($schedule->slot_minutes)->lte($end)) {
            $timeStr = $current->format('H:i');

            if (! in_array($timeStr, $bookedTimes) && $current->isFuture()) {
                $slots[] = [
                    'time' => $timeStr,
                    'datetime' => $current->toDateTimeString(),
                    'label' => $current->format('H:i'),
                ];
            }

            $current->addMinutes($schedule->slot_minutes);
        }

        return collect($slots);
    }

    /**
     * Returns dates (next $days days) on which the trainer has an active schedule.
     */
    public function availableDates(Trainer $trainer, int $days = 14): Collection
    {
        $activeDays = TrainerSchedule::where('trainer_id', $trainer->id)
            ->where('is_active', true)
            ->pluck('day_of_week')
            ->unique()
            ->all();

        $dates = [];
        $current = now()->startOfDay()->addDay();

        for ($i = 0; $i < $days; $i++) {
            if (in_array($current->dayOfWeek, $activeDays)) {
                $dates[] = $current->toDateString();
            }
            $current->addDay();
        }

        return collect($dates);
    }
}
