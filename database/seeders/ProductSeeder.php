<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug')->toArray();

        $products = [
            [
                'name' => 'Brownie Kukus Coklat',
                'slug' => 'brownie-kukus-coklat',
                'category' => 'Kue Basah',
                'sku' => 'BK001',
                'price' => 75000,
                'sale_price' => 65000,
                'is_sale' => true,
                'badge' => 'best',
                'is_featured' => true,
                'stock' => 30,
                'unit' => 'pcs',
                'meta' => ['weight' => '450 g', 'dimensions' => '18x18x5 cm', 'calories' => '380 kkcal', 'servings' => '8'],
                'image' => 'https://picsum.photos/seed/brownie/600/600',
                'gallery' => ['https://picsum.photos/seed/brownie-1/600/600', 'https://picsum.photos/seed/brownie-2/600/600'],
                'description' => 'Brownie kukus lembut dengan tekstur empuk dan coklat yang kaya.',
            ],
            [
                'name' => 'Kue Lapis Legit',
                'slug' => 'kue-lapis-legit',
                'category' => 'Kue Basah',
                'sku' => 'BK002',
                'price' => 95000,
                'sale_price' => 85000,
                'is_sale' => true,
                'badge' => 'best',
                'is_featured' => true,
                'stock' => 20,
                'unit' => 'pcs',
                'meta' => ['weight' => '550 g', 'dimensions' => '20x20x6 cm', 'calories' => '420 kkcal', 'servings' => '10'],
                'image' => 'https://picsum.photos/seed/lapis/600/600',
                'gallery' => ['https://picsum.photos/seed/lapis-1/600/600'],
                'description' => 'Kue lapis legit klasik dengan lapisan telur yang kecoklatan.',
            ],
            [
                'name' => 'Kue Kering Kacang Rolade',
                'slug' => 'kue-kering-kacang-rolade',
                'category' => 'Kue Kering',
                'sku' => 'KK001',
                'price' => 45000,
                'badge' => 'new',
                'is_featured' => true,
                'stock' => 50,
                'unit' => 'pcs',
                'meta' => ['weight' => '100 g (5 pcs)', 'dimensions' => '-', 'calories' => '120 kkcal', 'servings' => '1'],
                'image' => 'https://picsum.photos/seed/rolade/600/600',
                'gallery' => [],
                'description' => 'Kue kering kacang dengan tekstur renyah, cocok untuk oleh-oleh.',
            ],
            [
                'name' => 'Kue Birthday Karakter',
                'slug' => 'kue-birthday-karakter',
                'category' => 'Kue Ulang Tahun',
                'sku' => 'KK002',
                'price' => 350000,
                'badge' => 'sale',
                'is_featured' => true,
                'stock' => 8,
                'unit' => 'pcs',
                'meta' => ['weight' => '1500 g', 'dimensions' => '30x30x12 cm', 'calories' => '500 kkcal', 'servings' => '15'],
                'image' => 'https://picsum.photos/seed/birthday/600/600',
                'gallery' => [],
                'description' => 'Kue ulang tahun custom karakter, cocok untuk si kecil.',
            ],
            [
                'name' => 'Lemper Ayam',
                'slug' => 'lemper-ayam',
                'category' => 'Snack & Camilan',
                'sku' => 'KS001',
                'price' => 12000,
                'badge' => 'new',
                'stock' => 40,
                'unit' => 'pcs',
                'meta' => ['weight' => '80 g', 'dimensions' => '10x5x3 cm', 'calories' => '220 kkcal', 'servings' => '1'],
                'image' => 'https://picsum.photos/seed/lemper/600/600',
                'gallery' => [],
                'description' => 'Lemper isi ayam kecap pedas, kulitnya kenyal dan gurih.',
            ],
            [
                'name' => 'Kue Kering Coklat Chip',
                'slug' => 'kue-kering-coklat-chip',
                'category' => 'Kue Kering',
                'sku' => 'KK003',
                'price' => 55000,
                'badge' => 'best',
                'stock' => 35,
                'unit' => 'pcs',
                'meta' => ['weight' => '120 g (4 pcs)', 'dimensions' => '-', 'calories' => '180 kkcal', 'servings' => '1'],
                'image' => 'https://picsum.photos/seed/chip/600/600',
                'gallery' => [],
                'description' => 'Cookie coklat chip dengan tepung komplek.',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['sku' => $p['sku']], [
                'category_id' => $categories[$p['category']] ?? ($categories['Kue Basah'] ?? 1),
                'name' => $p['name'],
                'slug' => $p['slug'],
                'image' => $p['image'],
                'gallery' => $p['gallery'] ?? [],
                'unit' => $p['unit'],
                'stock' => $p['stock'],
                'price' => $p['price'],
                'sale_price' => $p['sale_price'] ?? null,
                'is_sale' => $p['is_sale'] ?? false,
                'badge' => $p['badge'] ?? null,
                'is_featured' => $p['is_featured'] ?? false,
                'is_active' => true,
                'sort_order' => 0,
                'description' => $p['description'],
                'meta' => $p['meta'],
            ]);
        }

    }
}
