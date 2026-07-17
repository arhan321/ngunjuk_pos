<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ProductPerformanceMatrix extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.product-performance-matrix';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 6,
        'xl' => 8,
    ];

    protected function getViewData(): array
    {
        $metric = $this->getDashboardMetric();
        $sortColumn = $this->getDashboardMetricSortColumn();

        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $products = $query
            ->select([
                'order_items.product_name as product_name',
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.subtotal) as revenue'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as orders_count'),
            ])
            ->groupBy('order_items.product_name')
            ->orderByDesc($sortColumn)
            ->limit(4)
            ->get();

        $totalMetric = (float) $products->sum($sortColumn);
        $maxMetric = max((float) $products->max($sortColumn), 1);

        $items = $products
            ->values()
            ->map(function ($product, int $index) use ($metric, $sortColumn, $totalMetric, $maxMetric): array {
                $metricValue = (float) $product->{$sortColumn};

                return [
                    'rank' => $index + 1,
                    'name' => (string) $product->product_name,
                    'units_sold' => (int) $product->units_sold,
                    'orders_count' => (int) $product->orders_count,
                    'revenue' => (int) $product->revenue,
                    'metric_value' => $metricValue,
                    'metric_formatted' => $this->formatMetricValue($metric, $metricValue),
                    'revenue_formatted' => $this->formatRupiah((int) $product->revenue),
                    'units_formatted' => number_format((int) $product->units_sold, 0, ',', '.') . ' item',
                    'orders_formatted' => number_format((int) $product->orders_count, 0, ',', '.') . ' order',
                    'bar_width' => round(($metricValue / $maxMetric) * 100, 2),
                    'contribution' => $totalMetric > 0
                        ? round(($metricValue / $totalMetric) * 100, 1)
                        : 0,
                ];
            })
            ->toArray();

        $bestProduct = $items[0] ?? null;

        return [
            'items' => $items,
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'activeMetric' => $metric,
            'activeMetricLabel' => $this->getDashboardMetricLabel(),
            'bestProductName' => $bestProduct['name'] ?? '-',
            'bestProductValue' => $bestProduct['metric_formatted'] ?? '-',
            'totalProductsAnalyzed' => count($items),
        ];
    }

    private function formatMetricValue(string $metric, float $value): string
    {
        return match ($metric) {
            'orders' => number_format((int) $value, 0, ',', '.') . ' order',
            'revenue' => $this->formatRupiah((int) $value),
            'units' => number_format((int) $value, 0, ',', '.') . ' item',
            default => number_format((int) $value, 0, ',', '.') . ' item',
        };
    }

    private function formatRupiah(int $value): string
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}