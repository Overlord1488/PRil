<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFile;
use Illuminate\Database\Seeder;

class DemoProductFilesSeeder extends Seeder
{
    public function run(): void
    {
        $files = [
            'start-30-dnei-v-forme' => [
                'label' => 'Программа тренировок PDF',
                'path'  => 'digital/start-30-days.pdf',
            ],
            'sziganie-zira-intensiv-8-nedel' => [
                'label' => 'Программа жиросжигания PDF',
                'path'  => 'digital/fat-burn-8weeks.pdf',
            ],
            'massonabor-silovoi-kurs' => [
                'label' => 'Силовой курс PDF',
                'path'  => 'digital/muscle-gain.pdf',
            ],
            'rukovodstvo-po-pitaniiu-sportsmena' => [
                'label' => 'Руководство по питанию PDF',
                'path'  => 'digital/nutrition-guide.pdf',
            ],
        ];

        foreach ($files as $slug => $data) {
            $product = Product::where('slug', $slug)->first();
            if (! $product) {
                continue;
            }

            ProductFile::updateOrCreate(
                ['product_id' => $product->id, 'path' => $data['path']],
                [
                    'label'      => $data['label'],
                    'disk'       => 'local',
                    'mime_type'  => 'application/pdf',
                    'size_bytes' => filesize(storage_path('app/private/'.$data['path'])),
                    'sort_order' => 0,
                ]
            );
        }
    }
}
