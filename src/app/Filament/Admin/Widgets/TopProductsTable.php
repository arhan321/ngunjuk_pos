<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\OrderItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopProductsTable extends TableWidget
{
    use HasDashboardMetric;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 8,
    ];

    protected function getTablePaginationPageOptions(): array
    {
        return [5];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Top Product by ' . $this->getDashboardMetricLabel() . ' - ' . $this->getDashboardPeriodLabel())
            ->query($this->getTableQuery())
            ->paginated([5])
            ->columns([
                TextColumn::make('product_name')
                    ->label('Produk')
                    ->searchable(),

                TextColumn::make('orders_count')
                    ->label('Orders')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('units_sold')
                    ->label('Units Sold')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('revenue')
                    ->label('Revenue')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->defaultSort($this->getDashboardMetricSortColumn(), 'desc');
    }

    protected function getTableQuery(): Builder
    {
        $query = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        return $query
            ->select([
                DB::raw('MIN(order_items.id) as id'),
                'order_items.product_name as product_name',
                DB::raw('COUNT(DISTINCT order_items.order_id) as orders_count'),
                DB::raw('SUM(order_items.quantity) as units_sold'),
                DB::raw('SUM(order_items.subtotal) as revenue'),
            ])
            ->groupBy('order_items.product_name');
    }
}