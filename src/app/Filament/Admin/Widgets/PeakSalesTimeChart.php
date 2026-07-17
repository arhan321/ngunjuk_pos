<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class PeakSalesTimeChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.peak-sales-time-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 6,
    ];

    protected function getViewData(): array
    {
        $period = $this->getDashboardPeriod();

        [$labels, $ranges] = match ($period) {
            'today' => $this->getHourlyRanges(),
            'week' => $this->getDailyRangesForCurrentWeek(),
            'month' => $this->getWeeklyRangesForCurrentMonth(),
            'year' => $this->getMonthlyRangesForCurrentYear(),
            'all' => $this->getLastTwelveMonthsRanges(),
            default => $this->getHourlyRanges(),
        };

        $items = [];
        $maxValue = 1;

        foreach ($ranges as $index => $range) {
            [$start, $end] = $range;

            $query = Order::query()
                ->where('status', 'Selesai')
                ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [$start, $end]);

            $value = match ($this->getDashboardMetric()) {
                'orders' => (int) $query->count(),
                'revenue' => (int) $query->sum('total_price'),
                'units' => (int) $query->sum('total_item'),
                default => (int) $query->sum('total_item'),
            };

            $maxValue = max($maxValue, $value);

            $items[] = [
                'label' => $labels[$index],
                'value' => $value,
                'formatted' => $this->formatMetricValue($value),
                'height' => 0,
            ];
        }

        foreach ($items as $index => $item) {
            $items[$index]['height'] = $maxValue > 0
                ? max(round(($item['value'] / $maxValue) * 100, 2), $item['value'] > 0 ? 8 : 0)
                : 0;
        }

        $peakItem = collect($items)
            ->sortByDesc('value')
            ->first();

        return [
            'items' => $items,
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'metricLabel' => $this->getDashboardMetricLabel(),
            'peakLabel' => $peakItem['label'] ?? '-',
            'peakValue' => $peakItem['formatted'] ?? '0',
        ];
    }

    private function formatMetricValue(int|float $value): string
    {
        return match ($this->getDashboardMetric()) {
            'revenue' => 'Rp ' . number_format((int) $value, 0, ',', '.'),
            'orders' => number_format((int) $value, 0, ',', '.') . ' order',
            'units' => number_format((int) $value, 0, ',', '.') . ' item',
            default => number_format((int) $value, 0, ',', '.') . ' item',
        };
    }

    private function getHourlyRanges(): array
    {
        $labels = [];
        $ranges = [];

        for ($hour = 7; $hour <= 22; $hour++) {
            $time = now()->copy()->startOfDay()->addHours($hour);

            $labels[] = $time->format('H:i');
            $ranges[] = [
                $time->copy()->startOfHour(),
                $time->copy()->endOfHour(),
            ];
        }

        return [$labels, $ranges];
    }

    private function getDailyRangesForCurrentWeek(): array
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

    private function getWeeklyRangesForCurrentMonth(): array
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

    private function getMonthlyRangesForCurrentYear(): array
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

    private function getLastTwelveMonthsRanges(): array
    {
        $labels = [];
        $ranges = [];

        for ($monthIndex = 11; $monthIndex >= 0; $monthIndex--) {
            $month = now()->copy()->subMonths($monthIndex);

            $labels[] = $month->format('M y');
            $ranges[] = [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ];
        }

        return [$labels, $ranges];
    }
}