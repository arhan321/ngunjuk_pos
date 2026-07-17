<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Widgets;

use App\Filament\Admin\Resources\Products\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\Widget;

final class ProductFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.products.widgets.product-form-hero-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $totalProducts = Product::query()->count();

        $activeProducts = Product::query()
            ->where('is_active', true)
            ->count();

        $totalCategories = Category::query()->count();

        return [
            'isEdit' => $isEdit,
            'title' => $isEdit ? 'Edit Produk' : 'Tambah Produk Baru',
            'description' => $isEdit
                ? 'Perbarui informasi produk, kategori, gambar, size, dan harga produk.'
                : 'Tambahkan produk minuman baru lengkap dengan kategori, gambar, size, dan harga.',
            'backUrl' => ProductResource::getUrl('index'),
            'stats' => [
                'total_products' => (int) $totalProducts,
                'active_products' => (int) $activeProducts,
                'total_categories' => (int) $totalCategories,
            ],
        ];
    }
}
