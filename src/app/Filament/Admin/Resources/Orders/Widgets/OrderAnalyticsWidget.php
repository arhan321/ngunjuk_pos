<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final class OrderAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.orders.widgets.order-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $filter = $this->activeFilterState();
        $range = $this->dateRange($filter['period'], $filter['month'], $filter['year']);

        $periodOrders = $this->applyRange(Order::query(), $range);
        $finishedPeriodOrders = $this->applyRange(Order::query()->where('status', 'Selesai'), $range);

        $totalRevenue = (int) (clone $finishedPeriodOrders)->sum('total_price');
        $totalOrders = (int) (clone $periodOrders)->count();
        $finishedOrdersCount = (int) (clone $finishedPeriodOrders)->count();
        $unitsSold = (int) (clone $finishedPeriodOrders)->sum('total_item');

        $avgOrder = $finishedOrdersCount > 0
            ? (int) round($totalRevenue / $finishedOrdersCount)
            : 0;

        $todayOrders = (int) Order::query()
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->count();

        $todayRevenue = (int) Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                now()->startOfDay(),
                now()->endOfDay(),
            ])
            ->sum('total_price');

        $latestOrder = (clone $periodOrders)
            ->latest('ordered_at')
            ->first();

        $statusCounts = (clone $periodOrders)
            ->select('status', DB::raw('COUNT(*) as aggregate'))
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->toArray();

        return [
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'units_sold' => $unitsSold,
                'avg_order' => $avgOrder,
                'today_orders' => $todayOrders,
                'today_revenue' => $todayRevenue,
                'latest_order_code' => $latestOrder?->order_code ?? '-',
                'latest_order_time' => $latestOrder?->ordered_at?->format('d M Y H:i') ?? '-',
                'status_counts' => [
                    'Selesai' => (int) ($statusCounts['Selesai'] ?? 0),
                    'Diproses' => (int) ($statusCounts['Diproses'] ?? 0),
                    'Dibatalkan' => (int) ($statusCounts['Dibatalkan'] ?? 0),
                ],
            ],
            'period' => [
                'key' => $filter['period'],
                'label' => $this->periodLabel($filter['period'], $filter['month'], $filter['year']),
                'date_range' => $this->dateRangeLabel($range),
                'selected_month' => $filter['month'],
                'selected_year' => $filter['year'],
            ],
            'filters' => [
                'months' => $this->months(),
                'years' => range(now()->year - 4, now()->year + 1),
                'periods' => [
                    'today' => 'Hari Ini',
                    'month' => 'Bulanan',
                ],
            ],
            'links' => [
                'orders' => url('/admin/orders'),
            ],
        ];
    }

    protected function applyRange(Builder $query, array $range): Builder
    {
        return $query->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), $range);
    }

    protected function activeFilterState(): array
    {
        $hasFilterRequest = request()->has('period') || request()->has('month') || request()->has('year');

        $period = $hasFilterRequest
            ? (string) request()->input('period', request()->query('period', 'month'))
            : (string) session('ng_order_filter.period', 'month');

        if (! in_array($period, ['today', 'month'], true)) {
            $period = 'month';
        }

        $month = $hasFilterRequest
            ? (int) request()->input('month', request()->query('month', session('ng_order_filter.month', now()->month)))
            : (int) session('ng_order_filter.month', now()->month);

        $year = $hasFilterRequest
            ? (int) request()->input('year', request()->query('year', session('ng_order_filter.year', now()->year)))
            : (int) session('ng_order_filter.year', now()->year);

        $month = min(12, max(1, $month));
        $year = min(now()->year + 2, max(now()->year - 10, $year));

        session([
            'ng_order_filter.period' => $period,
            'ng_order_filter.month' => $month,
            'ng_order_filter.year' => $year,
        ]);

        return [
            'period' => $period,
            'month' => $month,
            'year' => $year,
        ];
    }

    protected function dateRange(string $period, int $month, int $year): array
    {
        if ($period === 'today') {
            return [
                now()->startOfDay(),
                now()->endOfDay(),
            ];
        }

        return [
            Carbon::create($year, $month, 1)->startOfMonth(),
            Carbon::create($year, $month, 1)->endOfMonth(),
        ];
    }

    protected function dateRangeLabel(array $range): string
    {
        $start = Carbon::parse($range[0]);
        $end = Carbon::parse($range[1]);

        if ($start->isSameDay($end)) {
            return $start->format('d M Y');
        }

        return $start->format('d M Y').' - '.$end->format('d M Y');
    }

    protected function periodLabel(string $period, int $month, int $year): string
    {
        if ($period === 'today') {
            return 'Hari Ini';
        }

        return ($this->months()[$month] ?? 'Bulan').' '.$year;
    }

    protected function months(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}
