<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class PosStatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 6;
    }

    protected function getStats(): array
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $todayOrdersQuery = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $todayStart,
                $todayEnd,
            ]);

        $todayRevenue = (int) (clone $todayOrdersQuery)->sum('total_price');
        $todayOrders = (int) (clone $todayOrdersQuery)->count();
        $todayUnitsSold = (int) (clone $todayOrdersQuery)->sum('total_item');

        $todayAvgOrder = $todayOrders > 0
            ? (int) round($todayRevenue / $todayOrders)
            : 0;

        $totalProduct = Product::query()->count();
        $totalCategory = Category::query()->count();

        $outOfStockProduct = Product::query()
            ->where('stock', '<=', 0)
            ->count();

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Pendapatan hari ini')
                ->descriptionIcon('heroicon-o-banknotes', IconPosition::After)
                ->color('success'),

            Stat::make('Total Orders', number_format($todayOrders, 0, ',', '.'))
                ->description('Jumlah transaksi hari ini')
                ->descriptionIcon('heroicon-o-shopping-bag', IconPosition::After)
                ->color('primary'),

            Stat::make('Units Sold', number_format($todayUnitsSold, 0, ',', '.'))
                ->description('Item terjual hari ini')
                ->descriptionIcon('heroicon-o-chart-bar', IconPosition::After)
                ->color('warning'),

            Stat::make('Total Product', number_format($totalProduct, 0, ',', '.'))
                ->description(number_format($totalCategory, 0, ',', '.') . ' kategori')
                ->descriptionIcon('heroicon-o-tag', IconPosition::After)
                ->color('primary'),

            Stat::make('Stok Habis', number_format($outOfStockProduct, 0, ',', '.'))
                ->description('Produk perlu restock')
                ->descriptionIcon('heroicon-o-exclamation-triangle', IconPosition::After)
                ->color('danger'),

            Stat::make('Avg Order', 'Rp ' . number_format($todayAvgOrder, 0, ',', '.'))
                ->description('Rata-rata order hari ini')
                ->descriptionIcon('heroicon-o-presentation-chart-bar', IconPosition::After)
                ->color('gray'),
        ];
    }
}