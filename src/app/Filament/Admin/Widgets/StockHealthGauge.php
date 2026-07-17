<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class StockHealthGauge extends Widget
{
    protected string $view = 'filament.admin.widgets.stock-health-gauge';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $safeStock = (int) Product::query()
            ->where('stock', '>', 5)
            ->count();

        $lowStock = (int) Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $outOfStock = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $total = max($safeStock + $lowStock + $outOfStock, 1);

        $safePercentage = round(($safeStock / $total) * 100, 1);
        $lowPercentage = round(($lowStock / $total) * 100, 1);
        $outPercentage = round(($outOfStock / $total) * 100, 1);

        $healthScore = max(0, min(100, round($safePercentage - ($outPercentage * 0.8), 1)));

        $status = match (true) {
            $healthScore >= 80 => 'Sehat',
            $healthScore >= 55 => 'Perlu Dipantau',
            default => 'Perlu Restock',
        };

        $statusClass = match (true) {
            $healthScore >= 80 => 'safe',
            $healthScore >= 55 => 'warning',
            default => 'danger',
        };

        return [
            'safeStock' => $safeStock,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
            'totalProducts' => $total,
            'safePercentage' => $safePercentage,
            'lowPercentage' => $lowPercentage,
            'outPercentage' => $outPercentage,
            'healthScore' => $healthScore,
            'status' => $status,
            'statusClass' => $statusClass,
        ];
    }
}