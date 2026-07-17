<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Products\ProductResource;
use App\Filament\Admin\Resources\Products\Widgets\ProductFormHeroWidget;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected static bool $isLazy = false;

    protected ?string $heading = '';

    protected ?string $subheading = '';

    public function getTitle(): string
    {
        return '';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProductFormHeroWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Produk')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalIcon('heroicon-o-exclamation-triangle')
                ->modalHeading(fn (Product $record): string => 'Hapus produk "' . $record->name . '"?')
                ->modalDescription('Produk beserta data size-nya akan dihapus permanen dan tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->successNotificationTitle('Produk berhasil dihapus')
                ->disabled(fn (Product $record): bool => $record->orderItems()->exists())
                ->tooltip(fn (Product $record): ?string => $record->orderItems()->exists()
                    ? 'Produk tidak dapat dihapus karena sudah digunakan pada transaksi. Nonaktifkan produk agar tidak tampil di kasir.'
                    : 'Hapus produk'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return ProductResource::getUrl('index');
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Simpan Perubahan')
            ->icon('heroicon-o-check-circle');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Produk berhasil diperbarui';
    }
}