<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Pages\Page;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Throwable;

final class Dashboard extends Page
{
    public string $period = 'last_7_days';

    public string $customStartDate = '';

    public string $customEndDate = '';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = '';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 0;

    /**
     * Penting:
     * Di versi Filament project ini, property $view pada parent Page adalah NON-STATIC.
     * Jadi jangan pakai: protected static string $view
     */
    protected string $view = 'filament.admin.pages.dashboard';

    protected ?array $dashboardDataCache = null;

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public function mount(): void
    {
        $this->period = $this->normalizePeriod((string) request()->query('period', 'last_7_days'));

        $defaultStart = now()->subDays(6)->toDateString();
        $defaultEnd = now()->toDateString();

        $this->customStartDate = $this->normalizeDateString((string) request()->query('start_date', $defaultStart)) ?? $defaultStart;
        $this->customEndDate = $this->normalizeDateString((string) request()->query('end_date', $defaultEnd)) ?? $defaultEnd;

        if ($this->period === 'custom') {
            $this->syncCustomRangeOrder();
        }
    }

    public function setPeriod(string $period): void
    {
        $this->period = $this->normalizePeriod($period);

        if ($this->period === 'custom') {
            $this->syncCustomRangeOrder();
        }

        $this->refreshDashboardAfterFilterChange();
    }

    public function applyCustomRange(): void
    {
        $this->period = 'custom';
        $this->syncCustomRangeOrder();

        $this->refreshDashboardAfterFilterChange();
    }

    public function resetSmartFilter(): void
    {
        $this->period = 'last_7_days';
        $this->customStartDate = now()->subDays(6)->toDateString();
        $this->customEndDate = now()->toDateString();

        $this->refreshDashboardAfterFilterChange();
    }

