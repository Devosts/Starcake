<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyKatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kue Ulang Tahun Premium' => 'Kue spesial untuk momen paling berharga.',
            'Kue Kering Spesial' => 'Kue kering renyah dengan cita rasa istimewa.',
            'Cake Custom' => 'Cake custom sesuai selera dan tema acaramu.',
        ];

        foreach ($categories as $name => $desc) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'image' => null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]
            );
        }

        $products = [
            [
                'name' => 'Red Velvet Premium Deluxe',
                'category' => 'Kue Ulang Tahun Premium',
                'sku' => 'DUM001',
                'price' => 385000,
                'sale_price' => 349000,
                'is_sale' => true,
                'badge' => 'best',
                'stock' => 12,
                'unit' => 'pcs',
                'image' => 'https://picsum.photos/seed/redvelvet-dummy/600/600',
                'gallery' => ['https://picsum.photos/seed/redvelvet-dummy-1/600/600'],
                'description' => 'Red velvet lembut berlapis cream cheese icing premium, wajib dicoba.',
                'meta' => ['weight' => '1200 g', 'dimensions' => '22x22x8 cm', 'calories' => '380 kkal', 'servings' => '12'],
            ],
            [
                'name' => 'Nastar Keju Spesial',
                'category' => 'Kue Kering Spesial',
                'sku' => 'DUM002',
                'price' => 65000,
                'badge' => 'best',
                'stock' => 40,
                'unit' => 'pcs',
                'image' => 'https://picsum.photos/seed/nastar-dummy/600/600',
                'gallery' => [],
                'description' => 'Nastar isi selai nanas dengan taburan keju yang gurih dan lumer di mulut.',
                'meta' => ['weight' => '150 g (10 pcs)', 'dimensions' => '-', 'calories' => '220 kkal', 'servings' => '2'],
            ],
            [
                'name' => 'Mini Cake Custom',
                'category' => 'Cake Custom',
                'sku' => 'DUM003',
                'price' => 175000,
                'badge' => 'best',
                'stock' => 20,
                'unit' => 'pcs',
                'image' => 'https://picsum.photos/seed/minicake-dummy/600/600',
                'gallery' => ['https://picsum.photos/seed/minicake-dummy-1/600/600'],
                'description' => 'Mini cake dengan desain custom sesuai keinginanmu, cocok untuk hadiah kecil.',
                'meta' => ['weight' => '500 g', 'dimensions' => '12x12x8 cm', 'calories' => '300 kkal', 'servings' => '4'],
            ],
        ];

        $categoriesBySlug = Category::pluck('id', 'slug')->toArray();

        foreach ($products as $p) {
            Product::updateOrCreate(['sku' => $p['sku']], [
                'category_id' => $categoriesBySlug[Str::slug($p['category'])] ?? null,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'sku' => $p['sku'],
                'image' => $p['image'],
                'gallery' => $p['gallery'] ?? [],
                'unit' => $p['unit'],
                'stock' => $p['stock'],
                'price' => $p['price'],
                'sale_price' => $p['sale_price'] ?? null,
                'is_sale' => $p['is_sale'] ?? false,
                'badge' => $p['badge'] ?? null,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 0,
                'description' => $p['description'],
                'meta' => $p['meta'],
            ]);
        }
    }
}
