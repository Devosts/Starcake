<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kue Kering' => [
                'slug' => 'kue-kering',
                'description' => 'Kue kering renyah dan tahan lama, cocok untuk oleh-oleh.',
                'image' => 'categories/kue-kering.svg',
                'sort_order' => 1,
            ],
            'Cake' => [
                'slug' => 'cake',
                'description' => 'Cake lembut berlapis krim dan cokelat untuk setiap momen spesial.',
                'image' => 'categories/cake.svg',
                'sort_order' => 2,
            ],
            'Roti' => [
                'slug' => 'roti',
                'description' => 'Roti fresh-baked setiap pagi, dari roti susu hingga roti bawang.',
                'image' => 'categories/roti.svg',
                'sort_order' => 3,
            ],
        ];

        Category::whereNotIn('slug', collect($categories)->pluck('slug'))->update(['is_active' => false]);

        foreach ($categories as $name => $data) {
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $name,
                    'description' => $data['description'],
                    'image' => $data['image'],
                    'is_active' => true,
                    'sort_order' => $data['sort_order'],
                ]
            );
        }

        $products = [
            [
                'name' => 'Black Forest',
                'category' => 'Cake',
                'sku' => 'CF001',
                'price' => 185000,
                'sale_price' => 165000,
                'is_sale' => true,
                'badge' => 'best',
                'is_featured' => true,
                'stock' => 25,
                'image' => 'products/black-forest.svg',
                'description' => 'Black forest lembut berlapis ganache dark chocolate dan whipped cream, dihiasi ceri segar di atasnya.',
                'meta' => ['weight' => '1500 g', 'dimensions' => '22x22x10 cm', 'calories' => '420 kkcal', 'servings' => '12'],
            ],
            [
                'name' => 'Bolu Kukus Gula Merah',
                'category' => 'Cake',
                'sku' => 'CF002',
                'price' => 60000,
                'badge' => 'new',
                'is_featured' => false,
                'stock' => 45,
                'image' => 'products/bolu-kukus-gula-merah.svg',
                'description' => 'Bolu kukus mekar dari gula merah asli, wangi karamel dan teksturnya lembut. Pas untuk teman minum teh.',
                'meta' => ['weight' => '350 g', 'dimensions' => '15x15x6 cm', 'calories' => '280 kkcal', 'servings' => '6'],
            ],
            [
                'name' => 'Garlic Bread',
                'category' => 'Roti',
                'sku' => 'RT001',
                'price' => 45000,
                'badge' => 'best',
                'is_featured' => true,
                'stock' => 30,
                'image' => 'products/garlic-bread.svg',
                'description' => 'Roti bawang gurih dengan mentega bawang putih dan parsley, dipanggang renyah keemasan.',
                'meta' => ['weight' => '300 g', 'dimensions' => '30x10x6 cm', 'calories' => '340 kkcal', 'servings' => '4'],
            ],
            [
                'name' => 'Japanese Milk Bread',
                'category' => 'Roti',
                'sku' => 'RT002',
                'price' => 55000,
                'badge' => 'new',
                'is_featured' => true,
                'stock' => 30,
                'image' => 'products/japanese-milk-bread.svg',
                'description' => 'Shokupan super fluffy — roti susu Jepang dengan mentega dan susu segar, potong tebal.',
                'meta' => ['weight' => '600 g', 'dimensions' => '25x12x12 cm', 'calories' => '260 kkcal', 'servings' => '10'],
            ],
            [
                'name' => 'Nastar',
                'category' => 'Kue Kering',
                'sku' => 'KK101',
                'price' => 95000,
                'badge' => 'best',
                'is_featured' => true,
                'stock' => 40,
                'unit' => 'toples',
                'image' => 'products/nastar.svg',
                'description' => 'Nastar lumer isi selai nanas homemade, dengan olesan butter yang glossy.',
                'meta' => ['weight' => '500 g (±40 pcs)', 'dimensions' => '-', 'calories' => '130 kkcal / pcs', 'servings' => '±40 pcs'],
            ],
            [
                'name' => 'Kastengel',
                'category' => 'Kue Kering',
                'sku' => 'KK102',
                'price' => 105000,
                'badge' => null,
                'is_featured' => false,
                'stock' => 40,
                'unit' => 'toples',
                'image' => 'products/kastengel.svg',
                'description' => 'Kastengel keju edam renyah dengan taburan keju parut melimpah di setiap batangnya.',
                'meta' => ['weight' => '500 g (±45 pcs)', 'dimensions' => '-', 'calories' => '140 kkcal / pcs', 'servings' => '±45 pcs'],
            ],
            [
                'name' => 'Putri Salju',
                'category' => 'Kue Kering',
                'sku' => 'KK103',
                'price' => 80000,
                'badge' => 'new',
                'is_featured' => false,
                'stock' => 40,
                'unit' => 'toples',
                'image' => 'products/putri-salju.svg',
                'description' => 'Kue sabit lumer di mulut, dibalut tepung gula halus yang tebal. Klasik yang selalu dirindukan.',
                'meta' => ['weight' => '450 g (±45 pcs)', 'dimensions' => '-', 'calories' => '120 kkcal / pcs', 'servings' => '±45 pcs'],
            ],
        ];

        Product::whereNotIn('sku', collect($products)->pluck('sku'))->update(['is_active' => false]);

        $categoryIds = Category::pluck('id', 'name');

        foreach ($products as $index => $p) {
            Product::updateOrCreate(
                ['sku' => $p['sku']],
                [
                    'category_id' => $categoryIds[$p['category']],
                    'name' => $p['name'],
                    'slug' => Str::slug($p['name']),
                    'image' => $p['image'],
                    'gallery' => [],
                    'unit' => $p['unit'] ?? 'pcs',
                    'stock' => $p['stock'],
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'] ?? null,
                    'is_sale' => $p['is_sale'] ?? false,
                    'badge' => $p['badge'] ?? null,
                    'is_featured' => $p['is_featured'] ?? false,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                    'description' => $p['description'],
                    'meta' => $p['meta'],
                ]
            );
        }
    }
}
