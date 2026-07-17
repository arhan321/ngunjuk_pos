<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class RestockPriorityChart extends Widget
{
    protected string $view = 'filament.admin.widgets.restock-priority-chart';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 6,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $safeLimit = 10;

        $criticalCount = (int) Product::query()
            ->where('stock', '<=', 0)
            ->count();

        $lowCount = (int) Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 2)
            ->count();

        $warningCount = (int) Product::query()
            ->where('stock', '>', 2)
            ->where('stock', '<=', 5)
            ->count();

        $safeCount = (int) Product::query()
            ->where('stock', '>', 5)
            ->count();

        $totalProducts = max($criticalCount + $lowCount + $warningCount + $safeCount, 1);
        $riskProducts = $criticalCount + $lowCount + $warningCount;

        $distribution = [
            $this->makeDistributionItem('Aman', $safeCount, 'safe', $totalProducts),
            $this->makeDistributionItem('Waspada', $warningCount, 'warning', $totalProducts),
            $this->makeDistributionItem('Rendah', $lowCount, 'low', $totalProducts),
            $this->makeDistributionItem('Kritis', $criticalCount, 'critical', $totalProducts),
        ];

        $items = Product::query()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(2)
            ->get(['name', 'stock'])
            ->map(fn (Product $product): array => $this->makeStockItem($product, $safeLimit))
            ->toArray();

        return [
            'items' => $items,
            'distribution' => $distribution,
            'safeLimit' => $safeLimit,
            'totalProducts' => $totalProducts,
            'riskProducts' => $riskProducts,
        ];
    }

    private function makeDistributionItem(string $label, int $count, string $class, int $total): array
    {
        return [
            'label' => $label,
            'count' => $count,
            'class' => $class,
            'width' => round(($count / max($total, 1)) * 100, 2),
        ];
    }

    private function makeStockItem(Product $product, int $safeLimit): array
    {
        $stock = max((int) $product->stock, 0);

        if ($stock <= 0) {
            $status = 'Kritis';
            $statusClass = 'critical';
        } elseif ($stock <= 2) {
            $status = 'Rendah';
            $statusClass = 'low';
        } else {
            $status = 'Waspada';
            $statusClass = 'warning';
        }

        return [
            'name' => (string) $product->name,
            'stock' => $stock,
            'status' => $status,
            'statusClass' => $statusClass,
            'width' => min(round(($stock / max($safeLimit, 1)) * 100, 2), 100),
            'safeLimit' => $safeLimit,
        ];
    }
}