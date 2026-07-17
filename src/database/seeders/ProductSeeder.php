<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $coffee = Category::firstOrCreate(
            ['slug' => 'coffee'],
            ['name' => 'Coffee', 'is_active' => true]
        );

        $tea = Category::firstOrCreate(
            ['slug' => 'tea'],
            ['name' => 'Tea', 'is_active' => true]
        );

        $yakult = Category::firstOrCreate(
            ['slug' => 'yakult'],
            ['name' => 'Yakult', 'is_active' => true]
        );

        $products = [
            [
                'category_id' => $coffee->id,
                'name' => 'Kopi Susu',
                'description' => 'Perpaduan kopi, susu, dan gula yang cocok untuk menu favorit pelanggan.',
                'stock' => 18,
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=500&q=80',
                'sizes' => [
                    ['name' => 'Small', 'price' => 5000, 'is_default' => true],
                    ['name' => 'Large', 'price' => 8000, 'is_default' => false],
                ],
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Kopi Gula Aren',
                'description' => 'Kopi susu dengan rasa manis gula aren yang ringan dan creamy.',
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=500&q=80',
                'sizes' => [
                    ['name' => 'Small', 'price' => 5000, 'is_default' => true],
                    ['name' => 'Large', 'price' => 8000, 'is_default' => false],
                ],
            ],
            [
                'category_id' => $coffee->id,
                'name' => 'Cappuccino Milk',
                'description' => 'Rasa cappuccino berpadu susu segar untuk pelanggan yang suka creamy.',
                'stock' => 0,
                'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=500&q=80',
                'sizes' => [
                    ['name' => 'Regular', 'price' => 12000, 'is_default' => true],
                ],
            ],
            [
                'category_id' => $tea->id,
                'name' => 'Es Teh Original',
                'description' => 'Es teh segar dengan rasa manis yang pas.',
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=500&q=80',
                'sizes' => [
                    ['name' => 'Regular', 'price' => 3000, 'is_default' => true],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $sizes = $productData['sizes'];
            unset($productData['sizes']);

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($productData['name'])],
                array_merge($productData, [
                    'slug' => Str::slug($productData['name']),
                    'is_active' => true,
                ])
            );

            $product->sizes()->delete();

            foreach ($sizes as $size) {
                $product->sizes()->create([
                    'name' => $size['name'],
                    'price' => $size['price'],
                    'is_default' => $size['is_default'],
                    'is_active' => true,
                ]);
            }
        }
    }
}