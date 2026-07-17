<?php
    $summary = method_exists($this, 'getActivitySummary') ? $this->getActivitySummary() : [];

    $totalLogs = number_format((int) ($summary['total_logs'] ?? 0), 0, ',', '.');
    $accessLogs = number_format((int) ($summary['access_logs'] ?? $summary['total_logs'] ?? 0), 0, ',', '.');
    $loginLogs = number_format((int) ($summary['login_logs'] ?? 0), 0, ',', '.');
    $logoutLogs = number_format((int) ($summary['logout_logs'] ?? 0), 0, ',', '.');

    $latestUser = (string) ($summary['latest_user'] ?? '-');
    $latestEvent = (string) ($summary['latest_event'] ?? '-');
    $latestTime = (string) ($summary['latest_time'] ?? '-');

    $topUser = (string) ($summary['top_user'] ?? '-');
    $topUserTotal = number_format((int) ($summary['top_user_total'] ?? 0), 0, ',', '.');

    $cards = [
        [
            'label' => 'Total Access',
            'value' => $accessLogs,
            'caption' => 'Login & logout tercatat',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Login',
            'value' => $loginLogs,
            'caption' => 'User masuk sistem',
            'icon' => '↳',
            'color' => '#3b82f6',
        ],
        [
            'label' => 'Logout',
            'value' => $logoutLogs,
            'caption' => 'User keluar sistem',
            'icon' => '↲',
            'color' => '#ef4444',
        ],
        [
            'label' => 'Top User',
            'value' => $topUser,
            'caption' => $topUserTotal . ' aktivitas',
            'icon' => '★',
            'color' => '#f97316',
        ],
    ];
