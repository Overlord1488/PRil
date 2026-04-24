<?php

namespace Database\Seeders;

use App\Enums\ProductType;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoProductsSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Category::where('slug', 'dlya-nachinayushchikh')->first();
        $weightloss = Category::where('slug', 'dlya-pokhudeniya')->first();
        $muscle = Category::where('slug', 'nabor-massy')->first();
        $protein = Category::where('slug', 'protein')->first();
        $gainer = Category::where('slug', 'gayner')->first();

        $products = [
            [
                'name' => 'Старт: 30 дней в форме',
                'type' => ProductType::Program,
                'category' => $programs,
                'description' => 'Идеальная программа для тех, кто только начинает тренироваться. Постепенное увеличение нагрузки.',
                'price' => 990,
                'cover_path' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=800&fit=crop&q=80',
            ],
            [
                'name' => 'Сжигание жира: интенсив 8 недель',
                'type' => ProductType::Program,
                'category' => $weightloss,
                'description' => 'Программа высокоинтенсивных тренировок для эффективного жиросжигания.',
                'price' => 1490,
                'cover_path' => 'https://images.unsplash.com/photo-1480179087180-d9f0ec044897?w=800&fit=crop&q=80',
            ],
            [
                'name' => 'Массонабор: силовой курс',
                'type' => ProductType::Program,
                'category' => $muscle,
                'description' => 'Проверенная программа набора мышечной массы с прогрессивной нагрузкой.',
                'price' => 1990,
                'cover_path' => 'https://images.unsplash.com/photo-1534258936925-c58bed479fcb?w=800&fit=crop&q=80',
            ],
            [
                'name' => 'Whey Protein Gold 1кг',
                'type' => ProductType::Physical,
                'category' => $protein,
                'description' => 'Сывороточный протеин премиум класса. 25г белка на порцию.',
                'price' => 2800,
                'cover_path' => 'https://images.unsplash.com/photo-1693996045300-521e9d08cabc?w=800&fit=crop&q=80',
                'weight_kg' => 1.1,
                'stock_qty' => 25,
            ],
            [
                'name' => 'Mass Gainer Pro 3кг',
                'type' => ProductType::Physical,
                'category' => $gainer,
                'description' => 'Гейнер с высоким содержанием углеводов и белка для набора массы.',
                'price' => 3200,
                'cover_path' => 'https://images.unsplash.com/photo-1704650311298-4d6915d34c64?w=800&fit=crop&q=80',
                'weight_kg' => 3.2,
                'stock_qty' => 15,
            ],
            [
                'name' => 'Руководство по питанию спортсмена',
                'type' => ProductType::Digital,
                'category' => $protein,
                'description' => 'Подробное руководство по спортивному питанию с планом меню на месяц.',
                'price' => 590,
                'cover_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&fit=crop&q=80',
            ],
        ];

        foreach ($products as $data) {
            $category = $data['category'];
            unset($data['category']);

            $slug = Str::slug($data['name']);

            Product::updateOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'slug' => $slug,
                    'type' => $data['type']->value,
                    'category_id' => $category?->id,
                    'is_published' => true,
                    'in_stock' => true,
                    'weight_kg' => $data['weight_kg'] ?? null,
                    'stock_qty' => $data['stock_qty'] ?? null,
                ])
            );
        }
    }
}
