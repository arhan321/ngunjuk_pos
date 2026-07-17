<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardDummySeeder extends Seeder
{
    /**
     * Target omzet dummy 3 bulan.
     *
     * Data dibuat untuk April, Mei, dan Juni 2026.
     * Total revenue dibuat di atas 15 juta dan tertinggi sekitar 25 juta.
     */
    private array $monthlyTargets = [
        '2026-04' => 16_800_000,
        '2026-05' => 20_700_000,
        '2026-06' => 24_300_000,
    ];

    public function run(): void
    {
        DB::transaction(function (): void {
            $this->deleteOldDummyOrders();

            $this->ensureDummyProductsExist();

            $products = Product::query()
                ->with([
                    'sizes' => function ($query): void {
                        $query
                            ->where('is_active', true)
                            ->orderByDesc('is_default')
                            ->orderBy('price');
                    },
                ])
                ->where('is_active', true)
                ->whereHas('sizes', function ($query): void {
                    $query->where('is_active', true);
                })
                ->get();

            if ($products->isEmpty()) {
                throw new \RuntimeException('Tidak ada produk aktif dengan ukuran aktif. Seeder dummy dashboard dibatalkan.');
            }

            foreach ($this->monthlyTargets as $month => $targetRevenue) {
                $this->generateMonthlyOrders($month, $targetRevenue, $products);
            }

            $this->setStockForDashboardVisualization();
        });
    }

    private function deleteOldDummyOrders(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus order dummy lama saja
        |--------------------------------------------------------------------------
        | Data asli tidak ikut terhapus karena hanya order_code dengan prefix DUMMY-
        | yang dihapus.
        */
        $dummyOrderIds = Order::query()
            ->where('order_code', 'like', 'DUMMY-%')
            ->pluck('id');

        if ($dummyOrderIds->isNotEmpty()) {
            OrderItem::query()
                ->whereIn('order_id', $dummyOrderIds)
                ->delete();

            Order::query()
                ->whereIn('id', $dummyOrderIds)
                ->delete();
        }
    }

    private function ensureDummyProductsExist(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Produk dummy dashboard
        |--------------------------------------------------------------------------
        | Kalau produk sudah ada, tidak dibuat ulang.
        | Kalau belum ada, seeder akan membuat kategori, produk, dan ukuran.
        */
        $menus = [
            'Coffee' => [
                ['Kopi Gula Aren', 15000, 18000],
                ['Kopi Susu', 14000, 17000],
                ['Kopi Item', 10000, 13000],
                ['Cappuccino Milk', 18000, 22000],
                ['Latte Vanilla', 18000, 23000],
            ],
            'Smoothies' => [
                ['Strawberry Smoothies', 18000, 24000],
                ['Blueberry Smoothie', 19000, 25000],
                ['Mango Smoothie', 18000, 24000],
                ['Avocado Smoothie', 20000, 26000],
            ],
            'Cheese Series' => [
                ['Taro Cheese', 17000, 22000],
                ['Ovaltine Cheese', 18000, 23000],
                ['Matcha Cheese', 19000, 24000],
                ['Chocolate Cheese', 18000, 23000],
            ],
            'Yakult Series' => [
                ['Leci Yakult', 16000, 21000],
                ['Mango Yakult', 16000, 21000],
                ['Anggur Ocean', 16000, 21000],
            ],
            'Tea Series' => [
                ['Lemon Tea', 10000, 14000],
                ['Milk Tea', 13000, 17000],
                ['Thai Tea', 14000, 18000],
                ['Green Tea', 14000, 18000],
            ],
        ];

        foreach ($menus as $categoryName => $products) {
            $category = Category::query()->firstOrCreate(
                [
                    'slug' => Str::slug($categoryName),
                ],
                [
                    'name' => $categoryName,
                    'is_active' => true,
                ]
            );

            if (! $category->is_active) {
                $category->update([
                    'is_active' => true,
                ]);
            }

            foreach ($products as [$productName, $regularPrice, $largePrice]) {
                $product = Product::query()->firstOrCreate(
                    [
                        'slug' => Str::slug($productName),
                    ],
                    [
                        'category_id' => $category->id,
                        'name' => $productName,
                        'description' => 'Menu dummy untuk visualisasi dashboard POS Ngunjuk.',
                        'stock' => 300,
                        'image' => null,
                        'is_active' => true,
                    ]
                );

                if (! $product->wasRecentlyCreated) {
                    $product->update([
                        'category_id' => $category->id,
                        'name' => $productName,
                        'description' => $product->description ?: 'Menu dummy untuk visualisasi dashboard POS Ngunjuk.',
                        'is_active' => true,
                    ]);
                }

                ProductSize::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'name' => 'Regular',
                    ],
                    [
                        'price' => $regularPrice,
                        'is_default' => true,
                        'is_active' => true,
                    ]
                );

                ProductSize::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'name' => 'Large',
                    ],
                    [
                        'price' => $largePrice,
                        'is_default' => false,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function generateMonthlyOrders(string $month, int $targetRevenue, $products): void
    {
        $monthStart = Carbon::parse($month . '-01')->startOfMonth();
        $monthEnd = Carbon::parse($month . '-01')->endOfMonth();

        $orderIndex = 1;
        $currentRevenue = 0;

        while ($currentRevenue < $targetRevenue) {
            $remaining = $targetRevenue - $currentRevenue;

            $orderedAt = $this->randomBusinessDateTime($monthStart, $monthEnd);

            $orderItems = $this->buildRandomOrderItems($products, $remaining);

            if (empty($orderItems)) {
                break;
            }

            $totalItem = (int) collect($orderItems)->sum('quantity');
            $totalPrice = (int) collect($orderItems)->sum('subtotal');

            if ($totalPrice <= 0) {
                break;
            }

            /*
            |--------------------------------------------------------------------------
            | Hindari omzet lewat terlalu jauh dari target
            |--------------------------------------------------------------------------
            | Kalau sisa target kecil, sistem membuat order kecil.
            */
            if ($currentRevenue + $totalPrice > $targetRevenue + 50_000) {
                $orderItems = $this->buildSmallFinalOrder($products, $remaining);

                if (empty($orderItems)) {
                    break;
                }

                $totalItem = (int) collect($orderItems)->sum('quantity');
                $totalPrice = (int) collect($orderItems)->sum('subtotal');
            }

            $order = Order::query()->create([
                'order_code' => sprintf('DUMMY-%s-%04d', str_replace('-', '', $month), $orderIndex),
                'total_item' => $totalItem,
                'total_price' => $totalPrice,
                'status' => 'Selesai',
                'ordered_at' => $orderedAt,
                'created_at' => $orderedAt,
                'updated_at' => $orderedAt,
            ]);

            foreach ($orderItems as $item) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_size_id' => $item['product_size_id'],
                    'product_name' => $item['product_name'],
                    'size_name' => $item['size_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => $orderedAt,
                    'updated_at' => $orderedAt,
                ]);
            }

            $currentRevenue += $totalPrice;
            $orderIndex++;

            /*
            |--------------------------------------------------------------------------
            | Safety stop
            |--------------------------------------------------------------------------
            | Mencegah loop terlalu panjang jika ada kondisi tidak normal.
            */
            if ($orderIndex > 3000) {
                break;
            }
        }
    }

    private function buildRandomOrderItems($products, int $remaining): array
    {
        $items = [];
        $itemCount = random_int(1, 4);

        for ($i = 0; $i < $itemCount; $i++) {
            $product = $this->pickWeightedProduct($products);
            $size = $product->sizes->random();

            $quantity = random_int(1, 4);

            /*
            |--------------------------------------------------------------------------
            | Produk populer dibuat lebih sering laku
            |--------------------------------------------------------------------------
            | Ini membantu visualisasi:
            | - Top Product Performance
            | - Product Performance Quadrant
            | - Category Contribution
            */
            if (in_array($product->name, [
                'Kopi Gula Aren',
                'Strawberry Smoothies',
                'Taro Cheese',
                'Mango Yakult',
                'Cappuccino Milk',
            ], true)) {
                $quantity += random_int(1, 2);
            }

            $subtotal = (int) $size->price * $quantity;

            if ($subtotal > $remaining + 100_000 && $remaining > 0) {
                $quantity = max(1, (int) floor($remaining / max((int) $size->price, 1)));
                $subtotal = (int) $size->price * $quantity;
            }

            if ($quantity <= 0 || $subtotal <= 0) {
                continue;
            }

            $items[] = [
                'product_id' => $product->id,
                'product_size_id' => $size->id,
                'product_name' => $product->name,
                'size_name' => $size->name,
                'price' => (int) $size->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return $items;
    }

    private function buildSmallFinalOrder($products, int $remaining): array
    {
        $availableItems = [];

        foreach ($products as $product) {
            foreach ($product->sizes as $size) {
                if ((int) $size->price <= max($remaining, 10_000)) {
                    $availableItems[] = [
                        'product' => $product,
                        'size' => $size,
                    ];
                }
            }
        }

        if (empty($availableItems)) {
            $product = $products->random();
            $size = $product->sizes->sortBy('price')->first();
        } else {
            $selected = collect($availableItems)->random();
            $product = $selected['product'];
            $size = $selected['size'];
        }

        $quantity = max(1, min(3, (int) floor($remaining / max((int) $size->price, 1))));

        if ($quantity <= 0) {
            $quantity = 1;
        }

        return [
            [
                'product_id' => $product->id,
                'product_size_id' => $size->id,
                'product_name' => $product->name,
                'size_name' => $size->name,
                'price' => (int) $size->price,
                'quantity' => $quantity,
                'subtotal' => (int) $size->price * $quantity,
            ],
        ];
    }

    private function pickWeightedProduct($products): Product
    {
        /*
        |--------------------------------------------------------------------------
        | Bobot produk
        |--------------------------------------------------------------------------
        | Beberapa produk dibuat dominan agar grafik dashboard punya pola.
        */
        $popularNames = [
            'Kopi Gula Aren',
            'Strawberry Smoothies',
            'Taro Cheese',
            'Mango Yakult',
            'Cappuccino Milk',
            'Thai Tea',
        ];

        if (random_int(1, 100) <= 65) {
            $popularProducts = $products->filter(
                fn (Product $product): bool => in_array($product->name, $popularNames, true)
            );

            if ($popularProducts->isNotEmpty()) {
                return $popularProducts->random();
            }
        }

        return $products->random();
    }

    private function randomBusinessDateTime(Carbon $monthStart, Carbon $monthEnd): Carbon
    {
        /*
        |--------------------------------------------------------------------------
        | Fix TypeError random_int
        |--------------------------------------------------------------------------
        | diffInDays pada versi Carbon tertentu bisa terbaca float,
        | jadi harus dipaksa menjadi integer.
        */
        $totalDays = (int) floor($monthStart->diffInDays($monthEnd));

        $date = $monthStart
            ->copy()
            ->addDays(random_int(0, max($totalDays, 0)));

        /*
        |--------------------------------------------------------------------------
        | Jam operasional dummy
        |--------------------------------------------------------------------------
        | Dibuat padat pada jam 10-21 agar Sales Heatmap terlihat jelas.
        */
        $weightedHours = [
            8, 9,
            10, 10, 10,
            11, 11,
            12, 12, 12,
            13, 13,
            14,
            15, 15,
            16, 16,
            17, 17, 17,
            18, 18, 18,
            19, 19, 19,
            20, 20,
            21,
            22,
        ];

        $hour = $weightedHours[array_rand($weightedHours)];

        return $date
            ->setHour($hour)
            ->setMinute(random_int(0, 59))
            ->setSecond(random_int(0, 59));
    }

    private function setStockForDashboardVisualization(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Stok dibuat bervariasi
        |--------------------------------------------------------------------------
        | Supaya widget Stock Risk tetap terlihat:
        | - produk kritis
        | - produk rendah
        | - produk waspada
        | - mayoritas produk aman
        */
        Product::query()->update([
            'stock' => 80,
            'is_active' => true,
        ]);

        $stockMap = [
            'Cappuccino Milk' => 0,
            'Strawberry Smoothies' => 1,
            'Kopi Item' => 2,
            'Kopi Gula Aren' => 4,
            'Kopi Susu' => 5,
            'Taro Cheese' => 12,
            'Mango Yakult' => 18,
            'Thai Tea' => 25,
        ];

        foreach ($stockMap as $productName => $stock) {
            Product::query()
                ->where('name', $productName)
                ->update([
                    'stock' => $stock,
                    'is_active' => true,
                ]);
        }
    }
}