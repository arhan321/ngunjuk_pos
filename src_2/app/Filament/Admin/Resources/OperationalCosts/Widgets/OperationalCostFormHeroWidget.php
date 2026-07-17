<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Widgets;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Models\OperationalCost;
use Carbon\Carbon;
use Filament\Widgets\Widget;

final class OperationalCostFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.operational-costs.widgets.operational-cost-form-hero-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function rupiah(int|float|null $value): string
    {
        return 'Rp '.number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }

    protected function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $totalCosts = (int) OperationalCost::query()->count();

        $activeCosts = (int) OperationalCost::query()
            ->where('is_active', true)
            ->count();

        $monthlyCost = (int) OperationalCost::query()
            ->where('is_active', true)
            ->get()
            ->sum(fn (OperationalCost $cost): int => $this->allocatedCostForPeriod($cost, $start, $end));

        return [
            'title' => $isEdit ? 'Edit Biaya Operasional' : 'Tambah Biaya Operasional',
            'description' => $isEdit
                ? 'Perbarui data biaya berdasarkan tanggal bayar dan tipe biaya agar Dashboard Keuangan tetap akurat.'
                : 'Input biaya usaha berdasarkan tanggal bayar. Pilih tipe biaya agar sistem tahu apakah biaya masuk sekali, bulanan, atau tahunan.',
            'backUrl' => OperationalCostResource::getUrl('index'),
            'stats' => [
                'total_costs' => $totalCosts,
                'active_costs' => $activeCosts,
                'monthly_cost' => $monthlyCost,
            ],
        ];
    }

    private function allocatedCostForPeriod(OperationalCost $cost, Carbon $start, Carbon $end): int
    {
        $costDate = Carbon::parse($cost->cost_date)->startOfDay();
        $amount = (int) $cost->amount;

        if ($this->costType($cost) === 'annual') {
            $months = $this->countAnnualOverlapMonths($costDate, $start, $end);

            return $months > 0 ? (int) round(($amount / 12) * $months) : 0;
        }

        return $costDate->betweenIncluded($start->copy()->startOfDay(), $end->copy()->endOfDay())
            ? $amount
            : 0;
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
}
