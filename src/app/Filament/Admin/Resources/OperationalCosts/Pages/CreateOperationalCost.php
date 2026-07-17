<?php

namespace App\Filament\Admin\Resources\OperationalCosts\Pages;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Filament\Admin\Resources\OperationalCosts\Widgets\OperationalCostFormHeroWidget;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateOperationalCost extends CreateRecord
{
    protected static string $resource = OperationalCostResource::class;

    protected static bool $isLazy = false;

    protected function getHeaderWidgets(): array
    {
        return [
            OperationalCostFormHeroWidget::class,
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan Biaya')
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['category'] ?? null) === 'rent' && empty($data['cost_type'])) {
            $data['cost_type'] = 'annual';
        }

        $data['cost_type'] = $data['cost_type'] ?? 'monthly';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return OperationalCostResource::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Biaya operasional berhasil dibuat';
    }
}