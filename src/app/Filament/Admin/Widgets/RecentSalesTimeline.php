<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Widgets\Concerns\HasDashboardMetric;
use App\Models\Order;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class RecentSalesTimeline extends Widget
{
    use HasDashboardMetric;

    protected string $view = 'filament.admin.widgets.recent-sales-timeline';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 4,
    ];

    protected function getViewData(): array
    {
        $query = Order::query()
            ->where('status', 'Selesai');

        $this->applyDashboardPeriodFilterToOrderQuery($query);

        $orders = (clone $query)
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->limit(6)
            ->get([
                'id',
                'order_code',
                'total_item',
                'total_price',
                'status',
                'ordered_at',
                'created_at',
            ]);

        $maxRevenue = max((int) $orders->max('total_price'), 1);

        return [
            'orders' => $orders,
            'maxRevenue' => $maxRevenue,
            'totalOrders' => (int) (clone $query)->count(),
            'totalRevenue' => (int) (clone $query)->sum('total_price'),
            'periodLabel' => $this->getDashboardPeriodLabel(),
        ];
    }
}