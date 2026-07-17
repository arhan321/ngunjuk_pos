<?php
    $createUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('create');

    $cards = [
        [
            'label' => 'Total Roles',
            'value' => number_format((int) ($summary['total_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua role sistem',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Permissions',
            'value' => number_format((int) ($summary['total_permissions'] ?? 0), 0, ',', '.'),
            'caption' => 'Hak akses tersedia',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Guard Web',
            'value' => number_format((int) ($summary['web_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Role guard web',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Role Kosong',
            'value' => number_format((int) ($summary['empty_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Belum ada permission',
            'icon' => '!',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Access Control',
            'value' => 'Shield',
            'caption' => 'Filament permission',
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

    <div class="ng-role-page">
        <section class="ng-role-hero-grid">
            <article class="ng-widget-card ng-role-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Role & Permission</h1>

                        <p>
                            Kelola hak akses pengguna, role admin, role karyawan, guard, dan permission sistem
                            agar akses fitur POS tetap aman dan terkontrol.
                        </p>
                    </div>
                </div>

                <div class="ng-hero-actions">
                    <a href="<?php echo e($createUrl); ?>" class="ng-primary-button">
                        + New Role
                    </a>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-role-kpi-grid">
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

        body:has(.ng-role-page) {
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

        body:has(.ng-role-page) .fi-main,
        body:has(.ng-role-page) .fi-main-ctn,
        body:has(.ng-role-page) .fi-page,
        body:has(.ng-role-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-page) .fi-page,
        body:has(.ng-role-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-role-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-role-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-role-page) .fi-wi,
        body:has(.ng-role-page) .fi-wi-widget,
        body:has(.ng-role-page) .fi-wi-widget-content,
        body:has(.ng-role-page) .fi-wi-widgets,
        body:has(.ng-role-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-role-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-page * {
            box-sizing: border-box;
        }

        .ng-role-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
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

        .ng-role-hero-card {
            min-height: 126px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            width: 100%;
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

        .ng-highlight-actions {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 9px;
            flex-wrap: wrap;
        }

        .ng-role-highlight-card {
            display: none !important;
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
        | TABLE FILAMENT - ROLE PAGE
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-page) .fi-ta-ctn {
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

        body:has(.ng-role-page) .fi-section,
        body:has(.ng-role-page) .fi-ta,
        body:has(.ng-role-page) .fi-ta-content,
        body:has(.ng-role-page) .fi-ta-table,
        body:has(.ng-role-page) .fi-ta-ctn > div,
        body:has(.ng-role-page) .fi-ta-ctn > div > div,
        body:has(.ng-role-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-role-page) table,
        body:has(.ng-role-page) thead,
        body:has(.ng-role-page) tbody,
        body:has(.ng-role-page) tr,
        body:has(.ng-role-page) th,
        body:has(.ng-role-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-role-page) .fi-ta-header,
        body:has(.ng-role-page) .fi-ta-toolbar {
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-role-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-role-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-role-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-role-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-role-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
        }

        body:has(.ng-role-page) .fi-ta-pagination,
        body:has(.ng-role-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-role-page) .fi-input-wrp,
        body:has(.ng-role-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-role-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-role-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-role-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-role-page) .fi-btn-color-primary,
        body:has(.ng-role-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-role-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-page) .fi-sidebar-item-active a,
        body:has(.ng-role-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-role-page) .fi-sidebar-item-active svg,
        body:has(.ng-role-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-role-page) .fi-sidebar-item-active span,
        body:has(.ng-role-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-role-hero-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-role-page {
                padding: 18px 18px 10px !important;
            }

            .ng-role-hero-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-hero-actions {
                justify-content: flex-start;
            }

            body:has(.ng-role-page) .fi-ta-ctn {
                margin: 0 18px 22px !important;
                width: calc(100% - 36px) !important;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-role-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-role-page) .fi-ta-ctn {
                margin: 0 14px 20px !important;
                width: calc(100% - 28px) !important;
            }
        }
    </style>


    <style id="ng-final-hp-kpi-2x2-ng-role-page">
        /* =========================================================
           FINAL HP KPI 2x2 - scoped only for .ng-role-page
           Tablet & desktop tetap mengikuti style sebelumnya.
        ========================================================= */
        @media (max-width: 700px) {
            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 10px !important;
                align-items: stretch !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid > .ng-kpi-card {
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

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-icon {
                width: 36px !important;
                height: 36px !important;
                min-width: 36px !important;
                flex: 0 0 36px !important;
                border-radius: 13px !important;
                font-size: 14px !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content {
                min-width: 0 !important;
                width: 100% !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-label {
                gap: 5px !important;
                font-size: 9px !important;
                line-height: 1.2 !important;
                letter-spacing: 0.035em !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-label span {
                display: none !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content strong {
                margin-top: 6px !important;
                font-size: clamp(15px, 4.3vw, 18px) !important;
                line-height: 1.1 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content p,
            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content .neutral,
            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content span:not(.ng-kpi-label span) {
                margin-top: 5px !important;
                font-size: 9.5px !important;
                line-height: 1.25 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }
        }

        @media (max-width: 380px) {
            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid {
                gap: 8px !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid > .ng-kpi-card {
                min-height: 94px !important;
                padding: 10px !important;
                gap: 7px !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-icon {
                width: 32px !important;
                height: 32px !important;
                min-width: 32px !important;
                flex-basis: 32px !important;
                font-size: 13px !important;
            }

            body:has(.ng-role-page) .ng-role-page .ng-role-kpi-grid .ng-kpi-content strong {
                font-size: clamp(13px, 4vw, 16px) !important;
            }
        }
    

        /* =========================================================
           FINAL HP TABLE CLEANUP - USER & ROLE
           Khusus HP: tabel dibuat scroll horizontal rapi,
           kolom tidak saling tumpuk, tablet/desktop tidak berubah.
        ========================================================= */

        @media (max-width: 700px) {
            body:has(.ng-user-page) .fi-ta-ctn,
            body:has(.ng-role-page) .fi-ta-ctn {
                overflow: hidden !important;
                border-radius: 22px !important;
            }

            body:has(.ng-user-page) .fi-ta-content,
            body:has(.ng-role-page) .fi-ta-content {
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: auto !important;
                overflow-y: hidden !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: thin !important;
            }

            body:has(.ng-user-page) .fi-ta-table,
            body:has(.ng-role-page) .fi-ta-table {
                width: max-content !important;
                table-layout: fixed !important;
                border-collapse: separate !important;
                border-spacing: 0 !important;
            }

            body:has(.ng-user-page) .fi-ta-table {
                min-width: 1080px !important;
            }

            body:has(.ng-role-page) .fi-ta-table {
                min-width: 940px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th,
            body:has(.ng-user-page) .fi-ta-table td,
            body:has(.ng-role-page) .fi-ta-table th,
            body:has(.ng-role-page) .fi-ta-table td {
                vertical-align: middle !important;
                white-space: nowrap !important;
                word-break: keep-all !important;
                overflow-wrap: normal !important;
                padding-top: 12px !important;
                padding-bottom: 12px !important;
            }

            body:has(.ng-user-page) .fi-ta-row,
            body:has(.ng-role-page) .fi-ta-row {
                height: 72px !important;
                min-height: 72px !important;
            }

            body:has(.ng-user-page) .fi-ta-cell,
            body:has(.ng-role-page) .fi-ta-cell {
                height: 72px !important;
                min-height: 72px !important;
            }

            body:has(.ng-user-page) .fi-ta-cell > *,
            body:has(.ng-role-page) .fi-ta-cell > * {
                min-height: 0 !important;
            }

            body:has(.ng-user-page) .fi-ta-text,
            body:has(.ng-user-page) .fi-ta-text-item,
            body:has(.ng-user-page) .fi-ta-text-item-label,
            body:has(.ng-role-page) .fi-ta-text,
            body:has(.ng-role-page) .fi-ta-text-item,
            body:has(.ng-role-page) .fi-ta-text-item-label {
                max-width: 100% !important;
                white-space: nowrap !important;
                word-break: keep-all !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            body:has(.ng-user-page) .fi-ta-actions,
            body:has(.ng-role-page) .fi-ta-actions {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                flex-wrap: nowrap !important;
                gap: 8px !important;
                width: 100% !important;
            }

            body:has(.ng-user-page) .fi-ta-actions .fi-btn,
            body:has(.ng-user-page) .fi-ta-actions .fi-icon-btn,
            body:has(.ng-user-page) .fi-ta-actions a,
            body:has(.ng-role-page) .fi-ta-actions .fi-btn,
            body:has(.ng-role-page) .fi-ta-actions .fi-icon-btn,
            body:has(.ng-role-page) .fi-ta-actions a {
                flex: 0 0 auto !important;
                white-space: nowrap !important;
            }

            /* USER TABLE WIDTH */
            body:has(.ng-user-page) .fi-ta-table th:nth-child(1),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(1) {
                width: 56px !important;
                min-width: 56px !important;
                max-width: 56px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th:nth-child(2),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(2) {
                width: 230px !important;
                min-width: 230px !important;
                max-width: 230px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th:nth-child(3),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(3) {
                width: 270px !important;
                min-width: 270px !important;
                max-width: 270px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th:nth-child(4),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(4) {
                width: 150px !important;
                min-width: 150px !important;
                max-width: 150px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th:nth-child(5),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(5),
            body:has(.ng-user-page) .fi-ta-table th:nth-child(6),
            body:has(.ng-user-page) .fi-ta-table td:nth-child(6) {
                width: 150px !important;
                min-width: 150px !important;
                max-width: 150px !important;
            }

            body:has(.ng-user-page) .fi-ta-table th:last-child,
            body:has(.ng-user-page) .fi-ta-table td:last-child {
                width: 170px !important;
                min-width: 170px !important;
                max-width: 170px !important;
                text-align: right !important;
            }

            /* ROLE TABLE WIDTH */
            body:has(.ng-role-page) .fi-ta-table th:nth-child(1),
            body:has(.ng-role-page) .fi-ta-table td:nth-child(1) {
                width: 56px !important;
                min-width: 56px !important;
                max-width: 56px !important;
            }

            body:has(.ng-role-page) .fi-ta-table th:nth-child(2),
            body:has(.ng-role-page) .fi-ta-table td:nth-child(2) {
                width: 230px !important;
                min-width: 230px !important;
                max-width: 230px !important;
            }

            body:has(.ng-role-page) .fi-ta-table th:nth-child(3),
            body:has(.ng-role-page) .fi-ta-table td:nth-child(3) {
                width: 130px !important;
                min-width: 130px !important;
                max-width: 130px !important;
            }

            body:has(.ng-role-page) .fi-ta-table th:nth-child(4),
            body:has(.ng-role-page) .fi-ta-table td:nth-child(4) {
                width: 180px !important;
                min-width: 180px !important;
                max-width: 180px !important;
                text-align: center !important;
            }

            body:has(.ng-role-page) .fi-ta-table th:nth-child(5),
            body:has(.ng-role-page) .fi-ta-table td:nth-child(5) {
                width: 170px !important;
                min-width: 170px !important;
                max-width: 170px !important;
            }

            body:has(.ng-role-page) .fi-ta-table th:last-child,
            body:has(.ng-role-page) .fi-ta-table td:last-child {
                width: 190px !important;
                min-width: 190px !important;
                max-width: 190px !important;
                text-align: right !important;
            }

            body:has(.ng-role-page) .fi-badge,
            body:has(.ng-user-page) .fi-badge {
                white-space: nowrap !important;
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/roles/widgets/role-analytics-widget.blade.php ENDPATH**/ ?>