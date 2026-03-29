<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Программы тренировок',
                'slug' => 'programmy-trenirovok',
                'type' => CategoryType::Programs,
                'description' => 'Готовые тренировочные программы для любого уровня подготовки.',
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Для начинающих', 'slug' => 'dlya-nachinayushchikh', 'sort_order' => 1],
                    ['name' => 'Для похудения', 'slug' => 'dlya-pokhudeniya', 'sort_order' => 2],
                    ['name' => 'Набор массы', 'slug' => 'nabor-massy', 'sort_order' => 3],
                    ['name' => 'Функциональный тренинг', 'slug' => 'funktsionalnyy-trening', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Спортивное питание',
                'slug' => 'sportivnoe-pitanie',
                'type' => CategoryType::Nutrition,
                'description' => 'Протеины, гейнеры, аминокислоты и витамины для спортсменов.',
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Протеин', 'slug' => 'protein', 'sort_order' => 1],
                    ['name' => 'Гейнер', 'slug' => 'gayner', 'sort_order' => 2],
                    ['name' => 'Аминокислоты', 'slug' => 'aminokisloty', 'sort_order' => 3],
                    ['name' => 'Витамины', 'slug' => 'vitaminy', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Инвентарь',
                'slug' => 'inventar',
                'type' => CategoryType::Equipment,
                'description' => 'Спортивный инвентарь для тренировок дома и в зале.',
                'sort_order' => 3,
                'children' => [],
            ],
        ];

        foreach ($categories as $data) {
            $children = $data['children'] ?? [];
            unset($data['children']);

            $parent = Category::create(array_merge($data, [
                'type' => $data['type']->value,
                'is_active' => true,
            ]));

            foreach ($children as $child) {
                Category::create(array_merge($child, [
                    'type' => $parent->type->value,
                    'parent_id' => $parent->id,
                    'is_active' => true,
                ]));
            }
        }
    }
}
