<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Pages;

use App\Filament\Admin\Resources\Orders\OrderResource;
use App\Filament\Admin\Resources\Orders\Widgets\OrderAnalyticsWidget;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static bool $isLazy = false;

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderAnalyticsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}