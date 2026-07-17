<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SalesTargets\Tables;

use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SalesTargetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->heading(fn (): string => 'Total Data ' . self::totalDataForFilter())
            ->modifyQueryUsing(fn (EloquentBuilder $query): EloquentBuilder => self::applyYearAndStatusFilter($query))
            ->columns([
                TextColumn::make('month')
                    ->label('Bulan')
                    ->date('M Y')
                    ->sortable()
                    ->weight('bold')
                    ->wrap(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-month-col',
                        'style' => 'width: 180px !important; min-width: 180px !important; max-width: 180px !important; padding-left: 24px !important; padding-right: 16px !important; text-align: left !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-month-col',
                        'style' => 'width: 180px !important; min-width: 180px !important; max-width: 180px !important; padding-left: 24px !important; padding-right: 16px !important; text-align: left !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('target_revenue')
                    ->label('Target & Aktual')
                    ->sortable()
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => self::rupiah((int) $state))
                    ->description(fn ($record): string => 'Aktual ' . self::rupiah(self::monthlyRevenueForTarget($record)))
                    ->wrap(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-revenue-col',
                        'style' => 'width: 240px !important; min-width: 240px !important; max-width: 240px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-revenue-col',
                        'style' => 'width: 240px !important; min-width: 240px !important; max-width: 240px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('progress_revenue')
                    ->label('Progress')
                    ->getStateUsing(fn ($record): string => number_format(self::progressForTarget($record), 1, ',', '.') . '%')
                    ->alignEnd()
                    ->description(fn ($record): string => self::achievementStatusLabel(self::achievementStatusKey($record)))
                    ->sortable(false)
                    ->wrap(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-progress-col',
                        'style' => 'width: 190px !important; min-width: 190px !important; max-width: 190px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-progress-col',
                        'style' => 'width: 190px !important; min-width: 190px !important; max-width: 190px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('revenue_gap')
                    ->label('Selisih')
                    ->getStateUsing(fn ($record): int => self::gapForTarget($record))
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => self::rupiahWithSign((int) $state))
                    ->color(fn ($state): string => ((int) $state) >= 0 ? 'success' : 'danger')
                    ->description(fn ($record): string => 'Terhadap target')
                    ->sortable(false)
                    ->wrap(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-gap-col',
                        'style' => 'width: 200px !important; min-width: 200px !important; max-width: 200px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-admin-sales-target-col ng-sales-target-gap-col',
                        'style' => 'width: 200px !important; min-width: 200px !important; max-width: 200px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),
            ])
            ->headerActions([])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Edit Target')
                        ->icon('heroicon-o-pencil-square')
                        ->color('primary'),
                ])
                    ->label('')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->button()
                    ->size('sm')
                    ->color('gray'),
            ])
            ->toolbarActions([])
            ->emptyStateIcon('heroicon-o-flag')
            ->emptyStateHeading('Tidak ada target sesuai filter')
            ->emptyStateDescription('Coba ubah filter Tahun atau Status di bagian atas.')
            ->defaultSort('month', 'desc');
    }

    private static function applyYearAndStatusFilter(EloquentBuilder $query): EloquentBuilder
    {
        $year = self::selectedYear();
        $status = self::selectedStatus();

        $query->whereYear('month', $year);

        if ($status === 'all') {
            return $query;
        }

        $ids = (clone $query)
            ->get()
            ->filter(function ($record) use ($status): bool {
                $recordStatus = self::achievementStatusKey($record);

                if ($status === 'achieved') {
                    return $recordStatus === 'achieved';
                }

                return $recordStatus !== 'achieved';
            })
            ->pluck('id')
            ->values()
            ->all();

        return $query->whereIn('id', $ids);
    }

    private static function selectedYear(): int
    {
        $year = (int) (self::queryValue('year') ?: now()->year);

        if ($year < 2000 || $year > 2100) {
            return now()->year;
        }

        return $year;
    }

    private static function selectedStatus(): string
    {
        $status = (string) (self::queryValue('status') ?: 'all');

        return array_key_exists($status, self::statusOptions()) ? $status : 'all';
    }

    private static function queryValue(string $key): ?string
    {
        $value = request()->query($key) ?? request()->input($key);

        if ($value !== null && $value !== '') {
            return (string) $value;
        }

        $referer = (string) request()->headers->get('referer', '');

        if ($referer !== '') {
            $query = parse_url($referer, PHP_URL_QUERY);

            if (is_string($query)) {
                parse_str($query, $params);

                if (isset($params[$key]) && $params[$key] !== '') {
                    return (string) $params[$key];
                }
            }
        }

        return null;
    }

    private static function monthlyRevenueForTarget(object $record): int
    {
        if (! Schema::hasTable('orders')) {
            return 0;
        }

        $amountColumn = Schema::hasColumn('orders', 'total_price')
            ? 'total_price'
            : (Schema::hasColumn('orders', 'total_amount') ? 'total_amount' : null);

        if (! $amountColumn) {
            return 0;
        }

        $start = self::periodStart($record);
        $end = $start->copy()->endOfMonth();

        $query = DB::table('orders')
            ->whereBetween(
                DB::raw('COALESCE(ordered_at, created_at)'),
                [$start->toDateTimeString(), $end->toDateTimeString()]
            );

        self::excludeCanceledOrders($query);

        return (int) $query->sum($amountColumn);
    }

    private static function periodStart(object $record): Carbon
    {
        return Carbon::parse(data_get($record, 'month'))->startOfMonth();
    }

    private static function progressForTarget(object $record): float
    {
        $target = (int) data_get($record, 'target_revenue', 0);

        if ($target <= 0) {
            return 0.0;
        }

        $actual = self::monthlyRevenueForTarget($record);

        return round(min(($actual / $target) * 100, 999), 1);
    }

    private static function gapForTarget(object $record): int
    {
        $actual = self::monthlyRevenueForTarget($record);
        $target = (int) data_get($record, 'target_revenue', 0);

        return $actual - $target;
    }

    private static function achievementStatusKey(object $record): string
    {
        $target = (int) data_get($record, 'target_revenue', 0);
        $actual = self::monthlyRevenueForTarget($record);

        if ($target <= 0) {
            return 'no_target';
        }

        if ($actual <= 0) {
            return 'no_transaction';
        }

        $progress = ($actual / $target) * 100;

        if ($progress >= 100) {
            return 'achieved';
        }

        if ($progress >= 80) {
            return 'near';
        }

        return 'not_achieved';
    }

    private static function achievementStatusLabel(string $status): string
    {
        return [
            'all' => 'Semua Status',
            'achieved' => 'Tercapai',
            'near' => 'Hampir Tercapai',
            'not_achieved' => 'Belum Tercapai',
            'no_transaction' => 'Belum Ada Transaksi',
            'no_target' => 'Belum Ada Target',
        ][$status] ?? 'Belum Tercapai';
    }

    private static function totalDataForFilter(): int
    {
        if (! Schema::hasTable('sales_targets')) {
            return 0;
        }

        $year = self::selectedYear();
        $status = self::selectedStatus();

        $records = DB::table('sales_targets')
            ->whereYear('month', $year)
            ->get();

        if ($status === 'all') {
            return $records->count();
        }

        return $records
            ->filter(function (object $record) use ($status): bool {
                $recordStatus = self::achievementStatusKey($record);

                if ($status === 'achieved') {
                    return $recordStatus === 'achieved';
                }

                return $recordStatus !== 'achieved';
            })
            ->count();
    }

    private static function tableHeaderDescription(): string
    {
        return 'Ringkasan target revenue, aktual transaksi, progress, dan selisih per bulan. Filter aktif: '
            . self::selectedYear()
            . ' • '
            . self::achievementStatusLabel(self::selectedStatus());
    }

    private static function statusOptions(): array
    {
        return [
            'all' => 'Semua Status',
            'achieved' => 'Tercapai',
            'not_achieved' => 'Belum Tercapai',
        ];
    }

    private static function rupiah(int|float|null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private static function rupiahWithSign(int $value): string
    {
        $prefix = $value > 0 ? '+' : ($value < 0 ? '-' : '');

        return $prefix . 'Rp ' . number_format(abs($value), 0, ',', '.');
    }

    private static function excludeCanceledOrders(Builder $query): void
    {
        if (! Schema::hasColumn('orders', 'status')) {
            return;
        }

        $query->where(function (Builder $statusQuery): void {
            $statusQuery
                ->whereNull('status')
                ->orWhereNotIn(DB::raw('LOWER(status)'), [
                    'batal',
                    'dibatalkan',
                    'cancel',
                    'cancelled',
                    'canceled',
                ]);
        });
    }
}
