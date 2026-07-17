<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Widgets;

use App\Filament\Admin\Pages\FinancialDashboard;
use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Models\OperationalCost;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class OperationalCostAnalyticsWidget extends Widget
{
    public int|string|null $selectedMonth = null;

    public int|string|null $selectedYear = null;

    protected string $view = 'filament.admin.resources.operational-costs.widgets.operational-cost-analytics-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function rupiah(int|float|null $value): string
    {
        return 'Rp '.number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    protected function getViewData(): array
    {
        $period = $this->selectedPeriod();
        $start = $period['start'];
        $end = $period['end'];

        $activeCostRows = OperationalCost::query()
            ->where('is_active', true)
            ->get();

        $periodCosts = $activeCostRows
            ->map(function (OperationalCost $cost) use ($start, $end): array {
                return [
                    'record' => $cost,
                    'allocated' => $this->allocatedCostForPeriod($cost, $start, $end),
                ];
            })
            ->filter(fn (array $row): bool => $row['allocated'] > 0)
            ->values();

        $monthlyCost = (int) $periodCosts->sum('allocated');

        $recurringMonthlyCost = (int) $periodCosts
            ->filter(fn (array $row): bool => $this->costType($row['record']) === 'monthly')
            ->sum('allocated');

        $annualMonthlyCost = (int) $periodCosts
            ->filter(fn (array $row): bool => $this->costType($row['record']) === 'annual')
            ->sum('allocated');

        $oneTimeCost = (int) $periodCosts
            ->filter(fn (array $row): bool => $this->costType($row['record']) === 'one_time')
            ->sum('allocated');

        $totalCosts = (int) OperationalCost::query()->count();

        $periodActiveCosts = (int) $periodCosts->count();

        $inactiveCosts = (int) OperationalCost::query()
            ->where('is_active', false)
            ->count();

        $adjustedThisMonth = $this->monthlyAdjustmentTableExists()
            ? (int) DB::table('operational_cost_monthly_adjustments')
                ->where('month', $period['selected_month'])
                ->where('year', $period['selected_year'])
                ->where('is_deleted_for_month', false)
                ->count()
            : 0;

        $annualInputTotal = (int) $activeCostRows
            ->filter(fn (OperationalCost $cost): bool => $this->costType($cost) === 'annual')
            ->sum(fn (OperationalCost $cost): int => (int) $cost->amount);

        $highestPeriodCost = $periodCosts
            ->sortByDesc('allocated')
            ->first();

        $highestCost = $highestPeriodCost['record'] ?? null;
        $highestCostAmount = (int) ($highestPeriodCost['allocated'] ?? 0);

        $latestPeriodCost = $periodCosts
            ->sortByDesc(fn (array $row): string => (string) $row['record']->cost_date)
            ->first();

        $latestCost = $latestPeriodCost['record'] ?? null;

        $categoryBreakdown = $periodCosts
            ->groupBy(fn (array $row): string => (string) $row['record']->category)
            ->map(fn ($items, string $category): array => [
                'label' => $this->categoryLabel($category),
                'value' => (int) collect($items)->sum('allocated'),
            ])
            ->sortByDesc('value')
            ->take(5)
            ->values()
            ->all();

        $periodQuery = [
            'month' => (string) $period['selected_month'],
            'year' => (string) $period['selected_year'],
        ];

        return [
            'createUrl' => OperationalCostResource::getUrl('create').'?'.http_build_query($periodQuery),
            'indexUrl' => OperationalCostResource::getUrl('index'),
            'dashboardUrl' => FinancialDashboard::getUrl().'?'.http_build_query($periodQuery),
            'period' => [
                'label' => $period['label'],
                'start' => $start->translatedFormat('d M Y'),
                'end' => $end->translatedFormat('d M Y'),
                'selected_month' => (string) $period['selected_month'],
                'selected_year' => (int) $period['selected_year'],
            ],
            'filters' => [
                'months' => $this->monthFilterOptions(),
                'years' => range(now()->year - 4, now()->year + 1),
            ],
            'summary' => [
                'monthly_cost' => $monthlyCost,
                'normal_monthly_cost' => $recurringMonthlyCost + $oneTimeCost,
                'recurring_monthly_cost' => $recurringMonthlyCost,
                'annual_monthly_cost' => $annualMonthlyCost,
                'one_time_cost' => $oneTimeCost,
                'rent_monthly_cost' => $annualMonthlyCost,
                'total_costs' => $totalCosts,
                'active_costs' => $periodActiveCosts,
                'inactive_costs' => $inactiveCosts,
                'adjusted_this_month' => $adjustedThisMonth,
                'annual_rent' => $annualInputTotal,
                'highest_cost_name' => $highestCost?->name ?? '-',
                'highest_cost_amount' => $highestCostAmount,
                'highest_cost_input_amount' => (int) ($highestCost?->amount ?? 0),
                'latest_cost_name' => $latestCost?->name ?? '-',
                'latest_cost_date' => $latestCost?->cost_date?->format('d M Y') ?? '-',
                'category_breakdown' => $categoryBreakdown,
            ],
        ];
    }

    private function selectedPeriod(): array
    {
        $selectedMonth = (int) (
            $this->selectedMonth
            ?: $this->queryValue('month')
            ?: now()->month
        );

        $selectedYear = (int) (
            $this->selectedYear
            ?: $this->queryValue('year')
            ?: now()->year
        );

        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        $start = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();
        $end = $start->copy()->endOfMonth();

        return [
            'start' => $start,
            'end' => $end,
            'selected_month' => $selectedMonth,
            'selected_year' => $selectedYear,
            'label' => $this->monthName($selectedMonth).' '.$selectedYear,
        ];
    }

    private function queryValue(string $key): ?string
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

    private function allocatedCostForPeriod(OperationalCost $cost, Carbon $start, Carbon $end): int
    {
        if (! $this->costValidForPeriod($cost, $start, $end)) {
            return 0;
        }

        $adjustment = $this->monthlyAdjustmentForPeriod($cost, $start);

        if ($adjustment !== null) {
            if ((bool) $adjustment->is_deleted_for_month) {
                return 0;
            }

            if ($adjustment->amount !== null) {
                return (int) $adjustment->amount;
            }
        }

        $costDate = Carbon::parse($cost->cost_date)->startOfDay();
        $amount = (int) $cost->amount;

        return match ($this->costType($cost)) {
            'annual' => $this->annualAllocationForPeriod($costDate, $amount, $start, $end),
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()) ? $amount : 0,
            default => $costDate->lte($end->copy()->endOfDay()) ? $amount : 0,
        };
    }

    private function costValidForPeriod(OperationalCost $cost, Carbon $start, Carbon $end): bool
    {
        $costDate = Carbon::parse($cost->cost_date)->startOfDay();

        return match ($this->costType($cost)) {
            'annual' => $this->countAnnualOverlapMonths($costDate, $start, $end) > 0,
            'one_time' => $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay()),
            default => $costDate->lte($end->copy()->endOfDay()),
        };
    }

    private function annualAllocationForPeriod(Carbon $costDate, int $amount, Carbon $start, Carbon $end): int
    {
        $months = $this->countAnnualOverlapMonths($costDate, $start, $end);

        return $months > 0 ? (int) round(($amount / 12) * $months) : 0;
    }

    private function monthlyAdjustmentForPeriod(OperationalCost $cost, Carbon $periodStart): ?object
    {
        if (! $this->monthlyAdjustmentTableExists()) {
            return null;
        }

        return DB::table('operational_cost_monthly_adjustments')
            ->where('operational_cost_id', $cost->id)
            ->where('month', $periodStart->month)
            ->where('year', $periodStart->year)
            ->first();
    }

    private function monthlyAdjustmentTableExists(): bool
    {
        static $exists = null;

        if ($exists !== null) {
            return $exists;
        }

        return $exists = Schema::hasTable('operational_cost_monthly_adjustments');
    }

    private function costType(object $cost): string
    {
        $type = (string) data_get($cost, 'cost_type', '');

        if (in_array($type, ['one_time', 'monthly', 'annual'], true)) {
            return $type;
        }

        return ((string) data_get($cost, 'category', '') === 'rent') ? 'annual' : 'monthly';
    }

    private function countAnnualOverlapMonths(Carbon $costDate, Carbon $periodStart, Carbon $periodEnd): int
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

    private function monthFilterOptions(): array
    {
        return [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    private function monthName(int $month): string
    {
        return $this->monthFilterOptions()[(string) $month] ?? 'Bulan';
    }

    private function categoryLabel(string $category): string
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
