<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait HasDashboardMetric
{
    protected function getDashboardQueryValue(string $key, ?string $default = null): ?string
    {
        $value = request()->query($key);

        if (! $value) {
            $referer = request()->headers->get('referer');

            if ($referer) {
                $query = parse_url($referer, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);

                    $value = $params[$key] ?? null;
                }
            }
        }

        return $value ? (string) $value : $default;
    }

    protected function getDashboardMetric(): string
    {
        $metric = $this->getDashboardQueryValue('metric', 'units');

        return in_array($metric, ['orders', 'revenue', 'units'], true)
            ? $metric
            : 'units';
    }

    protected function getDashboardMetricLabel(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'Orders',
            'revenue' => 'Revenue',
            'units' => 'Units Sold',
            default => 'Units Sold',
        };
    }

    protected function getDashboardMetricDatasetLabel(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'Orders',
            'revenue' => 'Revenue',
            'units' => 'Units',
            default => 'Units',
        };
    }

    protected function getDashboardMetricSortColumn(): string
    {
        return match ($this->getDashboardMetric()) {
            'orders' => 'orders_count',
            'revenue' => 'revenue',
            'units' => 'units_sold',
            default => 'units_sold',
        };
    }

    protected function getDashboardPeriod(): string
    {
        $period = $this->getDashboardQueryValue('period', 'today');

        return in_array($period, ['today', 'week', 'month', 'year', 'all'], true)
            ? $period
            : 'today';
    }

    protected function getDashboardPeriodLabel(): string
    {
        return match ($this->getDashboardPeriod()) {
            'today' => 'Hari Ini',
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
            'all' => 'Semua Data',
            default => 'Hari Ini',
        };
    }

    protected function getDashboardPeriodOptions(): array
    {
        return [
            'today' => 'Hari Ini',
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
            'all' => 'Semua Data',
        ];
    }

    protected function getDashboardPeriodRange(?string $period = null): array
    {
        $period = $period ?: $this->getDashboardPeriod();

        return match ($period) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
            ],
            'week' => [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ],
            'month' => [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ],
            'year' => [
                now()->startOfYear(),
                now()->endOfYear(),
            ],
            'all' => [
                null,
                null,
            ],
            default => [
                now()->startOfDay(),
                now()->endOfDay(),
            ],
        };
    }

    protected function getPreviousDashboardPeriodRange(?string $period = null): array
    {
        $period = $period ?: $this->getDashboardPeriod();

        return match ($period) {
            'today' => [
                now()->subDay()->startOfDay(),
                now()->subDay()->endOfDay(),
            ],
            'week' => [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek(),
            ],
            'month' => [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth(),
            ],
            'year' => [
                now()->subYear()->startOfYear(),
                now()->subYear()->endOfYear(),
            ],
            'all' => [
                null,
                null,
            ],
            default => [
                now()->subDay()->startOfDay(),
                now()->subDay()->endOfDay(),
            ],
        };
    }

    protected function applyDashboardPeriodFilterToOrderQuery(Builder $query, string $ordersTable = 'orders'): Builder
    {
        [$start, $end] = $this->getDashboardPeriodRange();

        if (! $start || ! $end) {
            return $query;
        }

        return $query->whereBetween(
            DB::raw("COALESCE({$ordersTable}.ordered_at, {$ordersTable}.created_at)"),
            [$start, $end],
        );
    }

    protected function applyCustomPeriodFilterToOrderQuery(
        Builder $query,
        ?Carbon $start,
        ?Carbon $end,
        string $ordersTable = 'orders',
    ): Builder {
        if (! $start || ! $end) {
            return $query;
        }

        return $query->whereBetween(
            DB::raw("COALESCE({$ordersTable}.ordered_at, {$ordersTable}.created_at)"),
            [$start, $end],
        );
    }

    protected function calculateGrowthPercentage(int|float $current, int|float $previous): array
    {
        $current = (float) $current;
        $previous = (float) $previous;

        if ($previous <= 0 && $current <= 0) {
            return [
                'value' => 0,
                'direction' => 'neutral',
                'label' => 'Belum ada perubahan',
            ];
        }

        if ($previous <= 0 && $current > 0) {
            return [
                'value' => 100,
                'direction' => 'up',
                'label' => 'Naik 100% dari periode sebelumnya',
            ];
        }

        $percentage = (($current - $previous) / $previous) * 100;

        if ($percentage > 0) {
            return [
                'value' => round($percentage, 1),
                'direction' => 'up',
                'label' => 'Naik ' . round($percentage, 1) . '% dari periode sebelumnya',
            ];
        }

        if ($percentage < 0) {
            return [
                'value' => abs(round($percentage, 1)),
                'direction' => 'down',
                'label' => 'Turun ' . abs(round($percentage, 1)) . '% dari periode sebelumnya',
            ];
        }

        return [
            'value' => 0,
            'direction' => 'neutral',
            'label' => 'Sama dengan periode sebelumnya',
        ];
    }
}