<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->size(46)
                    ->extraImgAttributes([
                        'style' => 'border-radius: 15px; object-fit: cover; box-shadow: 0 12px 22px rgba(101,58,21,.12); border: 1px solid rgba(255,255,255,.58);',
                    ]),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function (?string $state): string {
                        $name = $state ?: '-';
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));

                        return '
                            <div style="display:flex;align-items:center;gap:10px;min-width:210px;">
                                <div style="
                                    width:38px;
                                    height:38px;
                                    border-radius:14px;
                                    display:grid;
                                    place-items:center;
                                    color:#fff;
                                    font-size:14px;
                                    font-weight:950;
                                    background:linear-gradient(135deg,#ff9d18,#ee6500);
                                    box-shadow:0 12px 24px rgba(238,101,0,.20);
                                ">
                                    '.e($initial).'
                                </div>

                                <div style="min-width:0;">
                                    <div style="
                                        color:#23160d;
                                        font-size:13px;
                                        font-weight:950;
                                        line-height:1.25;
                                    ">
                                        '.e($name).'
                                    </div>

                                    <div style="
                                        margin-top:3px;
                                        color:#8b7057;
                                        font-size:11px;
                                        font-weight:750;
                                    ">
                                        Produk Ngunjuk
                                    </div>
                                </div>
                            </div>
                        ';
                    }),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable()
                    ->html()
                    ->formatStateUsing(fn (?string $state): string => '
                        <span style="
                            display:inline-flex;
                            align-items:center;
                            min-height:28px;
                            padding:0 11px;
                            border-radius:999px;
                            color:#078657;
                            background:rgba(16,185,129,.12);
                            border:1px solid rgba(16,185,129,.22);
                            font-size:10px;
                            font-weight:950;
                            white-space:nowrap;
                        ">
                            • '.e($state ?? '-').'
                        </span>
                    '),

                TextColumn::make('sizes_summary')
                    ->label('Size')
                    ->html()
                    ->getStateUsing(function ($record): string {
                        $sizes = $record->sizes ?? collect();

                        if ($sizes->isEmpty()) {
                            return '
                                <span style="
                                    display:inline-flex;
                                    min-height:26px;
                                    align-items:center;
                                    padding:0 10px;
                                    border-radius:999px;
                                    color:#64748b;
                                    background:rgba(148,163,184,.12);
                                    border:1px solid rgba(148,163,184,.24);
                                    font-size:10px;
                                    font-weight:900;
                                ">
                                    Belum ada size
                                </span>
                            ';
                        }

                        return $sizes
                            ->map(function ($size): string {
                                return '
                                    <span style="
                                        display:inline-flex;
                                        min-height:26px;
                                        align-items:center;
                                        padding:0 10px;
                                        margin-right:5px;
                                        margin-bottom:4px;
                                        border-radius:999px;
                                        color:#2563eb;
                                        background:rgba(59,130,246,.10);
                                        border:1px solid rgba(59,130,246,.20);
                                        font-size:10px;
                                        font-weight:950;
                                    ">
                                        '.e($size->name ?? '-').'
                                    </span>
                                ';
                            })
                            ->implode('');
                    }),

                TextColumn::make('prices_summary')
                    ->label('Harga')
                    ->html()
                    ->getStateUsing(function ($record): string {
                        $sizes = $record->sizes ?? collect();

                        if ($sizes->isEmpty()) {
                            return '
                                <span style="
                                    display:inline-flex;
                                    min-height:26px;
                                    align-items:center;
                                    padding:0 10px;
                                    border-radius:999px;
                                    color:#64748b;
                                    background:rgba(148,163,184,.12);
                                    border:1px solid rgba(148,163,184,.24);
                                    font-size:10px;
                                    font-weight:900;
                                ">
                                    Rp 0
                                </span>
                            ';
                        }

                        return $sizes
                            ->map(function ($size): string {
                                return '
                                    <span style="
                                        display:inline-flex;
                                        min-height:26px;
                                        align-items:center;
                                        padding:0 10px;
                                        margin-right:5px;
                                        margin-bottom:4px;
                                        border-radius:999px;
                                        color:#4b3525;
                                        background:rgba(255,255,255,.28);
                                        border:1px solid rgba(255,255,255,.42);
                                        font-size:10px;
                                        font-weight:950;
                                    ">
                                        Rp '.number_format((int) ($size->price ?? 0), 0, ',', '.').'
                                    </span>
                                ';
                            })
                            ->implode('');
                    }),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Produk'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
