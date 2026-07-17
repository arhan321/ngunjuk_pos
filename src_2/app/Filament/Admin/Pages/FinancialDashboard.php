<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use UnitEnum;

final class FinancialDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';

    protected static string|UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Analisis Keuangan';

    protected static ?string $title = 'Dashboard Keuangan';

    protected static ?string $slug = 'dashboard-keuangan';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.admin.pages.financial-dashboard';

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getFinancialDashboardData(): array
    {
        [$start, $end, $periodLabel, $periodKey, $selectedMonth, $selectedYear, $isYearMonthDetail] = $this->getSelectedRange();

        $revenue = $this->revenueBetween($start, $end);

        $finance = $this->financeBetween($start, $end);

        $totalHpp = $finance['total_hpp'];
        $grossProfit = $finance['gross_profit'];

        $operationalCost = $this->operationalCostBetween($start, $end);

        $netProfit = $grossProfit - $operationalCost;

        /*
        |--------------------------------------------------------------------------
        | Monthly Target Sync
        |--------------------------------------------------------------------------
        | Target tidak dibuat otomatis. Dashboard hanya membaca target dari
        | menu Target Penjualan sesuai bulan aktif yang sedang dipilih.
        */
        $target = $this->targetForMonth($start);
        $targetRevenue = (int) ($target?->target_revenue ?? 0);
        $targetGrossProfit = (int) ($target?->target_gross_profit ?? 0);
        $targetNetProfit = (int) ($target?->target_net_profit ?? 0);

        $targetRevenueActual = $revenue;
        $targetGrossProfitActual = $grossProfit;
        $targetNetProfitActual = $netProfit;

        $revenueProgress = $this->progressPercent($targetRevenueActual, $targetRevenue);
        $grossProfitProgress = $this->progressPercent($targetGrossProfitActual, $targetGrossProfit);
        $netProfitProgress = $this->progressPercent($targetNetProfitActual, $targetNetProfit);

        $remainingRevenueTarget = max($targetRevenue - $targetRevenueActual, 0);
        $remainingGrossProfitTarget = max($targetGrossProfit - $targetGrossProfitActual, 0);
        $remainingNetProfitTarget = max($targetNetProfit - $targetNetProfitActual, 0);

        $profitMargin = $revenue > 0 ? round(($grossProfit / $revenue) * 100, 1) : 0;

        return [
            'period' => [
                'key' => $periodKey,
                'label' => $periodLabel,
                'start' => $start->format('d M Y'),
                'end' => $end->format('d M Y'),
                'start_query' => $start->toDateString(),
                'end_query' => $end->toDateString(),
                'selected_month' => $selectedMonth,
                'selected_year' => $selectedYear,
                'is_year_month_detail' => $isYearMonthDetail,
            ],
            'filters' => [
                'periods' => [
                    'month' => 'Bulanan',
                ],
                'months' => $this->monthFilterOptions(),
                'selected_month' => $selectedMonth,
                'selected_year' => $selectedYear,
            ],
            'metrics' => [
                [
                    'label' => 'Revenue',
                    'value' => $this->rupiah($revenue),
                    'trend' => null,
                    'caption' => 'Total penjualan periode ini',
                    'icon' => '▣',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Total HPP',
                    'value' => $this->rupiah($totalHpp),
                    'trend' => null,
                    'caption' => 'Modal produk terjual',
                    'icon' => '∑',
                    'color' => '#14b8a6',
                ],
                [
                    'label' => 'Gross Profit',
                    'value' => $this->rupiah($grossProfit),
                    'trend' => null,
                    'caption' => 'Revenue dikurangi HPP',
                    'icon' => '▥',
                    'color' => '#22c55e',
                ],
                [
                    'label' => 'Biaya Operasional',
                    'value' => $this->rupiah($operationalCost),
                    'trend' => null,
                    'caption' => 'Sesuai tanggal bayar dan tipe biaya',
                    'icon' => '⌁',
                    'color' => '#ef4444',
                ],
                [
                    'label' => 'Net Profit',
                    'value' => $this->rupiah($netProfit),
                    'trend' => null,
                    'caption' => 'Gross profit dikurangi biaya',
                    'icon' => '◆',
                    'color' => $netProfit >= 0 ? '#16a34a' : '#dc2626',
                ],
                [
                    'label' => 'Profit Margin',
                    'value' => $profitMargin.'%',
                    'trend' => null,
                    'caption' => 'Persentase laba kotor',
                    'icon' => '◎',
                    'color' => '#8b5cf6',
                ],
                [
                    'label' => 'Target Revenue',
                    'value' => $targetRevenue > 0 ? $revenueProgress.'%' : '0%',
                    'trend' => null,
                    'caption' => $targetRevenue > 0 ? 'Sisa '.$this->rupiah($remainingRevenueTarget) : 'Target belum diatur',
                    'icon' => '⚑',
                    'color' => '#f97316',
                ],
                [
                    'label' => 'Target Gross Profit',
                    'value' => $targetGrossProfit > 0 ? $grossProfitProgress.'%' : '0%',
                    'trend' => null,
                    'caption' => $targetGrossProfit > 0 ? 'Sisa '.$this->rupiah($remainingGrossProfitTarget) : 'Target belum diatur',
                    'icon' => '◈',
                    'color' => '#22c55e',
                ],
                [
                    'label' => 'Target Net Profit',
                    'value' => $targetNetProfit > 0 ? $netProfitProgress.'%' : '0%',
                    'trend' => null,
                    'caption' => $targetNetProfit > 0 ? 'Sisa '.$this->rupiah($remainingNetProfitTarget) : 'Target belum diatur',
                    'icon' => '◉',
                    'color' => '#6366f1',
                ],
            ],
            'summary' => [
                'revenue' => $revenue,
                'total_hpp' => $totalHpp,
                'gross_profit' => $grossProfit,
                'operational_cost' => $operationalCost,
                'net_profit' => $netProfit,
                'profit_margin' => $profitMargin,
                'target_revenue' => $targetRevenue,
                'target_gross_profit' => $targetGrossProfit,
                'target_net_profit' => $targetNetProfit,
                'target_revenue_actual' => $revenue,
                'target_gross_profit_actual' => $grossProfit,
                'target_net_profit_actual' => $netProfit,
                'target_revenue_remaining' => $remainingRevenueTarget,
                'target_gross_profit_remaining' => $remainingGrossProfitTarget,
                'target_net_profit_remaining' => $remainingNetProfitTarget,
            ],
            'revenueTrend' => $this->getRevenueTrendData($start, $end, $periodKey, $selectedMonth, $selectedYear),
            'costs' => $this->getOperationalCostList($start, $end),
            'productMargins' => $this->getProductMarginList($start, $end),
            'yearlyDetails' => $this->getYearlyDetails($selectedYear),
            'links' => [
                'operational_costs' => $this->safeAdminUrl('operational-costs'),
                'sales_targets' => $this->safeAdminUrl('sales-targets'),
                'products' => $this->safeAdminUrl('products'),
                'dashboard_keuangan' => $this->safeAdminUrl('dashboard-keuangan'),
            ],
        ];
    }

    public function rupiah(int|float|null $value): string
    {
        return 'Rp '.number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private function getSelectedRange(): array
    {
        /*
        |--------------------------------------------------------------------------
        | Monthly Financial Dashboard
        |--------------------------------------------------------------------------
        | Dashboard keuangan dibuat fokus bulanan supaya target, revenue,
        | gross profit, biaya operasional, net profit, grafik, dan rincian biaya
        | selalu berada pada konteks bulan yang sama.
        */

        $selectedYear = (int) request()->query('year', now()->year);
        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        $selectedMonth = (int) request()->query('month', now()->month);
        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        $start = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();
        $end = $start->copy()->endOfMonth();

        return [
            $start,
            $end,
            $this->monthName($selectedMonth).' '.$selectedYear,
            'month',
            (string) $selectedMonth,
            $selectedYear,
            false,
        ];
    }

    private function getPreviousRange(Carbon $start, Carbon $end, string $periodKey, string $selectedMonth = 'all'): array
    {

        if ($periodKey === 'custom') {
            $days = max(1, ((int) floor($start->diffInDays($end))) + 1);
            $previousEnd = $start->copy()->subSecond();
            $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

            return [$previousStart, $previousEnd];
        }

        if ($periodKey === 'today') {
            return [
                $start->copy()->subDay()->startOfDay(),
                $start->copy()->subDay()->endOfDay(),
            ];
        }

        if ($periodKey === 'month') {
            return [
                $start->copy()->subMonthNoOverflow()->startOfMonth(),
                $start->copy()->subMonthNoOverflow()->endOfMonth(),
            ];
        }

        if ($periodKey === 'year') {
            if ($this->isValidMonthValue($selectedMonth)) {
                return [
                    $start->copy()->subYear()->startOfMonth(),
                    $start->copy()->subYear()->endOfMonth(),
                ];
            }

            return [
                $start->copy()->subYear()->startOfYear(),
                $start->copy()->subYear()->endOfYear(),
            ];
        }

        $days = max(1, ((int) floor($start->diffInDays($end))) + 1);
        $previousEnd = $start->copy()->subSecond();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [$previousStart, $previousEnd];
    }

    private function revenueBetween(Carbon $start, Carbon $end): int
    {
        if (! Schema::hasTable('orders')) {
            return 0;
        }

        $revenueColumn = Schema::hasColumn('orders', 'total_price') ? 'total_price' : 'total_amount';

        if (! Schema::hasColumn('orders', $revenueColumn)) {
            return 0;
        }

        return (int) $this->ordersBetween($start, $end)->sum($revenueColumn);
    }

    private function ordersBetween(Carbon $start, Carbon $end)
    {
        $query = DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            );

        if (Schema::hasColumn('orders', 'status')) {
            $query->where('status', '!=', 'Dibatalkan');
        }

        return $query;
    }

    private function financeBetween(Carbon $start, Carbon $end): array
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasTable('orders')) {
            return [
                'total_hpp' => 0,
                'gross_profit' => 0,
            ];
        }

        $hasTotalHpp = Schema::hasColumn('order_items', 'total_hpp');
        $hasHpp = Schema::hasColumn('order_items', 'hpp');
        $hasQuantity = Schema::hasColumn('order_items', 'quantity');
        $hasSubtotal = Schema::hasColumn('order_items', 'subtotal');

        $totalHppExpression = match (true) {
            $hasTotalHpp => 'COALESCE(SUM(order_items.total_hpp), 0)',
            $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.hpp * order_items.quantity), 0)',
            default => '0',
        };

        $grossProfitExpression = match (true) {
            $hasSubtotal && $hasTotalHpp => 'COALESCE(SUM(order_items.subtotal - order_items.total_hpp), 0)',
            $hasSubtotal && $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.subtotal - (order_items.hpp * order_items.quantity)), 0)',
            $hasSubtotal => 'COALESCE(SUM(order_items.subtotal), 0)',
            default => '0',
        };

        $query = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            );

        if (Schema::hasColumn('orders', 'status')) {
            $query->where('orders.status', '!=', 'Dibatalkan');
        }

        $finance = $query
            ->selectRaw($totalHppExpression.' as total_hpp')
            ->selectRaw($grossProfitExpression.' as gross_profit')
            ->first();

        return [
            'total_hpp' => (int) ($finance->total_hpp ?? 0),
            'gross_profit' => (int) ($finance->gross_profit ?? 0),
        ];
    }

    private function operationalCostBetween(Carbon $start, Carbon $end): int
    {
        return (int) $this->operationalCostRowsForPeriod($start, $end)->sum('amount');
    }

    private function getRevenueTrendData(Carbon $start, Carbon $end, string $periodKey, string $selectedMonth = 'all', ?int $selectedYear = null): array
    {
        if (! Schema::hasTable('orders')) {
            return [];
        }

        $revenueColumn = Schema::hasColumn('orders', 'total_price') ? 'total_price' : 'total_amount';

        if (! Schema::hasColumn('orders', $revenueColumn)) {
            return [];
        }

        $dateExpression = 'COALESCE(ordered_at, created_at)';

        $query = DB::table('orders')
            ->whereBetween(DB::raw($dateExpression), [
                $start->toDateTimeString(),
                $end->toDateTimeString(),
            ]);

        if (Schema::hasColumn('orders', 'status')) {
            $query->where('status', '!=', 'Dibatalkan');
        }

        if ($periodKey === 'today') {
            $bucketExpression = 'HOUR('.$dateExpression.')';

            $rows = $query
                ->selectRaw($bucketExpression.' as bucket')
                ->selectRaw('COALESCE(SUM('.$revenueColumn.'), 0) as total')
                ->groupBy(DB::raw($bucketExpression))
                ->pluck('total', 'bucket');

            $data = [];

            for ($hour = 0; $hour <= 23; $hour++) {
                $data[] = [
                    'label' => mb_str_pad((string) $hour, 2, '0', STR_PAD_LEFT).':00',
                    'short_label' => mb_str_pad((string) $hour, 2, '0', STR_PAD_LEFT),
                    'tooltip_label' => mb_str_pad((string) $hour, 2, '0', STR_PAD_LEFT).':00',
                    'value' => (int) ($rows[$hour] ?? 0),
                ];
            }

            return $data;
        }

        if ($periodKey === 'year' && ! $this->isValidMonthValue($selectedMonth)) {
            $bucketExpression = 'MONTH('.$dateExpression.')';

            $rows = $query
                ->selectRaw($bucketExpression.' as bucket')
                ->selectRaw('COALESCE(SUM('.$revenueColumn.'), 0) as total')
                ->groupBy(DB::raw($bucketExpression))
                ->pluck('total', 'bucket');

            $year = $selectedYear ?: $start->year;
            $data = [];

            for ($month = 1; $month <= 12; $month++) {
                $monthDate = Carbon::create($year, $month, 1);

                $data[] = [
                    'label' => $monthDate->translatedFormat('M'),
                    'short_label' => $monthDate->translatedFormat('M'),
                    'tooltip_label' => $monthDate->translatedFormat('F Y'),
                    'value' => (int) ($rows[$month] ?? 0),
                ];
            }

            return $data;
        }

        $bucketExpression = 'DATE('.$dateExpression.')';

        $rows = $query
            ->selectRaw($bucketExpression.' as bucket')
            ->selectRaw('COALESCE(SUM('.$revenueColumn.'), 0) as total')
            ->groupBy(DB::raw($bucketExpression))
            ->pluck('total', 'bucket');

        /*
        |--------------------------------------------------------------------------
        | Monthly dashboard: compact weekly revenue bars
        |--------------------------------------------------------------------------
        */
        if ($periodKey === 'month') {
            $data = [];
            $cursor = $start->copy()->startOfDay();
            $weekIndex = 1;

            while ($cursor->lte($end)) {
                $weekStart = $cursor->copy()->startOfDay();
                $weekEnd = $cursor->copy()->addDays(6)->startOfDay();

                if ($weekEnd->gt($end)) {
                    $weekEnd = $end->copy()->startOfDay();
                }

                $total = 0;
                $dayCursor = $weekStart->copy();

                while ($dayCursor->lte($weekEnd)) {
                    $total += (int) ($rows[$dayCursor->toDateString()] ?? 0);
                    $dayCursor->addDay();
                }

                $tooltipLabel = $weekStart->translatedFormat('d M').' - '.$weekEnd->translatedFormat('d M Y');

                $data[] = [
                    'label' => 'Minggu '.$weekIndex,
                    'short_label' => 'M'.$weekIndex,
                    'tooltip_label' => $tooltipLabel,
                    'value' => $total,
                ];

                $cursor = $weekEnd->copy()->addDay()->startOfDay();
                $weekIndex++;
            }

            return $data;
        }

        $data = [];
        $cursor = $start->copy()->startOfDay();

        while ($cursor->lte($end)) {
            $key = $cursor->toDateString();

            $data[] = [
                'label' => $cursor->translatedFormat('d M'),
                'short_label' => $cursor->format('d'),
                'tooltip_label' => $cursor->translatedFormat('d M Y'),
                'value' => (int) ($rows[$key] ?? 0),
            ];

            $cursor->addDay();
        }

        return $data;
    }

    private function targetForRange(Carbon $start, Carbon $end, string $periodKey, string $selectedMonth = 'all'): ?object
    {
        if (! Schema::hasTable('sales_targets')) {
            return null;
        }

        return $this->targetForMonth($start);
    }

    private function targetForMonth(Carbon $date): ?object
    {
        if (! Schema::hasTable('sales_targets')) {
            return null;
        }

        return DB::table('sales_targets')
            ->whereDate('month', $date->copy()->startOfMonth()->toDateString())
            ->first();
    }

    private function getOperationalCostList(Carbon $start, Carbon $end): array
    {
        return $this->operationalCostRowsForPeriod($start, $end)
            ->sortByDesc('amount')
            ->values()
            ->all();
    }

    private function operationalCostRowsForPeriod(Carbon $start, Carbon $end): Collection
    {
        if (! Schema::hasTable('operational_costs')) {
            return collect();
        }

        return DB::table('operational_costs')
            ->where('is_active', true)
            ->get()
            ->map(function ($cost) use ($start, $end): ?array {
                $allocatedAmount = $this->allocatedOperationalCostForPeriod($cost, $start, $end);

                if ($allocatedAmount <= 0) {
                    return null;
                }

                $type = $this->costType($cost);
                $inputAmount = (int) ($cost->amount ?? 0);
                $monthlyAmount = $type === 'annual' ? (int) round($inputAmount / 12) : $inputAmount;
                $adjustment = $this->monthlyAdjustmentForOperationalCost($cost, $start);
                $isAdjusted = $adjustment !== null && ! (bool) ($adjustment->is_deleted_for_month ?? false);

                return [
                    'name' => (string) ($cost->name ?? '-'),
                    'category' => $this->costCategoryLabel((string) ($cost->category ?? 'other')),
                    'cost_type' => $type,
                    'cost_type_label' => $this->costTypeLabel($type),
                    'amount' => $allocatedAmount,
                    'input_amount' => $inputAmount,
                    'annual_amount' => $type === 'annual' ? $inputAmount : null,
                    'monthly_amount' => $monthlyAmount,
                    'date' => $this->operationalCostDateDisplay($cost, $start),
                    'is_annual' => $type === 'annual',
                    'is_adjusted' => $isAdjusted,
                    'description' => $this->operationalCostDescription($cost, $start, $end, $allocatedAmount, $adjustment),
                    'status' => $isAdjusted ? 'Disesuaikan' : 'Dihitung',
                ];
            })
            ->filter()
            ->values();
    }

    private function allocatedOperationalCostForPeriod(object $cost, Carbon $start, Carbon $end): int
    {
        if (! $this->operationalCostValidForPeriod($cost, $start, $end)) {
            return 0;
        }

        $adjustment = $this->monthlyAdjustmentForOperationalCost($cost, $start);

        if ($adjustment !== null) {
            if ((bool) ($adjustment->is_deleted_for_month ?? false)) {
                return 0;
            }

            if ($adjustment->amount !== null) {
                return (int) $adjustment->amount;
            }
        }

        $costDate = Carbon::parse($cost->cost_date)->startOfDay();
        $amount = (int) ($cost->amount ?? 0);

        return match ($this->costType($cost)) {
            'annual' => $this->annualOperationalAllocationForPeriod($costDate, $amount, $start, $end),
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()) ? $amount : 0,
            default => $costDate->lte($end->copy()->endOfDay()) ? $amount : 0,
        };
    }

    private function operationalCostValidForPeriod(object $cost, Carbon $start, Carbon $end): bool
    {
        if (empty($cost->cost_date)) {
            return false;
        }

        $costDate = Carbon::parse($cost->cost_date)->startOfDay();

        return match ($this->costType($cost)) {
            'annual' => $this->countAnnualCostOverlapMonths($costDate, $start, $end) > 0,
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()),
            default => $costDate->lte($end->copy()->endOfDay()),
        };
    }

    private function annualOperationalAllocationForPeriod(Carbon $costDate, int $amount, Carbon $start, Carbon $end): int
    {
        $months = $this->countAnnualCostOverlapMonths($costDate, $start, $end);

        return $months > 0 ? (int) round(($amount / 12) * $months) : 0;
    }

    private function monthlyAdjustmentForOperationalCost(object $cost, Carbon $periodStart): ?object
    {
        if (! $this->monthlyAdjustmentTableExists()) {
            return null;
        }

        return DB::table('operational_cost_monthly_adjustments')
            ->where('operational_cost_id', $cost->id)
            ->where('month', $periodStart->month)
            ->where('year', $periodStart->year)
            ->first();
    }

    private function monthlyAdjustmentTableExists(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        return $exists = Schema::hasTable('operational_cost_monthly_adjustments');
    }

    private function operationalCostDateDisplay(object $cost, Carbon $periodStart): string
    {
        $costDate = Carbon::parse($cost->cost_date)->startOfDay();

        if ($this->costType($cost) === 'one_time') {
            return $costDate->format('d M Y');
        }

        $day = min($costDate->day, $periodStart->copy()->endOfMonth()->day);

        return $periodStart->copy()
            ->day($day)
            ->format('d M Y');
    }

    private function operationalCostDescription(object $cost, Carbon $start, Carbon $end, int $allocatedAmount, ?object $adjustment): string
    {
        if ($adjustment !== null) {
            if ((bool) ($adjustment->is_deleted_for_month ?? false)) {
                return 'Dihapus dari bulan aktif';
            }

            return 'Khusus bulan ini'.(! empty($adjustment->note) ? ' • '.(string) $adjustment->note : '');
        }

        $type = $this->costType($cost);
        $note = mb_trim((string) ($cost->note ?? ''));

        if ($type === 'annual') {
            $monthlyAmount = (int) round(((int) ($cost->amount ?? 0)) / 12);

            return 'Tahunan '.$this->rupiah((int) ($cost->amount ?? 0)).' • dihitung '.$this->rupiah($monthlyAmount).'/bulan';
        }

        if ($type === 'one_time') {
            return $note !== '' ? $note : 'Sekali bayar pada bulan aktif';
        }

        return $note !== '' ? $note : 'Rutin bulanan sejak tanggal mulai';
    }

    private function getProductMarginList(Carbon $start, Carbon $end): array
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasTable('orders')) {
            return [];
        }

        $hasTotalHpp = Schema::hasColumn('order_items', 'total_hpp');
        $hasHpp = Schema::hasColumn('order_items', 'hpp');
        $hasQuantity = Schema::hasColumn('order_items', 'quantity');
        $hasSubtotal = Schema::hasColumn('order_items', 'subtotal');

        $totalHppExpression = match (true) {
            $hasTotalHpp => 'COALESCE(SUM(order_items.total_hpp), 0)',
            $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.hpp * order_items.quantity), 0)',
            default => '0',
        };

        $grossProfitExpression = match (true) {
            $hasSubtotal && $hasTotalHpp => 'COALESCE(SUM(order_items.subtotal - order_items.total_hpp), 0)',
            $hasSubtotal && $hasHpp && $hasQuantity => 'COALESCE(SUM(order_items.subtotal - (order_items.hpp * order_items.quantity)), 0)',
            $hasSubtotal => 'COALESCE(SUM(order_items.subtotal), 0)',
            default => '0',
        };

        $query = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('COALESCE(order_items.product_name, "Produk") as name')
            ->selectRaw('SUM(order_items.quantity) as units')
            ->selectRaw('SUM(order_items.subtotal) as revenue')
            ->selectRaw($totalHppExpression.' as total_hpp')
            ->selectRaw($grossProfitExpression.' as gross_profit')
            ->whereBetween(
                DB::raw('COALESCE(orders.ordered_at, orders.created_at)'),
                [
                    $start->toDateTimeString(),
                    $end->toDateTimeString(),
                ]
            );

        if (Schema::hasColumn('orders', 'status')) {
            $query->where('orders.status', '!=', 'Dibatalkan');
        }

        return $query
            ->groupByRaw('COALESCE(order_items.product_name, "Produk")')
            ->orderByDesc('gross_profit')
            ->limit(8)
            ->get()
            ->map(function ($row): array {
                $revenue = (int) $row->revenue;
                $grossProfit = (int) $row->gross_profit;

                return [
                    'name' => (string) $row->name,
                    'units' => (int) $row->units,
                    'revenue' => $revenue,
                    'total_hpp' => (int) $row->total_hpp,
                    'gross_profit' => $grossProfit,
                    'margin' => $revenue > 0 ? round(($grossProfit / $revenue) * 100, 1) : 0,
                ];
            })
            ->values()
            ->all();
    }

    private function getYearlyDetails(int $year): array
    {
        $rows = [];

        for ($month = 1; $month <= 12; $month++) {
            $start = Carbon::create($year, $month, 1)->startOfDay();
            $end = $start->copy()->endOfMonth();

            $revenue = $this->revenueBetween($start, $end);
            $finance = $this->financeBetween($start, $end);
            $operationalCost = $this->operationalCostBetween($start, $end);
            $target = $this->targetForMonth($start);

            $grossProfit = $finance['gross_profit'];
            $totalHpp = $finance['total_hpp'];
            $netProfit = $grossProfit - $operationalCost;

            $rows[] = [
                'month' => $month,
                'month_key' => (string) $month,
                'month_name' => $this->monthName($month),
                'short_name' => $start->format('M'),
                'period' => $start->format('M Y'),
                'revenue' => $revenue,
                'total_hpp' => $totalHpp,
                'gross_profit' => $grossProfit,
                'operational_cost' => $operationalCost,
                'net_profit' => $netProfit,
                'profit_margin' => $revenue > 0 ? round(($grossProfit / $revenue) * 100, 1) : 0,
                'target_revenue' => (int) ($target?->target_revenue ?? 0),
                'target_gross_profit' => (int) ($target?->target_gross_profit ?? 0),
                'target_net_profit' => (int) ($target?->target_net_profit ?? 0),
            ];
        }

        return $rows;
    }

    private function getAnnualOperationalCosts(): Collection
    {
        if (! Schema::hasTable('operational_costs')) {
            return collect();
        }

        $query = DB::table('operational_costs')
            ->where('is_active', true);

        if (Schema::hasColumn('operational_costs', 'cost_type')) {
            $query->where('cost_type', 'annual');
        } else {
            $query->where('category', 'rent');
        }

        return $query->get();
    }

    private function countAnnualCostOverlapMonths(Carbon $costDate, Carbon $periodStart, Carbon $periodEnd): int
    {
        $annualStart = $costDate->copy()->startOfMonth();
        $annualEnd = $annualStart->copy()->addMonths(11)->endOfMonth();
        $rangeStart = $periodStart->copy()->startOfMonth();
        $rangeEnd = $periodEnd->copy()->endOfMonth();

        if ($annualEnd->lt($rangeStart) || $annualStart->gt($rangeEnd)) {
            return 0;
        }

        $overlapStart = $annualStart->gt($rangeStart) ? $annualStart->copy() : $rangeStart->copy();
        $overlapEnd = $annualEnd->lt($rangeEnd) ? $annualEnd->copy() : $rangeEnd->copy();

        return (($overlapEnd->year - $overlapStart->year) * 12) + ($overlapEnd->month - $overlapStart->month) + 1;
    }

    private function costType(object $cost): string
    {
        $type = (string) ($cost->cost_type ?? '');

        if (in_array($type, ['one_time', 'monthly', 'annual'], true)) {
            return $type;
        }

        return ((string) ($cost->category ?? '') === 'rent') ? 'annual' : 'monthly';
    }

    private function costTypeLabel(string $type): string
    {
        return match ($type) {
            'one_time' => 'Sekali Bayar',
            'annual' => 'Tahunan',
            default => 'Bulanan',
        };
    }

    private function costCategoryLabel(string $category): string
    {
        return match ($category) {
            'rent' => 'Sewa Tempat Tahunan',
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Wifi / Internet',
            'salary' => 'Gaji',
            'marketing' => 'Promosi / Marketing',
            'maintenance' => 'Maintenance',
            default => 'Lainnya',
        };
    }

    private function monthFilterOptions(): array
    {
        return [
            'all' => 'Semua Bulan',
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    private function monthName(int $month): string
    {
        return $this->monthFilterOptions()[(string) $month] ?? 'Bulan';
    }

    private function isValidMonthValue(string|int|null $month): bool
    {
        if ($month === null || $month === 'all') {
            return false;
        }

        return is_numeric($month) && (int) $month >= 1 && (int) $month <= 12;
    }

    private function progressPercent(int|float $actual, int|float $target): float
    {
        if ($target <= 0) {
            return 0.0;
        }

        return round(min(($actual / $target) * 100, 999), 1);
    }

    private function trendPercent(int|float $current, int|float $previous): ?float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function safeAdminUrl(string $path): string
    {
        return url('/admin/'.mb_trim($path, '/'));
    }
}
