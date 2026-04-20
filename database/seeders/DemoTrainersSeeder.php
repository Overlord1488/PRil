<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\TrainingDirection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoTrainersSeeder extends Seeder
{
    public function run(): void
    {
        $power = TrainingDirection::where('slug', 'silovye-trenirovki')->first();
        $crossfit = TrainingDirection::where('slug', 'crossfit')->first();
        $yoga = TrainingDirection::where('slug', 'yoga')->first();
        $boxing = TrainingDirection::where('slug', 'boks')->first();
        $cardio = TrainingDirection::where('slug', 'kardio')->first();
        $stretching = TrainingDirection::where('slug', 'stretching')->first();

        $trainers = [
            [
                'name' => 'Алексей Петров',
                'email' => 'aleksey@sportdivision.local',
                'slug' => 'aleksey-petrov',
                'display_name' => 'Алексей Петров',
                'photo_path' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&fit=crop&q=80',
                'bio' => 'Мастер спорта по тяжёлой атлетике. Специализируется на силовых тренировках и наборе мышечной массы. Работает с атлетами всех уровней — от новичков до спортсменов.',
                'experience_years' => 8,
                'rating' => 4.9,
                'directions' => [$power, $crossfit],
            ],
            [
                'name' => 'Мария Соколова',
                'email' => 'maria@sportdivision.local',
                'slug' => 'maria-sokolova',
                'display_name' => 'Мария Соколова',
                'photo_path' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&fit=crop&q=80',
                'bio' => 'Сертифицированный инструктор по йоге и стретчингу. Помогает снять стресс, улучшить гибкость и обрести гармонию. Проводит групповые и индивидуальные занятия.',
                'experience_years' => 6,
                'rating' => 4.8,
                'directions' => [$yoga, $stretching],
            ],
            [
                'name' => 'Дмитрий Волков',
                'email' => 'dmitry@sportdivision.local',
                'slug' => 'dmitry-volkov',
                'display_name' => 'Дмитрий Волков',
                'photo_path' => 'https://images.unsplash.com/photo-1601422407692-ec4eeec1d9b3?w=600&fit=crop&q=80',
                'bio' => 'Тренер по CrossFit и функциональному тренингу. КМС по боксу. Любит нестандартные подходы и высокую интенсивность. Гарантирует результат при регулярных тренировках.',
                'experience_years' => 5,
                'rating' => 4.7,
                'directions' => [$crossfit, $boxing, $cardio],
            ],
        ];

        foreach ($trainers as $data) {
            $directions = $data['directions'];
            unset($data['directions'], $data['name']);

            $email = $data['email'];
            unset($data['email']);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $data['display_name'],
                    'password' => Hash::make('Trainer12345!'),
                    'email_verified_at' => now(),
                ]
            );

            $user->assignRole('trainer');

            $trainer = Trainer::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id' => $user->id,
                    'reviews_count' => rand(5, 30),
                    'is_active' => true,
                    'sort_order' => 0,
                ])
            );

            $trainer->directions()->sync(
                collect($directions)->filter()->pluck('id')
            );
        }
    }
}
