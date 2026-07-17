<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Categories\Widgets;

use App\Filament\Admin\Resources\Categories\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

final class CategoryFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.categories.widgets.category-form-hero-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $totalCategories = Category::query()->count();
        $activeCategories = Category::query()->where('is_active', true)->count();
        $totalProducts = Product::query()->count();

        return [
            'isEdit' => $isEdit,
            'title' => $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru',
            'description' => $isEdit
                ? 'Perbarui nama kategori, slug, dan status aktif kategori produk.'
                : 'Buat kategori baru untuk mengelompokkan produk minuman UMKM Ngunjuk.',
            'backUrl' => CategoryResource::getUrl('index'),
            'stats' => [
                'total_categories' => (int) $totalCategories,
                'active_categories' => (int) $activeCategories,
                'total_products' => (int) $totalProducts,
            ],
        ];
    }
}
