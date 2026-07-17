<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OperationalCosts\Pages;

use App\Filament\Admin\Resources\OperationalCosts\OperationalCostResource;
use App\Filament\Admin\Resources\OperationalCosts\Widgets\OperationalCostAnalyticsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListOperationalCosts extends ListRecords
{
    protected static string $resource = OperationalCostResource::class;

    protected static bool $isLazy = false;

    public function mount(): void
    {
        $this->syncSelectedOperationalPeriod();

        parent::mount();
    }

    public function hydrate(): void
    {
        $this->syncSelectedOperationalPeriod();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OperationalCostAnalyticsWidget::class,
        ];
    }

    protected function getHeaderWidgetsData(): array
    {
        $period = $this->currentPeriodQuery();

        return [
            'selectedMonth' => (int) $period['month'],
            'selectedYear' => (int) $period['year'],
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Biaya Operasional')
                ->icon('heroicon-o-plus')
                ->color('warning')
                ->url(fn (): string => OperationalCostResource::getUrl('create').'?'.http_build_query($this->currentPeriodQuery())),
        ];
    }

    private function syncSelectedOperationalPeriod(): void
    {
        $selectedMonth = (int) request()->query('month', now()->month);
        $selectedYear = (int) request()->query('year', now()->year);

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        session([
            'ng_operational_cost_month' => $selectedMonth,
            'ng_operational_cost_year' => $selectedYear,
        ]);
    }

    private function currentPeriodQuery(): array
    {
        $selectedMonth = (int) request()->query('month', session('ng_operational_cost_month', now()->month));
        $selectedYear = (int) request()->query('year', session('ng_operational_cost_year', now()->year));

        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = now()->month;
        }

        if ($selectedYear < 2000 || $selectedYear > 2100) {
            $selectedYear = now()->year;
        }

        return [
            'month' => (string) $selectedMonth,
            'year' => (string) $selectedYear,
        ];
    }
}
