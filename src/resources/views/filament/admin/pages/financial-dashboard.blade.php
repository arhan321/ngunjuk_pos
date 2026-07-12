<x-filament-panels::page>
    @php
        $finance = $this->getFinancialDashboardData();

        $period = $finance['period'] ?? [];
        $activePeriod = $period['key'] ?? 'month';

        $summary = $finance['summary'] ?? [];
        $costs = collect($finance['costs'] ?? []);
        $costPages = $costs->chunk(5)->values();
        $totalCostPages = max(1, $costPages->count());
        $links = $finance['links'] ?? [];
        $revenueTrend = collect($finance['revenueTrend'] ?? []);

        $filters = $finance['filters'] ?? [];
        $selectedMonth = (string) ($period['selected_month'] ?? $filters['selected_month'] ?? request()->query('month', 'all'));
        $selectedYear = (int) ($period['selected_year'] ?? $filters['selected_year'] ?? request()->query('year', now()->year));
        $months = $filters['months'] ?? [
            'all' => 'Semua Bulan',
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

        $selectedMonthLabel = $months[$selectedMonth] ?? 'Bulan Ini';
        $availableYears = range(now()->year - 4, now()->year + 1);

        $baseDashboardUrl = $links['dashboard_keuangan'] ?? url('/admin/dashboard-keuangan');

        $makeMonthlyUrl = function (string $month, int $year) use ($baseDashboardUrl) {
            return $baseDashboardUrl . '?' . http_build_query([
                'month' => $month,
                'year' => $year,
            ]);
        };

        $periods = [
            'month' => 'Bulanan',
        ];

        $revenue = (int) ($summary['revenue'] ?? 0);
        $grossProfit = (int) ($summary['gross_profit'] ?? 0);
        $operationalCost = (int) ($summary['operational_cost'] ?? 0);
        $netProfit = (int) ($summary['net_profit'] ?? 0);

        $targetRevenue = (int) ($summary['target_revenue'] ?? 0);
        $targetGrossProfit = (int) ($summary['target_gross_profit'] ?? 0);
        $targetNetProfit = (int) ($summary['target_net_profit'] ?? 0);

        $targetItems = [
            [
                'title' => 'Target Revenue',
                'actual' => (int) ($summary['target_revenue_actual'] ?? 0),
                'target' => $targetRevenue,
                'icon' => '↗',
                'color' => '#f97316',
            ],
            [
                'title' => 'Target Gross Profit',
                'actual' => (int) ($summary['target_gross_profit_actual'] ?? 0),
                'target' => $targetGrossProfit,
                'icon' => '◔',
                'color' => '#16a34a',
            ],
            [
                'title' => 'Target Net Profit',
                'actual' => (int) ($summary['target_net_profit_actual'] ?? 0),
                'target' => $targetNetProfit,
                'icon' => '▥',
                'color' => $netProfit >= 0 ? '#16a34a' : '#ef4444',
            ],
        ];

        $kpiCards = [
            [
                'label' => 'Revenue',
                'value' => $this->rupiah($revenue),
                'icon' => '↗',
                'color' => '#f97316',
            ],
            [
                'label' => 'Gross Profit',
                'value' => $this->rupiah($grossProfit),
                'icon' => '◔',
                'color' => '#16a34a',
            ],
            [
                'label' => 'Biaya Operasional',
                'value' => $this->rupiah($operationalCost),
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Net Profit',
                'value' => $this->rupiah($netProfit),
                'icon' => '▥',
                'color' => $netProfit >= 0 ? '#f97316' : '#ef4444',
            ],
        ];

        $maxRevenueTrend = max(1, (int) $revenueTrend->max('value'));

        $niceChartMax = max(1, (int) (ceil($maxRevenueTrend / 50000) * 50000));

        $formatShortMoney = function (int|float $value): string {
            $value = (int) $value;

            if ($value >= 1000000000) {
                return rtrim(rtrim(number_format($value / 1000000000, 1, ',', '.'), '0'), ',') . 'M';
            }

            if ($value >= 1000000) {
                return rtrim(rtrim(number_format($value / 1000000, 1, ',', '.'), '0'), ',') . 'jt';
            }

            if ($value >= 1000) {
                return rtrim(rtrim(number_format($value / 1000, 1, ',', '.'), '0'), ',') . 'rb';
            }

            return (string) $value;
        };

        $dateRangeLabel = ($period['start'] ?? '-') . ' - ' . ($period['end'] ?? '-');
        $customStartDate = (string) ($period['start_query'] ?? request()->query('start_date', now()->startOfMonth()->toDateString()));
        $customEndDate = (string) ($period['end_query'] ?? request()->query('end_date', now()->endOfMonth()->toDateString()));
    @endphp

    <div class="ng-finance-dashboard-new">
        <section class="ng-topbar">
            <div class="ng-title-area">
                <h1>Analisis Keuangan</h1>
                <p>Ringkasan kinerja dan analisis keuangan UMKM Ngunjuk </p>
                <small class="ng-active-data-label">
                    Data bulan aktif: {{ $selectedMonthLabel }} {{ $selectedYear }} • {{ $dateRangeLabel }}
                </small>
            </div>

            <div class="ng-filter-area">
                <div class="ng-monthly-filter-block">
                    <span class="ng-filter-label"></span>

                    <div class="ng-monthly-filter-card">
                        <select class="ng-monthly-select" onchange="window.location.href = this.value">
                            @foreach ($months as $monthKey => $monthLabel)
                                @continue($monthKey === 'all')

                                <option value="{{ $makeMonthlyUrl((string) $monthKey, $selectedYear) }}"
                                        @selected((string) $selectedMonth === (string) $monthKey)>
                                    {{ $monthLabel }}
                                </option>
                            @endforeach
                        </select>

                        <select class="ng-monthly-select ng-year-select" onchange="window.location.href = this.value">
                            @foreach ($availableYears as $yearOption)
                                <option value="{{ $makeMonthlyUrl((string) $selectedMonth, (int) $yearOption) }}"
                                        @selected((int) $selectedYear === (int) $yearOption)>
                                    {{ $yearOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-kpi-grid">
            @foreach ($kpiCards as $card)
                <article class="ng-kpi-card" style="--accent: {{ $card['color'] }};">
                    <div class="ng-kpi-icon">
                        {{ $card['icon'] }}
                    </div>

                    <div class="ng-kpi-content">
                        <span>{{ $card['label'] }}</span>
                        <strong>{{ $card['value'] }}</strong>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-visual-grid">
            <article class="ng-card ng-revenue-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Revenue Mingguan Bulan {{ $selectedMonthLabel }} {{ $selectedYear }}</h2>
                    </div>
                </div>

                <div id="ngFinanceRevenueChart" wire:ignore class="ng-chart ng-chart-lg ng-finance-apex-chart">
                    <div class="ng-chart-loader">
                        <span></span>
                        <p>Memuat grafik...</p>
                    </div>
                </div>
            </article>

            <article class="ng-card ng-target-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Progress Target</h2>
                    </div>
                </div>
                <div class="ng-target-list">
                    @foreach ($targetItems as $target)
                        @php
                            $actual = (int) ($target['actual'] ?? 0);
                            $targetValue = (int) ($target['target'] ?? 0);
                            $percent = $targetValue > 0 ? round(($actual / $targetValue) * 100, 1) : 0;
                            $barWidth = $targetValue > 0 ? min(100, max(5, abs($percent))) : 0;
                            $remaining = $targetValue > 0 ? max($targetValue - $actual, 0) : 0;
                            $isNegativeProgress = $percent < 0;
                        @endphp

                        <div class="ng-target-row" style="--target-color: {{ $target['color'] }}">
                            <div class="ng-target-icon">
                                {{ $target['icon'] }}
                            </div>

                            <div class="ng-target-main">
                                <div class="ng-target-top">
                                    <div>
                                        <strong>{{ $target['title'] }}</strong>
                                        <span>{{ $this->rupiah($actual) }}</span>
                                    </div>

                                    <div>
                                        <strong>{{ $targetValue > 0 ? $this->rupiah($targetValue) : 'Target belum diatur' }}</strong>
                                    </div>

                                    <b class="{{ $isNegativeProgress ? 'negative' : 'positive' }}">
                                        {{ number_format($percent, 1, ',', '.') }}%
                                    </b>
                                </div>

                                <div class="ng-target-track {{ $isNegativeProgress ? 'danger' : '' }}">
                                    <i style="width: {{ $barWidth }}%;"></i>
                                </div>

                                <div class="ng-target-bottom">
                                    <span></span>
                                    <small>{{ $targetValue > 0 ? 'Sisa ' . $this->rupiah($remaining) : 'Silakan atur target penjualan' }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="ng-card ng-cost-table-card">
            <div class="ng-table-head">
                <div>
                    <h2>Rincian Biaya Operasional</h2>
                </div>

                <div class="ng-table-actions">
                    <a href="{{ $links['operational_costs'] ?? '#' }}">⚙ Kelola Biaya</a>
                </div>
            </div>

            <div class="ng-cost-table-wrap">
                <table class="ng-cost-table">
                    <thead>
                        <tr>
                            <th>Nama Biaya</th>
                            <th>Kategori</th>
                            <th>Tipe Biaya</th>
                            <th>Tanggal Bayar</th>
                            <th>Dihitung Bulan Ini</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($costs->count() > 0)
                            @foreach ($costPages as $pageIndex => $costPage)
                                @foreach ($costPage as $cost)
                                    <tr class="ng-cost-page-row {{ $pageIndex === 0 ? 'is-active' : '' }}"
                                        data-cost-page="{{ $pageIndex + 1 }}">
                                        <td>
                                            <div class="ng-cost-category">
                                                <span>▣</span>
                                                <strong>{{ $cost['name'] ?? '-' }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ $cost['category'] ?? '-' }}</td>
                                        <td>
                                            <span class="ng-cost-type-badge {{ ! empty($cost['is_annual']) ? 'annual' : '' }}">
                                                {{ $cost['cost_type_label'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $cost['date'] ?? '-' }}</td>
                                        <td class="ng-money">
                                            {{ $this->rupiah($cost['amount'] ?? 0) }}
                                            @if (! empty($cost['is_annual']))
                                            @endif
                                        </td>
                                        <td><span class="ng-status-paid">Dihitung</span></td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <div class="ng-empty-state">
                                        Belum ada biaya operasional.
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($costs->count() > 0)
                <div class="ng-table-footer"
                     data-total-costs="{{ $costs->count() }}"
                     data-per-page="5"
                     data-total-pages="{{ $totalCostPages }}">

                    <div class="ng-cost-pagination">
                        <button type="button"
                                class="ng-cost-page-btn is-disabled"
                                data-cost-prev
                                aria-label="Data biaya sebelumnya">
                            ‹
                        </button>

                        <button type="button"
                                class="ng-cost-page-btn {{ $totalCostPages <= 1 ? 'is-disabled' : '' }}"
                                data-cost-next
                                aria-label="Data biaya berikutnya">
                            ›
                        </button>
                    </div>
                </div>
            @endif
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) {
            background:
                linear-gradient(120deg, rgba(255, 248, 237, .18), rgba(255, 224, 185, .05)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255, 255, 255, .48) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255, 118, 0, .42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255, 181, 83, .30) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-layout,
        body:has(.ng-finance-dashboard-new) .fi-main,
        body:has(.ng-finance-dashboard-new) .fi-main-ctn,
        body:has(.ng-finance-dashboard-new) .fi-page,
        body:has(.ng-finance-dashboard-new) .fi-page-content,
        body:has(.ng-finance-dashboard-new) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-page,
        body:has(.ng-finance-dashboard-new) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-finance-dashboard-new {
            width: 100%;
            min-height: 100vh;
            padding: 24px 24px 32px;
            color: #24180f;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow: hidden;
        }

        .ng-finance-dashboard-new * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | TOPBAR - STRUKTUR TETAP, WARNA IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 14px;
            padding: 18px;
            min-height: 118px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            overflow: hidden;
        }

        .ng-title-area {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-title-area h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-title-area p {
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-active-data-label {
            display: inline-flex;
            width: fit-content;
            margin-top: 10px;
            padding: 7px 12px;
            border-radius: 999px;
            color: #d95d00;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .ng-filter-area {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .ng-monthly-filter-block {
            display: grid;
            gap: 8px;
        }

        .ng-filter-label {
            color: #d95d00;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-monthly-filter-card,
        .ng-target-filter,
        .ng-period-tabs,
        .ng-date-chip,
        .ng-month-select-wrap {
            display: flex;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 14px 28px rgba(101, 58, 21, .10),
                inset 0 1px 0 rgba(255, 255, 255, .54);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-monthly-filter-card {
            min-height: 52px;
            gap: 9px;
            padding: 6px;
            border-radius: 18px;
        }

        .ng-monthly-select,
        .ng-target-month-select,
        .ng-month-select {
            min-height: 40px;
            border: 0;
            outline: 0;
            cursor: pointer;
            border-radius: 14px;
            padding: 0 14px;
            color: #4a321f;
            background: rgba(255, 255, 255, .78);
            font-size: 13px;
            font-weight: 900;
        }

        .ng-monthly-select {
            min-width: 150px;
        }

        .ng-year-select {
            min-width: 112px;
        }

        .ng-monthly-select:focus,
        .ng-target-month-select:focus,
        .ng-month-select:focus {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, .22);
        }

        .ng-monthly-select option,
        .ng-target-month-select option {
            color: #2d1f16;
            background: #fff6ea;
            font-weight: 850;
        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY-LIKE CARD COLORS
        |--------------------------------------------------------------------------
        */

        .ng-card,
        .ng-kpi-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .58);
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-card::before,
        .ng-kpi-card::before,
        .ng-topbar::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
            min-width: 0;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 17px;
            font-weight: 950;
        }

        .ng-kpi-content {
            position: relative;
            z-index: 1;
            min-width: 0;
            flex: 1;
        }

        .ng-kpi-content > span {
            display: block;
            color: #6f5946;
            font-size: 12px;
            line-height: 1.2;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 22px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p {
            margin: 8px 0 0;
            color: #6f5946;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 850;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-kpi-content p em {
            margin-left: 3px;
            color: #6f5946;
            font-style: normal;
            font-weight: 750;
        }

        .ng-kpi-content .positive {
            color: #16a34a;
        }

        .ng-kpi-content .negative {
            color: #ef4444;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL + TARGET CARDS
        |--------------------------------------------------------------------------
        */

        .ng-visual-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 16px;
            align-items: stretch;
        }

        .ng-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-revenue-card,
        .ng-target-card {
            height: 354px;
            min-height: 354px;
            max-height: 354px;
        }

        .ng-card-head,
        .ng-table-head,
        .ng-cost-table-wrap,
        .ng-table-footer,
        .ng-target-list {
            position: relative;
            z-index: 2;
        }

        .ng-card-head {
            margin-bottom: 10px;
        }

        .ng-card-head h2,
        .ng-table-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-card-head p,
        .ng-table-head p {
            margin: 7px 0 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-finance-apex-chart,
        .ng-chart,
        .ng-chart-lg {
            position: relative;
            z-index: 2;
            min-height: 286px;
            width: 100%;
        }

        .ng-chart-loader {
            height: 286px;
            display: grid;
            place-items: center;
            align-content: center;
            gap: 10px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-chart-loader span {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 4px solid rgba(249, 115, 22, .18);
            border-top-color: #f97316;
            animation: ngSpin .8s linear infinite;
        }

        @keyframes ngSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .ng-target-list {
            display: grid;
            gap: 17px;
            padding-top: 12px;
        }

        .ng-target-row {
            display: grid;
            grid-template-columns: 46px minmax(0, 1fr);
            align-items: center;
            gap: 14px;
        }

        .ng-target-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--target-color), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 17px;
            font-weight: 950;
        }

        .ng-target-main {
            min-width: 0;
        }

        .ng-target-top {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(110px, .72fr) 70px;
            gap: 10px;
            align-items: start;
            margin-bottom: 7px;
        }

        .ng-target-top strong,
        .ng-target-top span {
            display: block;
        }

        .ng-target-top strong {
            color: #21160d;
            font-size: 12px;
            line-height: 1.15;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-target-top span {
            margin-top: 3px;
            color: #6f5946;
            font-size: 11px;
            line-height: 1.15;
            font-weight: 800;
        }

        .ng-target-top b {
            color: var(--target-color);
            font-size: 22px;
            line-height: 1;
            font-weight: 950;
            text-align: right;
        }

        .ng-target-top b.negative {
            color: #ef4444;
        }

        .ng-target-track {
            height: 10px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .14);
        }

        .ng-target-track i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--target-color), #ff8a00);
        }

        .ng-target-track.danger i {
            background: linear-gradient(90deg, #ef4444, #fb7185);
        }

        .ng-target-bottom {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
        }

        .ng-target-bottom small {
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        /*
        |--------------------------------------------------------------------------
        | COST TABLE CARD - WARNA IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-cost-table-card {
            padding: 18px;
        }

        .ng-table-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-table-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-table-actions a {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
            border-radius: 12px;
            color: #f97316;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .58);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
        }

        .ng-cost-table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 18px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .16), rgba(255, 246, 231, .08)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .06), transparent 38%) !important;
        }

        .ng-cost-table {
            width: 100%;
            min-width: 880px;
            border-collapse: collapse;
            background: transparent;
        }

        .ng-cost-table th,
        .ng-cost-table td {
            padding: 13px 14px;
            border-top: 1px solid rgba(113, 74, 44, .10);
            color: #4b3525;
            font-size: 13px;
            text-align: left;
            white-space: nowrap;
            background: transparent;
        }

        .ng-cost-table th {
            color: #3f3024;
            font-size: 12px;
            font-weight: 950;
            background: rgba(255, 255, 255, .10);
        }

        .ng-cost-table td {
            font-weight: 760;
        }

        .ng-cost-category {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ng-cost-category span {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(135deg, #f97316, #d95d00);
            box-shadow: 0 12px 22px rgba(249, 115, 22, .18);
            font-weight: 950;
        }

        .ng-cost-category strong {
            color: #2d1f16;
            font-weight: 950;
        }

        .ng-money {
            color: #ef4444 !important;
            font-weight: 950 !important;
        }

        .ng-money small {
            display: block;
            max-width: 260px;
            margin-top: 4px;
            color: #8b7057;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 750;
            white-space: normal;
        }

        .ng-cost-type-badge {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 0 10px;
            border-radius: 8px;
            color: #0f766e;
            background: rgba(20, 184, 166, .13);
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-cost-type-badge.annual {
            color: #d95d00;
            background: rgba(249, 115, 22, .13);
        }

        .ng-status-paid {
            display: inline-flex;
            align-items: center;
            min-height: 26px;
            padding: 0 10px;
            border-radius: 8px;
            color: #16a34a;
            background: rgba(22, 163, 74, .12);
            font-size: 12px;
            font-weight: 900;
        }

        .ng-empty-state {
            position: relative;
            z-index: 2;
            padding: 18px;
            border-radius: 16px;
            color: #7b624c;
            background: rgba(255, 255, 255, .30);
            font-size: 13px;
            font-weight: 850;
            text-align: center;
        }

        /*
        |--------------------------------------------------------------------------
        | COST TABLE PAGINATION
        |--------------------------------------------------------------------------
        */

        .ng-cost-page-row {
            display: none;
        }

        .ng-cost-page-row.is-active {
            display: table-row;
            animation: ngCostFadeIn .18s ease both;
        }

        @keyframes ngCostFadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ng-table-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding-top: 15px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-table-footer div,
        .ng-cost-pagination {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ng-table-footer button,
        .ng-table-footer strong,
        .ng-cost-page-btn,
        .ng-cost-page-number {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .38);
            color: #7b624c;
            font-size: 13px;
            font-weight: 950;
            cursor: pointer;
            transition: .18s ease;
        }

        .ng-table-footer strong,
        .ng-cost-page-btn:hover,
        .ng-cost-page-number:hover,
        .ng-cost-page-number.is-active {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 10px 20px rgba(238, 101, 0, .22);
        }

        .ng-cost-page-btn.is-disabled {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-finance-dashboard-new) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-visual-grid {
                grid-template-columns: 1fr;
            }

            .ng-revenue-card,
            .ng-target-card {
                height: auto;
                min-height: 354px;
                max-height: none;
            }
        }

        @media (max-width: 1100px) {
            .ng-finance-dashboard-new {
                padding: 18px 18px 28px;
            }

            .ng-topbar {
                flex-direction: column;
            }

            .ng-filter-area {
                width: 100%;
                justify-content: flex-start;
            }

            .ng-target-top {
                grid-template-columns: 1fr 1fr;
            }

            .ng-target-top b {
                grid-column: 1 / -1;
                text-align: left;
            }
        }

        @media (max-width: 700px) {
            .ng-finance-dashboard-new {
                padding: 14px 14px 24px;
            }

            .ng-title-area h1 {
                font-size: 26px;
            }

            .ng-kpi-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .ng-kpi-card {
                min-height: 108px;
                padding: 16px;
            }

            .ng-visual-grid {
                gap: 14px;
                margin-bottom: 14px;
            }

            .ng-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-target-row {
                grid-template-columns: 44px minmax(0, 1fr);
                gap: 12px;
            }

            .ng-target-icon {
                width: 44px;
                height: 44px;
                min-width: 44px;
                font-size: 16px;
            }

            .ng-table-head {
                flex-direction: column;
            }

            .ng-table-actions {
                width: 100%;
            }

            .ng-table-actions a {
                flex: 1;
            }
        }
    </style>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const footer = document.querySelector('.ng-finance-dashboard-new .ng-table-footer');

            if (! footer) {
                return;
            }

            const totalCosts = Number(footer.dataset.totalCosts || 0);
            const perPage = Number(footer.dataset.perPage || 5);
            const totalPages = Number(footer.dataset.totalPages || 1);
            const rows = Array.from(document.querySelectorAll('.ng-cost-page-row'));
            const info = footer.querySelector('.ng-cost-page-info');
            const prev = footer.querySelector('[data-cost-prev]');
            const next = footer.querySelector('[data-cost-next]');
            const pageButtons = Array.from(footer.querySelectorAll('[data-cost-page-button]'));

            let currentPage = 1;

            const rupiahNumber = new Intl.NumberFormat('id-ID');

            function setPage(page) {
                currentPage = Math.max(1, Math.min(totalPages, Number(page || 1)));

                rows.forEach(function (row) {
                    row.classList.toggle('is-active', Number(row.dataset.costPage) === currentPage);
                });

                pageButtons.forEach(function (button) {
                    button.classList.toggle('is-active', Number(button.dataset.costPageButton) === currentPage);
                });

                if (prev) {
                    prev.classList.toggle('is-disabled', currentPage <= 1);
                }

                if (next) {
                    next.classList.toggle('is-disabled', currentPage >= totalPages);
                }

                if (info) {
                    const start = ((currentPage - 1) * perPage) + 1;
                    const end = Math.min(currentPage * perPage, totalCosts);

                    info.textContent = rupiahNumber.format(start) + ' - ' + rupiahNumber.format(end) + ' dari ' + rupiahNumber.format(totalCosts);
                }
            }

            if (prev) {
                prev.addEventListener('click', function () {
                    setPage(currentPage - 1);
                });
            }

            if (next) {
                next.addEventListener('click', function () {
                    setPage(currentPage + 1);
                });
            }

            pageButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    setPage(button.dataset.costPageButton);
                });
            });

            setPage(1);
        });
    </script>
