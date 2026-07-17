<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class MonthlyComparisonChart extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.monthly-comparison-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $items = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
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
                'height' => 0,
            ];
        }

        $maxValue = max($values ?: [1]);
        $maxValue = max((float) $maxValue, 1);

        foreach ($items as $index => $item) {
            $items[$index]['height'] = $maxValue > 0
                ? max(round(((float) $item['value'] / $maxValue) * 100, 2), $item['value'] > 0 ? 8 : 0)
                : 0;
        }

        $bestItem = collect($items)
            ->sortByDesc('value')
            ->first();

        return [
            'items' => $items,
            'metricLabel' => $this->getDashboardMetricLabel(),
            'periodLabel' => $this->getDashboardPeriodLabel(),
            'bestMonth' => $bestItem['full_label'] ?? '-',
            'bestValue' => $bestItem['formatted'] ?? '0',
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