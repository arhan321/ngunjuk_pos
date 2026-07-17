<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DailyUnitsChart extends ChartWidget
{
    use HasDashboardMetric;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 8,
    ];

    protected ?string $maxHeight = '280px';

    public function getHeading(): string
    {
        return 'Daily ' . $this->getDashboardMetricLabel() . ' - ' . $this->getDashboardPeriodLabel();
    }

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $labels[] = $date->format('D');

            $query = Order::query()
                ->where('status', 'Selesai')
                ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                    $date->copy()->startOfDay(),
                    $date->copy()->endOfDay(),
                ]);

            $this->applyDashboardPeriodFilterToOrderQuery($query);

            $values[] = match ($this->getDashboardMetric()) {
                'orders' => (int) $query->count(),
                'revenue' => (int) $query->sum('total_price'),
                'units' => (int) $query->sum('total_item'),
                default => (int) $query->sum('total_item'),
            };
        }

        return [
            'datasets' => [
                [
                    'label' => $this->getDashboardMetricDatasetLabel(),
                    'data' => $values,
                    'backgroundColor' => '#14b8a6',
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                    'barThickness' => 38,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}