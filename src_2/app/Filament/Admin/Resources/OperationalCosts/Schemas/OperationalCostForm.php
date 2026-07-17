<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

final class OperationalCostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Biaya Operasional')
                    ->description('Biaya rutin bulanan otomatis muncul setiap bulan. Gunakan Edit Bulan Ini pada tabel untuk mengubah nominal satu bulan saja.')
                    ->icon('heroicon-o-receipt-percent')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Biaya')
                            ->placeholder('Contoh: Wifi, Gaji, Listrik, Sewa Ruko, Endorse')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Gunakan nama yang jelas agar mudah dibaca pada laporan biaya.'),

                        Select::make('category')
                            ->label('Kategori Biaya')
                            ->native(true)
                            ->required()
                            ->options([
                                'rent' => 'Sewa Tempat / Ruko',
                                'electricity' => 'Listrik',
                                'water' => 'Air',
                                'internet' => 'Wifi / Internet',
                                'salary' => 'Gaji',
                                'marketing' => 'Promosi / Marketing',
                                'maintenance' => 'Maintenance',
                                'other' => 'Lainnya',
                            ])
                            ->default('other')
                            ->helperText('Kategori hanya untuk pengelompokan laporan.'),

                        Select::make('cost_type')
                            ->label('Tipe Biaya')
                            ->native(true)
                            ->required()
                            ->options([
                                'monthly' => 'Biaya Rutin Bulanan - otomatis muncul setiap bulan',
                                'annual' => 'Biaya Tahunan - nominal dibagi 12 bulan',
                                'one_time' => 'Sekali Bayar - hanya masuk bulan tanggal bayar',
                            ])
                            ->default('monthly')
                            ->helperText('Gunakan Biaya Rutin Bulanan untuk wifi, gaji, listrik, air, telepon, dan biaya tetap/rutin lainnya.'),

                        TextInput::make('amount')
                            ->label('Nominal Default / Nominal Master')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->required()
                            ->default(0)
                            ->helperText('Edit field ini berarti mengubah nominal master. Untuk ubah 1 bulan saja, gunakan tombol Edit Bulan Ini di tabel.'),

                        DatePicker::make('cost_date')
                            ->label('Tanggal Mulai / Tanggal Bayar')
                            ->native(true)
                            ->format('Y-m-d')
                            ->required()
                            ->default(fn (): string => self::defaultCostDate())
                            ->helperText('Bulanan: mulai muncul sejak bulan tanggal ini. Sekali bayar: masuk hanya bulan tanggal ini. Tahunan: mulai alokasi 12 bulan dari tanggal ini.'),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->helperText('Jika nonaktif, biaya tidak dihitung pada dashboard.')
                            ->default(true),

                        Textarea::make('note')
                            ->label('Catatan Master')
                            ->placeholder('Contoh: pembayaran setiap tanggal 3 / periode pemakaian 28 Juni - 27 Juli')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }

    private static function defaultCostDate(): string
    {
        $selectedYear = (int) request()->query('year', session('ng_operational_cost_year', now()->year));
        $selectedMonth = (int) request()->query('month', session('ng_operational_cost_month', now()->month));

        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        return Carbon::create($selectedYear, $selectedMonth, 1)->toDateString();
    }
}
