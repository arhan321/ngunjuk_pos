<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Models\Order;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use UnitEnum;

class MonthlyRevenueReport extends Page
{
    protected string $view = 'filament.admin.pages.monthly-revenue-report';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Export Monthly Revenue';

    protected static ?int $navigationSort = 2;

    public function getTitle(): string
    {
        return '';
    }

    public function getHeading(): string
    {
        return '';
    }

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('super_admin');
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        $selectedMonth = $this->getSelectedMonth();

        [$startDate, $endDate] = $this->getMonthRange($selectedMonth);

        $baseQuery = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $startDate,
                $endDate,
            ]);

        $totalOrders = (int) (clone $baseQuery)->count();
        $totalItems = (int) (clone $baseQuery)->sum('total_item');
        $totalRevenue = (int) (clone $baseQuery)->sum('total_price');

        $avgOrder = $totalOrders > 0
            ? (int) round($totalRevenue / $totalOrders)
            : 0;

        $highestOrder = (int) ((clone $baseQuery)->max('total_price') ?? 0);
        $lowestOrder = (int) ((clone $baseQuery)->min('total_price') ?? 0);

        $orders = (clone $baseQuery)
            ->orderByDesc(DB::raw('COALESCE(ordered_at, created_at)'))
            ->paginate(
                perPage: 10,
                columns: ['*'],
                pageName: 'ordersPage',
            )
            ->withQueryString();

        return [
            'months' => $this->getAvailableMonths(),
            'selectedMonth' => $selectedMonth,
            'selectedMonthLabel' => Carbon::createFromFormat('Y-m', $selectedMonth)->translatedFormat('F Y'),
            'orders' => $orders,
            'summary' => [
                'total_orders' => $totalOrders,
                'total_items' => $totalItems,
                'total_revenue' => $totalRevenue,
                'avg_order' => $avgOrder,
                'highest_order' => $highestOrder,
                'lowest_order' => $lowestOrder,
            ],
        ];
    }

    private function getAvailableMonths(): array
    {
        $months = Order::query()
            ->where('status', 'Selesai')
            ->select([
                DB::raw("DATE_FORMAT(COALESCE(ordered_at, created_at), '%Y-%m') as month_key"),
            ])
            ->groupBy('month_key')
            ->orderByDesc('month_key')
            ->pluck('month_key')
            ->filter()
            ->values()
            ->toArray();

        if (empty($months)) {
            return [
                now()->format('Y-m'),
            ];
        }

        return $months;
    }

    private function getSelectedMonth(): string
    {
        $month = request()->query('month');

        if (! $month) {
            $referer = request()->headers->get('referer');

            if ($referer) {
                $query = parse_url($referer, PHP_URL_QUERY);

                if ($query) {
                    parse_str($query, $params);

                    $month = $params['month'] ?? null;
                }
            }
        }

        $availableMonths = $this->getAvailableMonths();

        $month = (string) ($month ?: $availableMonths[0]);

        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            return $availableMonths[0];
        }

        if (! in_array($month, $availableMonths, true)) {
            return $availableMonths[0];
        }

        return $month;
    }

    private function getMonthRange(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);

        return [
            $date->copy()->startOfMonth(),
            $date->copy()->endOfMonth(),
        ];
    }

    public function exportSelectedMonth(): StreamedResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('super_admin'),
            403
        );

        $selectedMonth = $this->getSelectedMonth();

        [$startDate, $endDate] = $this->getMonthRange($selectedMonth);

        $orders = Order::query()
            ->where('status', 'Selesai')
            ->whereBetween(DB::raw('COALESCE(ordered_at, created_at)'), [
                $startDate,
                $endDate,
            ])
            ->orderBy(DB::raw('COALESCE(ordered_at, created_at)'))
            ->get();

        $monthLabel = Carbon::createFromFormat('Y-m', $selectedMonth)->translatedFormat('F Y');

        $totalOrders = (int) $orders->count();
        $totalItems = (int) $orders->sum('total_item');
        $totalRevenue = (int) $orders->sum('total_price');

        $avgOrder = $totalOrders > 0
            ? (int) round($totalRevenue / $totalOrders)
            : 0;

        $fileName = 'monthly-revenue-ngunjuk-' . $selectedMonth . '.xls';

        return response()->streamDownload(function () use (
            $orders,
            $monthLabel,
            $totalOrders,
            $totalItems,
            $totalRevenue,
            $avgOrder
        ): void {
            echo "\xEF\xBB\xBF";

            echo '
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                            }

                            table {
                                border-collapse: collapse;
                                width: 100%;
                            }

                            th {
                                background: #f97316;
                                color: #ffffff;
                                font-weight: bold;
                                border: 1px solid #d9d9d9;
                                padding: 8px;
                            }

                            td {
                                border: 1px solid #d9d9d9;
                                padding: 8px;
                            }

                            .title {
                                font-size: 18px;
                                font-weight: bold;
                            }

                            .subtitle {
                                color: #666666;
                            }

                            .summary-label {
                                background: #fff3df;
                                font-weight: bold;
                            }

                            .total-row {
                                background: #fff3df;
                                font-weight: bold;
                            }
                        </style>
                    </head>

                    <body>
                        <table>
                            <tr>
                                <td colspan="6" class="title">LAPORAN MONTHLY REVENUE</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="subtitle">Sistem Informasi Point of Sale UMKM Ngunjuk</td>
                            </tr>
                            <tr>
                                <td colspan="6">Periode: ' . e($monthLabel) . '</td>
                            </tr>
                            <tr><td colspan="6"></td></tr>

                            <tr>
                                <td class="summary-label">Total Orders</td>
                                <td>' . number_format($totalOrders, 0, ',', '.') . '</td>
                                <td class="summary-label">Units Sold</td>
                                <td>' . number_format($totalItems, 0, ',', '.') . '</td>
                                <td class="summary-label">Avg Order</td>
                                <td>Rp ' . number_format($avgOrder, 0, ',', '.') . '</td>
                            </tr>

                            <tr>
                                <td class="summary-label">Total Revenue</td>
                                <td colspan="5">Rp ' . number_format($totalRevenue, 0, ',', '.') . '</td>
                            </tr>

                            <tr><td colspan="6"></td></tr>

                            <tr>
                                <th>No</th>
                                <th>ID Order</th>
                                <th>Tanggal</th>
                                <th>Total Item</th>
                                <th>Total Revenue</th>
                                <th>Status</th>
                            </tr>
            ';

            foreach ($orders as $index => $order) {
                $date = $order->ordered_at ?? $order->created_at;

                echo '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>' . e($order->order_code ?? ('ORD-' . $order->id)) . '</td>
                        <td>' . e(Carbon::parse($date)->translatedFormat('d F Y H:i')) . '</td>
                        <td>' . number_format((int) $order->total_item, 0, ',', '.') . '</td>
                        <td>Rp ' . number_format((int) $order->total_price, 0, ',', '.') . '</td>
                        <td>' . e($order->status) . '</td>
                    </tr>
                ';
            }

            echo '
                            <tr class="total-row">
                                <td colspan="3">TOTAL</td>
                                <td>' . number_format($totalItems, 0, ',', '.') . '</td>
                                <td>Rp ' . number_format($totalRevenue, 0, ',', '.') . '</td>
                                <td></td>
                            </tr>
                        </table>
                    </body>
                </html>
            ';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
        ]);
    }
}