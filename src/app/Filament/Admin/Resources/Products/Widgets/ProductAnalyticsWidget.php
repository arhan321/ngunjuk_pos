<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

class ProductAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.products.widgets.product-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalProducts = Product::query()->count();

        $activeProducts = Product::query()
            ->where('is_active', true)
            ->count();

        $totalCategories = Category::query()->count();

        $topCategory = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->first();

        return [
            'summary' => [
                'total_products' => (int) $totalProducts,
                'active_products' => (int) $activeProducts,
                'total_categories' => (int) $totalCategories,
                'top_category_name' => $topCategory?->name ?? '-',
                'top_category_products' => (int) ($topCategory?->products_count ?? 0),
            ],
        ];
    }
}
