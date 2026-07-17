<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

class CategoryAnalyticsWidget extends Widget
{
    protected string $view = 'filament.admin.resources.categories.widgets.category-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalCategories = Category::query()->count();

        $activeCategories = Category::query()
            ->where('is_active', true)
            ->count();

        $inactiveCategories = Category::query()
            ->where('is_active', false)
            ->count();

        $totalProducts = Product::query()->count();

        $topCategory = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->first();

        $emptyCategories = Category::query()
            ->withCount('products')
            ->get()
            ->where('products_count', 0)
            ->count();

        return [
            'summary' => [
                'total_categories' => (int) $totalCategories,
                'active_categories' => (int) $activeCategories,
                'inactive_categories' => (int) $inactiveCategories,
                'total_products' => (int) $totalProducts,
                'empty_categories' => (int) $emptyCategories,
                'top_category_name' => $topCategory?->name ?? '-',
                'top_category_products' => (int) ($topCategory?->products_count ?? 0),
            ],
        ];
    }
}