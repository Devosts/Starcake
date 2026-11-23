<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kue Kering' => 'Kue kering renyah dan tahan lama, cocok untuk oleh-oleh.',
            'Kue Basah' => 'Kue basah lembut, manis, dan lembut.',
            'Kue Ulang Tahun' => 'Kue spesial untuk perayaan ulang tahun.',
            'Kue Lebaran' => 'Kue tradisional ketika hari raya.',
            'Snack & Camilan' => 'Camilan ringan pendamping minum.',
        ];

        foreach ($categories as $name => $desc) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );
        }
    }
}
