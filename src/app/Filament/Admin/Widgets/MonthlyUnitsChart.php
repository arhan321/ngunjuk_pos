<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyUnitsChart extends ChartWidget
{
    use HasDashboardMetric;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 4,
    ];

    protected ?string $maxHeight = '280px';

    public function getHeading(): string
    {
        return 'Monthly ' . $this->getDashboardMetricLabel() . ' Bar - ' . $this->getDashboardPeriodLabel();
    }

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $labels[] = $date->format('M');

            $query = Order::query()
                ->where('status', 'Selesai')
                ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                    $date->copy()->startOfMonth(),
                    $date->copy()->endOfMonth(),
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
                    'backgroundColor' => '#159d86',
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                    'barThickness' => 32,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => true,
            'aspectRatio' => 1.35,
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