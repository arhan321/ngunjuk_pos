<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

final class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.product_size_id' => ['required', 'exists:product_sizes,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.note' => ['nullable', 'string', 'max:120'],
        ]);

        try {
            $order = DB::transaction(function () use ($validated): Order {
                $order = Order::create([
                    'order_code' => $this->generateOrderCode(),
                    'total_item' => 0,
                    'total_price' => 0,
                    'status' => 'Selesai',
                    'ordered_at' => now(),
                ]);

                $totalItem = 0;
                $totalPrice = 0;

                foreach ($validated['items'] as $item) {
                    $product = Product::query()
                        ->lockForUpdate()
                        ->findOrFail($item['product_id']);

                    $productSize = ProductSize::query()
                        ->where('product_id', $product->id)
                        ->where('is_active', true)
                        ->findOrFail($item['product_size_id']);

                    $quantity = (int) $item['quantity'];

                    /*
                    |--------------------------------------------------------------------------
                    | Harga Jual dan HPP
                    |--------------------------------------------------------------------------
                    | price = harga jual produk berdasarkan size.
                    | hpp = estimasi modal / HPP per cup berdasarkan size.
                    |
                    | Nilai HPP disimpan sebagai snapshot ke order_items.
                    | Jadi kalau HPP produk berubah di kemudian hari, transaksi lama tetap aman.
                    */
                    $price = (int) $productSize->price;
                    $hpp = (int) ($productSize->hpp ?? 0);

                    $subtotal = $price * $quantity;
                    $totalHpp = $hpp * $quantity;
                    $grossProfit = $subtotal - $totalHpp;

                    $note = isset($item['note']) && mb_trim((string) $item['note']) !== ''
                        ? mb_trim((string) $item['note'])
                        : null;

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_size_id' => $productSize->id,
                        'product_name' => $product->name,
                        'size_name' => $productSize->name,
                        'price' => $price,
                        'hpp' => $hpp,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                        'total_hpp' => $totalHpp,
                        'gross_profit' => $grossProfit,
                        'note' => $note,
                    ]);

                    $totalItem += $quantity;
                    $totalPrice += $subtotal;
                }

                $order->update([
                    'total_item' => $totalItem,
                    'total_price' => $totalPrice,
                ]);

                return $order->load('items');
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan.',
                'data' => $order,
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan transaksi.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    private function generateOrderCode(): string
    {
        $date = now()->format('Ymd');

        $lastOrder = Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->latest('id')
            ->first();

        $nextNumber = 1;

        if ($lastOrder) {
            $nextNumber = ((int) mb_substr($lastOrder->order_code, -4)) + 1;
        }

        return 'ORD-'.$date.'-'.mb_str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
