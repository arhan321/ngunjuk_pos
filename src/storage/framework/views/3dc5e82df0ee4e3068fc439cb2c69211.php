<?php
    $summary = $summary ?? [];
    $period = $period ?? [];
    $filters = $filters ?? [];
    $links = $links ?? [];

    $activePeriod = (string) ($period['key'] ?? 'month');
    $activePeriodLabel = (string) ($period['label'] ?? 'Bulan Ini');
    $dateRangeLabel = (string) ($period['date_range'] ?? '-');

    $months = $filters['months'] ?? [];
    $years = $filters['years'] ?? range(now()->year - 4, now()->year + 1);
    $periods = $filters['periods'] ?? [
        'today' => 'Hari Ini',
        'month' => 'Bulanan',
    ];

    $selectedMonth = (int) ($period['selected_month'] ?? session('ng_order_filter.month', now()->month));
    $selectedYear = (int) ($period['selected_year'] ?? session('ng_order_filter.year', now()->year));
    $baseOrderUrl = $links['orders'] ?? url('/admin/orders');

    $makePeriodUrl = function (string $periodKey) use ($baseOrderUrl, $selectedMonth, $selectedYear): string {
        $params = [
            'period' => $periodKey,
            'month' => $selectedMonth,
            'year' => $selectedYear,
            '_refresh' => time(),
        ];

        return $baseOrderUrl . '?' . http_build_query($params);
    };

    $makeMonthUrl = fn (int $month, int $year): string => $baseOrderUrl . '?' . http_build_query([
        'period' => 'month',
        'month' => $month,
        'year' => $year,
        '_refresh' => time(),
    ]);

    $makeYearUrl = fn (int $year): string => $baseOrderUrl . '?' . http_build_query([
        'period' => 'month',
        'month' => $selectedMonth,
        'year' => $year,
        '_refresh' => time(),
    ]);

    $statusCounts = $summary['status_counts'] ?? [];

    $cards = [
        [
            'label' => 'Total Orders',
            'value' => number_format((int) ($summary['total_orders'] ?? 0), 0, ',', '.'),
            'caption' => 'Periode aktif',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Units Sold',
            'value' => number_format((int) ($summary['units_sold'] ?? 0), 0, ',', '.'),
            'caption' => 'Item selesai',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
    ];

    $latestOrderCode = $summary['latest_order_code'] ?? '-';
    $latestOrderTime = $summary['latest_order_time'] ?? '-';
?>

<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <div class="ng-order-page">
        <section class="ng-order-hero-grid">
            <article class="ng-widget-card ng-order-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Order Management</h1>

                        <small class="ng-active-order-label">
                            Data aktif: <?php echo e($activePeriodLabel); ?> • <?php echo e($dateRangeLabel); ?>

                        </small>
                    </div>

                    <div class="ng-order-filter-panel">

                        <div class="ng-period-tabs">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodKey => $periodLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <a href="<?php echo e($makePeriodUrl((string) $periodKey)); ?>"
                                   class="ng-period-tab <?php echo e($activePeriod === (string) $periodKey ? 'active' : ''); ?>"
                                   data-ng-period-url="<?php echo e($makePeriodUrl((string) $periodKey)); ?>"
                                   onclick="event.preventDefault(); window.location.assign(this.getAttribute('data-ng-period-url'));">
                                    <?php echo e($periodLabel); ?>

                                </a>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <div class="ng-order-select-row">
                            <select class="ng-order-select" onchange="window.location.assign(this.value)">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthKey => $monthLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($makeMonthUrl((int) $monthKey, $selectedYear)); ?>"
                                            <?php if((int) $selectedMonth === (int) $monthKey): echo 'selected'; endif; ?>>
                                        <?php echo e($monthLabel); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>

                            <select class="ng-order-select ng-order-year-select" onchange="window.location.assign(this.value)">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($makeYearUrl((int) $year)); ?>"
                                            <?php if((int) $selectedYear === (int) $year): echo 'selected'; endif; ?>>
                                        <?php echo e($year); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </article>

        </section>


        <section class="ng-kpi-grid ng-order-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <article class="ng-kpi-card" style="--accent: <?php echo e($card['color'] ?? '#f97316'); ?>;">
                    <div class="ng-kpi-icon">
                        <?php echo e($card['icon'] ?? '▣'); ?>

                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            <?php echo e($card['label'] ?? '-'); ?>

                            <span>⋮</span>
                        </div>

                        <strong>
                            <?php echo e($card['value'] ?? '-'); ?>

                        </strong>

                        <p class="neutral">
                            <?php echo e($card['caption'] ?? '-'); ?>

                        </p>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-order-page) {
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

        body:has(.ng-order-page) .fi-main,
        body:has(.ng-order-page) .fi-main-ctn,
        body:has(.ng-order-page) .fi-page,
        body:has(.ng-order-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-order-page) .fi-page,
        body:has(.ng-order-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-order-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-order-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-order-page) .fi-wi,
        body:has(.ng-order-page) .fi-wi-widget,
        body:has(.ng-order-page) .fi-wi-widget-content,
        body:has(.ng-order-page) .fi-wi-widgets,
        body:has(.ng-order-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-order-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-order-page * {
            box-sizing: border-box;
        }

        .ng-order-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(360px, .55fr);
            gap: 16px;
            margin-bottom: 14px;
        }

        .ng-widget-card,
        .ng-kpi-card,
        .ng-order-status-strip {
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
        .ng-kpi-card::before,
        .ng-order-status-strip::before {
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

        .ng-order-hero-card,
        .ng-order-highlight-card {
            min-height: 126px;
        }

        .ng-order-hero-card {
            display: flex;
            align-items: center;
        }

        .ng-order-highlight-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
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
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-active-order-label {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            min-height: 30px;
            margin-top: 10px;
            padding: 0 12px;
            border-radius: 999px;
            color: #d95d00;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .52);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-order-filter-panel {
            display: grid;
            gap: 8px;
            min-width: 360px;
            justify-items: end;
        }

        .ng-order-filter-panel > span {
            color: #d95d00;
            font-size: 12px;
            line-height: 1;
            font-weight: 950;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ng-period-tabs,
        .ng-order-select-row {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .58);
            background: rgba(255, 255, 255, .38);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .ng-period-tab {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            border-radius: 13px;
            color: #5f4a38;
            font-size: 11px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: .2s ease;
        }

        .ng-period-tab.active,
        .ng-period-tab:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9500, #f26a00);
            box-shadow: 0 10px 18px rgba(242, 106, 0, .20);
        }

        .ng-order-select-row {
            padding: 5px;
        }

        .ng-order-select {
            min-width: 140px;
            min-height: 34px;
            border: 0;
            outline: 0;
            border-radius: 12px;
            padding: 0 12px;
            color: #2d1f16;
            background: rgba(255, 255, 255, .42);
            font-size: 11px;
            font-weight: 950;
            cursor: pointer;
        }

        .ng-order-year-select {
            min-width: 92px;
        }

        .ng-highlight-info {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-highlight-info span {
            display: block;
            color: #765d45;
            font-size: 11px;
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

        .ng-highlight-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 850;
        }

        .ng-today-badge {
            position: relative;
            z-index: 2;
            display: inline-grid;
            place-items: center;
            min-width: 94px;
            min-height: 54px;
            padding: 10px 14px;
            border-radius: 18px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-weight: 950;
        }

        .ng-today-badge span {
            font-size: 11px;
            line-height: 1;
            font-weight: 900;
        }

        .ng-today-badge strong {
            margin-top: 5px;
            font-size: 18px;
            line-height: 1;
            font-weight: 950;
        }

        .ng-order-status-strip {
            position: relative;
            z-index: 2;
            min-height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 14px;
            padding: 12px 18px;
            border-radius: 20px;
        }

        .ng-order-status-strip > div {
            position: relative;
            z-index: 2;
        }

        .ng-order-status-strip span {
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-order-status-strip strong {
            display: block;
            margin-top: 3px;
            color: #21160d;
            font-size: 16px;
            font-weight: 950;
        }

        .ng-status-mini-list {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ng-status-mini-list span {
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-status-mini-list .success {
            color: #078657;
            background: rgba(16,185,129,.13);
            border: 1px solid rgba(16,185,129,.24);
        }

        .ng-status-mini-list .process {
            color: #d76a00;
            background: rgba(255,159,64,.16);
            border: 1px solid rgba(255,159,64,.26);
        }

        .ng-status-mini-list .danger {
            color: #d73333;
            background: rgba(255,98,98,.13);
            border: 1px solid rgba(255,98,98,.24);
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 5px;
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

        body:has(.ng-order-page) .fi-ta-ctn {
            margin: 0 24px 24px !important;
            width: calc(100% - 48px) !important;
            transform: none !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .34), rgba(255, 246, 231, .18)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .12), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .54) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            overflow: hidden !important;
        }

        body:has(.ng-order-page) .fi-section,
        body:has(.ng-order-page) .fi-ta,
        body:has(.ng-order-page) .fi-ta-content,
        body:has(.ng-order-page) .fi-ta-table,
        body:has(.ng-order-page) .fi-ta-ctn > div,
        body:has(.ng-order-page) .fi-ta-ctn > div > div,
        body:has(.ng-order-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-order-page) table,
        body:has(.ng-order-page) thead,
        body:has(.ng-order-page) tbody,
        body:has(.ng-order-page) tr,
        body:has(.ng-order-page) th,
        body:has(.ng-order-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-order-page) .fi-ta-header,
        body:has(.ng-order-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-order-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-order-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-order-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-order-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-order-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-order-page) .fi-ta-pagination,
        body:has(.ng-order-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-order-page) .fi-input-wrp,
        body:has(.ng-order-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-order-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-order-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-order-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-order-page) .fi-btn-color-primary,
        body:has(.ng-order-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-order-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-order-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-order-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-order-page) .fi-sidebar-item-active a,
        body:has(.ng-order-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-order-page) .fi-sidebar-item-active svg,
        body:has(.ng-order-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-order-page) .fi-sidebar-item-active span,
        body:has(.ng-order-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-order-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-order-filter-panel {
                width: 100%;
                min-width: 0;
                justify-items: start;
            }
        }

        @media (max-width: 1100px) {
            .ng-order-page {
                padding: 18px 18px 10px !important;
            }

            .ng-order-highlight-card,
            .ng-order-status-strip {
                align-items: flex-start;
                flex-direction: column;
            }

            body:has(.ng-order-page) .fi-ta-ctn {
                margin: 0 18px 22px !important;
                width: calc(100% - 36px) !important;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-order-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-order-page) .fi-ta-ctn {
                margin: 0 14px 20px !important;
                width: calc(100% - 28px) !important;
            }
        }
    </style>

    <script>
        (function () {
            function bindOrderPeriodTabs() {
                document.querySelectorAll('[data-ng-period-url]').forEach(function (tab) {
                    if (tab.dataset.periodBound === '1') {
                        return;
                    }

                    tab.dataset.periodBound = '1';

                    tab.addEventListener('click', function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const url = tab.getAttribute('data-ng-period-url');

                        if (url) {
                            window.location.assign(url);
                        }
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', bindOrderPeriodTabs);
            document.addEventListener('livewire:navigated', bindOrderPeriodTabs);
            document.addEventListener('livewire:update', bindOrderPeriodTabs);
            bindOrderPeriodTabs();
        })();
    </script>

    <style id="ng-order-layout-clean-kpi">
        /*
        |--------------------------------------------------------------------------
        | ORDER PAGE CLEAN LAYOUT
        |--------------------------------------------------------------------------
        | 1. Widget Order Terbaru Periode dihapus.
        | 2. Widget Order Management dilebarkan full width.
        | 3. Status periode aktif dihapus.
        | 4. KPI hanya Total Orders dan Units Sold.
        */

        body:has(.ng-order-page) .ng-order-hero-grid {
            grid-template-columns: 1fr !important;
            gap: 0 !important;
            margin-bottom: 14px !important;
        }

        body:has(.ng-order-page) .ng-order-hero-card {
            width: 100% !important;
            min-height: 138px !important;
        }

        body:has(.ng-order-page) .ng-widget-head {
            width: 100% !important;
        }

        body:has(.ng-order-page) .ng-widget-head p {
            max-width: 820px !important;
        }

        body:has(.ng-order-page) .ng-order-filter-panel {
            min-width: 360px !important;
        }

        body:has(.ng-order-page) .ng-order-status-strip,
        body:has(.ng-order-page) .ng-order-highlight-card {
            display: none !important;
        }

        body:has(.ng-order-page) .ng-order-kpi-grid,
        body:has(.ng-order-page) .ng-kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 14px !important;
            margin-bottom: 6px !important;
        }

        body:has(.ng-order-page) .ng-order-kpi-grid .ng-kpi-card {
            min-height: 106px !important;
        }

        body:has(.ng-order-page) .ng-kpi-content strong {
            font-size: 24px !important;
        }

        @media (max-width: 900px) {
            body:has(.ng-order-page) .ng-widget-head {
                align-items: flex-start !important;
                flex-direction: column !important;
            }

            body:has(.ng-order-page) .ng-order-filter-panel {
                width: 100% !important;
                min-width: 0 !important;
                justify-items: start !important;
            }

            body:has(.ng-order-page) .ng-order-kpi-grid,
            body:has(.ng-order-page) .ng-kpi-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>



    <style id="ng-order-kpi-2x2-safe-final">
        /* FINAL SAFE: Order Management KPI 2 kolom hanya tablet/HP */
        @media (max-width: 900px) {
            body:has(.ng-order-page) .ng-order-page .ng-order-kpi-grid,
            body:has(.ng-order-page) .ng-order-page .ng-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            body:has(.ng-order-page) .ng-order-page .ng-kpi-card {
                width: 100% !important;
                min-width: 0 !important;
                min-height: 108px !important;
                padding: 14px !important;
                border-radius: 20px !important;
            }

            body:has(.ng-order-page) .ng-order-page .ng-kpi-icon {
                width: 42px !important;
                height: 42px !important;
                flex: 0 0 42px !important;
                border-radius: 14px !important;
            }

            body:has(.ng-order-page) .ng-order-page .ng-kpi-label {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body:has(.ng-order-page) .ng-order-page .ng-kpi-content strong {
                font-size: 18px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }
        }

        @media (max-width: 520px) {
            body:has(.ng-order-page) .ng-order-page .ng-order-kpi-grid,
            body:has(.ng-order-page) .ng-order-page .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
            }

            body:has(.ng-order-page) .ng-order-page .ng-kpi-card {
                min-height: 100px !important;
                padding: 12px !important;
                gap: 10px !important;
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/orders/widgets/order-analytics-widget.blade.php ENDPATH**/ ?>