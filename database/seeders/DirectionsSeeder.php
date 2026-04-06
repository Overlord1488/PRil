<?php

namespace Database\Seeders;

use App\Models\TrainingDirection;
use Illuminate\Database\Seeder;

class DirectionsSeeder extends Seeder
{
    public function run(): void
    {
        $directions = [
            ['name' => 'Силовые тренировки', 'slug' => 'silovye-trenirovki', 'icon' => '🏋️', 'description' => 'Работа с железом: штанга, гантели, тренажёры. Развитие силы и мышечной массы.', 'sort_order' => 1],
            ['name' => 'Кардио', 'slug' => 'kardio', 'icon' => '🏃', 'description' => 'Беговые дорожки, велотренажёры, эллипсоид. Улучшение выносливости и сжигание жира.', 'sort_order' => 2],
            ['name' => 'Йога', 'slug' => 'yoga', 'icon' => '🧘', 'description' => 'Расслабление, растяжка, медитация. Гармония тела и разума.', 'sort_order' => 3],
            ['name' => 'CrossFit', 'slug' => 'crossfit', 'icon' => '⚡', 'description' => 'Высокоинтенсивный функциональный тренинг. Комплексное развитие физических качеств.', 'sort_order' => 4],
            ['name' => 'Бокс', 'slug' => 'boks', 'icon' => '🥊', 'description' => 'Техника боксёрских ударов, работа с грушей. Улучшение координации и реакции.', 'sort_order' => 5],
            ['name' => 'Стретчинг', 'slug' => 'stretching', 'icon' => '🤸', 'description' => 'Развитие гибкости и подвижности суставов. Профилактика травм.', 'sort_order' => 6],
            ['name' => 'Плавание', 'slug' => 'plavanie', 'icon' => '🏊', 'description' => 'Тренировки в бассейне для всех уровней. Щадящая нагрузка на суставы.', 'sort_order' => 7],
            ['name' => 'Пилатес', 'slug' => 'pilates', 'icon' => '🎽', 'description' => 'Укрепление глубоких мышц, коррекция осанки, восстановление после травм.', 'sort_order' => 8],
        ];

        foreach ($directions as $data) {
            TrainingDirection::create(array_merge($data, ['is_active' => true]));
        }
    }
}
