<?php

namespace App\Filament\Admin\Resources\SalesTargets\Widgets;

use App\Filament\Admin\Resources\SalesTargets\SalesTargetResource;
use App\Models\SalesTarget;
use Filament\Widgets\Widget;

class SalesTargetFormHeroWidget extends Widget
{
    protected string $view = 'filament.admin.resources.sales-targets.widgets.sales-target-form-hero-widget';

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $routeName = request()->route()?->getName() ?? '';
        $isEdit = str_contains($routeName, '.edit');

        $monthStart = now()->startOfMonth()->toDateString();

        $currentTarget = SalesTarget::query()
            ->whereDate('month', $monthStart)
            ->first();

        $totalTargets = (int) SalesTarget::query()->count();

        $yearTargetRevenue = (int) SalesTarget::query()
            ->whereBetween('month', [
                now()->startOfYear()->toDateString(),
                now()->endOfYear()->toDateString(),
            ])
            ->sum('target_revenue');

        return [
            'title' => $isEdit ? 'Edit Target Penjualan' : 'Tambah Target Penjualan',
            'description' => $isEdit
                ? 'Perbarui target revenue, gross profit, dan net profit agar progress dashboard tetap akurat.'
                : 'Tetapkan target bulanan untuk mengukur performa revenue, laba kotor, dan laba bersih usaha.',
            'backUrl' => SalesTargetResource::getUrl('index'),
            'stats' => [
                'total_targets' => $totalTargets,
                'current_target_revenue' => (int) ($currentTarget?->target_revenue ?? 0),
                'year_target_revenue' => $yearTargetRevenue,
            ],
        ];
    }

    public function rupiah(int | float | null $value): string
    {
        return 'Rp ' . number_format((int) round((float) ($value ?? 0)), 0, ',', '.');
    }
}