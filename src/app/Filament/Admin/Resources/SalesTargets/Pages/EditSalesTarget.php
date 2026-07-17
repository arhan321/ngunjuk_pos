<?php

namespace App\Filament\Admin\Resources\SalesTargets\Pages;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Filament\Admin\Resources\SalesTargets\Widgets\SalesTargetFormHeroWidget;

class EditSalesTarget extends EditRecord
{
    protected static string $resource = SalesTargetResource::class;

    protected static bool $isLazy = false;

    protected function getHeaderWidgets(): array
    {
        return [
            SalesTargetFormHeroWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Target')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Hapus target penjualan?')
                ->modalDescription('Data target yang dihapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus Target')
                ->successNotificationTitle('Target penjualan berhasil dihapus'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['month'])) {
            $data['month'] = Carbon::parse($data['month'])->startOfMonth()->toDateString();
        }

        return $data;
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

    protected function getRedirectUrl(): string
    {
        return SalesTargetResource::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Target penjualan berhasil diperbarui';
    }
}