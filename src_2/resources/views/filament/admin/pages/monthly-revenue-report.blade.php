<x-filament-panels::page>
    @php
        $currentUrl = request()->url();

        $cards = [
            [
                'label' => 'Total Revenue',
                'value' => 'Rp ' . number_format((int) ($summary['total_revenue'] ?? 0), 0, ',', '.'),
                'caption' => 'Periode ' . ($selectedMonthLabel ?? '-'),
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Total Orders',
                'value' => number_format((int) ($summary['total_orders'] ?? 0), 0, ',', '.'),
                'caption' => 'Transaksi bulan ini',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Units Sold',
                'value' => number_format((int) ($summary['total_items'] ?? 0), 0, ',', '.'),
                'caption' => 'Item terjual',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Highest Order',
                'value' => 'Rp ' . number_format((int) ($summary['highest_order'] ?? 0), 0, ',', '.'),
                'caption' => 'Order tertinggi',
                'icon' => '!',
                'color' => '#ef4444',
            ],
        ];
    @endphp

    <div class="ng-monthly-revenue-page">
        <section class="ng-report-hero-grid">
            <article class="ng-widget-card ng-report-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Monthly Revenue Analytics</h1>

                        <p>
                            Pantau histori pendapatan bulanan, jumlah transaksi, unit terjual,
                            dan detail transaksi selesai berdasarkan periode laporan.
                        </p>
                    </div>

                    <div class="ng-report-inline-filter">
                        <span class="ng-report-filter-title">Pilih Periode Laporan</span>

                        <div class="ng-report-filter-row">
                            <select
                                class="ng-report-select"
                                onchange="window.location.href = '{{ $currentUrl }}?month=' + this.value"
                            >
                                @foreach ($months as $month)
                                    <option value="{{ $month }}" @selected($month === $selectedMonth)>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}
                                    </option>
                                @endforeach
                            </select>

                            <button
                                type="button"
                                class="ng-primary-button"
                                wire:click="exportSelectedMonth"
                                wire:loading.attr="disabled"
                                wire:target="exportSelectedMonth"
                            >
                                <span wire:loading.remove wire:target="exportSelectedMonth">
                                    Download Laporan
                                </span>

                                <span wire:loading wire:target="exportSelectedMonth">
                                    Menyiapkan...
                                </span>
                            </button>
                        </div>

                        <small>Periode aktif: {{ $selectedMonthLabel }}</small>
                    </div>

                </div>
            </article>

        </section>

        <section class="ng-kpi-grid ng-report-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-kpi-card" style="--accent: {{ $card['color'] ?? '#f97316' }};">
                    <div class="ng-kpi-icon">
                        {{ $card['icon'] ?? '▣' }}
                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            {{ $card['label'] ?? '-' }}
                            <span>⋮</span>
                        </div>

                        <strong>
                            {{ $card['value'] ?? '-' }}
                        </strong>

                        <p class="neutral">
                            {{ $card['caption'] ?? '-' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-widget-card ng-report-table-card">
            <div class="ng-widget-head ng-report-table-head">
                <div>
                    <h2>Data Order Bulan {{ $selectedMonthLabel }}</h2>
                    <p>Data yang ditampilkan hanya transaksi dengan status selesai.</p>
                </div>

                <span class="ng-widget-badge">
                    Total Data {{ number_format((int) ($summary['total_orders'] ?? 0), 0, ',', '.') }}
                </span>
            </div>

            <div class="ng-report-table-wrap">
                <table class="ng-report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Order</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $order)
                            @php
                                $date = $order->ordered_at ?? $order->created_at;
                            @endphp

                            <tr>
                                <td>
                                    <span class="ng-number-pill">
                                        {{ $orders->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-order-code-pill">
                                        {{ $order->order_code ?? 'ORD-' . $order->id }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-date-pill">
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y H:i') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-item-pill">
                                        {{ number_format((int) $order->total_item, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-total-pill">
                                        Rp {{ number_format((int) $order->total_price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ng-status-pill">
                                        ✓ {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="ng-empty-state">
                                        <strong>Belum ada data penjualan</strong>
                                        <span>Tidak ada transaksi selesai pada bulan {{ $selectedMonthLabel }}.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($orders->total() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="3">TOTAL</td>

                                <td>
                                    {{ number_format((int) ($summary['total_items'] ?? 0), 0, ',', '.') }}
                                </td>

                                <td>
                                    Rp {{ number_format((int) ($summary['total_revenue'] ?? 0), 0, ',', '.') }}
                                </td>

                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="ng-report-pagination">
                    <div class="ng-report-pagination-info">
                        Menampilkan
                        <strong>{{ number_format($orders->firstItem(), 0, ',', '.') }}</strong>
                        sampai
                        <strong>{{ number_format($orders->lastItem(), 0, ',', '.') }}</strong>
                        dari
                        <strong>{{ number_format($orders->total(), 0, ',', '.') }}</strong>
                        data
                    </div>

                    <div class="ng-report-pagination-actions">
                        @if ($orders->onFirstPage())
                            <span class="ng-page-btn is-disabled">
                                ← Previous
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="ng-page-btn">
                                ← Previous
                            </a>
                        @endif

                        <div class="ng-page-numbers">
                            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if (
                                    $page === 1
                                    || $page === $orders->lastPage()
                                    || abs($page - $orders->currentPage()) <= 1
                                )
                                    @if ($page === $orders->currentPage())
                                        <span class="ng-page-number is-active">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="ng-page-number">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @elseif (
                                    $page === $orders->currentPage() - 2
                                    || $page === $orders->currentPage() + 2
                                )
                                    <span class="ng-page-dots">...</span>
                                @endif
                            @endforeach
                        </div>

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="ng-page-btn">
                                Next →
                            </a>
                        @else
                            <span class="ng-page-btn is-disabled">
                                Next →
                            </span>
                        @endif
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

        body:has(.ng-monthly-revenue-page) {
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
        }

        body:has(.ng-monthly-revenue-page) .fi-layout,
        body:has(.ng-monthly-revenue-page) .fi-main,
        body:has(.ng-monthly-revenue-page) .fi-main-ctn,
        body:has(.ng-monthly-revenue-page) .fi-page,
        body:has(.ng-monthly-revenue-page) .fi-page-content,
        body:has(.ng-monthly-revenue-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page,
        body:has(.ng-monthly-revenue-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-monthly-revenue-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-monthly-revenue-page * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | CARD UTAMA - DIAMBIL DARI CATEGORY MANAGEMENT
        |--------------------------------------------------------------------------
        */

        .ng-widget-card,
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

        .ng-widget-card::before,
        .ng-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-widget-card {
            min-width: 0;
            padding: 18px;
            border-radius: 24px;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO
        |--------------------------------------------------------------------------
        */

        .ng-report-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 14px;
        }

        .ng-report-hero-card {
            min-height: 126px;
            display: flex;
            align-items: center;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            width: 100%;
        }

        .ng-widget-head > div:first-child {
            min-width: 0;
            flex: 1 1 auto;
        }

        .ng-widget-head h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-head p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-report-inline-filter {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            min-width: 430px;
            display: grid;
            gap: 6px;
            padding: 0;
            border: 0;
            background: transparent;
            box-shadow: none;
        }

        .ng-report-filter-title,
        .ng-report-inline-filter small {
            display: block;
            margin: 0;
            color: #765d45;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 900;
            white-space: nowrap;
        }

        .ng-report-filter-title {
            color: #d95d00;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-report-filter-row {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .ng-report-select {
            width: 220px;
            height: 42px;
            min-height: 42px;
            margin: 0;
            padding: 0 14px;
            border: 1px solid rgba(255, 255, 255, .42);
            outline: none;
            border-radius: 16px;
            color: #4a321f;
            background: rgba(255, 255, 255, .28);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 12px;
            font-weight: 950;
            cursor: pointer;
        }

        .ng-report-select option {
            color: #2d1f16;
            background: #fff6ea;
            font-weight: 850;
        }

        .ng-primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            height: 42px;
            padding: 0 16px;
            border: 0;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: .2s ease;
        }

        .ng-primary-button:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-primary-button:disabled {
            cursor: not-allowed;
            opacity: .72;
            transform: none;
        }

        /*
        |--------------------------------------------------------------------------
        | KPI - WARNA DAN UKURAN IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-kpi-grid,
        .ng-report-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 16px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
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

        .ng-kpi-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
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

        /*
        |--------------------------------------------------------------------------
        | TABLE CARD - TIDAK ADA LAPISAN PUTIH DI DALAM WIDGET
        |--------------------------------------------------------------------------
        */

        .ng-report-table-card {
            padding: 18px;
            border-radius: 24px;
            margin-bottom: 14px;
        }

        .ng-report-table-head {
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .ng-widget-badge {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 14px;
            border-radius: 14px;
            color: #d95d00;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .52);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-report-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            overflow-x: auto;
            border: 0 !important;
            border-radius: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
        }

        .ng-report-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            color: #3a2a1f;
            background: transparent !important;
        }

        .ng-report-table,
        .ng-report-table thead,
        .ng-report-table tbody,
        .ng-report-table tfoot,
        .ng-report-table tr,
        .ng-report-table th,
        .ng-report-table td {
            background: transparent !important;
            box-shadow: none !important;
        }

        .ng-report-table th,
        .ng-report-table td {
            padding: 13px 14px;
            text-align: left;
            border-bottom: 1px solid rgba(114, 74, 41, .08);
        }

        .ng-report-table thead tr,
        .ng-report-table thead th {
            background: rgba(255, 247, 235, .04) !important;
        }

        .ng-report-table th {
            color: #4b3525;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
        }

        .ng-report-table td {
            color: #4b3525;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-report-table tbody tr,
        .ng-report-table tbody tr:nth-child(odd),
        .ng-report-table tbody tr:nth-child(even) {
            min-height: 52px;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease;
        }

        .ng-report-table tbody tr:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        .ng-report-table tfoot tr,
        .ng-report-table tfoot td {
            color: #21160d;
            font-weight: 950;
            background: rgba(255, 247, 235, .04) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | PILL DI TABLE - DIBUAT LEBIH SOFT AGAR MENYATU
        |--------------------------------------------------------------------------
        */

        .ng-number-pill,
        .ng-order-code-pill,
        .ng-date-pill,
        .ng-item-pill,
        .ng-total-pill,
        .ng-status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            padding: 0 10px;
            border-radius: 999px;
            white-space: nowrap;
            font-size: 10px;
            font-weight: 950;
        }

        .ng-number-pill {
            min-width: 34px;
            color: #64748b;
            background: rgba(148, 163, 184, .12);
            border: 1px solid rgba(148, 163, 184, .22);
        }

        .ng-order-code-pill,
        .ng-total-pill,
        .ng-status-pill {
            color: #078657;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .22);
        }

        .ng-date-pill {
            color: #6f5946;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-item-pill {
            min-width: 38px;
            color: #2563eb;
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .20);
        }

        .ng-empty-state {
            min-height: 120px;
            display: grid;
            place-items: center;
            align-content: center;
            gap: 6px;
            color: #765d45;
            text-align: center;
        }

        .ng-empty-state strong {
            color: #21160d;
            font-size: 16px;
            font-weight: 950;
        }

        .ng-empty-state span {
            font-size: 12px;
            font-weight: 800;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION - IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-report-pagination {
            position: relative;
            z-index: 2;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 14px;
            color: #6f5946;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-report-pagination-info {
            color: #765d45;
            font-size: 12px;
            font-weight: 800;
        }

        .ng-report-pagination-info strong {
            color: #21160d;
            font-weight: 950;
        }

        .ng-report-pagination-actions,
        .ng-page-numbers {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ng-page-btn,
        .ng-page-number,
        .ng-page-dots {
            min-width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 11px;
            border-radius: 14px;
            color: #7b6049;
            background: rgba(255, 255, 255, .32);
            border: 1px solid rgba(255, 255, 255, .48);
            font-size: 11px;
            font-weight: 900;
            text-decoration: none;
        }

        .ng-page-btn {
            min-width: 96px;
        }

        .ng-page-number.is-active,
        .ng-page-btn:hover,
        .ng-page-number:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-page-btn.is-disabled {
            opacity: .45;
            cursor: not-allowed;
            pointer-events: none;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC - IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        body:has(.ng-monthly-revenue-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active a,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active svg,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active span,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item a:hover span,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-monthly-revenue-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }


        /*
        |--------------------------------------------------------------------------
        | MONTHLY REVENUE SOFT CATEGORY TONE
        |--------------------------------------------------------------------------
        | Tone widget dibuat lebih soft dan tidak terlalu terang.
        | Tetap mengikuti konsep Category, tapi lapisan putih dikurangi.
        |--------------------------------------------------------------------------
        */

        .ng-widget-card,
        .ng-kpi-card {
            background:
                linear-gradient(145deg, rgba(255, 242, 221, .36), rgba(255, 214, 165, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .13), transparent 38%) !important;
            box-shadow:
                0 18px 44px rgba(101, 58, 21, .10),
                0 0 0 1px rgba(255, 255, 255, .10) inset,
                inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .20), transparent 30%, transparent 72%, rgba(255, 236, 210, .12)) !important;
            opacity: .24 !important;
        }

        .ng-report-table-card {
            background:
                linear-gradient(145deg, rgba(255, 239, 213, .34), rgba(255, 204, 145, .17)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
        }

        .ng-report-table-wrap {
            background: rgba(255, 230, 195, .06) !important;
        }

        .ng-report-table thead tr,
        .ng-report-table thead th {
            background: rgba(255, 226, 190, .08) !important;
        }

        .ng-report-table tbody tr,
        .ng-report-table tbody tr:nth-child(odd),
        .ng-report-table tbody tr:nth-child(even),
        .ng-report-table tfoot tr,
        .ng-report-table tfoot td {
            background: rgba(255, 226, 190, .035) !important;
        }

        .ng-report-table tbody tr:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        .ng-report-select,
        .ng-widget-badge,
        .ng-page-btn,
        .ng-page-number,
        .ng-page-dots {
            background: rgba(255, 239, 218, .28) !important;
            border-color: rgba(255, 255, 255, .38) !important;
        }

        .ng-date-pill {
            background: rgba(255, 239, 218, .20) !important;
        }



        /*
        |--------------------------------------------------------------------------
        | MONTHLY REVENUE BALANCED CATEGORY BRIGHTNESS
        |--------------------------------------------------------------------------
        | Versi sebelumnya terlalu redup. Ini dinaikkan lagi efek terang/glass-nya,
        | tetapi tidak kembali terlalu putih.
        |--------------------------------------------------------------------------
        */

        .ng-widget-card,
        .ng-kpi-card {
            background:
                linear-gradient(145deg, rgba(255, 248, 237, .42), rgba(255, 224, 185, .21)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .15), transparent 38%) !important;
            box-shadow:
                0 20px 50px rgba(101, 58, 21, .11),
                0 0 0 1px rgba(255, 255, 255, .11) inset,
                inset 0 1px 0 rgba(255, 255, 255, .54) !important;
        }

        .ng-widget-card::before,
        .ng-kpi-card::before {
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .28), transparent 28%, transparent 70%, rgba(255, 255, 255, .14)) !important;
            opacity: .32 !important;
        }

        .ng-report-table-card {
            background:
                linear-gradient(145deg, rgba(255, 248, 237, .40), rgba(255, 224, 185, .20)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .14), transparent 38%) !important;
            box-shadow:
                0 20px 50px rgba(101, 58, 21, .11),
                0 0 0 1px rgba(255, 255, 255, .11) inset,
                inset 0 1px 0 rgba(255, 255, 255, .52) !important;
        }

        .ng-report-table-wrap {
            background: rgba(255, 245, 231, .035) !important;
        }

        .ng-report-table thead tr,
        .ng-report-table thead th {
            background: rgba(255, 255, 255, .055) !important;
        }

        .ng-report-table tbody tr,
        .ng-report-table tbody tr:nth-child(odd),
        .ng-report-table tbody tr:nth-child(even),
        .ng-report-table tfoot tr,
        .ng-report-table tfoot td {
            background: rgba(255, 247, 235, .045) !important;
        }

        .ng-report-table tbody tr:hover {
            background: rgba(255, 255, 255, .13) !important;
        }

        .ng-report-select,
        .ng-widget-badge,
        .ng-page-btn,
        .ng-page-number,
        .ng-page-dots {
            background: rgba(255, 255, 255, .34) !important;
            border-color: rgba(255, 255, 255, .46) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .42) !important;
        }

        .ng-date-pill {
            background: rgba(255, 255, 255, .24) !important;
            border-color: rgba(255, 255, 255, .38) !important;
        }


        @media (max-width: 1500px) {
            .ng-kpi-grid,
            .ng-report-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-report-inline-filter {
                width: 100%;
                min-width: 0;
            }
        }

        @media (max-width: 1100px) {
            .ng-monthly-revenue-page {
                padding: 18px 18px 10px !important;
            }

            .ng-kpi-grid,
            .ng-report-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-report-filter-row {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 640px) {
            .ng-monthly-revenue-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-report-select {
                width: 100%;
            }

            .ng-primary-button {
                width: 100%;
            }

            .ng-report-pagination {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>



    <style id="ng-monthly-kpi-2x2-safe-final">
        /* FINAL SAFE: Export Monthly Revenue KPI 2 kolom hanya tablet/HP */
        @media (max-width: 1100px) {
            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-grid,
            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-report-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-card {
                width: 100% !important;
                min-width: 0 !important;
                min-height: 108px !important;
                padding: 14px !important;
                border-radius: 20px !important;
            }

            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-icon {
                width: 42px !important;
                height: 42px !important;
                flex: 0 0 42px !important;
                border-radius: 14px !important;
            }

            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-label {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-content strong {
                font-size: 18px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }
        }

        @media (max-width: 520px) {
            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-grid,
            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-report-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
            }

            body:has(.ng-monthly-revenue-page) .ng-monthly-revenue-page .ng-kpi-card {
                min-height: 100px !important;
                padding: 12px !important;
                gap: 10px !important;
            }
        }
    </style>
</x-filament-panels::page>
