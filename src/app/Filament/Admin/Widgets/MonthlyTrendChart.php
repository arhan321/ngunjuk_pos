<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class MonthlyTrendChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.monthly-trend-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 6,
        'xl' => 8,
    ];

    protected function getViewData(): array
    {
        $items = [];
        $values = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->copy()->subMonths($i);

            $query = Order::query()
                ->where('status', 'Selesai')
                ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                    $date->copy()->startOfMonth(),
                    $date->copy()->endOfMonth(),
                ]);

            $value = match ($this->getDashboardMetric()) {
                'orders' => (int) $query->count(),
                'revenue' => (int) $query->sum('total_price'),
                'units' => (int) $query->sum('total_item'),
                default => (int) $query->sum('total_item'),
            };

            $values[] = $value;

            $items[] = [
                'label' => $date->format('M'),
                'full_label' => $date->format('M Y'),
                'value' => $value,
                'formatted' => $this->formatMetricValue($value),
            ];
        }

        $maxValue = max($values ?: [1]);
        $minValue = min($values ?: [0]);

        $maxValue = max((float) $maxValue, 1);
        $minValue = (float) $minValue;

        if ($maxValue <= $minValue) {
            $maxValue = $minValue + 1;
        }

        /*
         * Compact chart size.
         * Dibuat lebih pendek supaya dashboard tidak terlalu panjang ke bawah.
         */
        $chartWidth = 860;
        $chartHeight = 260;

        $paddingTop = 32;
        $paddingRight = 28;
        $paddingBottom = 32;
        $paddingLeft = 28;

        $plotWidth = $chartWidth - $paddingLeft - $paddingRight;
        $plotHeight = $chartHeight - $paddingTop - $paddingBottom;

        $points = [];
        $count = count($items);
        $stepX = $count > 1 ? $plotWidth / ($count - 1) : $plotWidth;

        foreach ($items as $index => $item) {
            $value = (float) $item['value'];

            $x = $paddingLeft + ($index * $stepX);
            $y = $paddingTop + (($maxValue - $value) / ($maxValue - $minValue)) * $plotHeight;

            $points[] = [
                'x' => round($x, 2),
                'y' => round($y, 2),
                'label' => $item['label'],
                'full_label' => $item['full_label'],
                'value' => $value,
                'formatted' => $item['formatted'],
            ];
        }

        $linePath = '';
        $areaPath = '';

        if (count($points) > 0) {
            $linePath = 'M ' . $points[0]['x'] . ' ' . $points[0]['y'];

            for ($i = 1; $i < count($points); $i++) {
                $previous = $points[$i - 1];
                $current = $points[$i];

                $controlX = ($previous['x'] + $current['x']) / 2;

                $linePath .= ' C '
                    . $controlX . ' ' . $previous['y'] . ', '
                    . $controlX . ' ' . $current['y'] . ', '
                    . $current['x'] . ' ' . $current['y'];
            }

            $baselineY = $paddingTop + $plotHeight;

            $areaPath = 'M ' . $points[0]['x'] . ' ' . $baselineY . ' ';
            $areaPath .= 'L ' . $points[0]['x'] . ' ' . $points[0]['y'] . ' ';

            for ($i = 1; $i < count($points); $i++) {
                $previous = $points[$i - 1];
                $current = $points[$i];

                $controlX = ($previous['x'] + $current['x']) / 2;

                $areaPath .= 'C '
                    . $controlX . ' ' . $previous['y'] . ', '
                    . $controlX . ' ' . $current['y'] . ', '
                    . $current['x'] . ' ' . $current['y'] . ' ';
            }

            $lastPoint = $points[count($points) - 1];
            $areaPath .= 'L ' . $lastPoint['x'] . ' ' . $baselineY . ' Z';
        }

        $currentValue = (float) end($values);
        $previousValue = count($values) >= 2 ? (float) $values[count($values) - 2] : 0;
        $growth = $this->calculateGrowthPercentage($currentValue, $previousValue);

        return [
            'points' => $points,
            'linePath' => $linePath,
            'areaPath' => $areaPath,
            'chartWidth' => $chartWidth,
            'chartHeight' => $chartHeight,
            'paddingLeft' => $paddingLeft,
            'paddingRight' => $paddingRight,
            'paddingTop' => $paddingTop,
            'plotHeight' => $plotHeight,
            'gridLines' => 4,
            'metricLabel' => $this->getDashboardMetricLabel(),
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'currentValue' => $this->formatMetricValue($currentValue),
            'growth' => $growth,
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
}