<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainerSchedule;
use Illuminate\Database\Seeder;

class DemoScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = Trainer::with('user')->get()->keyBy('slug');

        // Алексей — Mon(1), Wed(3), Fri(5) 09:00-17:00
        if ($t = $trainers->get('aleksey-smirnov')) {
            foreach ([1, 3, 5] as $day) {
                TrainerSchedule::firstOrCreate(
                    ['trainer_id' => $t->id, 'day_of_week' => $day],
                    ['start_time' => '09:00', 'end_time' => '17:00', 'slot_minutes' => 60, 'is_active' => true]
                );
            }
        }

        // Мария — Tue(2), Thu(4), Sat(6) 10:00-18:00
        if ($t = $trainers->get('mariya-petrova')) {
            foreach ([2, 4, 6] as $day) {
                TrainerSchedule::firstOrCreate(
                    ['trainer_id' => $t->id, 'day_of_week' => $day],
                    ['start_time' => '10:00', 'end_time' => '18:00', 'slot_minutes' => 60, 'is_active' => true]
                );
            }
        }

        // Дмитрий — Mon-Fri 08:00-14:00
        if ($t = $trainers->get('dmitriy-ivanov')) {
            foreach ([1, 2, 3, 4, 5] as $day) {
                TrainerSchedule::firstOrCreate(
                    ['trainer_id' => $t->id, 'day_of_week' => $day],
                    ['start_time' => '08:00', 'end_time' => '14:00', 'slot_minutes' => 60, 'is_active' => true]
                );
            }
        }
    }
}
