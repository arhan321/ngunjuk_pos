<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Order')
                    ->schema([
                        TextEntry::make('order_code')
                            ->label('ID Order'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Selesai' => 'success',
                                'Diproses' => 'warning',
                                'Dibatalkan' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('total_item')
                            ->label('Total Item'),

                        TextEntry::make('total_price')
                            ->label('Total Pembayaran')
                            ->money('IDR'),

                        TextEntry::make('ordered_at')
                            ->label('Waktu Order')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),

                Section::make('Detail Item')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('Item Order')
                            ->schema([
                                TextEntry::make('product_name')
                                    ->label('Produk'),

                                TextEntry::make('size_name')
                                    ->label('Size'),

                                TextEntry::make('quantity')
                                    ->label('Qty'),

                                TextEntry::make('price')
                                    ->label('Harga')
                                    ->money('IDR'),

                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->money('IDR'),
                            ])
                            ->columns(5),
                    ]),
            ]);
    }
}
