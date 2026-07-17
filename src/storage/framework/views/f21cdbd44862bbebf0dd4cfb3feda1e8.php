<?php
    $createUrl = \App\Filament\Admin\Resources\Products\ProductResource::getUrl('create');

    $cards = [
        [
            'label' => 'Total Produk',
            'value' => number_format((int) ($summary['total_products'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua data produk',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Produk Aktif',
            'value' => number_format((int) ($summary['active_products'] ?? 0), 0, ',', '.'),
            'caption' => 'Tampil di kasir',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Total Kategori',
            'value' => number_format((int) ($summary['total_categories'] ?? 0), 0, ',', '.'),
            'caption' => 'Kategori produk',
            'icon' => '◇',
            'color' => '#3b82f6',
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

    <div class="ng-product-page">
        <section class="ng-product-hero-grid">
            <article class="ng-widget-card ng-product-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Product Management</h1>

                        <p>
                            Kelola data produk minuman, kategori, ukuran, harga, gambar produk,
                            dan status aktif produk dalam satu halaman admin.
                        </p>
                    </div>

                    <div class="ng-product-hero-actions">
                        <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                            + New Product
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-product-kpi-grid">
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

        body:has(.ng-product-page) {
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

        body:has(.ng-product-page) .fi-main,
        body:has(.ng-product-page) .fi-main-ctn,
        body:has(.ng-product-page) .fi-page,
        body:has(.ng-product-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-product-page) .fi-page,
        body:has(.ng-product-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-product-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-product-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-product-page) .fi-wi,
        body:has(.ng-product-page) .fi-wi-widget,
        body:has(.ng-product-page) .fi-wi-widget-content,
        body:has(.ng-product-page) .fi-wi-widgets,
        body:has(.ng-product-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-product-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-product-page * {
            box-sizing: border-box;
        }

        .ng-product-hero-grid {
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
            border-radius: 24px;
            padding: 18px;
            min-width: 0;
        }

        .ng-product-hero-card {
            min-height: 126px;
        }

        .ng-product-hero-card {
            display: flex;
            align-items: center;
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

        .ng-widget-head p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }



        .ng-product-hero-actions {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .ng-primary-button {
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
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 6px;
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
        | TABLE FILAMENT - PRODUCT PAGE
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-page) .fi-ta-ctn {
            margin: 0 24px 24px !important;
            width: calc(100% - 48px) !important;
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

        body:has(.ng-product-page) .fi-section,
        body:has(.ng-product-page) .fi-ta,
        body:has(.ng-product-page) .fi-ta-content,
        body:has(.ng-product-page) .fi-ta-table,
        body:has(.ng-product-page) .fi-ta-ctn > div,
        body:has(.ng-product-page) .fi-ta-ctn > div > div,
        body:has(.ng-product-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-product-page) table,
        body:has(.ng-product-page) thead,
        body:has(.ng-product-page) tbody,
        body:has(.ng-product-page) tr,
        body:has(.ng-product-page) th,
        body:has(.ng-product-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-product-page) .fi-ta-header,
        body:has(.ng-product-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-product-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-product-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-product-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-product-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-product-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-product-page) .fi-ta-pagination,
        body:has(.ng-product-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-product-page) .fi-input-wrp,
        body:has(.ng-product-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-product-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-product-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-product-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-product-page) .fi-btn-color-primary,
        body:has(.ng-product-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-product-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-product-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-product-page) .fi-sidebar-item-active a,
        body:has(.ng-product-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-product-page) .fi-sidebar-item-active svg,
        body:has(.ng-product-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-product-page) .fi-sidebar-item-active span,
        body:has(.ng-product-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-product-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-product-page {
                padding: 18px 18px 10px !important;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-product-hero-actions {
                justify-content: flex-start;
            }

            body:has(.ng-product-page) .fi-ta-ctn {
                margin: 0 18px 22px !important;
                width: calc(100% - 36px) !important;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-product-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-product-page) .fi-ta-ctn {
                margin: 0 14px 20px !important;
                width: calc(100% - 28px) !important;
            }
        }
    </style>


    <style id="ng-final-hp-kpi-2x2-ng-product-page">
        /* =========================================================
           FINAL HP KPI 2x2 - scoped only for .ng-product-page
           Tablet & desktop tetap mengikuti style sebelumnya.
        ========================================================= */
        @media (max-width: 700px) {
            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
                align-items: stretch !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid > .ng-kpi-card {
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

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-icon {
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                flex: 0 0 36px !important;
                border-radius: 13px !important;
                font-size: 14px !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content {
                min-width: 0 !important;
                width: 100% !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-label {
                gap: 5px !important;
                font-size: 9px !important;
                line-height: 1.2 !important;
                letter-spacing: 0.035em !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-label span {
                display: none !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content strong {
                margin-top: 6px !important;
                font-size: clamp(15px, 4.3vw, 18px) !important;
                line-height: 1.1 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content p,
            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content .neutral,
            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content span:not(.ng-kpi-label span) {
                margin-top: 5px !important;
                font-size: 9.5px !important;
                line-height: 1.25 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
        }

        @media (max-width: 380px) {
            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid {
                gap: 8px !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid > .ng-kpi-card {
                min-height: 94px !important;
                padding: 10px !important;
                gap: 7px !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-icon {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
                flex-basis: 32px !important;
                font-size: 13px !important;
            }

            body:has(.ng-product-page) .ng-product-page .ng-product-kpi-grid .ng-kpi-content strong {
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/products/widgets/product-analytics-widget.blade.php ENDPATH**/ ?>