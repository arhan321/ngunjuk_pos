<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardLuxuryOverviewWidget extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.dashboard-luxury-overview-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        [$start, $end] = $this->getDashboardPeriodRange();
        [$previousStart, $previousEnd] = $this->getPreviousDashboardPeriodRange();

        $currentOrdersQuery = Order::query()
            ->where('status', 'Selesai');

        $this->applyCustomPeriodFilterToOrderQuery($currentOrdersQuery, $start, $end);

        $previousOrdersQuery = Order::query()
            ->where('status', 'Selesai');

        $this->applyCustomPeriodFilterToOrderQuery($previousOrdersQuery, $previousStart, $previousEnd);

        $currentRevenue = (int) (clone $currentOrdersQuery)->sum('total_price');
        $currentOrders = (int) (clone $currentOrdersQuery)->count();
        $currentUnitsSold = (int) (clone $currentOrdersQuery)->sum('total_item');

        $previousRevenue = (int) (clone $previousOrdersQuery)->sum('total_price');
        $previousOrders = (int) (clone $previousOrdersQuery)->count();
        $previousUnitsSold = (int) (clone $previousOrdersQuery)->sum('total_item');

        $totalProducts = (int) Product::query()->count();
        $totalCategories = (int) Category::query()->count();

        $outOfStockProducts = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $lowStockProducts = Product::query()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(6)
            ->get(['id', 'name', 'stock']);

        $activeMetric = $this->getDashboardMetric();

        return [
            'summary' => [
                'period_revenue' => $currentRevenue,
                'period_orders' => $currentOrders,
                'period_units_sold' => $currentUnitsSold,
                'total_products' => $totalProducts,
                'total_categories' => $totalCategories,
                'out_of_stock_products' => $outOfStockProducts,
            ],

            'trends' => [
                'orders' => $this->calculateGrowthPercentage($currentOrders, $previousOrders),
                'revenue' => $this->calculateGrowthPercentage($currentRevenue, $previousRevenue),
                'units' => $this->calculateGrowthPercentage($currentUnitsSold, $previousUnitsSold),
            ],

            'topProductsChart' => $this->getTopProductsChart($start, $end, $activeMetric),
            'revenueTrendChart' => $this->getRevenueTrendChart(),

            'lowStockProducts' => $lowStockProducts,

            'kpiVisuals' => [
                'orders' => $this->getKpiTrendVisual('orders'),
                'units' => $this->getKpiTrendVisual('units'),
                'revenue' => $this->getKpiTrendVisual('revenue'),
                'stock' => $this->getStockHealthVisual(),
            ],

            'activeMetric' => $activeMetric,
            'activePeriod' => $this->getDashboardPeriod(),
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'periodOptions' => $this->getDashboardPeriodOptions(),

            'metrics' => [
                'orders' => [
                    'label' => 'Orders',
                    'description' => 'Visualisasi berdasarkan jumlah transaksi',
                ],
                'revenue' => [
                    'label' => 'Revenue',
                    'description' => 'Visualisasi berdasarkan pendapatan',
                ],
                'units' => [
                    'label' => 'Units Sold',
                    'description' => 'Visualisasi berdasarkan item terjual',
                ],
            ],
        ];
    }

    private function getKpiTrendVisual(string $metric): array
    {
        $period = $this->getDashboardPeriod();

        [$labels, $ranges] = match ($period) {
            'today' => $this->getKpiHourlyRanges(),
            'week' => $this->getKpiDailyRangesForCurrentWeek(),
            'month' => $this->getKpiWeeklyRangesForCurrentMonth(),
            'year' => $this->getKpiMonthlyRangesForCurrentYear(),
            'all' => $this->getKpiLastSixMonthsRanges(),
            default => $this->getKpiHourlyRanges(),
        };

        $items = [];
        $maxValue = 1;

        foreach ($ranges as $index => $range) {
            [$start, $end] = $range;

            $query = Order::query()
                ->where('status', 'Selesai')
                ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [$start, $end]);

            $value = match ($metric) {
                'orders' => (int) $query->count(),
                'revenue' => (int) $query->sum('total_price'),
                'units' => (int) $query->sum('total_item'),
                default => 0,
            };

            $maxValue = max($maxValue, $value);

            $items[] = [
                'label' => $labels[$index] ?? '',
                'value' => $value,
                'height' => 0,
            ];
        }

        foreach ($items as $index => $item) {
            $items[$index]['height'] = $maxValue > 0
                ? max(round(((float) $item['value'] / $maxValue) * 100, 2), $item['value'] > 0 ? 8 : 0)
                : 0;
        }

        return [
            'items' => $items,
            'max_value' => $maxValue,
        ];
    }

    private function getStockHealthVisual(): array
    {
        $safeStock = (int) Product::query()
            ->where('stock', '>', 5)
            ->count();

        $lowStock = (int) Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $outOfStock = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $total = max($safeStock + $lowStock + $outOfStock, 1);

        return [
            'safe' => round(($safeStock / $total) * 100, 1),
            'low' => round(($lowStock / $total) * 100, 1),
            'out' => round(($outOfStock / $total) * 100, 1),
            'safe_count' => $safeStock,
            'low_count' => $lowStock,
            'out_count' => $outOfStock,
        ];
    }

    private function getKpiHourlyRanges(): array
    {
        $labels = [];
        $ranges = [];

        for ($hour = 7; $hour <= 22; $hour++) {
            $time = now()->copy()->startOfDay()->addHours($hour);

            $labels[] = $time->format('H');
            $ranges[] = [
                $time->copy()->startOfHour(),
                $time->copy()->endOfHour(),
            ];
        }

        return [$labels, $ranges];
    }

    private function getKpiDailyRangesForCurrentWeek(): array
    {
        $labels = [];
        $ranges = [];

        $startOfWeek = now()->copy()->startOfWeek();

        for ($day = 0; $day < 7; $day++) {
            $date = $startOfWeek->copy()->addDays($day);

            $labels[] = $date->format('D');
            $ranges[] = [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay(),
            ];
        }

        return [$labels, $ranges];
    }

    private function getKpiWeeklyRangesForCurrentMonth(): array
    {
        $labels = [];
        $ranges = [];

        $cursor = now()->copy()->startOfMonth();
        $endOfMonth = now()->copy()->endOfMonth();
        $weekIndex = 1;

        while ($cursor->lte($endOfMonth)) {
            $start = $cursor->copy()->startOfDay();
            $end = $cursor->copy()->addDays(6)->endOfDay();

            if ($end->gt($endOfMonth)) {
                $end = $endOfMonth->copy()->endOfDay();
            }

            $labels[] = 'W' . $weekIndex;
            $ranges[] = [$start, $end];

            $cursor->addWeek();
            $weekIndex++;
        }

        return [$labels, $ranges];
    }

    private function getKpiMonthlyRangesForCurrentYear(): array
    {
        $labels = [];
        $ranges = [];

        for ($monthIndex = 0; $monthIndex < 12; $monthIndex++) {
            $month = now()->copy()->startOfYear()->addMonths($monthIndex);

            $labels[] = $month->format('M');
            $ranges[] = [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ];
        }

        return [$labels, $ranges];
    }

    private function getKpiLastSixMonthsRanges(): array
    {
        $labels = [];
        $ranges = [];

        for ($monthIndex = 5; $monthIndex >= 0; $monthIndex--) {
            $month = now()->copy()->subMonths($monthIndex);

            $labels[] = $month->format('M');
            $ranges[] = [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ];
        }

        return [$labels, $ranges];
    }

    private function getTopProductsChart(?Carbon $start, ?Carbon $end, string $metric): array
    {
        $metricSelect = match ($metric) {
            'orders' => DB::raw('COUNT(DISTINCT order_items.order_id) as metric_total'),
            'revenue' => DB::raw('SUM(order_items.subtotal) as metric_total'),
            'units' => DB::raw('SUM(order_items.quantity) as metric_total'),
            default => DB::raw('SUM(order_items.quantity) as metric_total'),
        };

        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyCustomPeriodFilterToOrderQuery($query, $start, $end);

        $products = $query
            ->select([
                'order_items.product_name as name',
                $metricSelect,
            ])
            ->groupBy('order_items.product_name')
            ->orderByDesc('metric_total')
            ->limit(10)
            ->get();

        $maxValue = max((float) $products->max('metric_total'), 1);

        $items = $products->values()->map(function ($product) use ($metric, $maxValue): array {
            $value = (float) $product->metric_total;

            return [
                'name' => $product->name,
                'value' => $value,
                'formatted_value' => match ($metric) {
                    'revenue' => 'Rp ' . number_format((int) $value, 0, ',', '.'),
                    'orders' => number_format((int) $value, 0, ',', '.') . ' order',
                    'units' => number_format((int) $value, 0, ',', '.') . ' item',
                    default => number_format((int) $value, 0, ',', '.') . ' item',
                },
                'width' => round(($value / $maxValue) * 100, 2),
            ];
        })->toArray();

        return [
            'title' => 'Top 10 Product by ' . $this->getDashboardMetricLabel(),
            'metric_label' => $this->getDashboardMetricLabel(),
            'items' => $items,
            'max_value' => $maxValue,
        ];
    }

    private function getRevenueTrendChart(): array
    {
        $period = $this->getDashboardPeriod();
        $series = [];

        switch ($period) {
            case 'today':
                for ($i = 7; $i >= 0; $i--) {
                    $hour = now()->copy()->subHours($i);

                    $series[] = [
                        'label' => $hour->format('H:i'),
                        'value' => $this->getRevenueBetween(
                            $hour->copy()->startOfHour(),
                            $hour->copy()->endOfHour(),
                        ),
                    ];
                }
                break;

            case 'week':
                $startOfWeek = now()->copy()->startOfWeek();

                for ($i = 0; $i < 7; $i++) {
                    $day = $startOfWeek->copy()->addDays($i);

                    $series[] = [
                        'label' => $day->format('D'),
                        'value' => $this->getRevenueBetween(
                            $day->copy()->startOfDay(),
                            $day->copy()->endOfDay(),
                        ),
                    ];
                }
                break;

            case 'month':
                $cursor = now()->copy()->startOfMonth();
                $endOfMonth = now()->copy()->endOfMonth();
                $weekIndex = 1;

                while ($cursor->lte($endOfMonth)) {
                    $segmentStart = $cursor->copy()->startOfDay();
                    $segmentEnd = $cursor->copy()->addDays(6)->endOfDay();

                    if ($segmentEnd->gt($endOfMonth)) {
                        $segmentEnd = $endOfMonth->copy()->endOfDay();
                    }

                    $series[] = [
                        'label' => 'W' . $weekIndex,
                        'value' => $this->getRevenueBetween($segmentStart, $segmentEnd),
                    ];

                    $cursor->addWeek();
                    $weekIndex++;
                }
                break;

            case 'year':
                for ($i = 0; $i < 12; $i++) {
                    $month = now()->copy()->startOfYear()->addMonths($i);

                    $series[] = [
                        'label' => $month->format('M'),
                        'value' => $this->getRevenueBetween(
                            $month->copy()->startOfMonth(),
                            $month->copy()->endOfMonth(),
                        ),
                    ];
                }
                break;

            case 'all':
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->copy()->subMonths($i);

                    $series[] = [
                        'label' => $month->format('M y'),
                        'value' => $this->getRevenueBetween(
                            $month->copy()->startOfMonth(),
                            $month->copy()->endOfMonth(),
                        ),
                    ];
                }
                break;

            default:
                for ($i = 7; $i >= 0; $i--) {
                    $hour = now()->copy()->subHours($i);

                    $series[] = [
                        'label' => $hour->format('H:i'),
                        'value' => $this->getRevenueBetween(
                            $hour->copy()->startOfHour(),
                            $hour->copy()->endOfHour(),
                        ),
                    ];
                }
                break;
        }

        $values = array_map(
            fn (array $point): float => (float) $point['value'],
            $series,
        );

        return [
            'series' => $series,
            'trend_values' => $this->calculateTrendLineValues($values),
            'max_value' => max($values ?: [1]),
            'min_value' => min($values ?: [0]),
        ];
    }

    private function getRevenueBetween(Carbon $start, Carbon $end): int
    {
        $query = Order::query()
            ->where('status', 'Selesai');

        $this->applyCustomPeriodFilterToOrderQuery($query, $start, $end);

        return (int) $query->sum('total_price');
    }

    private function calculateTrendLineValues(array $values): array
    {
        $count = count($values);

        if ($count <= 1) {
            return $values;
        }

        $sumX = 0;
        $sumY = 0;
        $sumXY = 0;
        $sumXX = 0;

        foreach ($values as $index => $value) {
            $x = $index + 1;
            $y = (float) $value;

            $sumX += $x;
            $sumY += $y;
            $sumXY += ($x * $y);
            $sumXX += ($x * $x);
        }

        $denominator = ($count * $sumXX) - ($sumX * $sumX);

        if ($denominator === 0) {
            return $values;
        }

        $slope = (($count * $sumXY) - ($sumX * $sumY)) / $denominator;
        $intercept = ($sumY - ($slope * $sumX)) / $count;

        $trendValues = [];

        foreach ($values as $index => $value) {
            $x = $index + 1;
            $trendValues[] = max(0, round($intercept + ($slope * $x), 2));
        }

        return $trendValues;
    }
}