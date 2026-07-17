<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class MetricTabsWidget extends Widget
{
    protected string $view = 'filament.admin.widgets.metric-tabs';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $activeMetric = request()->query('metric');

        if (! $activeMetric) {
            $referer = request()->headers->get('referer');

            if ($referer) {
                $query = parse_url($referer, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);

                    $activeMetric = $params['metric'] ?? null;
                }
            }
        }

        $activeMetric = (string) ($activeMetric ?: 'units');

        if (! in_array($activeMetric, ['orders', 'revenue', 'units'], true)) {
            $activeMetric = 'units';
        }

        return [
            'activeMetric' => $activeMetric,
            'metrics' => [
                'orders' => [
                    'label' => 'Orders',
                    'description' => 'Visualisasi berdasarkan jumlah transaksi',
                ],
                'revenue' => [
                    'label' => 'Revenue',
                    'description' => 'Visualisasi berdasarkan pendapatan',
                ],
                'units' => [
                    'label' => 'Units Sold',
                    'description' => 'Visualisasi berdasarkan item terjual',
                ],
            ],
        ];
    }
}
