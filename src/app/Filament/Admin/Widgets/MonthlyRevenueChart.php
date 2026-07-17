<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyRevenueChart extends ChartWidget
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
        return 'Monthly ' . $this->getDashboardMetricLabel() . ' - ' . $this->getDashboardPeriodLabel();
    }

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $labels[] = $date->format('M Y');

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
                    'borderColor' => '#159d86',
                    'backgroundColor' => 'rgba(21, 157, 134, 0.16)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 5,
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
        return 'line';
    }
}