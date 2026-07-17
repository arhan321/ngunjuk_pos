<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrdersTable extends TableWidget
{
    use HasDashboardMetric;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 4,
    ];

    protected function getTablePaginationPageOptions(): array
    {
        return [5];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest Orders - ' . $this->getDashboardPeriodLabel())
            ->query($this->getTableQuery())
            ->paginated([5])
            ->columns([
                TextColumn::make('order_code')
                    ->label('ID Order')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('ID order berhasil disalin')
                    ->copyMessageDuration(1500)
                    ->extraAttributes([
                        'class' => 'whitespace-nowrap',
                    ]),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->extraAttributes([
                        'class' => 'whitespace-nowrap',
                    ]),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Diproses' => 'warning',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('ordered_at', 'desc');
    }

    protected function getTableQuery(): Builder
    {
        $query = Order::query()
            ->latest('ordered_at');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        return $query;
    }
}