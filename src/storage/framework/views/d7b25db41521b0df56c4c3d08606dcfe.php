<?php
    $period = $period ?? [];
    $filters = $filters ?? [];

    $selectedMonth = (string) ($period['selected_month'] ?? request()->query('month', now()->month));
    $selectedYear = (int) ($period['selected_year'] ?? request()->query('year', now()->year));
    $periodLabel = (string) ($period['label'] ?? now()->translatedFormat('F Y'));
    $selectedStatus = (string) request()->query('status', session('ng_operational_cost_status', 'active'));

    if (! in_array($selectedStatus, ['active', 'inactive', 'all'], true)) {
        $selectedStatus = 'active';
    }

    $statusOptions = [
        'active' => 'Aktif',
        'inactive' => 'Nonaktif',
        'all' => 'Semua',
    ];

    $months = $filters['months'] ?? [
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

    $years = $filters['years'] ?? range(now()->year - 4, now()->year + 1);
    $baseOperationalUrl = $indexUrl ?? url('/admin/operational-costs');

    $makePeriodUrl = function (string|int $month, string|int $year) use ($baseOperationalUrl, $selectedStatus): string {
        return $baseOperationalUrl . '?' . http_build_query([
            'month' => (string) $month,
            'year' => (string) $year,
            'status' => $selectedStatus,
        ]);
    };

    $makeStatusUrl = function (string $status) use ($baseOperationalUrl, $selectedMonth, $selectedYear): string {
        return $baseOperationalUrl . '?' . http_build_query([
            'month' => (string) $selectedMonth,
            'year' => (string) $selectedYear,
            'status' => $status,
        ]);
    };

    $cards = [
        [
            'label' => 'Biaya Periode Ini',
            'value' => $this->rupiah($summary['monthly_cost'] ?? 0),
            'caption' => 'Data aktif: ' . $periodLabel,
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Biaya',
            'value' => number_format((int) ($summary['total_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua data biaya',
            'icon' => '∑',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Biaya Aktif Periode',
            'value' => number_format((int) ($summary['active_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Tampil pada bulan aktif',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Biaya Nonaktif',
            'value' => number_format((int) ($summary['inactive_costs'] ?? 0), 0, ',', '.'),
            'caption' => 'Tidak dihitung',
            'icon' => '!',
            'color' => '#ef4444',
        ],
    ];
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

    <div class="ng-operational-page" data-active-month="<?php echo e($selectedMonth); ?>" data-active-year="<?php echo e($selectedYear); ?>">
        <section class="ng-op-hero-grid">
            <article class="ng-widget-card ng-op-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Biaya Operasional</h1>

                        <small class="ng-op-active-period">
                            Data aktif: <?php echo e($periodLabel); ?> • <?php echo e($period['start'] ?? '-'); ?> - <?php echo e($period['end'] ?? '-'); ?>

                        </small>
                    </div>

                    <div class="ng-op-hero-right">
                        <div class="ng-op-period-filter" wire:ignore>
                            <div class="ng-op-period-selects">
                                <select class="ng-op-select" data-ng-op-month onchange="if (this.value) window.location.href = this.value;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthKey => $monthLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($makePeriodUrl($monthKey, $selectedYear)); ?>"
                                                <?php if((string) $selectedMonth === (string) $monthKey): echo 'selected'; endif; ?>>
                                            <?php echo e($monthLabel); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>

                                <select class="ng-op-select ng-op-year-select" data-ng-op-year onchange="if (this.value) window.location.href = this.value;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yearOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($makePeriodUrl($selectedMonth, $yearOption)); ?>"
                                                <?php if((int) $selectedYear === (int) $yearOption): echo 'selected'; endif; ?>>
                                            <?php echo e($yearOption); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>

                                <select class="ng-op-select ng-op-status-select" data-ng-op-status onchange="if (this.value) window.location.href = this.value;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $statusLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($makeStatusUrl($statusKey)); ?>"
                                                <?php if($selectedStatus === $statusKey): echo 'selected'; endif; ?>>
                                            <?php echo e($statusLabel); ?>

                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                            + New Biaya
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-operational-kpi-grid">
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

                        <strong><?php echo e($card['value'] ?? '-'); ?></strong>

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

        body:has(.ng-operational-page) {
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

        body:has(.ng-operational-page) .fi-layout,
        body:has(.ng-operational-page) .fi-main,
        body:has(.ng-operational-page) .fi-main-ctn,
        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-page-content,
        body:has(.ng-operational-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-operational-page) .fi-page,
        body:has(.ng-operational-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-operational-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-operational-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-operational-page) .fi-wi,
        body:has(.ng-operational-page) .fi-wi-widget,
        body:has(.ng-operational-page) .fi-wi-widget-content,
        body:has(.ng-operational-page) .fi-wi-widgets,
        body:has(.ng-operational-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-operational-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-operational-page * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO + FILTER
        |--------------------------------------------------------------------------
        */

        .ng-op-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
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
            min-width: 0;
            padding: 18px;
            border-radius: 24px;
        }

        .ng-op-hero-card {
            min-height: 118px;
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

        .ng-op-active-period {
            display: inline-flex;
            margin-top: 10px;
            color: #d95d00;
            font-size: 12px;
            line-height: 1.3;
            font-weight: 950;
        }

        .ng-op-hero-right {
            position: relative;
            z-index: 3;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .ng-op-period-filter {
            position: relative;
            z-index: 3;
            min-width: 0;
            display: grid;
            gap: 8px;
            justify-items: end;
        }

        .ng-op-period-selects {
            min-height: 52px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .62);
            background: rgba(255, 255, 255, .38);
            box-shadow:
                0 18px 35px rgba(95, 55, 18, .10),
                inset 0 1px 0 rgba(255, 255, 255, .62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-op-select {
            min-height: 40px;
            min-width: 148px;
            border: 0;
            outline: none;
            border-radius: 14px;
            padding: 0 14px;
            color: #4a321f;
            background: rgba(255, 255, 255, .78);
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .ng-op-year-select {
            min-width: 94px;
        }

        .ng-op-status-select {
            min-width: 118px;
        }

        .ng-primary-button {
            position: relative;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
            font-size: 12px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-primary-button:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        /*
        |--------------------------------------------------------------------------
        | KPI - SAME AS CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-operational-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 6px;
        }

        .ng-kpi-card {
            min-height: 108px;
            display: flex;
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
        | TABLE FILAMENT - SAME COLOR STYLE AS CATEGORY
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-ctn {
            margin: 0 24px 24px !important;
            width: calc(100% - 48px) !important;
            max-width: calc(100% - 48px) !important;
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
            transform: none !important;
        }

        body:has(.ng-operational-page) .fi-section,
        body:has(.ng-operational-page) .fi-ta,
        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table,
        body:has(.ng-operational-page) .fi-ta-ctn > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div,
        body:has(.ng-operational-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-operational-page) table,
        body:has(.ng-operational-page) thead,
        body:has(.ng-operational-page) tbody,
        body:has(.ng-operational-page) tr,
        body:has(.ng-operational-page) th,
        body:has(.ng-operational-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-header,
        body:has(.ng-operational-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            box-shadow: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell,
        body:has(.ng-operational-page) .fi-ta-table thead th {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
            box-shadow: none !important;
        }

        body:has(.ng-operational-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-operational-page) .fi-ta-row,
        body:has(.ng-operational-page) .fi-ta-table tbody tr,
        body:has(.ng-operational-page) .fi-ta-table tbody tr:nth-child(odd),
        body:has(.ng-operational-page) .fi-ta-table tbody tr:nth-child(even) {
            min-height: 52px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-operational-page) .fi-ta-row:hover,
        body:has(.ng-operational-page) .fi-ta-table tbody tr:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-operational-page) .fi-ta-cell,
        body:has(.ng-operational-page) .fi-ta-table tbody td {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-operational-page) .fi-ta-table {
            table-layout: fixed !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }

        body:has(.ng-operational-page) .fi-ta-content,
        body:has(.ng-operational-page) .fi-ta-table-wrap {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th,
        body:has(.ng-operational-page) .fi-ta-table td {
            min-width: 0 !important;
            max-width: none !important;
            overflow: hidden !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            vertical-align: middle !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th:first-child,
        body:has(.ng-operational-page) .fi-ta-table td:first-child {
            width: 42px !important;
            max-width: 42px !important;
            padding-left: 16px !important;
            padding-right: 8px !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions,
        body:has(.ng-operational-page) .fi-ta-actions-cell,
        body:has(.ng-operational-page) td:has(.fi-ta-actions) {
            width: 58px !important;
            max-width: 58px !important;
            min-width: 58px !important;
            padding-left: 4px !important;
            padding-right: 14px !important;
            overflow: visible !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions {
            display: flex !important;
            justify-content: flex-end !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        body:has(.ng-operational-page) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-text-item-label {
            max-width: 100% !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        body:has(.ng-operational-page) .fi-ta-cell .fi-badge {
            max-width: 100% !important;
            white-space: nowrap !important;
        }

        body:has(.ng-operational-page) .fi-ta-pagination,
        body:has(.ng-operational-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-operational-page) .fi-input-wrp,
        body:has(.ng-operational-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-operational-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-operational-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-operational-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-operational-page) .fi-btn-color-primary,
        body:has(.ng-operational-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }


        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL TABLE COLUMN BALANCE
        |--------------------------------------------------------------------------
        | Rapihkan lebar kolom agar bagian kanan tidak kosong.
        | Kolom: Biaya, Nominal, Status, Tanggal, Action.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th,
        body:has(.ng-operational-page) .fi-ta-table td {
            vertical-align: middle !important;
        }

        /*
         * Biaya
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) {
            width: 38% !important;
            max-width: 38% !important;
            text-align: left !important;
            padding-left: 16px !important;
            padding-right: 14px !important;
        }

        /*
         * Nominal
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /*
         * Status
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /*
         * Tanggal
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /*
         * Action/menu kanan
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(5),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(5),
        body:has(.ng-operational-page) .fi-ta-actions-cell,
        body:has(.ng-operational-page) td:has(.fi-ta-actions) {
            width: 8% !important;
            max-width: 8% !important;
            min-width: 70px !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 16px !important;
            overflow: visible !important;
        }

        /*
         * Center-kan isi kolom selain Biaya.
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(2) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(3) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(4) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(5) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(5) > * {
            justify-content: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions .fi-btn {
            min-width: 36px !important;
            width: 36px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            border-radius: 999px !important;
        }

        /*
         * Pastikan text panjang tetap rapi.
         */
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item-label {
            text-align: left !important;
            justify-content: flex-start !important;
        }

        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) .fi-ta-text-item {
            text-align: center !important;
            justify-content: center !important;
        }



        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL BIAYA COLUMN POSITION TWEAK
        |--------------------------------------------------------------------------
        | Data kolom Biaya jangan terlalu kiri.
        | Jarak visual dari Biaya ke Nominal dibuat lebih rapat tanpa mengubah
        | jarak kolom Nominal, Status, Tanggal, dan action/menu kanan.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) {
            padding-left: 34px !important;
            padding-right: 10px !important;
        }

        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item-label {
            text-align: left !important;
            justify-content: flex-start !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th:nth-child(1) > * {
            justify-content: flex-start !important;
        }



        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL TABLE COLUMN FINAL POSITION
        |--------------------------------------------------------------------------
        | Revisi posisi:
        | - Kolom Biaya digeser ke area kanan sesuai garis referensi.
        | - Kolom Nominal, Status, dan Tanggal digeser sedikit ke kiri.
        | - Jarak antar Nominal, Status, Tanggal tetap rapi.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        /*
         * Biaya: dibuat lebih pendek supaya Nominal mendekat,
         * tapi isi teksnya digeser ke kanan.
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) {
            width: 32% !important;
            max-width: 32% !important;
            text-align: left !important;
            padding-left: 78px !important;
            padding-right: 10px !important;
        }

        /*
         * Nominal: geser kiri mengikuti lebar Biaya yang diperkecil.
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        /*
         * Status
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) {
            width: 18% !important;
            max-width: 18% !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        /*
         * Tanggal
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) {
            width: 20% !important;
            max-width: 20% !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        /*
         * Action/menu kanan tetap rapi.
         */
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(5),
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(5),
        body:has(.ng-operational-page) .fi-ta-actions-cell,
        body:has(.ng-operational-page) td:has(.fi-ta-actions) {
            width: 12% !important;
            max-width: 12% !important;
            min-width: 76px !important;
            text-align: center !important;
            padding-left: 8px !important;
            padding-right: 18px !important;
            overflow: visible !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th:nth-child(2) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(2) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(3) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(3) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(4) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(4) > *,
        body:has(.ng-operational-page) .fi-ta-table th:nth-child(5) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(5) > * {
            justify-content: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        body:has(.ng-operational-page) .fi-ta-table th:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item,
        body:has(.ng-operational-page) .fi-ta-table td:nth-child(1) .fi-ta-text-item-label {
            text-align: left !important;
            justify-content: flex-start !important;
        }

        body:has(.ng-operational-page) .fi-ta-actions {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
        }



        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL BIAYA HEADER ALIGN FIX
        |--------------------------------------------------------------------------
        | Judul kolom "Biaya" disejajarkan dengan data biaya di bawahnya.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1),
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) {
            padding-left: 78px !important;
            text-align: left !important;
        }

        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1) .fi-ta-header-cell-label,
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) .fi-ta-header-cell-label {
            justify-content: flex-start !important;
            text-align: left !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        body:has(.ng-operational-page) .fi-ta-table tbody td:nth-child(1) {
            padding-left: 78px !important;
            text-align: left !important;
        }



        /*
        |--------------------------------------------------------------------------
        | OPERATIONAL BIAYA HEADER FINAL ALIGN
        |--------------------------------------------------------------------------
        | Header "Biaya" digeser sedikit ke kanan agar sejajar dengan
        | data biaya di bawahnya. Data baris tetap dipertahankan posisinya.
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1),
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) {
            padding-left: 92px !important;
            text-align: left !important;
        }

        body:has(.ng-operational-page) .fi-ta-table tbody td:nth-child(1) {
            padding-left: 78px !important;
            text-align: left !important;
        }

        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) > *,
        body:has(.ng-operational-page) .fi-ta-table thead th:nth-child(1) .fi-ta-header-cell-label,
        body:has(.ng-operational-page) .fi-ta-header-cell:nth-child(1) .fi-ta-header-cell-label {
            justify-content: flex-start !important;
            text-align: left !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-operational-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item a,
        body:has(.ng-operational-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item-active a,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-operational-page) .fi-sidebar-item-active svg,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-operational-page) .fi-sidebar-item-active span,
        body:has(.ng-operational-page) .fi-sidebar-item a:hover span,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-operational-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1500px) {
            .ng-operational-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-operational-page {
                padding: 18px 18px 10px !important;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-op-hero-right {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .ng-op-period-filter {
                min-width: 0;
                justify-items: start;
            }

            .ng-op-period-selects {
                flex-wrap: wrap;
            }

            .ng-op-select {
                flex: 1;
                min-width: 140px;
            }

            .ng-operational-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            body:has(.ng-operational-page) .fi-ta-ctn {
                width: calc(100% - 36px) !important;
                max-width: calc(100% - 36px) !important;
                margin: 0 18px 22px !important;
            }
        }

        @media (max-width: 700px) {
            .ng-operational-page {
                padding: 14px 14px 8px !important;
            }

            .ng-operational-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-op-hero-right {
                width: 100%;
                align-items: stretch;
                flex-direction: column;
            }

            .ng-op-period-filter,
            .ng-op-period-selects {
                width: 100%;
            }

            .ng-primary-button {
                width: 100%;
            }

            .ng-widget-head h1 {
                font-size: 25px;
            }

            body:has(.ng-operational-page) .fi-ta-ctn {
                width: calc(100% - 28px) !important;
                max-width: calc(100% - 28px) !important;
                margin: 0 14px 20px !important;
            }
        }
    </style>
<script>
        (function () {
            function syncOperationalSidebarClass() {
                document.body.classList.add('ng-operational-sidebar-sync');
            }

            document.addEventListener('DOMContentLoaded', syncOperationalSidebarClass);
            document.addEventListener('livewire:navigated', syncOperationalSidebarClass);
            document.addEventListener('livewire:update', syncOperationalSidebarClass);
            syncOperationalSidebarClass();
        })();
    </script>



    <style id="ng-final-hp-kpi-2x2-ng-operational-page">
        /* =========================================================
           FINAL HP KPI 2x2 - scoped only for .ng-operational-page
           Tablet & desktop tetap mengikuti style sebelumnya.
        ========================================================= */
        @media (max-width: 700px) {
            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
                align-items: stretch !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid > .ng-kpi-card {
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

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-icon {
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                flex: 0 0 36px !important;
                border-radius: 13px !important;
                font-size: 14px !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content {
                min-width: 0 !important;
                width: 100% !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-label {
                gap: 5px !important;
                font-size: 9px !important;
                line-height: 1.2 !important;
                letter-spacing: 0.035em !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-label span {
                display: none !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content strong {
                margin-top: 6px !important;
                font-size: clamp(15px, 4.3vw, 18px) !important;
                line-height: 1.1 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content p,
            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content .neutral,
            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content span:not(.ng-kpi-label span) {
                margin-top: 5px !important;
                font-size: 9.5px !important;
                line-height: 1.25 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
        }

        @media (max-width: 380px) {
            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid {
                gap: 8px !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid > .ng-kpi-card {
                min-height: 94px !important;
                padding: 10px !important;
                gap: 7px !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-icon {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
                flex-basis: 32px !important;
                font-size: 13px !important;
            }

            body:has(.ng-operational-page) .ng-operational-page .ng-operational-kpi-grid .ng-kpi-content strong {
                font-size: clamp(13px, 4vw, 16px) !important;
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/operational-costs/widgets/operational-cost-analytics-widget.blade.php ENDPATH**/ ?>