<style id="ng-finance-target-percent-sidebar-fix">
        /*
        |--------------------------------------------------------------------------
        | TARGET PERCENT + SIDEBAR RESTORE FIX
        |--------------------------------------------------------------------------
        */

        /* Persentase Progress Target: kecil + hitam, tidak warna-warni */
        body:has(.ng-finance-dashboard-new) .ng-target-top b,
        body:has(.ng-finance-dashboard-new) .ng-target-top b.positive,
        body:has(.ng-finance-dashboard-new) .ng-target-top b.negative,
        body.ng-finance-sidebar-soft .ng-target-top b,
        body.ng-finance-sidebar-soft .ng-target-top b.positive,
        body.ng-finance-sidebar-soft .ng-target-top b.negative {
            color: #21160d !important;
            font-size: 16px !important;
            line-height: 1.05 !important;
            font-weight: 950 !important;
            letter-spacing: -.02em !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-target-top,
        body.ng-finance-sidebar-soft .ng-target-top {
            grid-template-columns: minmax(0, 1.15fr) minmax(110px, .72fr) 52px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR STYLE BALIK KE MODEL SEBELUMNYA
        |--------------------------------------------------------------------------
        | Active menu dibuat model white pill + teks orange, bukan orange full.
        */

        body:has(.ng-finance-dashboard-new) .fi-sidebar,
        body.ng-finance-sidebar-soft .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-nav,
        body.ng-finance-sidebar-soft .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item a,
        body.ng-finance-sidebar-soft .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #5f4a38 !important;
            background: transparent !important;
            box-shadow: none !important;
            transition: .2s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active a,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active a,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active a,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-button,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: rgba(255, 255, 255, .86) !important;
            color: #e45f00 !important;
            box-shadow:
                0 12px 28px rgba(144, 79, 22, .08),
                inset 0 1px 0 rgba(255, 255, 255, .70) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover {
            background: rgba(255, 255, 255, .72) !important;
            color: #e45f00 !important;
            box-shadow:
                0 10px 24px rgba(144, 79, 22, .07),
                inset 0 1px 0 rgba(255, 255, 255, .58) !important;
        }

        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover svg,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item a:hover span,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-finance-dashboard-new) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active span,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active span,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item.fi-active .fi-sidebar-item-label,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover svg,
        body.ng-finance-sidebar-soft .fi-sidebar-item a:hover span,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body.ng-finance-sidebar-soft .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label {
            color: #e45f00 !important;
        }
    </style>

    <script>
        (function () {
            function syncFinanceSoftSidebar() {
                document.body.classList.add('ng-finance-sidebar-soft');
            }

            document.addEventListener('DOMContentLoaded', syncFinanceSoftSidebar);
            document.addEventListener('livewire:navigated', syncFinanceSoftSidebar);
            document.addEventListener('livewire:update', syncFinanceSoftSidebar);
            syncFinanceSoftSidebar();
        })();
    </script>
<style id="ng-finance-cost-nav-center-only">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE PAGINATION CENTER ONLY
        |--------------------------------------------------------------------------
        | Hilangkan info 1-5 dan angka halaman.
        | Navigasi hanya tombol < > dan posisinya center tengah.
        */

        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            position: relative !important;
            width: 100% !important;
            height: 42px !important;
            min-height: 42px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 0 0 !important;
            margin: 0 !important;
            text-align: center !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -42%) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: auto !important;
            min-width: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            display: inline-grid !important;
            place-items: center !important;
            width: 34px !important;
            height: 34px !important;
            min-width: 34px !important;
            max-width: 34px !important;
            border: 0 !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, .58) !important;
            color: #9b6a43 !important;
            font-size: 19px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            box-shadow:
                0 10px 22px rgba(120, 74, 30, .08),
                inset 0 1px 0 rgba(255, 255, 255, .58) !important;
            cursor: pointer !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            box-shadow: 0 10px 20px rgba(242, 106, 0, .22) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn.is-disabled {
            opacity: .45 !important;
            cursor: default !important;
            pointer-events: none !important;
        }
    </style>

    <script>
        (function () {
            function setupCostOnlyArrows() {
                const footer = document.querySelector('.ng-table-footer[data-total-pages]');
                if (! footer) {
                    return;
                }

                const totalPages = Math.max(1, parseInt(footer.dataset.totalPages || '1', 10));
                let currentPage = Math.max(1, parseInt(footer.dataset.currentPage || '1', 10));

                const rows = Array.from(document.querySelectorAll('.ng-cost-page-row[data-cost-page]'));
                const prev = footer.querySelector('[data-cost-prev]');
                const next = footer.querySelector('[data-cost-next]');

                function applyPage(page) {
                    currentPage = Math.max(1, Math.min(totalPages, page));
                    footer.dataset.currentPage = String(currentPage);

                    rows.forEach((row) => {
                        row.classList.toggle('is-active', parseInt(row.dataset.costPage || '1', 10) === currentPage);
                    });

                    if (prev) {
                        prev.classList.toggle('is-disabled', currentPage <= 1);
                    }

                    if (next) {
                        next.classList.toggle('is-disabled', currentPage >= totalPages);
                    }
                }

                if (prev && ! prev.dataset.onlyArrowBound) {
                    prev.dataset.onlyArrowBound = '1';
                    prev.addEventListener('click', function () {
                        if (currentPage > 1) {
                            applyPage(currentPage - 1);
                        }
                    });
                }

                if (next && ! next.dataset.onlyArrowBound) {
                    next.dataset.onlyArrowBound = '1';
                    next.addEventListener('click', function () {
                        if (currentPage < totalPages) {
                            applyPage(currentPage + 1);
                        }
                    });
                }

                applyPage(currentPage);
            }

            document.addEventListener('DOMContentLoaded', setupCostOnlyArrows);
            document.addEventListener('livewire:navigated', setupCostOnlyArrows);
            document.addEventListener('livewire:update', setupCostOnlyArrows);
            setupCostOnlyArrows();
        })();
    </script>
