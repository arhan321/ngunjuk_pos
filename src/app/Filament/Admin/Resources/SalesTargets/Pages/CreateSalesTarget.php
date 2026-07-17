<?php

namespace App\Filament\Admin\Resources\SalesTargets\Pages;

use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Filament\Admin\Resources\SalesTargets\Widgets\SalesTargetFormHeroWidget;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesTarget extends CreateRecord
{
    protected static string $resource = SalesTargetResource::class;

    protected static bool $isLazy = false;

    protected function getHeaderWidgets(): array
    {
        return [
            SalesTargetFormHeroWidget::class,
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['month'])) {
            $data['month'] = Carbon::parse($data['month'])->startOfMonth()->toDateString();
        }

        return $data;
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Target')
            ->icon('heroicon-o-check-circle')
            ->color('warning');
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Simpan & Tambah Lagi')
            ->color('gray');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getRedirectUrl(): string
    {
        return SalesTargetResource::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Target penjualan berhasil dibuat';
    }
}