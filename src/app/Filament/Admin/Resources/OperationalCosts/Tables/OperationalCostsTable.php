<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Tables;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OperationalCostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => self::applySelectedPeriodQuery($query))
            ->columns([
                TextColumn::make('name')
                    ->label('Biaya')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => self::compactDescription($record))
                    ->wrap(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-name-col',
                        'style' => 'width: 260px !important; min-width: 260px !important; max-width: 260px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-name-col',
                        'style' => 'width: 260px !important; min-width: 260px !important; max-width: 260px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('allocated_monthly')
                    ->label('Nominal')
                    ->getStateUsing(fn ($record): int => self::allocatedAmountForSelectedPeriod($record))
                    ->alignEnd()
                    ->formatStateUsing(fn ($state): string => self::rupiah((int) $state))
                    ->description(fn ($record): string => self::allocationDescription($record))
                    ->sortable(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-nominal-col',
                        'style' => 'width: 210px !important; min-width: 210px !important; max-width: 210px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-nominal-col',
                        'style' => 'width: 210px !important; min-width: 210px !important; max-width: 210px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('period_status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(fn ($record): string => self::periodStatus($record))
                    ->color(fn ($state): string => match ($state) {
                        'Disesuaikan' => 'warning',
                        'Dihapus Bulan Ini' => 'danger',
                        'Nonaktif' => 'danger',
                        'Tahunan' => 'info',
                        'Sekali Bayar' => 'gray',
                        default => 'success',
                    })
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-status-col',
                        'style' => 'width: 170px !important; min-width: 170px !important; max-width: 170px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-status-col',
                        'style' => 'width: 170px !important; min-width: 170px !important; max-width: 170px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),

                TextColumn::make('active_period_display')
                    ->label('Tanggal')
                    ->getStateUsing(fn ($record): string => self::activePeriodDisplay($record))
                    ->sortable(false)
                    ->extraHeaderAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-date-col',
                        'style' => 'width: 160px !important; min-width: 160px !important; max-width: 160px !important; white-space: nowrap !important;',
                    ])
                    ->extraCellAttributes([
                        'class' => 'ng-mobile-table-col ng-operational-cost-col ng-operational-cost-date-col',
                        'style' => 'width: 160px !important; min-width: 160px !important; max-width: 160px !important; white-space: nowrap !important; word-break: normal !important; overflow-wrap: normal !important;',
                    ]),
            ])
            ->headerActions([])
            ->recordActions([
                ActionGroup::make([
                    Action::make('edit_current_month')
                        ->label('Edit Bulan Ini')
                        ->icon('heroicon-o-calendar-days')
                        ->color('warning')
                        ->modalHeading(fn ($record): string => 'Edit Bulan Ini - ' . $record->name)
                        ->modalDescription('Perubahan ini hanya berlaku pada bulan filter yang sedang aktif. Bulan lain tetap memakai nominal master.')
                        ->form([
                            TextInput::make('amount')
                                ->label('Nominal Bulan Ini')
                                ->numeric()
                                ->prefix('Rp')
                                ->minValue(0)
                                ->required(),

                            Textarea::make('note')
                                ->label('Catatan Bulan Ini')
                                ->rows(3)
                                ->placeholder('Contoh: tagihan bulan ini naik / ada penyesuaian khusus'),
                        ])
                        ->fillForm(fn ($record): array => [
                            'amount' => self::allocatedAmountForSelectedPeriod($record),
                            'note' => self::currentAdjustmentNote($record),
                        ])
                        ->action(function (array $data, $record): void {
                            self::saveMonthlyAdjustment(
                                record: $record,
                                amount: (int) ($data['amount'] ?? 0),
                                note: $data['note'] ?? null,
                                deleted: false,
                            );
                        })
                        ->successNotificationTitle('Nominal bulan ini berhasil disesuaikan'),

                    Action::make('delete_current_month')
                        ->label('Hapus Bulan Ini')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus dari bulan aktif?')
                        ->modalDescription('Biaya ini hanya dihapus dari bulan yang sedang dipilih. Data master dan bulan lainnya tetap aman.')
                        ->action(function ($record): void {
                            self::saveMonthlyAdjustment(
                                record: $record,
                                amount: 0,
                                note: 'Dihapus dari bulan aktif',
                                deleted: true,
                            );
                        })
                        ->successNotificationTitle('Biaya berhasil dihapus dari bulan aktif'),

                    Action::make('reset_current_month')
                        ->label('Reset Bulan Ini')
                        ->icon('heroicon-o-arrow-path')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => self::currentAdjustment($record) !== null)
                        ->modalHeading('Reset penyesuaian bulan ini?')
                        ->modalDescription('Nominal bulan ini akan kembali mengikuti nominal master.')
                        ->action(function ($record): void {
                            self::deleteMonthlyAdjustment($record);
                        })
                        ->successNotificationTitle('Penyesuaian bulan ini berhasil direset'),

                    EditAction::make()
                        ->label('Edit Master')
                        ->icon('heroicon-o-pencil-square')
                        ->color('primary'),

                    DeleteAction::make()
                        ->label('Hapus Master')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ])
                    ->label('')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->button()
                    ->size('sm')
                    ->color('gray'),
            ])
            ->toolbarActions([])
            ->emptyStateIcon('heroicon-o-receipt-percent')
            ->emptyStateHeading('Tidak ada data sesuai filter')
            ->emptyStateDescription('Coba ubah Status Data menjadi Aktif, Nonaktif, atau Semua.')
            ->defaultSort('cost_date', 'desc');
    }

    private static function applySelectedPeriodQuery(Builder $query): Builder
    {
        [$start, $end, $selectedMonth, $selectedYear] = self::selectedPeriod();

        $startDate = $start->toDateString();
        $endDate = $end->toDateString();
        $status = self::selectedDataStatus();

        if ($status === 'inactive') {
            return $query->where(function (Builder $statusQuery) use ($selectedMonth, $selectedYear): void {
                $statusQuery->where('is_active', false);

                if (self::monthlyAdjustmentTableExists()) {
                    $statusQuery->orWhereExists(function ($subQuery) use ($selectedMonth, $selectedYear): void {
                        $subQuery
                            ->selectRaw('1')
                            ->from('operational_cost_monthly_adjustments as ocma')
                            ->whereColumn('ocma.operational_cost_id', 'operational_costs.id')
                            ->where('ocma.month', $selectedMonth)
                            ->where('ocma.year', $selectedYear)
                            ->where('ocma.is_deleted_for_month', true);
                    });
                }
            });
        }

        if ($status === 'all') {
            return $query;
        }

        $query = self::applyActivePeriodBaseQuery($query, $startDate, $endDate)
            ->where('is_active', true);

        if (self::monthlyAdjustmentTableExists()) {
            $query->whereNotExists(function ($subQuery) use ($selectedMonth, $selectedYear): void {
                $subQuery
                    ->selectRaw('1')
                    ->from('operational_cost_monthly_adjustments as ocma')
                    ->whereColumn('ocma.operational_cost_id', 'operational_costs.id')
                    ->where('ocma.month', $selectedMonth)
                    ->where('ocma.year', $selectedYear)
                    ->where('ocma.is_deleted_for_month', true);
            });
        }

        return $query;
    }

    private static function applyActivePeriodBaseQuery(Builder $query, string $startDate, string $endDate): Builder
    {
        return $query->where(function (Builder $query) use ($startDate, $endDate): void {
            $query
                ->where(function (Builder $monthlyQuery) use ($endDate): void {
                    $monthlyQuery
                        ->where(function (Builder $typeQuery): void {
                            $typeQuery
                                ->where('cost_type', 'monthly')
                                ->orWhere(function (Builder $legacyNormal): void {
                                    $legacyNormal
                                        ->where(function (Builder $blankType): void {
                                            $blankType
                                                ->whereNull('cost_type')
                                                ->orWhere('cost_type', '');
                                        })
                                        ->where('category', '!=', 'rent');
                                });
                        })
                        ->whereDate('cost_date', '<=', $endDate);
                })
                ->orWhere(function (Builder $oneTimeQuery) use ($startDate, $endDate): void {
                    $oneTimeQuery
                        ->where('cost_type', 'one_time')
                        ->whereBetween('cost_date', [$startDate, $endDate]);
                })
                ->orWhere(function (Builder $annualQuery) use ($startDate, $endDate): void {
                    $annualQuery
                        ->where(function (Builder $typeQuery): void {
                            $typeQuery
                                ->where('cost_type', 'annual')
                                ->orWhere(function (Builder $legacyRent): void {
                                    $legacyRent
                                        ->where(function (Builder $blankType): void {
                                            $blankType
                                                ->whereNull('cost_type')
                                                ->orWhere('cost_type', '');
                                        })
                                        ->where('category', 'rent');
                                });
                        })
                        ->whereDate('cost_date', '<=', $endDate)
                        ->whereRaw("DATE_ADD(DATE_FORMAT(cost_date, '%Y-%m-01'), INTERVAL 11 MONTH) >= ?", [$startDate]);
                });
        });
    }

    private static function selectedDataStatus(): string
    {
        $status = (string) (self::queryValue('status') ?: session('ng_operational_cost_status', 'active'));

        if (! in_array($status, ['active', 'inactive', 'all'], true)) {
            $status = 'active';
        }

        session(['ng_operational_cost_status' => $status]);

        return $status;
    }

    private static function selectedPeriod(): array
    {
        $selectedMonth = (int) (self::queryValue('month') ?: session('ng_operational_cost_month', now()->month));
        $selectedYear = (int) (self::queryValue('year') ?: session('ng_operational_cost_year', now()->year));

        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        $start = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();

        return [
            $start,
            $start->copy()->endOfMonth(),
            $selectedMonth,
            $selectedYear,
        ];
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

    private static function rupiah(int|float|null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    private static function costType(object $record): string
    {
        $type = (string) data_get($record, 'cost_type', '');

        if (in_array($type, ['one_time', 'monthly', 'annual'], true)) {
            return $type;
        }

        return ((string) data_get($record, 'category', '') === 'rent') ? 'annual' : 'monthly';
    }

    private static function costTypeLabel(string $type): string
    {
        return match ($type) {
            'one_time' => 'Sekali Bayar',
            'annual' => 'Tahunan',
            default => 'Rutin Bulanan',
        };
    }

    private static function compactDescription(object $record): string
    {
        $category = self::categoryLabel((string) data_get($record, 'category', 'other'));
        $type = self::costTypeLabel(self::costType($record));

        return $category . ' • ' . $type;
    }

    private static function allocatedAmountForSelectedPeriod(object $record): int
    {
        [$start, $end] = self::selectedPeriod();

        if (! self::recordValidForPeriod($record, $start, $end)) {
            return 0;
        }

        $adjustment = self::currentAdjustment($record);

        if ($adjustment !== null) {
            if ((bool) $adjustment->is_deleted_for_month) {
                return 0;
            }

            if ($adjustment->amount !== null) {
                return (int) $adjustment->amount;
            }
        }

        $costDate = Carbon::parse(data_get($record, 'cost_date'))->startOfDay();
        $amount = (int) data_get($record, 'amount', 0);

        return match (self::costType($record)) {
            'annual' => self::annualAllocationForPeriod($costDate, $amount, $start, $end),
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()) ? $amount : 0,
            default => $costDate->lte($end->copy()->endOfDay()) ? $amount : 0,
        };
    }

    private static function recordValidForPeriod(object $record, Carbon $start, Carbon $end): bool
    {
        $costDate = Carbon::parse(data_get($record, 'cost_date'))->startOfDay();

        return match (self::costType($record)) {
            'annual' => self::countAnnualOverlapMonths($costDate, $start, $end) > 0,
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()),
            default => $costDate->lte($end->copy()->endOfDay()),
        };
    }

    private static function annualAllocationForPeriod(Carbon $costDate, int $amount, Carbon $start, Carbon $end): int
    {
        $months = self::countAnnualOverlapMonths($costDate, $start, $end);

        return $months > 0 ? (int) round(($amount / 12) * $months) : 0;
    }

    private static function countAnnualOverlapMonths(Carbon $costDate, Carbon $periodStart, Carbon $periodEnd): int
    {
        $annualStart = $costDate->copy()->startOfMonth();
        $annualEnd = $annualStart->copy()->addMonths(11)->endOfMonth();
        $rangeStart = $periodStart->copy()->startOfMonth();
        $rangeEnd = $periodEnd->copy()->endOfMonth();

        if ($annualEnd->lt($rangeStart) || $annualStart->gt($rangeEnd)) {
            return 0;
        }

        $overlapStart = $annualStart->gt($rangeStart) ? $annualStart->copy() : $rangeStart->copy();
        $overlapEnd = $annualEnd->lt($rangeEnd) ? $annualEnd->copy() : $rangeEnd->copy();

        return (($overlapEnd->year - $overlapStart->year) * 12) + ($overlapEnd->month - $overlapStart->month) + 1;
    }

    private static function allocationDescription(object $record): string
    {
        $adjustment = self::currentAdjustment($record);

        if (! (bool) data_get($record, 'is_active', true)) {
            return 'Tidak dihitung';
        }

        if ($adjustment !== null) {
            if ((bool) $adjustment->is_deleted_for_month) {
                return 'Tidak dihitung';
            }

            return 'Khusus bulan ini';
        }

        return match (self::costType($record)) {
            'annual' => 'Alokasi tahunan',
            'one_time' => 'Sekali bayar',
            default => 'Default master',
        };
    }

    private static function periodStatus(object $record): string
    {
        $adjustment = self::currentAdjustment($record);

        if ($adjustment !== null) {
            if ((bool) $adjustment->is_deleted_for_month) {
                return 'Dihapus Bulan Ini';
            }

            return 'Disesuaikan';
        }

        if (! (bool) data_get($record, 'is_active', true)) {
            return 'Nonaktif';
        }

        return match (self::costType($record)) {
            'annual' => 'Tahunan',
            'one_time' => 'Sekali Bayar',
            default => 'Default Master',
        };
    }

    private static function currentAdjustmentNote(object $record): ?string
    {
        $adjustment = self::currentAdjustment($record);

        return $adjustment?->note;
    }

    private static function currentAdjustment(object $record): ?object
    {
        if (! self::monthlyAdjustmentTableExists()) {
            return null;
        }

        [, , $selectedMonth, $selectedYear] = self::selectedPeriod();

        return DB::table('operational_cost_monthly_adjustments')
            ->where('operational_cost_id', data_get($record, 'id'))
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->first();
    }

    private static function saveMonthlyAdjustment(object $record, int $amount, ?string $note, bool $deleted): void
    {
        if (! self::monthlyAdjustmentTableExists()) {
            return;
        }

        [, , $selectedMonth, $selectedYear] = self::selectedPeriod();

        DB::table('operational_cost_monthly_adjustments')->updateOrInsert(
            [
                'operational_cost_id' => data_get($record, 'id'),
                'month' => $selectedMonth,
                'year' => $selectedYear,
            ],
            [
                'amount' => $deleted ? null : max(0, $amount),
                'note' => $note,
                'is_deleted_for_month' => $deleted,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    private static function deleteMonthlyAdjustment(object $record): void
    {
        if (! self::monthlyAdjustmentTableExists()) {
            return;
        }

        [, , $selectedMonth, $selectedYear] = self::selectedPeriod();

        DB::table('operational_cost_monthly_adjustments')
            ->where('operational_cost_id', data_get($record, 'id'))
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->delete();
    }

    private static function monthlyAdjustmentTableExists(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        return $exists = Schema::hasTable('operational_cost_monthly_adjustments');
    }

    private static function activePeriodDisplay(object $record): string
    {
        [$start] = self::selectedPeriod();

        $costDate = Carbon::parse(data_get($record, 'cost_date'))->startOfDay();

        if (self::costType($record) === 'one_time') {
            return $costDate->format('d M Y');
        }

        $day = min($costDate->day, $start->copy()->endOfMonth()->day);

        return $start->copy()
            ->day($day)
            ->format('d M Y');
    }

    private static function categoryLabel(string $category): string
    {
        return match ($category) {
            'rent' => 'Sewa Tempat',
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Wifi / Internet',
            'salary' => 'Gaji',
            'marketing' => 'Promosi / Marketing',
            'maintenance' => 'Maintenance',
            default => 'Lainnya',
        };
    }
}