    public function getColumns(): int|array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [];
    }

    public function getDashboardData(): array
    {
        if ($this->dashboardDataCache !== null) {
            return $this->dashboardDataCache;
        }

        [$start, $end, $periodLabel, $periodKey] = $this->getSelectedRange();
        [$previousStart, $previousEnd] = $this->getPreviousRange($start, $end, $periodKey);

        $chartGrouping = $this->getChartGrouping($start, $end, $periodKey);

        $revenue = (int) $this->ordersBetween($start, $end)->sum('total_price');
        $previousRevenue = (int) $this->ordersBetween($previousStart, $previousEnd)->sum('total_price');

        $totalOrders = (int) $this->ordersBetween($start, $end)->count();
        $previousOrders = (int) $this->ordersBetween($previousStart, $previousEnd)->count();

        $unitsSold = (int) $this->ordersBetween($start, $end)->sum('total_item');
        $previousUnits = (int) $this->ordersBetween($previousStart, $previousEnd)->sum('total_item');

        $totalProduct = (int) DB::table('products')
            ->where('is_active', true)
            ->count();

        return $this->dashboardDataCache = [
            'period' => [
                'key' => $periodKey,
                'label' => $periodLabel,
                'start' => $start->format('d M Y'),
                'end' => $end->format('d M Y'),
                'rangeLabel' => $this->formatPeriodRange($start, $end),
                'compareLabel' => 'Periode sebelumnya',
                'chartGrouping' => $chartGrouping,
                'chartGroupingLabel' => $this->getChartGroupingLabel($chartGrouping),
                'options' => $this->getPeriodOptions(),
                'customStartDate' => $this->customStartDate,
                'customEndDate' => $this->customEndDate,
            ],

            'metrics' => [
                [
                    'label' => 'Revenue',
                    'value' => $this->rupiah($revenue),
                    'trend' => $this->trendPercent($revenue, $previousRevenue),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▣',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Total Orders',
                    'value' => number_format($totalOrders, 0, ',', '.'),
                    'trend' => $this->trendPercent($totalOrders, $previousOrders),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▤',
                    'color' => '#3b82f6',
                ],
                [
                    'label' => 'Units Sold',
                    'value' => number_format($unitsSold, 0, ',', '.'),
                    'trend' => $this->trendPercent($unitsSold, $previousUnits),
                    'caption' => 'dari periode sebelumnya',
                    'icon' => '▰',
                    'color' => '#f59e0b',
                ],
                [
                    'label' => 'Total Product',
                    'value' => number_format($totalProduct, 0, ',', '.'),
                    'trend' => null,
                    'caption' => 'Produk aktif',
                    'icon' => '◇',
                    'color' => '#10b981',
                ],
            ],

            'charts' => [
                'revenue' => $this->getRevenueChart($start, $end, $chartGrouping),
                'topProducts' => $this->getProductSales($start, $end),
                'category' => $this->getCategoryContribution($start, $end),
                'salesByTime' => $this->getSalesByTime($start, $end),
            ],

            'latestOrders' => $this->getLatestOrders(),
        ];
    }

    public function rupiah(int|float|null $value): string
    {
        return 'Rp '.number_format((int) ($value ?? 0), 0, ',', '.');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    private function refreshDashboardAfterFilterChange(): void
    {
        $this->dashboardDataCache = null;

        $dashboard = $this->getDashboardData();

        $this->dispatch(
            'ng-dashboard-refresh',
            charts: $dashboard['charts'],
        );
    }

    private function getSelectedRange(): array
    {
        $period = $this->normalizePeriod($this->period);
        $now = now();

        return match ($period) {
            'today' => [
                $now->copy()->startOfDay(),
                $now->copy()->endOfDay(),
                'Hari Ini',
                'today',
            ],

            'yesterday' => [
                $now->copy()->subDay()->startOfDay(),
                $now->copy()->subDay()->endOfDay(),
                'Kemarin',
                'yesterday',
            ],

            'month' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfDay(),
                'Bulan Ini',
                'month',
            ],

            'year' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfDay(),
                'Tahun Ini',
                'year',
            ],

            'custom' => $this->getCustomRange(),

            default => [
                $now->copy()->subDays(6)->startOfDay(),
                $now->copy()->endOfDay(),
                '7 Hari Terakhir',
                'last_7_days',
            ],
        };
    }

    private function getCustomRange(): array
    {
        [$start, $end] = $this->getResolvedCustomDates();

        return [
            $start->copy()->startOfDay(),
            $end->copy()->endOfDay(),
            'Custom Range',
            'custom',
        ];
    }

    private function getResolvedCustomDates(): array
    {
        $start = $this->parseDate($this->customStartDate) ?? now()->subDays(6);
        $end = $this->parseDate($this->customEndDate) ?? now();

        if ($start->greaterThan($end)) {
            [$start, $end] = [$end, $start];
        }

        return [$start, $end];
    }

    private function syncCustomRangeOrder(): void
    {
        [$start, $end] = $this->getResolvedCustomDates();

        $this->customStartDate = $start->toDateString();
        $this->customEndDate = $end->toDateString();
    }

    private function parseDate(?string $date): ?Carbon
    {
        if (! is_string($date) || mb_trim($date) === '') {
            return null;
        }

        try {
            return Carbon::parse($date);
        } catch (Throwable) {
            return null;
        }
    }

    private function normalizeDateString(?string $date): ?string
    {
        return $this->parseDate($date)?->toDateString();
    }

    private function normalizePeriod(string $period): string
    {
        /*
        |--------------------------------------------------------------------------
        | Smart Period Filter
        |--------------------------------------------------------------------------
        | Opsi mingguan lama sudah dihapus dari tampilan filter karena fungsinya
        | digantikan oleh "7 Hari Terakhir". Mapping "week" tetap diterima agar
        | URL/cache lama tidak error, namun diarahkan ke last_7_days.
        */
        if ($period === 'week') {
            return 'last_7_days';
        }

        return in_array($period, ['today', 'yesterday', 'last_7_days', 'month', 'year', 'custom'], true)
            ? $period
            : 'last_7_days';
    }

    private function getPeriodOptions(): array
    {
        return [
            [
                'key' => 'today',
                'label' => 'Hari Ini',
                'caption' => 'Transaksi hari berjalan',
            ],
            [
                'key' => 'yesterday',
                'label' => 'Kemarin',
                'caption' => 'Transaksi satu hari sebelumnya',
            ],
            [
                'key' => 'last_7_days',
                'label' => '7 Hari Terakhir',
                'caption' => 'Rentang tujuh hari terakhir',
            ],
            [
                'key' => 'month',
                'label' => 'Bulan Ini',
                'caption' => 'Awal bulan sampai hari ini',
            ],
            [
                'key' => 'year',
                'label' => 'Tahun Ini',
                'caption' => 'Awal tahun sampai hari ini',
            ],
        ];
    }

    private function getPreviousRange(Carbon $start, Carbon $end, string $periodKey): array
    {
        if (in_array($periodKey, ['today', 'yesterday'], true)) {
            return [
                $start->copy()->subDay()->startOfDay(),
                $start->copy()->subDay()->endOfDay(),
            ];
        }

        if ($periodKey === 'month') {
            $days = $this->inclusiveDays($start, $end);
            $previousStart = $start->copy()->subMonthNoOverflow()->startOfMonth();
            $previousEnd = $previousStart->copy()->addDays($days - 1)->endOfDay();

            if ($previousEnd->greaterThan($previousStart->copy()->endOfMonth())) {
                $previousEnd = $previousStart->copy()->endOfMonth();
            }

            return [$previousStart, $previousEnd];
        }

        if ($periodKey === 'year') {
            return [
                $start->copy()->subYear()->startOfYear(),
                $end->copy()->subYear()->endOfDay(),
            ];
        }

        $days = $this->inclusiveDays($start, $end);
        $previousEnd = $start->copy()->subSecond();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [$previousStart, $previousEnd];
    }

    private function inclusiveDays(Carbon $start, Carbon $end): int
    {
        return max(1, ((int) floor($start->copy()->startOfDay()->diffInDays($end->copy()->startOfDay()))) + 1);
    }

    private function getChartGrouping(Carbon $start, Carbon $end, string $periodKey): string
    {
        if (in_array($periodKey, ['today', 'yesterday'], true)) {
            return 'hour';
        }

        if ($periodKey === 'year') {
            return 'month';
        }

        return $this->inclusiveDays($start, $end) > 31 ? 'month' : 'day';
    }

    private function getChartGroupingLabel(string $grouping): string
    {
        return match ($grouping) {
            'hour' => 'Per Jam',
            'month' => 'Per Bulan',
            default => 'Per Hari',
        };
    }

    private function formatPeriodRange(Carbon $start, Carbon $end): string
    {
        if ($start->isSameDay($end)) {
            return $start->format('d M Y');
        }

        if ($start->isSameMonth($end) && $start->isSameYear($end)) {
            return $start->format('d').' - '.$end->format('d M Y');
        }

        if ($start->isSameYear($end)) {
            return $start->format('d M').' - '.$end->format('d M Y');
        }

        return $start->format('d M Y').' - '.$end->format('d M Y');
    }

    private function ordersBetween(Carbon $start, Carbon $end): Builder
    {
        return DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            );
    }

    private function getRevenueChart(Carbon $start, Carbon $end, string $grouping): array
    {
        return match ($grouping) {
            'hour' => $this->getRevenueChartByHour($start, $end),
            'month' => $this->getRevenueChartByMonth($start, $end),
            default => $this->getRevenueChartByDay($start, $end),
        };
    }

    private function getRevenueChartByHour(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->selectRaw('HOUR(COALESCE(ordered_at, created_at)) as order_hour')
            ->selectRaw('SUM(total_price) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('order_hour')
            ->orderBy('order_hour')
            ->get()
            ->keyBy('order_hour');

        $labels = [];
        $revenue = [];
        $orders = [];

        for ($hour = 10; $hour <= 22; $hour++) {
            $labels[] = mb_str_pad((string) $hour, 2, '0', STR_PAD_LEFT).':00';
            $revenue[] = (int) ($rows[$hour]->revenue ?? 0);
            $orders[] = (int) ($rows[$hour]->orders ?? 0);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
        ];
    }

    private function getRevenueChartByDay(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->selectRaw('DATE(COALESCE(ordered_at, created_at)) as order_date')
            ->selectRaw('SUM(total_price) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get()
            ->keyBy('order_date');

        $labels = [];
        $revenue = [];
        $orders = [];
        $sameMonth = $start->isSameMonth($end) && $start->isSameYear($end);

        foreach (CarbonPeriod::create($start->copy()->startOfDay(), '1 day', $end->copy()->startOfDay()) as $date) {
            $key = $date->format('Y-m-d');
            $labels[] = $sameMonth ? $date->format('d') : $date->format('d M');
            $revenue[] = (int) ($rows[$key]->revenue ?? 0);
            $orders[] = (int) ($rows[$key]->orders ?? 0);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
        ];
    }

    private function getRevenueChartByMonth(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->selectRaw('YEAR(COALESCE(ordered_at, created_at)) as order_year')
            ->selectRaw('MONTH(COALESCE(ordered_at, created_at)) as order_month')
            ->selectRaw('SUM(total_price) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('order_year', 'order_month')
            ->orderBy('order_year')
            ->orderBy('order_month')
            ->get()
            ->keyBy(fn ($row): string => $row->order_year.'-'.mb_str_pad((string) $row->order_month, 2, '0', STR_PAD_LEFT));

        $labels = [];
        $revenue = [];
        $orders = [];
        $cursor = $start->copy()->startOfMonth();
        $lastMonth = $end->copy()->startOfMonth();
        $sameYear = $start->isSameYear($end);

        while ($cursor->lessThanOrEqualTo($lastMonth)) {
            $key = $cursor->format('Y-m');
            $labels[] = $sameYear ? $cursor->translatedFormat('M') : $cursor->translatedFormat('M Y');
            $revenue[] = (int) ($rows[$key]->revenue ?? 0);
            $orders[] = (int) ($rows[$key]->orders ?? 0);
            $cursor->addMonthNoOverflow();
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
        ];
    }

    private function getProductSales(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('COALESCE(order_items.product_name, products.name, "Produk") as name')
            ->selectRaw('COALESCE(categories.name, "Tanpa Kategori") as category')
            ->selectRaw('SUM(order_items.quantity) as units')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupByRaw('COALESCE(order_items.product_name, products.name, "Produk")')
            ->groupByRaw('COALESCE(categories.name, "Tanpa Kategori")')
            ->orderByDesc('units')
            ->get();

        $items = $rows->map(function ($row): array {
            return [
                'name' => (string) $row->name,
                'category' => (string) $row->category,
                'units' => (int) $row->units,
                'revenue' => (int) $row->revenue,
            ];
        })->values()->all();

        return [
            'items' => $items,
            'labels' => $rows->pluck('name')->values()->all(),
            'units' => $rows->pluck('units')->map(fn ($value): int => (int) $value)->values()->all(),
            'revenue' => $rows->pluck('revenue')->map(fn ($value): int => (int) $value)->values()->all(),
        ];
    }

    private function getCategoryContribution(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('COALESCE(categories.name, "Lainnya") as name')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupByRaw('COALESCE(categories.name, "Lainnya")')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        if ($rows->isEmpty()) {
            return [
                'labels' => ['Belum ada data'],
                'values' => [1],
                'summary' => [
                    [
                        'name' => 'Belum ada data',
                        'percentage' => 0,
                        'revenue' => 0,
                    ],
                ],
            ];
        }

        $total = max(1, (int) $rows->sum('revenue'));

        return [
            'labels' => $rows->pluck('name')->values()->all(),
            'values' => $rows->pluck('revenue')->map(fn ($value): int => (int) $value)->values()->all(),
            'summary' => $rows->map(function ($row) use ($total): array {
                return [
                    'name' => $row->name,
                    'percentage' => round(((int) $row->revenue / $total) * 100),
                    'revenue' => (int) $row->revenue,
                ];
            })->values()->all(),
        ];
    }

    private function getSalesByTime(Carbon $start, Carbon $end): array
    {
        $rows = DB::table('orders')
            ->selectRaw('HOUR(COALESCE(ordered_at, created_at)) as hour')
            ->selectRaw('COUNT(*) as orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $labels = [];
        $orders = [];

        for ($hour = 10; $hour <= 22; $hour++) {
            $labels[] = mb_str_pad((string) $hour, 2, '0', STR_PAD_LEFT).':00';
            $orders[] = (int) ($rows[$hour]->orders ?? 0);
        }

        return [
            'labels' => $labels,
            'orders' => $orders,
        ];
    }

    private function getLatestOrders(): array
    {
        return DB::table('orders')
            ->select('order_code', 'total_item', 'total_price', 'status', 'ordered_at', 'created_at')
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->limit(5)
            ->get()
            ->map(function ($order): array {
                $time = Carbon::parse($order->ordered_at ?? $order->created_at);

                return [
                    'order_code' => $order->order_code,
                    'time' => $time->format('d M Y H:i'),
                    'items' => (int) $order->total_item,
                    'total' => (int) $order->total_price,
                    'status' => $order->status,
                ];
            })
            ->values()
            ->all();
    }

    private function trendPercent(int|float $current, int|float $previous): ?float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
