<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class CategoryContributionChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.category-contribution-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 6,
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
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $categories = $query
            ->select([
                DB::raw("COALESCE(categories.name, 'Tanpa Kategori') as name"),
                $metricSelect,
            ])
            ->groupByRaw("COALESCE(categories.name, 'Tanpa Kategori')")
            ->orderByDesc('metric_total')
            ->limit(5)
            ->get();

        $totalValue = (float) $categories->sum('metric_total');
        $maxValue = max((float) $categories->max('metric_total'), 1);

        $items = $categories
            ->values()
            ->map(function ($category, int $index) use ($metric, $totalValue, $maxValue): array {
                $value = (float) $category->metric_total;

                return [
                    'rank' => $index + 1,
                    'name' => (string) $category->name,
                    'value' => $value,
                    'formatted' => $this->formatMetricValue($metric, $value),
                    'width' => round(($value / $maxValue) * 100, 2),
                    'share' => $totalValue > 0 ? round(($value / $totalValue) * 100, 1) : 0,
                ];
            })
            ->toArray();

        $topCategory = $items[0] ?? null;

        return [
            'items' => $items,
            'metricLabel' => $this->getDashboardMetricLabel(),
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'topCategoryName' => $topCategory['name'] ?? '-',
            'topCategoryShare' => $topCategory['share'] ?? 0,
            'totalCategoryValue' => $this->formatMetricValue($metric, $totalValue),
        ];
    }

    private function formatMetricValue(string $metric, int|float $value): string
    {
        return match ($metric) {
            'revenue' => $this->formatRupiah((int) $value),
            'orders' => number_format((int) $value, 0, ',', '.') . ' order',
            'units' => number_format((int) $value, 0, ',', '.') . ' item',
            default => number_format((int) $value, 0, ',', '.') . ' item',
        };
    }

    private function formatRupiah(int $value): string
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}