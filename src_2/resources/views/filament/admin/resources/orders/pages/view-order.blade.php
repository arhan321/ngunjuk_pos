<x-filament-panels::page>
    @php
        $order = $record;
        $order->loadMissing('items');

        $items = $order->items ?? collect();
        $date = $order->ordered_at ?? $order->created_at;

        $backUrl = \App\Filament\Admin\Resources\Orders\OrderResource::getUrl('index');

        $status = $order->status ?? '-';

        $statusStyle = match ($status) {
            'Selesai' => [
                'color' => '#078657',
                'bg' => 'rgba(16,185,129,.13)',
                'border' => 'rgba(16,185,129,.24)',
                'icon' => '✓',
            ],
            'Diproses' => [
                'color' => '#d76a00',
                'bg' => 'rgba(255,159,64,.16)',
                'border' => 'rgba(255,159,64,.26)',
                'icon' => '⏱',
            ],
            'Dibatalkan' => [
                'color' => '#d73333',
                'bg' => 'rgba(255,98,98,.13)',
                'border' => 'rgba(255,98,98,.24)',
                'icon' => '×',
            ],
            default => [
                'color' => '#64748b',
                'bg' => 'rgba(148,163,184,.12)',
                'border' => 'rgba(148,163,184,.24)',
                'icon' => '?',
            ],
        };

        $cards = [
            [
                'label' => 'ID Order',
                'value' => $order->order_code ?? 'ORD-' . $order->id,
                'caption' => 'Kode transaksi',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Total Item',
                'value' => number_format((int) ($order->total_item ?? 0), 0, ',', '.'),
                'caption' => 'Item dibeli',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Total Pembayaran',
                'value' => 'Rp ' . number_format((int) ($order->total_price ?? 0), 0, ',', '.'),
                'caption' => 'Revenue transaksi',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Waktu Order',
                'value' => $date ? \Carbon\Carbon::parse($date)->format('H:i') . ' WIB' : '-',
                'caption' => $date ? \Carbon\Carbon::parse($date)->translatedFormat('d M Y') : '-',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-order-detail-page">
        <section class="ng-order-detail-hero-grid">
            <article class="ng-widget-card ng-order-detail-hero-main">
                <div class="ng-widget-head">
                    <div>

                        <h1>Detail Transaksi</h1>

                        <p>
                            Informasi lengkap transaksi, total pembayaran, waktu order, status pesanan,
                            dan rincian produk yang dibeli.
                        </p>
                    </div>
                </div>

                <a href="{{ $backUrl }}" class="ng-primary-button">
                    ← Kembali
                </a>
            </article>

        </section>

        <section class="ng-kpi-grid ng-order-detail-kpi-grid">
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

        <section class="ng-order-detail-main-grid">
            <article class="ng-widget-card ng-order-info-card">
                <div class="ng-widget-card-head">
                    <div>
                        <h2>Informasi Order</h2>
                        <p>Ringkasan utama dari transaksi yang dipilih.</p>
                    </div>

                    <span class="ng-status-pill"
                          style="--status-color: {{ $statusStyle['color'] }}; --status-bg: {{ $statusStyle['bg'] }}; --status-border: {{ $statusStyle['border'] }};">
                        {{ $statusStyle['icon'] }} {{ $status }}
                    </span>
                </div>

                <div class="ng-order-info-list">
                    <div>
                        <span>ID Order</span>
                        <strong>{{ $order->order_code ?? 'ORD-' . $order->id }}</strong>
                    </div>

                    <div>
                        <span>Status</span>
                        <strong>{{ $status }}</strong>
                    </div>

                    <div>
                        <span>Total Item</span>
                        <strong>{{ number_format((int) ($order->total_item ?? 0), 0, ',', '.') }}</strong>
                    </div>

                    <div>
                        <span>Total Pembayaran</span>
                        <strong>Rp {{ number_format((int) ($order->total_price ?? 0), 0, ',', '.') }}</strong>
                    </div>

                    <div class="span-2">
                        <span>Waktu Order</span>
                        <strong>{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y H:i') : '-' }}</strong>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-order-items-card ng-order-items-card-side">
            <div class="ng-widget-card-head">
                <div>
                    <h2>Detail Item</h2>
                    <p>Daftar produk yang dibeli pada transaksi ini.</p>
                </div>

                <span class="ng-count-pill">
                    {{ number_format($items->count(), 0, ',', '.') }} Produk
                </span>
            </div>

            <div class="ng-order-items-list">
                @forelse ($items as $item)
                    <div class="ng-order-item-row">

                        <div class="ng-order-item-number">
                            {{ $loop->iteration }}
                        </div>

                        <div class="ng-order-item-name">
                            <strong>{{ $item->product_name ?? '-' }}</strong>
                            <span>Size: {{ $item->size_name ?? 'Regular' }}</span>
                        </div>

                        <div class="ng-order-item-meta">
                            <div class="ng-order-item-chip">
                                Qty {{ number_format((int) ($item->quantity ?? 0), 0, ',', '.') }}
                            </div>

                            <div class="ng-order-item-chip muted">
                                Rp {{ number_format((int) ($item->price ?? 0), 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="ng-order-item-subtotal">
                            <span>Subtotal</span>
                            <strong>
                                Rp {{ number_format((int) ($item->subtotal ?? 0), 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>
                @empty
                    <div class="ng-empty-order">
                        <strong>Tidak ada item</strong>
                        <span>Order ini belum memiliki detail item.</span>
                    </div>
                @endforelse
            </div>
        </article>

        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-order-detail-page) {
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

        body:has(.ng-order-detail-page) .fi-main,
        body:has(.ng-order-detail-page) .fi-main-ctn,
        body:has(.ng-order-detail-page) .fi-page,
        body:has(.ng-order-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-order-detail-page) .fi-page,
        body:has(.ng-order-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-order-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-order-detail-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-order-detail-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-order-detail-page * {
            box-sizing: border-box;
        }

        .ng-order-detail-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 16px;
            margin-bottom: 14px;
        }

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
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-order-detail-hero-main,
        .ng-order-detail-hero-side {
            min-height: 126px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .ng-order-detail-hero-main {
            justify-content: space-between;
        }

        .ng-order-detail-hero-side {
            justify-content: space-between;
        }

        .ng-widget-head,
        .ng-highlight-info,
        .ng-widget-card-head,
        .ng-order-info-list,
        .ng-payment-total,
        .ng-order-items-list {
            position: relative;
            z-index: 2;
        }

        .ng-kicker {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .50);
            border: 1px solid rgba(255, 255, 255, .58);
            color: #d95d00;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .70);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .ng-widget-head h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head p {
            max-width: 980px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-highlight-info {
            min-width: 0;
        }

        .ng-highlight-info span,
        .ng-highlight-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 850;
        }

        .ng-highlight-info span {
            font-weight: 900;
        }

        .ng-highlight-info strong {
            display: block;
            max-width: 280px;
            margin: 8px 0;
            overflow: hidden;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
            letter-spacing: -.03em;
        }

        .ng-primary-button {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none !important;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-status-pill,
        .ng-count-pill {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-status-pill {
            color: var(--status-color);
            background: var(--status-bg);
            border: 1px solid var(--status-border);
        }

        .ng-count-pill {
            color: #c25500;
            background: rgba(249, 115, 22, .12);
            border: 1px solid rgba(249, 115, 22, .22);
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
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

        .ng-order-detail-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .ng-widget-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-widget-card-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 16px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-card-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 11px;
            font-weight: 800;
        }

        .ng-order-info-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .ng-order-info-list div,
        .ng-order-item-row,
        .ng-empty-order {
            border-radius: 18px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .30);
        }

        .ng-order-info-list div {
            min-height: 74px;
            padding: 14px;
        }

        .ng-order-info-list .span-2 {
            grid-column: span 2;
        }

        .ng-order-info-list span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-order-info-list strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-payment-total span,
        .ng-payment-total p {
            display: block;
            color: #6f5946;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-payment-total strong {
            display: block;
            margin: 10px 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.1;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-order-items-card {
            padding: 18px !important;
        }

        .ng-order-items-list {
            display: grid;
            gap: 10px;
        }

        .ng-order-item-row {
            display: grid;
            grid-template-columns: 40px minmax(0, 1fr) auto auto minmax(150px, auto);
            align-items: center;
            gap: 10px;
            min-height: 64px;
            padding: 10px;
        }

        .ng-order-item-number {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .20);
            font-size: 13px;
            font-weight: 950;
        }

        .ng-order-item-name {
            min-width: 0;
        }

        .ng-order-item-name strong,
        .ng-order-item-name span {
            display: block;
        }

        .ng-order-item-name strong {
            color: #23160d;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-order-item-name span {
            margin-top: 4px;
            color: #8b7057;
            font-size: 11px;
            font-weight: 750;
        }

        .ng-order-item-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            color: #2563eb;
            background: rgba(59, 130, 246, .10);
            border: 1px solid rgba(59, 130, 246, .20);
            font-size: 10px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-order-item-chip.muted {
            color: #4b3525;
            background: rgba(255, 255, 255, .28);
            border-color: rgba(255, 255, 255, .42);
        }

        .ng-order-item-subtotal {
            text-align: right;
        }

        .ng-order-item-subtotal span {
            display: block;
            color: #8b7057;
            font-size: 10px;
            font-weight: 850;
        }

        .ng-order-item-subtotal strong {
            display: block;
            margin-top: 4px;
            color: #078657;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-empty-order {
            padding: 18px;
        }

        .ng-empty-order strong,
        .ng-empty-order span {
            display: block;
        }

        .ng-empty-order strong {
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-empty-order span {
            margin-top: 5px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-order-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-order-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-order-detail-page) .fi-sidebar-item-active svg,
        body:has(.ng-order-detail-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-order-detail-page) .fi-sidebar-item-active span,
        body:has(.ng-order-detail-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-order-detail-hero-grid,
            .ng-order-detail-main-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .ng-order-detail-page {
                padding: 18px 18px 24px !important;
            }

            .ng-order-detail-hero-main,
            .ng-order-detail-hero-side {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-order-info-list {
                grid-template-columns: 1fr;
            }

            .ng-order-info-list .span-2 {
                grid-column: span 1;
            }

            .ng-order-item-row {
                grid-template-columns: 40px minmax(0, 1fr);
            }

            .ng-order-item-chip,
            .ng-order-item-subtotal {
                grid-column: 2;
                justify-self: start;
                text-align: left;
            }
        }

        @media (max-width: 640px) {
            .ng-order-detail-page {
                padding: 14px 14px 22px !important;
            }

            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL ITEM SIDE LAYOUT
        |--------------------------------------------------------------------------
        | Payment Summary dihapus.
        | Detail Item dipindahkan ke area kanan bekas Payment Summary.
        */

        .ng-order-summary-card {
            display: none !important;
        }

        .ng-order-detail-main-grid {
            grid-template-columns: minmax(0, 1.18fr) minmax(430px, .82fr) !important;
            align-items: stretch !important;
        }

        .ng-order-items-card-side {
            height: 100% !important;
            min-height: 326px !important;
            max-height: 326px !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .ng-order-items-card-side .ng-widget-card-head {
            flex: 0 0 auto !important;
            margin-bottom: 12px !important;
        }

        .ng-order-items-card-side .ng-order-items-list {
            flex: 1 1 auto !important;
            min-height: 0 !important;
            max-height: 238px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding-right: 4px !important;
            scrollbar-width: thin !important;
            scrollbar-color: rgba(36, 128, 108, .58) rgba(255, 255, 255, .16) !important;
        }

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar {
            width: 6px !important;
        }

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .16) !important;
            border-radius: 999px !important;
        }

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar-thumb {
            background: rgba(36, 128, 108, .58) !important;
            border-radius: 999px !important;
        }

        .ng-order-items-card-side .ng-order-item-row {
            grid-template-columns: 38px minmax(0, 1fr) auto !important;
            gap: 10px !important;
            min-height: 68px !important;
            padding: 10px !important;
        }

        .ng-order-items-card-side .ng-order-item-number {
            width: 38px !important;
            height: 38px !important;
            border-radius: 13px !important;
        }

        .ng-order-items-card-side .ng-order-item-name {
            min-width: 0 !important;
        }

        .ng-order-items-card-side .ng-order-item-chip {
            min-height: 26px !important;
            padding: 0 9px !important;
        }

        .ng-order-items-card-side .ng-order-item-chip.muted {
            grid-column: 2 / 3 !important;
            justify-self: start !important;
            margin-top: -4px !important;
        }

        .ng-order-items-card-side .ng-order-item-subtotal {
            grid-column: 3 / 4 !important;
            grid-row: 1 / span 2 !important;
            align-self: center !important;
            min-width: 92px !important;
            text-align: right !important;
        }

        @media (max-width: 1500px) {
            .ng-order-detail-main-grid {
                grid-template-columns: 1fr !important;
            }

            .ng-order-items-card-side {
                min-height: auto !important;
                max-height: none !important;
            }

            .ng-order-items-card-side .ng-order-items-list {
                max-height: none !important;
                overflow: visible !important;
            }
        }

        @media (max-width: 900px) {
            .ng-order-items-card-side .ng-order-item-row {
                grid-template-columns: 40px minmax(0, 1fr) !important;
            }

            .ng-order-items-card-side .ng-order-item-chip,
            .ng-order-items-card-side .ng-order-item-chip.muted,
            .ng-order-items-card-side .ng-order-item-subtotal {
                grid-column: 2 !important;
                grid-row: auto !important;
                justify-self: start !important;
                text-align: left !important;
            }
        }
                /*
        |--------------------------------------------------------------------------
        | FINAL DETAIL ITEM CONSISTENT LAYOUT
        |--------------------------------------------------------------------------
        | Semua item mempertahankan bentuk yang sama seperti tampilan 2 item.
        | Item lebih dari 2 akan menggunakan internal scroll.
        |--------------------------------------------------------------------------
        */

        /* Widget Detail Item tetap stabil */
        .ng-order-items-card-side {
            height: 326px !important;
            min-height: 326px !important;
            max-height: 326px !important;

            display: flex !important;
            flex-direction: column !important;
        }

        /* Header tidak ikut scroll */
        .ng-order-items-card-side .ng-widget-card-head {
            flex: 0 0 auto !important;
            margin-bottom: 12px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | LIST ITEM
        |--------------------------------------------------------------------------
        | Penting:
        | - item tidak boleh stretch
        | - item tidak boleh mengecil
        | - banyak item cukup scroll
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-items-list {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
            grid-auto-rows: max-content !important;

            align-content: start !important;
            align-items: start !important;

            gap: 10px !important;

            flex: 1 1 auto !important;
            min-height: 0 !important;
            max-height: 238px !important;

            overflow-y: auto !important;
            overflow-x: hidden !important;

            padding-right: 4px !important;

            scrollbar-width: thin !important;
            scrollbar-color:
                rgba(36, 128, 108, .58)
                rgba(255, 255, 255, .16) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SETIAP ITEM
        |--------------------------------------------------------------------------
        | Bentuk dibuat konsisten seperti screenshot 2 item.
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-item-row {
            display: grid !important;

            grid-template-columns:
                38px
                minmax(0, 1fr)
                minmax(92px, auto) !important;

            grid-template-areas:
                "number name subtotal"
                "number meta subtotal" !important;

            grid-template-rows:
                auto
                auto !important;

            column-gap: 10px !important;
            row-gap: 6px !important;

            align-items: center !important;
            align-content: center !important;

            width: 100% !important;

            min-height: 104px !important;
            height: 104px !important;
            max-height: 104px !important;

            padding: 12px !important;

            flex: 0 0 auto !important;

            border-radius: 18px !important;

            background: rgba(255, 255, 255, .24) !important;

            border:
                1px solid
                rgba(255, 255, 255, .38) !important;

            box-shadow:
                inset 0 1px 0
                rgba(255, 255, 255, .30) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | NOMOR ITEM
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-item-number {
            grid-area: number !important;

            width: 38px !important;
            height: 38px !important;

            min-width: 38px !important;
            min-height: 38px !important;

            align-self: center !important;
            justify-self: start !important;

            display: grid !important;
            place-items: center !important;

            border-radius: 13px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | NAMA + SIZE
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-item-name {
            grid-area: name !important;

            min-width: 0 !important;

            align-self: end !important;
        }

        .ng-order-items-card-side .ng-order-item-name strong {
            display: block !important;

            max-width: 100% !important;

            overflow: hidden !important;
            white-space: nowrap !important;
            text-overflow: ellipsis !important;
        }

        .ng-order-items-card-side .ng-order-item-name span {
            display: block !important;
            margin-top: 4px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | QTY + HARGA
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-item-meta {
            grid-area: meta !important;

            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;

            gap: 8px !important;

            min-width: 0 !important;

            align-self: start !important;
        }

        .ng-order-items-card-side .ng-order-item-meta .ng-order-item-chip {
            position: static !important;

            grid-column: auto !important;
            grid-row: auto !important;

            margin: 0 !important;

            min-height: 26px !important;

            padding:
                0
                9px !important;

            flex: 0 0 auto !important;
        }

        .ng-order-items-card-side .ng-order-item-meta .ng-order-item-chip.muted {
            grid-column: auto !important;
            grid-row: auto !important;

            justify-self: auto !important;

            margin: 0 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SUBTOTAL
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-item-subtotal {
            grid-area: subtotal !important;

            grid-column: auto !important;
            grid-row: auto !important;

            align-self: center !important;
            justify-self: end !important;

            min-width: 92px !important;

            text-align: right !important;
        }

        .ng-order-items-card-side .ng-order-item-subtotal span {
            display: block !important;
        }

        .ng-order-items-card-side .ng-order-item-subtotal strong {
            display: block !important;

            margin-top: 4px !important;

            white-space: nowrap !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SCROLLBAR
        |--------------------------------------------------------------------------
        */

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar {
            width: 6px !important;
        }

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar-track {
            background:
                rgba(255, 255, 255, .16) !important;

            border-radius: 999px !important;
        }

        .ng-order-items-card-side .ng-order-items-list::-webkit-scrollbar-thumb {
            background:
                rgba(36, 128, 108, .58) !important;

            border-radius: 999px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLET / MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 900px) {
            .ng-order-items-card-side {
                height: auto !important;
                min-height: 326px !important;
                max-height: none !important;
            }

            .ng-order-items-card-side .ng-order-items-list {
                max-height: 420px !important;
                overflow-y: auto !important;
            }

            .ng-order-items-card-side .ng-order-item-row {
                grid-template-columns:
                    38px
                    minmax(0, 1fr) !important;

                grid-template-areas:
                    "number name"
                    "number meta"
                    "subtotal subtotal" !important;

                grid-template-rows:
                    auto
                    auto
                    auto !important;

                min-height: 126px !important;
                height: auto !important;
                max-height: none !important;
            }

            .ng-order-items-card-side .ng-order-item-subtotal {
                justify-self: end !important;
                text-align: right !important;
            }
        }

    </style>
</x-filament-panels::page>
