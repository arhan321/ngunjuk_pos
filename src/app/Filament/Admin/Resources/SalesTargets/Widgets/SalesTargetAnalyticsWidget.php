<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets\Widgets;

use App\Filament\Admin\Pages\FinancialDashboard;
use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Models\SalesTarget;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class SalesTargetAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.sales-targets.widgets.sales-target-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function rupiah(int|float|null $value): string
    {
        return 'Rp '.number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    protected function getViewData(): array
    {
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $currentTarget = SalesTarget::query()
            ->whereDate('month', $monthStart->toDateString())
            ->first();

        $monthlyRevenue = $this->monthlyRevenue($monthStart, $monthEnd);

        $targetRevenue = (int) ($currentTarget?->target_revenue ?? 0);
        $targetGrossProfit = (int) ($currentTarget?->target_gross_profit ?? 0);
        $targetNetProfit = (int) ($currentTarget?->target_net_profit ?? 0);

        $revenueProgress = $this->progressPercent($monthlyRevenue, $targetRevenue);
        $revenueGap = $monthlyRevenue - $targetRevenue;
        $remainingRevenue = max(0, $targetRevenue - $monthlyRevenue);
        $achievementStatus = $this->achievementStatus($monthlyRevenue, $targetRevenue);

        $latestTarget = SalesTarget::query()
            ->latest('month')
            ->first();

        $selectedYear = $this->selectedYear();
        $selectedStatus = $this->selectedStatus();

        return [
            'createUrl' => SalesTargetResource::getUrl('create'),
            'indexUrl' => SalesTargetResource::getUrl('index'),
            'dashboardUrl' => FinancialDashboard::getUrl(),
            'filters' => [
                'years' => $this->yearOptions(),
                'statuses' => $this->statusOptions(),
                'selected_year' => $selectedYear,
                'selected_status' => $selectedStatus,
            ],
            'summary' => [
                'period_label' => $monthStart->format('M Y'),

                // Alias lama dan baru supaya blade tidak error.
                'monthly_revenue' => $monthlyRevenue,
                'current_revenue' => $monthlyRevenue,
                'actual_revenue' => $monthlyRevenue,
                'revenue_actual' => $monthlyRevenue,

                'target_revenue' => $targetRevenue,
                'current_target_revenue' => $targetRevenue,
                'current_target' => $targetRevenue,

                'target_gross_profit' => $targetGrossProfit,
                'target_net_profit' => $targetNetProfit,

                'revenue_progress' => $revenueProgress,
                'revenue_gap' => $revenueGap,
                'remaining_revenue' => $remainingRevenue,
                'achievement_status' => $achievementStatus,

                'latest_target_month' => $latestTarget?->month?->format('M Y') ?? '-',
                'latest_target_value' => (int) ($latestTarget?->target_revenue ?? 0),
                'has_current_target' => ! is_null($currentTarget),
            ],
        ];
    }

    private function monthlyRevenue(Carbon $start, Carbon $end): int
    {
        if (! Schema::hasTable('orders')) {
            return 0;
        }

        $amountColumn = Schema::hasColumn('orders', 'total_price')
            ? 'total_price'
            : (Schema::hasColumn('orders', 'total_amount') ? 'total_amount' : null);

        if (! $amountColumn) {
            return 0;
        }

        $query = DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [$start->toDateTimeString(), $end->toDateTimeString()]
            );

        $this->excludeCanceledOrders($query);

        return (int) $query->sum($amountColumn);
    }

    private function excludeCanceledOrders(Builder $query): void
    {
        if (! Schema::hasColumn('orders', 'status')) {
            return;
        }

        $query->where(function (Builder $statusQuery): void {
            $statusQuery
                ->whereNull('status')
                ->orWhereNotIn(DB::raw('LOWER(status)'), [
                    'batal',
                    'dibatalkan',
                    'cancel',
                    'cancelled',
                    'canceled',
                ]);
        });
    }

    private function progressPercent(int|float $actual, int|float $target): float
    {
        if ($target <= 0) {
            return 0.0;
        }

        return round(min(($actual / $target) * 100, 999), 1);
    }

    private function achievementStatus(int|float $actual, int|float $target): string
    {
        if ($target <= 0) {
            return 'no_target';
        }

        if ($actual <= 0) {
            return 'no_transaction';
        }

        $progress = ($actual / $target) * 100;

        if ($progress >= 100) {
            return 'achieved';
        }

        if ($progress >= 80) {
            return 'near';
        }

        return 'not_achieved';
    }

    private function selectedYear(): int
    {
        $year = (int) ($this->queryValue('year') ?: now()->year);

        if ($year < 2000 || $year > 2100) {
            return now()->year;
        }

        return $year;
    }

    private function selectedStatus(): string
    {
        $status = (string) ($this->queryValue('status') ?: 'all');

        if (! array_key_exists($status, $this->statusOptions())) {
            return 'all';
        }

        return $status;
    }

    private function queryValue(string $key): ?string
    {
        $value = request()->query($key) ?? request()->input($key);

        if ($value !== null && $value !== '') {
            return (string) $value;
        }

        $referer = (string) request()->headers->get('referer', '');

        if ($referer !== '') {
            $query = parse_url($referer, PHP_URL_QUERY);

            if (is_string($query)) {
                parse_str($query, $params);

                if (isset($params[$key]) && $params[$key] !== '') {
                    return (string) $params[$key];
                }
            }
        }

        return null;
    }

    private function yearOptions(): array
    {
        $years = SalesTarget::query()
            ->selectRaw('YEAR(month) as year')
            ->whereNotNull('month')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->map(fn ($year): int => (int) $year)
            ->filter(fn (int $year): bool => $year >= 2000 && $year <= 2100)
            ->values()
            ->all();

        $currentYear = now()->year;

        if (! in_array($currentYear, $years, true)) {
            $years[] = $currentYear;
        }

        rsort($years);

        return $years;
    }

    private function statusOptions(): array
    {
        return [
            'all' => 'Semua Status',
            'achieved' => 'Tercapai',
            'not_achieved' => 'Belum Tercapai',
        ];
    }
}