<style id="ng-finance-cost-table-taller-next-right">
        /*
        |--------------------------------------------------------------------------
        | COST TABLE TALLER + NEXT BUTTON RIGHT
        |--------------------------------------------------------------------------
        */

        /* Widget bawah dipanjangkan sedikit */
        body:has(.ng-finance-dashboard-new) .ng-cost-table-card {
            height: 420px !important;
            min-height: 420px !important;
            max-height: 420px !important;
            padding-bottom: 58px !important;
            position: relative !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-table-wrap {
            height: 306px !important;
            min-height: 306px !important;
            max-height: 306px !important;
            overflow: auto !important;
            padding-bottom: 4px !important;
        }

        /* Footer pagination pindah ke pojok kanan bawah */
        body:has(.ng-finance-dashboard-new) .ng-table-footer {
            position: absolute !important;
            right: 26px !important;
            bottom: 14px !important;
            width: auto !important;
            height: auto !important;
            min-height: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            padding: 0 !important;
            margin: 0 !important;
            z-index: 10 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-pagination {
            position: static !important;
            transform: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            gap: 8px !important;
            width: auto !important;
            min-width: 0 !important;
            height: auto !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-info,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-number {
            display: none !important;
        }

        /* Tombol dibuat text pill simple */
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button {
            width: auto !important;
            min-width: 78px !important;
            max-width: none !important;
            height: 34px !important;
            min-height: 34px !important;
            padding: 0 16px !important;
            border: 1px solid rgba(255, 255, 255, .56) !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, .52) !important;
            color: #d95d00 !important;
            box-shadow:
                0 12px 26px rgba(120, 74, 30, .10),
                inset 0 1px 0 rgba(255, 255, 255, .68) !important;
            font-size: 0 !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            letter-spacing: .01em !important;
            cursor: pointer !important;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, color .18s ease, opacity .18s ease !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before {
            content: "Prev" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            content: "Next" !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-prev]::before,
        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn[data-cost-next]::before {
            display: block !important;
            font-size: 12px !important;
            line-height: 1 !important;
            font-weight: 950 !important;
            transform: none !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):hover,
        body:has(.ng-finance-dashboard-new) .ng-cost-pagination button:not(.is-disabled):hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            border-color: rgba(255, 255, 255, .44) !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
            transform: translateY(-1px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn:not(.is-disabled):active {
            transform: translateY(0) scale(.98) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-cost-page-btn.is-disabled {
            opacity: .42 !important;
            color: #a78566 !important;
            background: rgba(255, 255, 255, .32) !important;
            cursor: default !important;
            pointer-events: none !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }
    </style>
<style id="ng-finance-apex-revenue-chart-style">
        /*
        |--------------------------------------------------------------------------
        | FINANCE REVENUE APEX CHART
        |--------------------------------------------------------------------------
        | Revenue chart mengikuti pola Dashboard utama.
        */

        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart {
            position: relative !important;
            z-index: 2 !important;
            width: 100% !important;
            height: 260px !important;
            min-height: 260px !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart,
        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart > div,
        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart svg,
        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart .apexcharts-canvas {
            max-width: 100% !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart .apexcharts-tooltip {
            border: 1px solid rgba(255, 255, 255, .78) !important;
            border-radius: 16px !important;
            background: rgba(245, 245, 246, .97) !important;
            box-shadow: 0 18px 42px rgba(77, 51, 22, .18) !important;
            overflow: hidden !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart .apexcharts-tooltip-title {
            margin-bottom: 0 !important;
            border-bottom: 1px solid rgba(120, 74, 30, .08) !important;
            background: rgba(255, 255, 255, .34) !important;
            color: #747b84 !important;
            font-size: 13px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-finance-apex-chart .apexcharts-tooltip-series-group {
            color: #23170f !important;
            font-size: 13px !important;
            font-weight: 850 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-loader {
            height: 100% !important;
            min-height: inherit !important;
            display: grid !important;
            place-items: center !important;
            align-content: center !important;
            gap: 10px !important;
            color: #8a6e55 !important;
            font-size: 12px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-loader span {
            width: 26px !important;
            height: 26px !important;
            border-radius: 999px !important;
            border: 3px solid rgba(249, 115, 22, .18) !important;
            border-top-color: #f97316 !important;
            animation: ngSpin .75s linear infinite !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-chart-loader p {
            margin: 0 !important;
        }

        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-chart-responsive,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-y-axis,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-chart-area,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-grid-lines,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-bars-weekly,
        body:has(.ng-finance-dashboard-new) .ng-revenue-card .ng-active-chart-tooltip {
            display: none !important;
        }
    </style>

    <script id="ng-finance-apex-revenue-chart-script">
        window.ngFinanceChartsData = {
            revenueTrend: @json($revenueTrend ?? []),
        };

        window.ngFinanceApexInstances = window.ngFinanceApexInstances || {};
        window.ngFinanceBootTimer = window.ngFinanceBootTimer || null;
        window.ngApexCallbacks = window.ngApexCallbacks || [];

        function ngFinanceLoadApexCharts(callback) {
            if (window.ApexCharts) {
                callback();
                return;
            }

            window.ngApexCallbacks.push(callback);

            const existingScript = document.getElementById('ng-apexcharts-script');

            if (existingScript) {
                return;
            }

            const script = document.createElement('script');
            script.id = 'ng-apexcharts-script';
            script.src = 'https://cdn.jsdelivr.net/npm/apexcharts';
            script.async = true;

            script.onload = function () {
                const callbacks = window.ngApexCallbacks || [];
                window.ngApexCallbacks = [];

                callbacks.forEach(function (cb) {
                    try {
                        cb();
                    } catch (error) {
                        console.warn('Finance dashboard chart callback skipped:', error);
                    }
                });
            };

            document.head.appendChild(script);
        }

        function ngFinanceFormatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function ngFinanceFormatRupiahCompact(value) {
            const number = Number(value || 0);

            if (number === 0) {
                return 'Rp 0';
            }

            if (number >= 1000000000) {
                const billion = number / 1000000000;

                return 'Rp ' + billion
                    .toFixed(billion % 1 === 0 ? 0 : 1)
                    .replace('.', ',') + 'M';
            }

            if (number >= 1000000) {
                const million = number / 1000000;

                return 'Rp ' + million
                    .toFixed(million % 1 === 0 ? 0 : 1)
                    .replace('.', ',') + 'jt';
            }

            if (number >= 1000) {
                const thousand = number / 1000;

                return 'Rp ' + thousand
                    .toFixed(thousand % 1 === 0 ? 0 : 1)
                    .replace('.', ',') + 'rb';
            }

            return 'Rp ' + number.toLocaleString('id-ID');
        }

        function ngFinanceDestroyCharts() {
            Object.keys(window.ngFinanceApexInstances || {}).forEach(function (key) {
                const chart = window.ngFinanceApexInstances[key];

                if (chart && typeof chart.destroy === 'function') {
                    try {
                        chart.destroy();
                    } catch (error) {
                        console.warn('Finance chart destroy skipped:', key);
                    }
                }

                delete window.ngFinanceApexInstances[key];
            });
        }

        function ngFinanceClearChartElement(selector) {
            const el = document.querySelector(selector);

            if (!el) {
                return null;
            }

            el.innerHTML = '';

            return el;
        }

        function ngFinanceRenderChart(selector, key, options) {
            if (!window.ApexCharts) {
                return;
            }

            if (window.ngFinanceApexInstances[key]) {
                return;
            }

            const el = ngFinanceClearChartElement(selector);

            if (!el) {
                return;
            }

            const chart = new ApexCharts(el, options);

            window.ngFinanceApexInstances[key] = chart;

            chart.render();
        }

        function ngFinanceNormalizeTrendRows(rawRows) {
            const rows = Array.isArray(rawRows) ? rawRows : [];

            return rows.map(function (row, index) {
                const shortLabel = row.short_label || row.label || ('M' + (index + 1));
                const tooltipLabel = row.tooltip_label || row.label || shortLabel;
                const value = Number(row.value || 0);

                return {
                    shortLabel: shortLabel,
                    tooltipLabel: tooltipLabel,
                    value: value,
                };
            });
        }

        function ngFinanceInitCharts() {
            const dashboard = document.querySelector('.ng-finance-dashboard-new');

            if (!dashboard || !window.ApexCharts) {
                return;
            }

            const rows = ngFinanceNormalizeTrendRows((window.ngFinanceChartsData || {}).revenueTrend || []);
            const labels = rows.map(function (row) { return row.shortLabel; });
            const tooltipLabels = rows.map(function (row) { return row.tooltipLabel; });
            const values = rows.map(function (row) { return row.value; });

            ngFinanceDestroyCharts();

            requestAnimationFrame(function () {
                ngFinanceRenderChart('#ngFinanceRevenueChart', 'financeRevenue', {
                    chart: {
                        type: 'bar',
                        height: 260,
                        toolbar: { show: false },
                        fontFamily: 'Inter, Poppins, sans-serif',
                        foreColor: '#7a6048',
                        parentHeightOffset: 0,
                        zoom: { enabled: false },
                        animations: {
                            enabled: true,
                            speed: 420,
                            animateGradually: {
                                enabled: true,
                                delay: 90,
                            },
                            dynamicAnimation: {
                                enabled: true,
                                speed: 260,
                            },
                        },
                    },
                    series: [
                        {
                            name: 'Revenue',
                            data: values,
                        },
                    ],
                    colors: ['#f97316'],
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            columnWidth: '26%',
                            distributed: false,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    grid: {
                        borderColor: 'rgba(124, 92, 63, .12)',
                        strokeDashArray: 0,
                        padding: {
                            top: 10,
                            left: 14,
                            right: 18,
                            bottom: 10,
                        },
                    },
                    xaxis: {
                        categories: labels,
                        tickPlacement: 'on',
                        labels: {
                            rotate: 0,
                            trim: false,
                            hideOverlappingLabels: false,
                            style: {
                                colors: '#6b5541',
                                fontSize: '11px',
                                fontWeight: 900,
                            },
                        },
                        tooltip: {
                            enabled: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                    },
                    yaxis: {
                        min: 0,
                        tickAmount: 4,
                        forceNiceScale: true,
                        labels: {
                            offsetX: -4,
                            formatter: function (value) {
                                return ngFinanceFormatRupiahCompact(value);
                            },
                            style: {
                                colors: '#6b5541',
                                fontSize: '11px',
                                fontWeight: 850,
                            },
                        },
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.2,
                            gradientToColors: ['#ff6a00'],
                            inverseColors: false,
                            opacityFrom: 0.95,
                            opacityTo: 1,
                            stops: [0, 100],
                        },
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'lighten',
                                value: 0.04,
                            },
                        },
                        active: {
                            filter: {
                                type: 'none',
                            },
                        },
                    },
                    tooltip: {
                        enabled: true,
                        shared: false,
                        intersect: false,
                        followCursor: true,
                        x: {
                            formatter: function (value, opts) {
                                return tooltipLabels[opts.dataPointIndex] || value;
                            },
                        },
                        y: {
                            formatter: function (value) {
                                return ngFinanceFormatRupiah(value);
                            },
                            title: {
                                formatter: function () {
                                    return 'Revenue:';
                                },
                            },
                        },
                    },
                    legend: {
                        show: false,
                    },
                });
            });
        }

        function ngFinanceBootCharts() {
            clearTimeout(window.ngFinanceBootTimer);

            window.ngFinanceBootTimer = setTimeout(function () {
                ngFinanceLoadApexCharts(ngFinanceInitCharts);
            }, 80);
        }

        if (!window.ngFinanceChartEventsRegistered) {
            window.ngFinanceChartEventsRegistered = true;

            document.addEventListener('DOMContentLoaded', ngFinanceBootCharts);
            document.addEventListener('livewire:navigated', ngFinanceBootCharts);
            document.addEventListener('livewire:update', ngFinanceBootCharts);
            document.addEventListener('livewire:updated', ngFinanceBootCharts);
        }

        if (document.readyState !== 'loading') {
            ngFinanceBootCharts();
        }
    </script>


    <style id="ng-final-hp-kpi-2x2-ng-finance-dashboard-new">
        /* =========================================================
           FINAL HP KPI 2x2 - scoped only for .ng-finance-dashboard-new
           Tablet & desktop tetap mengikuti style sebelumnya.
        ========================================================= */
        @media (max-width: 700px) {
            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
                align-items: stretch !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid > .ng-kpi-card {
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
                min-height: 100px !important;
                padding: 12px !important;
                border-radius: 18px !important;
                gap: 9px !important;
                display: flex !important;
                align-items: flex-start !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-icon {
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                flex: 0 0 36px !important;
                border-radius: 13px !important;
                font-size: 14px !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content {
                min-width: 0 !important;
                width: 100% !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-label {
                gap: 5px !important;
                font-size: 9px !important;
                line-height: 1.2 !important;
                letter-spacing: 0.035em !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-label span {
                display: none !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content strong {
                margin-top: 6px !important;
                font-size: clamp(15px, 4.3vw, 18px) !important;
                line-height: 1.1 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content p,
            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content .neutral,
            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content span:not(.ng-kpi-label span) {
                margin-top: 5px !important;
                font-size: 9.5px !important;
                line-height: 1.25 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
        }

        @media (max-width: 380px) {
            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid {
                gap: 8px !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid > .ng-kpi-card {
                min-height: 94px !important;
                padding: 10px !important;
                gap: 7px !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-icon {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
                flex-basis: 32px !important;
                font-size: 13px !important;
            }

            body:has(.ng-finance-dashboard-new) .ng-finance-dashboard-new .ng-kpi-grid .ng-kpi-content strong {
                font-size: clamp(13px, 4vw, 16px) !important;
            }
        }
    </style>

</x-filament-panels::page>
