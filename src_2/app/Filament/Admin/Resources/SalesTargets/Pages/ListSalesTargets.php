<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets\Pages;

use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Filament\Admin\Resources\SalesTargets\Widgets\SalesTargetAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListSalesTargets extends ListRecords
{
    protected static string $resource = SalesTargetResource::class;

    protected static bool $isLazy = false;

    protected function getHeaderWidgets(): array
    {
        return [
            SalesTargetAnalyticsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Target Penjualan')
                ->icon('heroicon-o-plus')
                ->color('warning'),
        ];
    }
}
