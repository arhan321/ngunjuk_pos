<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Pages;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Filament\Admin\Resources\OperationalCosts\Widgets\OperationalCostFormHeroWidget;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditOperationalCost extends EditRecord
{
    protected static string $resource = OperationalCostResource::class;

    protected static bool $isLazy = false;

    protected function getHeaderWidgets(): array
    {
        return [
            OperationalCostFormHeroWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Biaya')
                ->icon('heroicon-o-trash')
                ->color('danger'),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan')
            ->icon('heroicon-o-check-circle')
            ->color('warning');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Biaya operasional berhasil diperbarui';
    }
}
