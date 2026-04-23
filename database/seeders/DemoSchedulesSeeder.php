<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainerSchedule;
use Illuminate\Database\Seeder;

class DemoSchedulesSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            'aleksey-petrov' => [
                ['day_of_week' => 1, 'start_time' => '09:00', 'end_time' => '18:00'],
                ['day_of_week' => 3, 'start_time' => '09:00', 'end_time' => '18:00'],
                ['day_of_week' => 5, 'start_time' => '09:00', 'end_time' => '18:00'],
            ],
            'maria-sokolova' => [
                ['day_of_week' => 1, 'start_time' => '10:00', 'end_time' => '19:00'],
                ['day_of_week' => 2, 'start_time' => '10:00', 'end_time' => '19:00'],
                ['day_of_week' => 4, 'start_time' => '10:00', 'end_time' => '19:00'],
                ['day_of_week' => 6, 'start_time' => '10:00', 'end_time' => '16:00'],
            ],
            'dmitry-volkov' => [
                ['day_of_week' => 2, 'start_time' => '08:00', 'end_time' => '17:00'],
                ['day_of_week' => 4, 'start_time' => '08:00', 'end_time' => '17:00'],
                ['day_of_week' => 6, 'start_time' => '10:00', 'end_time' => '18:00'],
                ['day_of_week' => 0, 'start_time' => '10:00', 'end_time' => '15:00'],
            ],
        ];

        foreach ($schedules as $slug => $rows) {
            $trainer = Trainer::where('slug', $slug)->first();
            if (! $trainer) {
                continue;
            }

            foreach ($rows as $row) {
                TrainerSchedule::updateOrCreate(
                    [
                        'trainer_id'  => $trainer->id,
                        'day_of_week' => $row['day_of_week'],
                    ],
                    [
                        'start_time'   => $row['start_time'],
                        'end_time'     => $row['end_time'],
                        'slot_minutes' => 60,
                        'is_active'    => true,
                    ]
                );
            }
        }
    }
}
