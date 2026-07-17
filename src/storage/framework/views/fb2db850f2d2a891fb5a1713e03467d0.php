<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <?php
        $dashboard = $this->getDashboardData();
        $activePeriod = $dashboard['period']['key'];
        $periodOptions = $dashboard['period']['options'] ?? [];
        $charts = $dashboard['charts'];
        $user = auth()->user();

        $productSales = $charts['topProducts']['items'] ?? [];
        $maxProductUnits = max(1, (int) collect($productSales)->max('units'));
        $visibleMetrics = collect($dashboard['metrics'] ?? [])
            ->reject(fn ($metric) => ($metric['label'] ?? '') === 'Avg Order Value')
            ->values();
    ?>

    <div class="ng-dashboard" wire:ignore.self wire:loading.class="ng-dashboard-loading" wire:target="setPeriod,applyCustomRange,resetSmartFilter">
        <section class="ng-dashboard-header">
            <div class="ng-title-area">
                <h1>Dashboard Performa Penjualan</h1>
                <p>Ringkasan performa penjualan UMKM Ngunjuk</p>
            </div>

            <div class="ng-filter-area">
                <details class="ng-smart-filter">
                    <summary class="ng-filter-trigger" aria-label="Filter periode dashboard">
                        <span class="ng-filter-trigger-text">
                            <small>Periode</small>
                            <strong><?php echo e($dashboard['period']['label']); ?></strong>
                            <em><?php echo e($dashboard['period']['rangeLabel']); ?></em>
                        </span>

                        <span class="ng-filter-chevron" aria-hidden="true"></span>
                    </summary>

                    <div class="ng-filter-menu">
                        <div class="ng-filter-menu-head">
                            <div>
                                <strong>Smart Period Filter</strong>
                                <span><?php echo e($dashboard['period']['compareLabel']); ?></span>
                            </div>

                            <i><?php echo e($dashboard['period']['chartGroupingLabel']); ?></i>
                        </div>

                        <div class="ng-filter-options">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $periodOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <button
                                    type="button"
                                    wire:click="setPeriod('<?php echo e($option['key']); ?>')"
                                    wire:loading.attr="disabled"
                                    wire:target="setPeriod,applyCustomRange,resetSmartFilter"
                                    onclick="this.closest('details')?.removeAttribute('open')"
                                    class="ng-filter-option <?php echo e($activePeriod === $option['key'] ? 'active' : ''); ?>"
                                >
                                    <span><?php echo e($option['label']); ?></span>
                                    <small><?php echo e($option['caption']); ?></small>
                                </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <div class="ng-custom-range <?php echo e($activePeriod === 'custom' ? 'active' : ''); ?>">
                            <div class="ng-custom-range-title">
                                <strong>Custom Range</strong>
                                <span>Pilih tanggal manual</span>
                            </div>

                            <div class="ng-custom-range-fields">
                                <label class="ng-date-field">
                                    <span>Mulai</span>
                                    <input
                                        type="date"
                                        wire:model="customStartDate"
                                        wire:loading.attr="disabled"
                                        wire:target="setPeriod,applyCustomRange,resetSmartFilter"
                                    >
                                </label>

                                <label class="ng-date-field">
                                    <span>Akhir</span>
                                    <input
                                        type="date"
                                        wire:model="customEndDate"
                                        wire:loading.attr="disabled"
                                        wire:target="setPeriod,applyCustomRange,resetSmartFilter"
                                    >
                                </label>
                            </div>

                            <div class="ng-filter-actions">
                                <button
                                    type="button"
                                    class="ng-reset-filter"
                                    wire:click="resetSmartFilter"
                                    wire:loading.attr="disabled"
                                    wire:target="setPeriod,applyCustomRange,resetSmartFilter"
                                    onclick="this.closest('details')?.removeAttribute('open')"
                                >
                                    Reset
                                </button>

                                <button
                                    type="button"
                                    class="ng-apply-custom"
                                    wire:click="applyCustomRange"
                                    wire:loading.attr="disabled"
                                    wire:target="setPeriod,applyCustomRange,resetSmartFilter"
                                    onclick="this.closest('details')?.removeAttribute('open')"
                                >
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>
                </details>

                <div class="ng-admin-profile">
                    <div class="ng-avatar">
                        <?php echo e(strtoupper(substr($user?->name ?? 'A', 0, 1))); ?>

                    </div>

                    <div>
                        <strong><?php echo e($user?->name ?? 'Administrator'); ?></strong>
                        <span>Super Admin</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="ng-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $visibleMetrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <article class="ng-kpi-card" style="--accent: <?php echo e($metric['color']); ?>;">
                    <div class="ng-kpi-icon">
                        <?php echo e($metric['icon']); ?>

                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            <?php echo e($metric['label']); ?>

                            <span>⋮</span>
                        </div>

                        <strong><?php echo e($metric['value']); ?></strong>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </section>

        <section class="ng-main-grid">
            <article class="ng-widget-card ng-revenue-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Revenue Performance</h2>
                        <p><?php echo e($dashboard['period']['start']); ?> - <?php echo e($dashboard['period']['end']); ?></p>
                    </div>

                    <span class="ng-widget-badge"><?php echo e($dashboard['period']['label']); ?></span>
                </div>

                <div id="ngRevenueChart" wire:ignore class="ng-chart ng-chart-lg">
                    <div class="ng-chart-loader">
                        <span></span>
                        <p>Memuat grafik...</p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-product-sales-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Product Sales</h2>
                        <p>Semua informasi penjualan produk</p>
                    </div>

                    <span class="ng-widget-badge">Scroll</span>
                </div>

                <div class="ng-product-sales-scroll">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $productSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $barWidth = min(100, round(((int) $product['units'] / $maxProductUnits) * 100));
                        ?>

                        <div class="ng-product-sales-row">
                            <div class="ng-product-rank">
                                <?php echo e($index + 1); ?>

                            </div>

                            <div class="ng-product-sales-info">
                                <div class="ng-product-sales-top">
                                    <strong title="<?php echo e($product['name']); ?>"><?php echo e($product['name']); ?></strong>
                                    <span><?php echo e($product['units']); ?> unit</span>
                                </div>

                                <div class="ng-product-sales-meta">
                                    <span><?php echo e($product['category']); ?></span>
                                    <span><?php echo e($this->rupiah($product['revenue'])); ?></span>
                                </div>

                                <div class="ng-product-sales-bar">
                                    <i style="width: <?php echo e($barWidth); ?>%;"></i>
                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="ng-empty-state">
                            Belum ada data penjualan produk.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </article>

            <article class="ng-widget-card ng-category-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Product Category Contribution</h2>
                        <p>Kontribusi kategori produk</p>
                    </div>

                    <span class="ng-widget-badge">Revenue</span>
                </div>

                <div class="ng-donut-wrap">
                    <div id="ngCategoryChart" wire:ignore class="ng-chart ng-chart-donut">
                        <div class="ng-chart-loader">
                            <span></span>
                            <p>Memuat grafik...</p>
                        </div>
                    </div>

                    <div class="ng-category-list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $charts['category']['summary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div>
                                <span title="<?php echo e($category['name']); ?>"><?php echo e($category['name']); ?></span>
                                <strong><?php echo e($category['percentage']); ?>%</strong>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-bottom-grid">
            <article class="ng-widget-card ng-time-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Sales by Time</h2>
                        <p>Jam ramai transaksi</p>
                    </div>

                    <span class="ng-widget-badge">Per Jam</span>
                </div>

                <div id="ngSalesTimeChart" wire:ignore class="ng-chart ng-chart-md">
                    <div class="ng-chart-loader">
                        <span></span>
                        <p>Memuat grafik...</p>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-orders-card">
                <div class="ng-widget-head">
                    <div>
                        <h2>Latest Orders</h2>
                        <p>Transaksi terbaru</p>
                    </div>

                    <a href="<?php echo e(url('/admin/orders')); ?>">Lihat Semua</a>
                </div>

                <div class="ng-table-wrap">
                    <table class="ng-orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Waktu</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $dashboard['latestOrders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td><?php echo e($order['order_code']); ?></td>
                                    <td><?php echo e($order['time']); ?></td>
                                    <td><?php echo e($order['items']); ?></td>
                                    <td><?php echo e($this->rupiah($order['total'])); ?></td>
                                    <td>
                                        <span class="ng-order-status">
                                            <?php echo e($order['status']); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="5">Belum ada transaksi.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-dashboard) {
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

        body:has(.ng-dashboard) .fi-main,
        body:has(.ng-dashboard) .fi-main-ctn,
        body:has(.ng-dashboard) .fi-page,
        body:has(.ng-dashboard) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-dashboard) .fi-page,
        body:has(.ng-dashboard) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-dashboard) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-dashboard) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-dashboard) .fi-sidebar-item-active a,
        body:has(.ng-dashboard) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        .ng-dashboard {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 22px 22px 30px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-dashboard * {
            box-sizing: border-box;
        }

        .ng-dashboard-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 16px;
        }

        .ng-title-area {
            min-width: 250px;
        }

        .ng-title-area h1 {
            margin: 0;
            color: #21160d;
            font-size: 29px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-title-area p {
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            font-weight: 650;
        }

        .ng-filter-area {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .ng-smart-filter,
        .ng-admin-profile {
            flex: 0 0 auto;
        }

        .ng-smart-filter {
            position: relative;
            z-index: 30;
        }

        .ng-smart-filter summary {
            list-style: none;
        }

        .ng-smart-filter summary::-webkit-details-marker {
            display: none;
        }

        .ng-filter-trigger,
        .ng-admin-profile {
            min-height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .09), inset 0 1px 0 rgba(255, 255, 255, .58);
            backdrop-filter: blur(13px);
        }

        .ng-filter-trigger {
            width: 255px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 8px 10px 8px 15px;
            cursor: pointer;
            user-select: none;
            transition: .2s ease;
        }

        .ng-smart-filter[open] .ng-filter-trigger,
        .ng-filter-trigger:hover {
            background: rgba(255, 255, 255, .50);
            box-shadow: 0 18px 50px rgba(120, 74, 30, .11), inset 0 1px 0 rgba(255, 255, 255, .64);
        }

        .ng-filter-trigger-text {
            display: grid;
            gap: 2px;
            min-width: 0;
        }

        .ng-filter-trigger-text small,
        .ng-filter-trigger-text em {
            color: #7a614c;
            font-style: normal;
            font-size: 10px;
            font-weight: 850;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-filter-trigger-text strong {
            color: #2d1f16;
            font-size: 13px;
            line-height: 1.15;
            font-weight: 950;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-filter-chevron {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 11px;
            color: #24180f;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .62);
            transition: .2s ease;
        }

        .ng-filter-chevron::before {
            content: "∨";
            display: block;
            color: #24180f;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1;
            font-weight: 900;
            transform: translateY(-1.5px);
        }

        .ng-smart-filter[open] .ng-filter-chevron {
            transform: rotate(180deg);
        }

        .ng-filter-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 80;
            width: 360px;
            padding: 18px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, .66);
            background-color: #fff0dc !important;
            background:
                linear-gradient(145deg, #fff6ea 0%, #ffedd7 48%, #ffe1c2 100%),
                radial-gradient(circle at 92% 88%, rgba(255, 142, 36, .18) 0 145px, transparent 245px) !important;
            box-shadow:
                0 26px 60px rgba(101, 58, 21, .16),
                0 0 0 1px rgba(255, 255, 255, .14) inset,
                inset 0 1px 0 rgba(255, 255, 255, .68);
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            opacity: 1 !important;
            isolation: isolate;
        }

        .ng-filter-menu::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            border-radius: inherit;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .46), rgba(255, 255, 255, .18) 34%, rgba(255, 224, 190, .24) 100%);
            opacity: 1;
        }

        .ng-filter-menu::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            border-radius: inherit;
            pointer-events: none;
            background: rgba(255, 239, 219, .54);
        }

        .ng-filter-menu-head,
        .ng-filter-options,
        .ng-custom-range {
            position: relative;
            z-index: 3;
        }

        .ng-filter-menu-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .ng-filter-menu-head strong,
        .ng-custom-range-title strong {
            display: block;
            color: #25170d;
            font-size: 14px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.02em;
        }

        .ng-filter-menu-head span,
        .ng-custom-range-title span {
            display: block;
            margin-top: 4px;
            color: #7b624c;
            font-size: 10px;
            line-height: 1.25;
            font-weight: 800;
        }

        .ng-filter-menu-head i {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 11px;
            border-radius: 12px;
            color: #da6200;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-style: normal;
            font-size: 10px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-filter-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 9px;
        }

        .ng-filter-option {
            min-height: 54px;
            display: grid;
            align-content: center;
            gap: 3px;
            padding: 9px 10px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, .38);
            background: rgba(255, 255, 255, .24);
            color: #5f4a37;
            font-family: inherit;
            text-align: left;
            cursor: pointer;
            transition: .2s ease;
        }

        .ng-filter-option span {
            color: inherit;
            font-size: 11px;
            line-height: 1.15;
            font-weight: 950;
        }

        .ng-filter-option small {
            color: #8a6e55;
            font-size: 9px;
            line-height: 1.25;
            font-weight: 750;
        }

        .ng-filter-option.active,
        .ng-filter-option:hover {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            border-color: rgba(255, 255, 255, .35);
            box-shadow: 0 13px 24px rgba(238, 101, 0, .22);
        }

        .ng-filter-option.active small,
        .ng-filter-option:hover small {
            color: rgba(255, 255, 255, .82);
        }

        .ng-custom-range {
            margin-top: 10px;
            padding: 11px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-custom-range.active {
            box-shadow: 0 0 0 1px rgba(249, 115, 22, .25) inset;
        }

        .ng-custom-range-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 9px;
        }

        .ng-date-field {
            display: grid;
            gap: 5px;
        }

        .ng-date-field span {
            color: #6f5946;
            font-size: 10px;
            font-weight: 900;
        }

        .ng-date-field input {
            width: 100%;
            min-height: 36px;
            padding: 0 9px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, .50);
            background: rgba(255, 255, 255, .42);
            color: #2d1f16;
            font-family: inherit;
            font-size: 11px;
            font-weight: 850;
            outline: none;
        }

        .ng-date-field input:focus {
            border-color: rgba(249, 115, 22, .52);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, .12);
        }

        .ng-filter-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 10px;
        }

        .ng-reset-filter,
        .ng-apply-custom {
            min-height: 34px;
            padding: 0 13px;
            border: 0;
            border-radius: 12px;
            font-family: inherit;
            font-size: 11px;
            font-weight: 950;
            cursor: pointer;
            transition: .2s ease;
        }

        .ng-reset-filter {
            color: #6b5541;
            background: rgba(255, 255, 255, .42);
            border: 1px solid rgba(255, 255, 255, .48);
        }

        .ng-apply-custom {
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-filter-option:disabled,
        .ng-reset-filter:disabled,
        .ng-apply-custom:disabled,
        .ng-date-field input:disabled {
            opacity: .72;
            cursor: wait;
        }

        .ng-admin-profile {
            min-width: 154px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 12px 7px 7px;
            overflow: hidden;
        }

        .ng-avatar {
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            font-weight: 950;
            background: linear-gradient(135deg, #ff9b1a, #f05e00);
            box-shadow: 0 10px 22px rgba(240, 94, 0, .25);
        }

        .ng-admin-profile > div:last-child {
            min-width: 0;
        }

        .ng-admin-profile strong,
        .ng-admin-profile span {
            display: block;
            line-height: 1.2;
            white-space: nowrap;
        }

        .ng-admin-profile strong {
            overflow: hidden;
            color: #2d1f16;
            font-size: 13px;
            font-weight: 950;
            text-overflow: ellipsis;
        }

        .ng-admin-profile span {
            margin-top: 3px;
            color: #7a614c;
            font-size: 11px;
            font-weight: 750;
        }

        .ng-dashboard-loading .ng-widget-card,
        .ng-dashboard-loading .ng-kpi-card {
            transition: opacity .18s ease, transform .18s ease;
        }

        .ng-dashboard-loading .ng-chart {
            opacity: .72;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 16px;
        }

        .ng-kpi-card,
        .ng-widget-card {
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
        }

        .ng-kpi-card::before,
        .ng-widget-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-kpi-card {
            min-height: 92px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 17px;
            border-radius: 22px;
        }

        .ng-kpi-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            border-radius: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #d95d00);
            box-shadow: 0 15px 28px rgba(249, 115, 22, .22);
            font-size: 16px;
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
        }

        .ng-kpi-content strong {
            display: block;
            margin-top: 8px;
            color: #23160d;
            font-size: 22px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ng-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .95fr) minmax(340px, 1fr);
            gap: 16px;
            margin-bottom: 16px;
            align-items: stretch;
        }

        .ng-bottom-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(480px, 1.35fr);
            gap: 16px;
            align-items: stretch;
        }

        .ng-widget-card {
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 8px;
        }

        .ng-widget-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 16px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-widget-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 11px;
            font-weight: 800;
        }

        .ng-widget-head a,
        .ng-widget-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 12px;
            color: #da6200;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            font-size: 11px;
            font-weight: 950;
            text-decoration: none;
            white-space: nowrap;
        }

        .ng-chart {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .ng-chart,
        .ng-chart > div,
        .ng-chart svg,
        .apexcharts-canvas {
            max-width: 100% !important;
        }

        .ng-chart-lg {
            height: 260px;
            min-height: 260px;
        }

        .ng-chart-md {
            height: 230px;
            min-height: 230px;
        }

        .ng-time-card .ng-chart-md {
            height: 258px;
            min-height: 258px;
        }

        .ng-chart-donut {
            height: 230px;
            min-height: 230px;
        }

        .ng-chart-loader {
            height: 100%;
            min-height: inherit;
            display: grid;
            place-items: center;
            align-content: center;
            gap: 10px;
            color: #8a6e55;
            font-size: 12px;
            font-weight: 900;
        }

        .ng-chart-loader span {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            border: 3px solid rgba(249, 115, 22, .18);
            border-top-color: #f97316;
            animation: ngSpin .75s linear infinite;
        }

        .ng-chart-loader p {
            margin: 0;
        }

        @keyframes ngSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .ng-product-sales-scroll {
            position: relative;
            z-index: 2;
            display: grid;
            gap: 9px;
            height: 250px;
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
            overscroll-behavior: contain;
        }

        .ng-product-sales-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .ng-product-sales-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .28);
            border-radius: 999px;
        }

        .ng-product-sales-scroll::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .55);
            border-radius: 999px;
        }

        .ng-product-sales-row {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            align-items: center;
            gap: 10px;
            min-height: 56px;
            padding: 8px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-product-rank {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            color: #f97316;
            background: rgba(249, 115, 22, .12);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-product-sales-info {
            min-width: 0;
        }

        .ng-product-sales-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-width: 0;
        }

        .ng-product-sales-top strong {
            display: block;
            min-width: 0;
            overflow: hidden;
            color: #2b1b10;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-product-sales-top span {
            flex: 0 0 auto;
            color: #2b1b10;
            font-size: 11px;
            font-weight: 950;
        }

        .ng-product-sales-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            min-width: 0;
            overflow: hidden;
        }

        .ng-product-sales-meta span {
            color: #8b7057;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .ng-product-sales-bar {
            width: 100%;
            height: 7px;
            margin-top: 7px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(249, 115, 22, .11);
        }

        .ng-product-sales-bar i {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #ff9d18, #f97316);
        }

        .ng-donut-wrap {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(116px, .8fr);
            align-items: center;
            gap: 10px;
            overflow: hidden;
        }

        .ng-category-list {
            display: grid;
            gap: 9px;
            min-width: 0;
            width: 100%;
            overflow: hidden;
        }

        .ng-category-list div {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 8px;
            color: #6d5540;
            font-size: 12px;
            font-weight: 850;
        }

        .ng-category-list span {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-category-list strong {
            color: #2a1b10;
            font-size: 12px;
            font-weight: 950;
        }

        .ng-orders-card {
            overflow: hidden;
        }

        .ng-table-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            max-height: 278px;
            overflow-y: auto;
        }

        .ng-table-wrap::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .ng-table-wrap::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, .22);
            border-radius: 999px;
        }

        .ng-table-wrap::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, .48);
            border-radius: 999px;
        }

        .ng-orders-table {
            width: 100%;
            min-width: 520px;
            border-collapse: collapse;
        }

        .ng-orders-table thead {
            background: #fff0dc !important;
        }

        .ng-orders-table th {
            position: sticky;
            top: 0;
            z-index: 3;
            color: #6f5946;
            background: #fff0dc !important;
            backdrop-filter: none !important;
            font-size: 11px;
            font-weight: 950;
            text-align: left;
            padding: 8px 9px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(114, 74, 41, .10);
        }

        .ng-orders-table td {
            color: #352316;
            font-size: 11px;
            font-weight: 750;
            padding: 9px;
            white-space: nowrap;
            border-bottom: 1px solid rgba(114, 74, 41, .08);
        }

        .ng-orders-table tbody tr:hover {
            background: rgba(255, 255, 255, .30);
        }

        .ng-order-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            padding: 0 8px;
            border-radius: 10px;
            color: #078657;
            background: rgba(16, 185, 129, .14);
            font-size: 10px;
            font-weight: 950;
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

        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-main-grid {
                grid-template-columns: minmax(0, 1.3fr) minmax(320px, 1fr);
            }

            .ng-category-card {
                grid-column: span 2;
            }

            .ng-bottom-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 1100px) {
            .ng-dashboard {
                padding: 18px 14px 28px !important;
            }

            .ng-dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .ng-filter-area {
                justify-content: flex-start;
            }

            .ng-smart-filter,
            .ng-filter-trigger {
                width: 100%;
            }

            .ng-filter-menu {
                left: 0;
                right: auto;
                width: min(360px, calc(100vw - 28px));
            }

            .ng-custom-range-fields {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid,
            .ng-main-grid,
            .ng-bottom-grid {
                grid-template-columns: 1fr;
            }

            .ng-category-card {
                grid-column: span 1;
            }

            .ng-time-card .ng-chart-md {
                height: 270px;
                min-height: 270px;
            }

            .ng-donut-wrap {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        window.ngDashboardChartsData = <?php echo json_encode($charts, 15, 512) ?>;
        window.ngDashboardApexInstances = window.ngDashboardApexInstances || {};
        window.ngDashboardBootTimer = window.ngDashboardBootTimer || null;
        window.ngApexCallbacks = window.ngApexCallbacks || [];

        function ngLoadApexCharts(callback) {
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
                        console.warn('Dashboard chart callback skipped:', error);
                    }
                });
            };

            document.head.appendChild(script);
        }

        function ngFormatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function ngFormatRupiahCompact(value) {
            const number = Number(value || 0);

            if (number === 0) {
                return 'Rp 0';
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

        function ngDestroyDashboardCharts() {
            Object.keys(window.ngDashboardApexInstances || {}).forEach(function (key) {
                const chart = window.ngDashboardApexInstances[key];

                if (chart && typeof chart.destroy === 'function') {
                    try {
                        chart.destroy();
                    } catch (error) {
                        console.warn('Chart destroy skipped:', key);
                    }
                }

                delete window.ngDashboardApexInstances[key];
            });
        }

        function ngClearChartElement(selector) {
            const el = document.querySelector(selector);

            if (!el) {
                return null;
            }

            el.innerHTML = '';

            return el;
        }

        function ngRenderChart(selector, key, options) {
            if (!window.ApexCharts) {
                return;
            }

            if (window.ngDashboardApexInstances[key]) {
                return;
            }

            const el = ngClearChartElement(selector);

            if (!el) {
                return;
            }

            const chart = new ApexCharts(el, options);

            window.ngDashboardApexInstances[key] = chart;

            chart.render();
        }

        function ngMakeRevenueXAxisLabels(labels) {
            const safeLabels = Array.isArray(labels) ? labels : [];

            /*
            |--------------------------------------------------------------------------
            | Revenue Performance X-Axis
            |--------------------------------------------------------------------------
            | Tampilkan semua label tanggal yang dikirim dari Dashboard.php.
            | Jadi untuk bulan April akan tampil:
            | 01, 02, 03, 04, 05, ... 30
            */
            return safeLabels;
        }

        function ngMakeSalesTimeLabels(labels) {
            const safeLabels = Array.isArray(labels) ? labels : [];

            return safeLabels.map(function (label, index) {
                const rawLabel = String(label || '').trim();
                const fallbackHour = index + 6;

                if (rawLabel === '') {
                    return String(fallbackHour).padStart(2, '0') + ':00';
                }

                const hourMatch = rawLabel.match(/^(\d{1,2})/);
                const parsedHour = hourMatch ? Number(hourMatch[1]) : fallbackHour;
                const safeHour = Number.isFinite(parsedHour) ? Math.max(0, Math.min(23, parsedHour)) : fallbackHour;

                return String(safeHour).padStart(2, '0') + ':00';
            });
        }

        function ngInitDashboardCharts() {
            const dashboard = document.querySelector('.ng-dashboard');

            if (!dashboard || !window.ApexCharts) {
                return;
            }

            const charts = window.ngDashboardChartsData || {};

            ngDestroyDashboardCharts();

            requestAnimationFrame(function () {
                const revenueLabels = charts.revenue?.labels || [];
                const revenueXAxisLabels = ngMakeRevenueXAxisLabels(revenueLabels);
                const salesTimeLabels = ngMakeSalesTimeLabels(charts.salesByTime?.labels || []);

                ngRenderChart('#ngRevenueChart', 'revenue', {
                    chart: {
                        type: 'line',
                        height: 260,
                        toolbar: { show: false },
                        fontFamily: 'Inter, Poppins, sans-serif',
                        foreColor: '#7a6048',
                        zoom: { enabled: false },
                        animations: {
                            enabled: true,
                            speed: 280,
                            animateGradually: { enabled: false },
                            dynamicAnimation: { enabled: false },
                        },
                    },
                    series: [
                        {
                            name: 'Revenue',
                            type: 'area',
                            data: charts.revenue?.revenue || [],
                        },
                        {
                            name: 'Orders',
                            type: 'line',
                            data: charts.revenue?.orders || [],
                        },
                    ],
                    labels: revenueLabels,
                    stroke: {
                        width: [4, 3],
                        curve: 'smooth',
                    },
                    fill: {
                        type: ['solid', 'solid'],
                        colors: ['rgba(118, 110, 100, 0.20)', '#2563eb'],
                        opacity: [1, 1],
                    },
                    colors: ['#f97316', '#2563eb'],
                    dataLabels: {
                        enabled: false,
                    },
                    grid: {
                        borderColor: 'rgba(124, 92, 63, .12)',
                        strokeDashArray: 5,
                        padding: {
                            left: 18,
                            right: 22,
                            bottom: 18,
                        },
                    },
                    markers: {
                        size: 0,
                        hover: {
                            size: 5,
                        },
                    },
                    xaxis: {
                        categories: revenueXAxisLabels,
                        tickPlacement: 'on',
                        labels: {
                            rotate: -45,
                            rotateAlways: true,
                            trim: false,
                            hideOverlappingLabels: false,
                            maxHeight: 84,
                            offsetY: 8,
                            style: {
                                fontSize: '9px',
                                fontWeight: 850,
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
                    yaxis: [
                        {
                            min: 0,
                            tickAmount: 4,
                            labels: {
                                offsetX: -4,
                                formatter: function (value) {
                                    return ngFormatRupiahCompact(value);
                                },
                                style: {
                                    fontSize: '11px',
                                    fontWeight: 800,
                                },
                            },
                        },
                        {
                            opposite: true,
                            min: 0,
                            tickAmount: 4,
                            labels: {
                                offsetX: 10,
                                formatter: function (value) {
                                    return Number(value || 0).toLocaleString('id-ID');
                                },
                                style: {
                                    fontSize: '11px',
                                    fontWeight: 800,
                                },
                            },
                        },
                    ],
                    tooltip: {
                        shared: true,
                        intersect: false,
                        x: {
                            formatter: function (value, opts) {
                                return revenueLabels[opts.dataPointIndex] || value;
                            },
                        },
                        y: [
                            {
                                formatter: function (value) {
                                    return ngFormatRupiah(value);
                                },
                            },
                            {
                                formatter: function (value) {
                                    return Number(value || 0).toLocaleString('id-ID') + ' order';
                                },
                            },
                        ],
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'left',
                        fontSize: '12px',
                        fontWeight: 800,
                        labels: {
                            colors: '#4c3524',
                        },
                    },
                });

                ngRenderChart('#ngCategoryChart', 'category', {
                    chart: {
                        type: 'donut',
                        height: 230,
                        toolbar: { show: false },
                        fontFamily: 'Inter, Poppins, sans-serif',
                        foreColor: '#7a6048',
                        animations: {
                            enabled: true,
                            speed: 280,
                            animateGradually: { enabled: false },
                            dynamicAnimation: { enabled: false },
                        },
                    },
                    series: charts.category?.values || [],
                    labels: charts.category?.labels || [],
                    colors: ['#f97316', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6'],
                    stroke: {
                        width: 3,
                        colors: ['rgba(255,255,255,.65)'],
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: false,
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '68%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        color: '#6f5946',
                                        fontSize: '11px',
                                        fontWeight: 900,
                                    },
                                    value: {
                                        show: true,
                                        color: '#24180f',
                                        fontSize: '18px',
                                        fontWeight: 950,
                                        formatter: function (value) {
                                            return ngFormatRupiah(value);
                                        },
                                    },
                                    total: {
                                        show: true,
                                        label: 'Revenue',
                                        color: '#6f5946',
                                        fontSize: '11px',
                                        fontWeight: 900,
                                        formatter: function (w) {
                                            const total = w.globals.seriesTotals.reduce(function (a, b) {
                                                return a + b;
                                            }, 0);

                                            return ngFormatRupiah(total);
                                        },
                                    },
                                },
                            },
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function (value) {
                                return ngFormatRupiah(value);
                            },
                        },
                    },
                });

                ngRenderChart('#ngSalesTimeChart', 'salesByTime', {
                    chart: {
                        type: 'bar',
                        height: 258,
                        toolbar: { show: false },
                        fontFamily: 'Inter, Poppins, sans-serif',
                        foreColor: '#7a6048',
                        parentHeightOffset: 0,
                        animations: {
                            enabled: true,
                            speed: 280,
                            animateGradually: { enabled: false },
                            dynamicAnimation: { enabled: false },
                        },
                    },
                    series: [
                        {
                            name: 'Orders',
                            data: charts.salesByTime?.orders || [],
                        },
                    ],
                    colors: ['#f97316'],
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '34%',
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    grid: {
                        borderColor: 'rgba(124, 92, 63, .12)',
                        strokeDashArray: 5,
                        padding: {
                            top: 8,
                            left: 8,
                            right: 10,
                            bottom: 48,
                        },
                    },
                    xaxis: {
                        categories: salesTimeLabels,
                        tickPlacement: 'on',
                        labels: {
                            rotate: -45,
                            rotateAlways: true,
                            trim: false,
                            hideOverlappingLabels: false,
                            maxHeight: 84,
                            offsetY: 8,
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
                        labels: {
                            formatter: function (value) {
                                return Number(value || 0).toLocaleString('id-ID');
                            },
                            style: {
                                fontSize: '11px',
                                fontWeight: 800,
                            },
                        },
                    },
                    tooltip: {
                        x: {
                            formatter: function (value, opts) {
                                return salesTimeLabels[opts.dataPointIndex] || value;
                            },
                        },
                        y: {
                            formatter: function (value) {
                                return Number(value || 0).toLocaleString('id-ID') + ' order';
                            },
                        },
                    },
                });
            });
        }


        function ngExtractDashboardChartsPayload(payload) {
            const raw = Array.isArray(payload) ? (payload[0] || {}) : (payload || {});
            const detail = raw.detail || raw;

            if (detail.charts) {
                return detail.charts;
            }

            if (detail.revenue || detail.category || detail.salesByTime) {
                return detail;
            }

            return null;
        }

        function ngApplyDashboardRefresh(payload) {
            const nextCharts = ngExtractDashboardChartsPayload(payload);

            if (!nextCharts) {
                ngBootDashboardCharts();
                return;
            }

            window.ngDashboardChartsData = nextCharts;
            ngBootDashboardCharts();
        }

        function ngRegisterDashboardEvents() {
            if (!window.ngDashboardStaticEventsRegistered) {
                window.ngDashboardStaticEventsRegistered = true;

                document.addEventListener('DOMContentLoaded', ngBootDashboardCharts);
                document.addEventListener('livewire:navigated', ngBootDashboardCharts);
                document.addEventListener('livewire:update', function () {
                    if (!window.ngDashboardRefreshFromServer) {
                        ngBootDashboardCharts();
                    }
                });
                document.addEventListener('livewire:updated', function () {
                    if (!window.ngDashboardRefreshFromServer) {
                        ngBootDashboardCharts();
                    }
                });

                window.addEventListener('ng-dashboard-refresh', function (event) {
                    window.ngDashboardRefreshFromServer = true;
                    ngApplyDashboardRefresh(event.detail);

                    setTimeout(function () {
                        window.ngDashboardRefreshFromServer = false;
                    }, 250);
                });
            }

            if (window.Livewire && !window.ngDashboardLivewireEventRegistered) {
                window.ngDashboardLivewireEventRegistered = true;

                window.Livewire.on('ng-dashboard-refresh', function (payload) {
                    window.ngDashboardRefreshFromServer = true;
                    ngApplyDashboardRefresh(payload);

                    setTimeout(function () {
                        window.ngDashboardRefreshFromServer = false;
                    }, 250);
                });
            }
        }

        function ngBootDashboardCharts() {
            clearTimeout(window.ngDashboardBootTimer);

            window.ngDashboardBootTimer = setTimeout(function () {
                ngLoadApexCharts(ngInitDashboardCharts);
            }, 80);
        }

        document.addEventListener('livewire:init', ngRegisterDashboardEvents);
        ngRegisterDashboardEvents();

        if (document.readyState !== 'loading') {
            ngBootDashboardCharts();
        }
    </script>


    <style id="ng-dashboard-kpi-2x2-safe-final">
        /* FINAL SAFE: Dashboard KPI 2 kolom hanya tablet/HP */
        @media (max-width: 1100px) {
            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-card {
                width: 100% !important;
                min-width: 0 !important;
                min-height: 108px !important;
                padding: 14px !important;
                border-radius: 20px !important;
            }

            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-icon {
                width: 42px !important;
                height: 42px !important;
                flex: 0 0 42px !important;
                border-radius: 14px !important;
            }

            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-label {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-content strong {
                font-size: 18px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }
        }

        @media (max-width: 520px) {
            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
            }

            body:has(.ng-dashboard) .ng-dashboard .ng-kpi-card {
                min-height: 100px !important;
                padding: 12px !important;
                gap: 10px !important;
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/pages/dashboard.blade.php ENDPATH**/ ?>