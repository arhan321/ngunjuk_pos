<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function list(): JsonResponse
    {
        $products = Product::query()
            ->with([
                'category',
                'sizes' => function ($query): void {
                    $query->where('is_active', true)
                        ->orderByDesc('is_default')
                        ->orderBy('id');
                },
            ])
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function (Product $product): array {
                return [
                    'id' => $product->id,
                    'category_id' => $product->category_id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'stock' => $product->stock,
                    'image' => $product->image,
                    'is_active' => $product->is_active,

                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                        'slug' => $product->category->slug ?? null,
                    ] : null,

                    /*
                    |--------------------------------------------------------------------------
                    | Size dikirim ke POS tanpa HPP
                    |--------------------------------------------------------------------------
                    | HPP tidak boleh dikirim ke frontend kasir/POS karena itu data modal.
                    | POS cukup butuh id size, nama size, harga jual, dan status default.
                    */
                    'sizes' => $product->sizes
                        ->map(function ($size): array {
                            return [
                                'id' => $size->id,
                                'product_id' => $size->product_id,
                                'name' => $size->name,
                                'price' => (int) $size->price,
                                'is_default' => (bool) $size->is_default,
                                'is_active' => (bool) $size->is_active,
                            ];
                        })
                        ->values()
                        ->all(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string'],

            'sizes' => ['required', 'array', 'min:1'],
            'sizes.*.name' => ['required', 'string', 'max:50'],
            'sizes.*.price' => ['required', 'integer', 'min:0'],

            /*
            |--------------------------------------------------------------------------
            | Field HPP baru
            |--------------------------------------------------------------------------
            | Dibuat nullable agar tetap aman kalau ada request lama yang belum mengirim HPP.
            | Kalau tidak dikirim, otomatis disimpan 0.
            */
            'sizes.*.hpp' => ['nullable', 'integer', 'min:0'],

            'sizes.*.is_default' => ['nullable', 'boolean'],
            'sizes.*.is_active' => ['nullable', 'boolean'],
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'stock' => $validated['stock'],
            'image' => $validated['image'] ?? null,
            'is_active' => true,
        ]);

        foreach ($validated['sizes'] as $index => $size) {
            $product->sizes()->create([
                'name' => $size['name'],
                'price' => (int) $size['price'],
                'hpp' => (int) ($size['hpp'] ?? 0),
                'is_default' => (bool) ($size['is_default'] ?? $index === 0),
                'is_active' => (bool) ($size['is_active'] ?? true),
            ]);
        }

        $product->load(['category', 'sizes']);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'data' => [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'stock' => $product->stock,
                'image' => $product->image,
                'is_active' => $product->is_active,
                'category' => $product->category,
                'sizes' => $product->sizes,
            ],
        ]);
    }
}