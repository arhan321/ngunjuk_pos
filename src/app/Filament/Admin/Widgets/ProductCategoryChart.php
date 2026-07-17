<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class ProductCategoryChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.product-category-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $metric = $this->getDashboardMetric();

        $metricSelect = match ($metric) {
            'orders' => DB::raw('COUNT(DISTINCT order_items.order_id) as metric_total'),
            'revenue' => DB::raw('SUM(order_items.subtotal) as metric_total'),
            'units' => DB::raw('SUM(order_items.quantity) as metric_total'),
            default => DB::raw('SUM(order_items.quantity) as metric_total'),
        };

        $query = OrderItem::query()
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $categorySales = $query
            ->select([
                'categories.name as name',
                $metricSelect,
            ])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('metric_total')
            ->get();

        $total = max((float) $categorySales->sum('metric_total'), 1);

        $colors = [
            '#22c55e',
            '#14b8a6',
            '#2dd4bf',
            '#0f766e',
            '#5eead4',
            '#3b82f6',
            '#f97316',
            '#a855f7',
            '#ef4444',
            '#eab308',
            '#06b6d4',
            '#ec4899',
        ];

        $data = $categorySales
            ->values()
            ->map(function ($category, int $index) use ($total, $colors): array {
                $count = (float) $category->metric_total;
                $percentage = ($count / $total) * 100;

                return [
                    'name' => $category->name,
                    'count' => $count,
                    'percentage' => round($percentage, 2),
                    'color' => $colors[$index % count($colors)],
                ];
            })
            ->toArray();

        return [
            'categories' => $data,
            'heading' => $this->getDashboardMetricLabel() . ' by Category - ' . $this->getDashboardPeriodLabel(),
            'metricLabel' => $this->getDashboardMetricLabel(),
        ];
    }
}