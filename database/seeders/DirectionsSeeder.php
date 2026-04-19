<?php

namespace Database\Seeders;

use App\Models\TrainingDirection;
use Illuminate\Database\Seeder;

class DirectionsSeeder extends Seeder
{
    public function run(): void
    {
        $directions = [
            [
                'name' => 'Силовые тренировки', 'slug' => 'silovye-trenirovki', 'icon' => '🏋️',
                'cover_path' => 'https://images.unsplash.com/photo-1517963879433-6ad2b056d712?w=600&fit=crop&q=80',
                'description' => 'Работа с железом: штанга, гантели, тренажёры. Развитие силы и мышечной массы.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Кардио', 'slug' => 'kardio', 'icon' => '🏃',
                'cover_path' => 'https://images.unsplash.com/photo-1633394782240-f81aba3f850d?w=600&fit=crop&q=80',
                'description' => 'Беговые дорожки, велотренажёры, эллипсоид. Улучшение выносливости и сжигание жира.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Йога', 'slug' => 'yoga', 'icon' => '🧘',
                'cover_path' => 'https://images.unsplash.com/photo-1573583804458-d4f9be45fd84?w=600&fit=crop&q=80',
                'description' => 'Расслабление, растяжка, медитация. Гармония тела и разума.',
                'sort_order' => 3,
            ],
            [
                'name' => 'CrossFit', 'slug' => 'crossfit', 'icon' => '⚡',
                'cover_path' => 'https://images.unsplash.com/photo-1601422407692-ec4eeec1d9b3?w=600&fit=crop&q=80',
                'description' => 'Высокоинтенсивный функциональный тренинг. Комплексное развитие физических качеств.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Бокс', 'slug' => 'boks', 'icon' => '🥊',
                'cover_path' => 'https://images.unsplash.com/photo-1518459031867-a89b944bffe4?w=600&fit=crop&q=80',
                'description' => 'Техника боксёрских ударов, работа с грушей. Улучшение координации и реакции.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Стретчинг', 'slug' => 'stretching', 'icon' => '🤸',
                'cover_path' => 'https://images.unsplash.com/photo-1575052814074-c05122e0a17a?w=600&fit=crop&q=80',
                'description' => 'Развитие гибкости и подвижности суставов. Профилактика травм.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Плавание', 'slug' => 'plavanie', 'icon' => '🏊',
                'cover_path' => 'https://images.unsplash.com/photo-1560090995-dab26f86f1ae?w=600&fit=crop&q=80',
                'description' => 'Тренировки в бассейне для всех уровней. Щадящая нагрузка на суставы.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Пилатес', 'slug' => 'pilates', 'icon' => '🎽',
                'cover_path' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&fit=crop&q=80',
                'description' => 'Укрепление глубоких мышц, коррекция осанки, восстановление после травм.',
                'sort_order' => 8,
            ],
        ];

        foreach ($directions as $data) {
            TrainingDirection::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
