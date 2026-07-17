<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        return view('history');
    }

    public function list(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $dateFilter = $request->query('date_filter', 'today');
        $sort = $request->query('sort', 'latest');

        /*
        |--------------------------------------------------------------------------
        | Query untuk data tabel history
        |--------------------------------------------------------------------------
        | Data tabel tetap mengikuti filter yang dipilih user.
        | Default-nya adalah order hari ini.
        */
        $orders = Order::query()
            ->with('items')
            ->when($search, function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('order_code', 'like', '%' . $search . '%')
                        ->orWhereHas('items', function ($itemQuery) use ($search): void {
                            $itemQuery
                                ->where('product_name', 'like', '%' . $search . '%')
                                ->orWhere('size_name', 'like', '%' . $search . '%')
                                ->orWhere('note', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status && $status !== 'all', function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($dateFilter === 'today', function ($query): void {
                $query->whereDate('ordered_at', today());
            })
            ->when($dateFilter === 'yesterday', function ($query): void {
                $query->whereDate('ordered_at', today()->subDay());
            })
            ->when($dateFilter === 'week', function ($query): void {
                $query->whereBetween('ordered_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ]);
            })
            ->when($dateFilter === 'month', function ($query): void {
                $query->whereBetween('ordered_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth(),
                ]);
            })
            ->when($sort === 'latest', function ($query): void {
                $query->latest('ordered_at');
            })
            ->when($sort === 'oldest', function ($query): void {
                $query->oldest('ordered_at');
            })
            ->when($sort === 'highest', function ($query): void {
                $query->orderByDesc('total_price');
            })
            ->when($sort === 'lowest', function ($query): void {
                $query->orderBy('total_price');
            })
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Summary harian history
        |--------------------------------------------------------------------------
        | 3 kartu statistik ini hanya menghitung transaksi hari ini.
        | Besok otomatis reset karena berdasarkan ordered_at hari berjalan.
        */
        $todayOrders = Order::query()
            ->with('items')
            ->whereDate('ordered_at', today())
            ->get();

        $todayProductsSold = $todayOrders->sum(function (Order $order): int {
            return (int) $order->items->sum('quantity');
        });

        $todayTotalOrder = $todayOrders->count();

        $todayTotalSales = (int) $todayOrders->sum('total_price');

        return response()->json([
            'success' => true,
            'filter' => [
                'date_filter' => $dateFilter,
                'sort' => $sort,
            ],
            'data' => $orders->map(function (Order $order): array {
                return [
                    'id' => $order->id,
                    'order_code' => $order->order_code,
                    'total_item' => $order->total_item,
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'ordered_at' => optional($order->ordered_at)->format('Y-m-d H:i:s'),
                    'ordered_at_human' => optional($order->ordered_at)
                        ? Carbon::parse($order->ordered_at)->translatedFormat('d F Y H:i')
                        : '-',
                    'items' => $order->items->map(function ($item): array {
                        return [
                            'product_name' => $item->product_name,
                            'size' => $item->size_name,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'subtotal' => $item->subtotal,
                            'note' => $item->note,
                        ];
                    })->values(),
                ];
            })->values(),
            'summary' => [
                'today_products_sold' => $todayProductsSold,
                'today_total_order' => $todayTotalOrder,
                'today_total_sales' => $todayTotalSales,
            ],
        ]);
    }
}