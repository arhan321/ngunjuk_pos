<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

final class ProductController extends Controller
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
}
