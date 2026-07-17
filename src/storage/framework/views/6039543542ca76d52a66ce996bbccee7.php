<?php
    $createUrl = \App\Filament\Admin\Resources\Categories\CategoryResource::getUrl('create');

    $cards = [
        [
            'label' => 'Total Kategori',
            'value' => number_format((int) ($summary['total_categories'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua kategori',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Kategori Aktif',
            'value' => number_format((int) ($summary['active_categories'] ?? 0), 0, ',', '.'),
            'caption' => 'Tampil pada sistem',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Kategori Nonaktif',
            'value' => number_format((int) ($summary['inactive_categories'] ?? 0), 0, ',', '.'),
            'caption' => 'Tidak digunakan',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Total Produk',
            'value' => number_format((int) ($summary['total_products'] ?? 0), 0, ',', '.'),
            'caption' => 'Produk terhubung',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Kategori Kosong',
            'value' => number_format((int) ($summary['empty_categories'] ?? 0), 0, ',', '.'),
            'caption' => 'Belum ada produk',
            'icon' => '○',
            'color' => '#8b5cf6',
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

    <div class="ng-category-page">
        <section class="ng-category-hero-grid">
            <article class="ng-widget-card ng-category-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Category Management</h1>

                        <p>
                            Kelola kategori produk minuman agar data produk lebih rapi dan mudah digunakan
                            pada halaman kasir POS.
                        </p>
                    </div>

                    <div class="ng-category-hero-actions">
                        <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                            + New Kategori
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid">
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

        body:has(.ng-category-page) {
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

        body:has(.ng-category-page) .fi-main,
        body:has(.ng-category-page) .fi-main-ctn,
        body:has(.ng-category-page) .fi-page,
        body:has(.ng-category-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-category-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-category-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-category-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-category-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-category-page) .fi-wi,
        body:has(.ng-category-page) .fi-wi-widget,
        body:has(.ng-category-page) .fi-wi-widget-content,
        body:has(.ng-category-page) .fi-wi-widgets,
        body:has(.ng-category-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-category-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-category-page * {
            box-sizing: border-box;
        }

        .ng-category-hero-grid {
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

        .ng-category-hero-card {
            min-height: 126px;
        }

        .ng-category-hero-card {
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

        .ng-widget-head p {
            max-width: 760px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-category-hero-actions {
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
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
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
        | TABLE FILAMENT - CATEGORY
        |--------------------------------------------------------------------------
        */

        body:has(.ng-category-page) .fi-ta-ctn {
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
            transform: none !important;
        }

        body:has(.ng-category-page) .fi-section,
        body:has(.ng-category-page) .fi-ta,
        body:has(.ng-category-page) .fi-ta-content,
        body:has(.ng-category-page) .fi-ta-table,
        body:has(.ng-category-page) .fi-ta-ctn > div,
        body:has(.ng-category-page) .fi-ta-ctn > div > div,
        body:has(.ng-category-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-category-page) table,
        body:has(.ng-category-page) thead,
        body:has(.ng-category-page) tbody,
        body:has(.ng-category-page) tr,
        body:has(.ng-category-page) th,
        body:has(.ng-category-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-category-page) .fi-ta-header,
        body:has(.ng-category-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-category-page) .fi-ta-header-cell {
            padding-top: 9px !important;
            padding-bottom: 9px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-category-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-category-page) .fi-ta-row {
            min-height: 52px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-category-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-category-page) .fi-ta-cell {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-category-page) .fi-ta-table {
            table-layout: fixed !important;
            width: 100% !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(1),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(1) {
            width: 52px !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(2),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(2) {
            width: 34% !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(3),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(3) {
            width: 20% !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) {
            width: 15% !important;
            text-align: center !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(5),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(5) {
            width: 18% !important;
            text-align: center !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(6),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(6) {
            width: 90px !important;
            text-align: right !important;
        }


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT FIX - KOLOM AKTIF
        |--------------------------------------------------------------------------
        | Posisi header "Aktif" dan ikon status aktif/nonaktif dipaksa sejajar.
        | Filament kadang memberi wrapper flex di dalam cell, jadi text-align saja
        | belum cukup untuk menyamakan posisi header dan isi data.
        */
        body:has(.ng-category-page) .fi-ta-table th:nth-child(4),
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) {
            width: 15% !important;
            text-align: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(4) > *,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) > * {
            width: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        body:has(.ng-category-page) .fi-ta-table th:nth-child(4) .fi-ta-header-cell-label,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) .fi-ta-icon,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) .fi-ta-text,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) svg,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) span,
        body:has(.ng-category-page) .fi-ta-table td:nth-child(4) div {
            margin-left: auto !important;
            margin-right: auto !important;
            justify-content: center !important;
            text-align: center !important;
        }

        body:has(.ng-category-page) .fi-ta-cell div[style*="min-width:210px"] {
            min-width: 170px !important;
            gap: 10px !important;
        }

        body:has(.ng-category-page) .fi-ta-cell div[style*="width:42px"] {
            width: 36px !important;
            height: 36px !important;
            border-radius: 13px !important;
        }

        body:has(.ng-category-page) .fi-ta-cell span[style*="border-radius:999px"],
        body:has(.ng-category-page) .fi-ta-cell div[style*="border-radius:999px"] {
            min-height: 26px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
            font-size: 10px !important;
        }

        body:has(.ng-category-page) .fi-ta-pagination,
        body:has(.ng-category-page) .fi-pagination {
            min-height: 50px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-category-page) .fi-input-wrp,
        body:has(.ng-category-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-category-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-category-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-category-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-category-page) .fi-btn-color-primary,
        body:has(.ng-category-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-category-page) .fi-sidebar,
        body:has(.ng-category-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-category-page) .fi-sidebar-nav,
        body:has(.ng-category-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-category-page) .fi-sidebar-item a,
        body:has(.ng-category-form-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-category-page) .fi-sidebar-item-active a,
        body:has(.ng-category-page) .fi-sidebar-item a:hover,
        body:has(.ng-category-form-page) .fi-sidebar-item-active a,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-category-page) .fi-sidebar-item-active svg,
        body:has(.ng-category-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-category-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-category-page) .fi-sidebar-item-active span,
        body:has(.ng-category-page) .fi-sidebar-item a:hover span,
        body:has(.ng-category-form-page) .fi-sidebar-item-active span,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-category-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-category-page {
                padding: 18px 18px 10px !important;
            }

            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-category-hero-actions {
                justify-content: flex-start;
            }

            body:has(.ng-category-page) .fi-ta-ctn {
                margin: 0 18px 22px !important;
                width: calc(100% - 36px) !important;
            }
        }

        @media (max-width: 640px) {
            .ng-category-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-category-page) .fi-ta-ctn {
                margin: 0 14px 20px !important;
                width: calc(100% - 28px) !important;
            }
        }
    </style>


    <style id="ng-category-kpi-2x2-safe-final">
        /* FINAL SAFE: Category KPI 2 kolom hanya tablet/HP */
        @media (max-width: 1100px) {
            body:has(.ng-category-page) .ng-category-page .ng-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-card {
                width: 100% !important;
                min-width: 0 !important;
                min-height: 108px !important;
                padding: 14px !important;
                border-radius: 20px !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-icon {
                width: 42px !important;
                height: 42px !important;
                flex: 0 0 42px !important;
                border-radius: 14px !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-label {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-content strong {
                font-size: 18px !important;
                line-height: 1.1 !important;
                white-space: normal !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-grid .ng-kpi-card:nth-child(5):last-child {
                grid-column: 1 / -1 !important;
            }
        }

        @media (max-width: 520px) {
            body:has(.ng-category-page) .ng-category-page .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
            }

            body:has(.ng-category-page) .ng-category-page .ng-kpi-card {
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/categories/widgets/category-analytics-widget.blade.php ENDPATH**/ ?>