?>

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

    <div class="ng-activity-page">
        <section class="ng-activity-hero-grid">
            <article class="ng-widget-card ng-activity-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1>Activity Log Analytics</h1>

                        <p>
                            Pantau seluruh aktivitas login, logout, dan riwayat akses pengguna
                            pada sistem POS Ngunjuk secara otomatis.
                        </p>

                    </div>

                </div>
            </article>
        </section>


        <section class="ng-activity-table-widget">
            <div class="ng-activity-table-head">
                <div>
                    <h2>Data Aktivitas</h2>
                    <p>Daftar riwayat login dan logout pengguna yang tercatat pada sistem.</p>
                </div>

                <span>Login / Logout Only</span>
            </div>

            <div class="ng-activity-table-wrap">
                <?php echo e($this->table); ?>

            </div>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-activity-page) {
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

        body:has(.ng-activity-page) .fi-main,
        body:has(.ng-activity-page) .fi-main-ctn,
        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-activity-page) .fi-page,
        body:has(.ng-activity-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-activity-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-activity-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-activity-page) .fi-wi,
        body:has(.ng-activity-page) .fi-wi-widget,
        body:has(.ng-activity-page) .fi-wi-widget-content,
        body:has(.ng-activity-page) .fi-wi-widgets,
        body:has(.ng-activity-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-activity-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-activity-page * {
            box-sizing: border-box;
        }

        .ng-activity-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin-bottom: 14px;
        }

        .ng-widget-card,
        .ng-kpi-card,
        .ng-activity-table-widget {
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
        .ng-activity-table-widget::before {
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

        .ng-activity-hero-card {
            min-height: 138px;
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

        .ng-widget-head h1 {
            margin: 0;
            color: #21160d;
            font-size: 30px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-widget-head p {
            max-width: 820px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-active-activity-label {
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

        .ng-activity-highlight-card {
            position: relative;
            z-index: 2;
            min-width: 360px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .30);
            border: 1px solid rgba(255, 255, 255, .48);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .48);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
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
            max-width: 220px;
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

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
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

        .ng-activity-table-widget {
            position: relative;
            z-index: 2;
            margin-bottom: 24px;
            border-radius: 24px;
        }

        .ng-activity-table-head {
            position: relative;
            z-index: 2;
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(114, 74, 41, .08);
            background: rgba(255, 247, 235, .10);
        }

        .ng-activity-table-head h2 {
            margin: 0;
            color: #21160d;
            font-size: 18px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-activity-table-head p {
            margin: 5px 0 0;
            color: #765d45;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 800;
        }

        .ng-activity-table-head > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #d95d00;
            background: rgba(255, 255, 255, .38);
            border: 1px solid rgba(255, 255, 255, .52);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-activity-table-wrap {
            position: relative;
            z-index: 2;
        }

        body:has(.ng-activity-page) .fi-ta-ctn {
            margin: 0 !important;
            width: 100% !important;
            transform: none !important;
            border-radius: 0 0 24px 24px !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            overflow: hidden !important;
        }

        body:has(.ng-activity-page) .fi-section,
        body:has(.ng-activity-page) .fi-ta,
        body:has(.ng-activity-page) .fi-ta-content,
        body:has(.ng-activity-page) .fi-ta-table,
        body:has(.ng-activity-page) .fi-ta-ctn > div,
        body:has(.ng-activity-page) .fi-ta-ctn > div > div,
        body:has(.ng-activity-page) .fi-ta-ctn > div > div > div,
        body:has(.ng-activity-page) table,
        body:has(.ng-activity-page) thead,
        body:has(.ng-activity-page) tbody,
        body:has(.ng-activity-page) tr,
        body:has(.ng-activity-page) th,
        body:has(.ng-activity-page) td {
            background: transparent !important;
            box-shadow: none !important;
        }

        body:has(.ng-activity-page) .fi-ta-header {
            display: block !important;
            min-height: 46px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-ta-heading {
            display: none !important;
        }

        body:has(.ng-activity-page) .fi-ta-toolbar,
        body:has(.ng-activity-page) .fi-ta-header-toolbar {
            min-height: 46px !important;
            padding: 0 !important;
            background: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            background: rgba(255, 255, 255, .10) !important;
            border-color: rgba(114, 74, 41, .08) !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell-label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
            justify-content: center !important;
            text-align: center !important;
        }

        body:has(.ng-activity-page) .fi-ta-row {
            min-height: 54px !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
            background: rgba(255, 247, 235, .04) !important;
            transition: .18s ease !important;
        }

        body:has(.ng-activity-page) .fi-ta-row:hover {
            background: rgba(255, 255, 255, .14) !important;
        }

        body:has(.ng-activity-page) .fi-ta-cell {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            border-color: rgba(114, 74, 41, .08) !important;
            background: transparent !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        body:has(.ng-activity-page) .fi-ta-header-cell > *,
        body:has(.ng-activity-page) .fi-ta-cell > *,
        body:has(.ng-activity-page) .fi-ta-cell .fi-ta-text,
        body:has(.ng-activity-page) .fi-ta-cell .fi-ta-text-item {
            justify-content: center !important;
            text-align: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        body:has(.ng-activity-page) .fi-ta-pagination,
        body:has(.ng-activity-page) .fi-pagination {
            min-height: 48px !important;
            padding: 8px 16px !important;
            background: rgba(255, 247, 235, .10) !important;
            border-top: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-activity-page) .fi-input-wrp,
        body:has(.ng-activity-page) .fi-ta-search-field .fi-input-wrp,
        body:has(.ng-activity-page) .fi-select-input {
            min-height: 38px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-activity-page) .fi-ta-search-field {
            max-width: 280px !important;
        }

        body:has(.ng-activity-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-activity-page) .fi-btn-color-primary,
        body:has(.ng-activity-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-activity-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item-active a,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-activity-page) .fi-sidebar-item-active svg,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-activity-page) .fi-sidebar-item-active span,
        body:has(.ng-activity-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-activity-highlight-card {
                width: 100%;
                min-width: 0;
            }
        }

        @media (max-width: 1100px) {
            .ng-activity-page {
                padding: 18px 18px 10px !important;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }

            .ng-activity-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-activity-table-head,
            .ng-activity-highlight-card {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | ACTIVITY LOG CLEAN HERO
        |--------------------------------------------------------------------------
        | Menghapus highlight kecil, label data aktif, dan KPI Activity Log.
        */

        body:has(.ng-activity-page) .ng-active-activity-label,
        body:has(.ng-activity-page) .ng-activity-highlight-card,
        body:has(.ng-activity-page) .ng-activity-kpi-grid {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            height: 0 !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body:has(.ng-activity-page) .ng-activity-hero-card {
            min-height: 126px !important;
        }

        body:has(.ng-activity-page) .ng-widget-head {
            justify-content: flex-start !important;
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/activity-logs/pages/list-activity-logs.blade.php ENDPATH**/ ?>