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

    <div class="ng-category-form-page">
        <section class="ng-category-form-hero-grid">
            <article class="ng-widget-card ng-category-form-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1><?php echo e($title); ?></h1>

                        <p>
                            <?php echo e($description); ?>

                        </p>
                    </div>

                    <div class="ng-category-form-hero-actions">
                        <a href="<?php echo e($backUrl); ?>" class="ng-primary-button">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid">
            <article class="ng-kpi-card" style="--accent: #f97316;">
                <div class="ng-kpi-icon">
                    ▣
                </div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Total Kategori
                        <span>⋮</span>
                    </div>

                    <strong>
                        <?php echo e(number_format((int) ($stats['total_categories'] ?? 0), 0, ',', '.')); ?>

                    </strong>

                    <p class="neutral">
                        Semua kategori
                    </p>
                </div>
            </article>

            <article class="ng-kpi-card" style="--accent: #10b981;">
                <div class="ng-kpi-icon">
                    ✓
                </div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Kategori Aktif
                        <span>⋮</span>
                    </div>

                    <strong>
                        <?php echo e(number_format((int) ($stats['active_categories'] ?? 0), 0, ',', '.')); ?>

                    </strong>

                    <p class="neutral">
                        Tampil pada sistem
                    </p>
                </div>
            </article>

            <article class="ng-kpi-card" style="--accent: #3b82f6;">
                <div class="ng-kpi-icon">
                    ◇
                </div>

                <div class="ng-kpi-content">
                    <div class="ng-kpi-label">
                        Total Produk
                        <span>⋮</span>
                    </div>

                    <strong>
                        <?php echo e(number_format((int) ($stats['total_products'] ?? 0), 0, ',', '.')); ?>

                    </strong>

                    <p class="neutral">
                        Produk terhubung
                    </p>
                </div>
            </article>
        </section>
    </div>
    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-category-form-page) {
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

        body:has(.ng-category-form-page) .fi-layout,
        body:has(.ng-category-form-page) .fi-main,
        body:has(.ng-category-form-page) .fi-main-ctn,
        body:has(.ng-category-form-page) .fi-page,
        body:has(.ng-category-form-page) .fi-page-content,
        body:has(.ng-category-form-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-category-form-page) .fi-page,
        body:has(.ng-category-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-category-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-category-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-category-form-page) .fi-wi,
        body:has(.ng-category-form-page) .fi-wi-widget,
        body:has(.ng-category-form-page) .fi-wi-widget-content,
        body:has(.ng-category-form-page) .fi-wi-widgets,
        body:has(.ng-category-form-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-category-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-category-form-page * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO - FULL WIDTH, IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-category-form-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 14px;
        }

        .ng-widget-card {
            position: relative;
            overflow: hidden;
            min-width: 0;
            padding: 18px;
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
        }

        .ng-widget-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-category-form-hero-card {
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

        .ng-widget-head p {
            max-width: 900px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-category-form-hero-actions {
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

        /*
        |--------------------------------------------------------------------------
        | FORM PANEL - IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        body:has(.ng-category-form-page) form,
        body:has(.ng-category-form-page) .fi-section,
        body:has(.ng-category-form-page) .fi-fo-component-ctn,
        body:has(.ng-category-form-page) .fi-section-content {
            background: transparent !important;
        }

        body:has(.ng-category-form-page) .fi-page-content > form {
            margin-top: -16px !important;
        }

        body:has(.ng-category-form-page) form .fi-section,
        body:has(.ng-category-form-page) .fi-section {
            position: relative !important;
            z-index: 25 !important;
            margin-left: 24px !important;
            margin-right: 24px !important;
            margin-top: 0 !important;
            width: calc(100% - 48px) !important;
            border-radius: 24px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .46), rgba(255, 246, 231, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101, 58, 21, .12),
                0 0 0 1px rgba(255, 255, 255, .12) inset,
                inset 0 1px 0 rgba(255, 255, 255, .62) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            overflow: visible !important;
        }

        body:has(.ng-category-form-page) form .fi-section::before,
        body:has(.ng-category-form-page) .fi-section::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: inherit;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        body:has(.ng-category-form-page) .fi-section-header,
        body:has(.ng-category-form-page) .fi-section-content {
            position: relative !important;
            z-index: 2 !important;
        }

        body:has(.ng-category-form-page) .fi-section-header {
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-category-form-page) .fi-section-header-heading,
        body:has(.ng-category-form-page) .fi-section-header-description {
            color: #4b3525 !important;
        }

        body:has(.ng-category-form-page) .fi-input-wrp,
        body:has(.ng-category-form-page) .fi-select-input,
        body:has(.ng-category-form-page) .fi-textarea {
            min-height: 40px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-category-form-page) .fi-input,
        body:has(.ng-category-form-page) .fi-select-input,
        body:has(.ng-category-form-page) textarea {
            color: #2d1f16 !important;
            font-weight: 750 !important;
        }

        body:has(.ng-category-form-page) .fi-input::placeholder,
        body:has(.ng-category-form-page) textarea::placeholder {
            color: rgba(111, 88, 68, .62) !important;
        }

        body:has(.ng-category-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-category-form-page) label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-category-form-page) .fi-fo-field-wrp-helper-text,
        body:has(.ng-category-form-page) .fi-fo-field-wrp-error-message {
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        body:has(.ng-category-form-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-category-form-page) .fi-btn-color-primary,
        body:has(.ng-category-form-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-category-form-page) .fi-btn-color-primary:hover,
        body:has(.ng-category-form-page) .fi-btn-color-warning:hover {
            box-shadow: 0 16px 28px rgba(238, 101, 0, .28) !important;
        }

        body:has(.ng-category-form-page) form .fi-form-actions,
        body:has(.ng-category-form-page) form .fi-ac {
            margin-top: 14px !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | DATEPICKER / DROPDOWN FIX
        |--------------------------------------------------------------------------
        */

        body:has(.ng-category-form-page),
        body:has(.ng-category-form-page) .fi-main,
        body:has(.ng-category-form-page) .fi-main-ctn,
        body:has(.ng-category-form-page) .fi-page,
        body:has(.ng-category-form-page) .fi-page-content,
        body:has(.ng-category-form-page) form,
        body:has(.ng-category-form-page) form .fi-section,
        body:has(.ng-category-form-page) .fi-section,
        body:has(.ng-category-form-page) .fi-section-content,
        body:has(.ng-category-form-page) .fi-fo-component-ctn,
        body:has(.ng-category-form-page) .fi-fo-field-wrp,
        body:has(.ng-category-form-page) .ng-category-form-page,
        body:has(.ng-category-form-page) .ng-widget-card {
            overflow: visible !important;
        }

        body:has(.ng-category-form-page) form {
            position: relative !important;
            z-index: 20 !important;
        }

        body:has(.ng-category-form-page) .fi-input-wrp,
        body:has(.ng-category-form-page) .fi-select-input,
        body:has(.ng-category-form-page) .fi-textarea,
        body:has(.ng-category-form-page) input,
        body:has(.ng-category-form-page) textarea {
            position: relative !important;
            z-index: 1 !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar,
        body:has(.ng-category-form-page) .flatpickr-calendar.open,
        body:has(.ng-category-form-page) .flatpickr-calendar.animate.open,
        body:has(.ng-category-form-page) .fi-date-time-picker-panel,
        body:has(.ng-category-form-page) .fi-dropdown-panel,
        body:has(.ng-category-form-page) .fi-popover,
        body:has(.ng-category-form-page) .fi-popover-panel,
        body:has(.ng-category-form-page) [role="dialog"],
        body:has(.ng-category-form-page) [role="listbox"],
        body:has(.ng-category-form-page) [data-headlessui-state],
        body:has(.ng-category-form-page) [data-floating-ui-portal],
        body:has(.ng-category-form-page) .choices__list--dropdown {
            z-index: 999999 !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar {
            isolation: isolate !important;
            overflow: hidden !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, .72) !important;
            background: rgba(255, 255, 255, .96) !important;
            box-shadow:
                0 24px 56px rgba(72, 42, 18, .20),
                0 0 0 1px rgba(255, 255, 255, .46) inset !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar * {
            z-index: auto !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-day,
        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-weekday,
        body:has(.ng-category-form-page) .flatpickr-calendar .cur-month,
        body:has(.ng-category-form-page) .flatpickr-calendar .numInputWrapper {
            color: #3b2a1c !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-day.selected,
        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-day.startRange,
        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-day.endRange {
            color: #fff !important;
            border-color: #f97316 !important;
            background: #f97316 !important;
        }

        body:has(.ng-category-form-page) .flatpickr-calendar .flatpickr-day:hover {
            border-color: rgba(249, 115, 22, .24) !important;
            background: rgba(249, 115, 22, .12) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-category-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-item a,
        body:has(.ng-category-form-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-item-active a,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover,
        body:has(.ng-category-form-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-category-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-category-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-category-form-page) .fi-sidebar-item-active span,
        body:has(.ng-category-form-page) .fi-sidebar-item a:hover span,
        body:has(.ng-category-form-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-category-form-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-category-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-category-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-category-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | KPI - DISAMAKAN DENGAN WARNA WIDGET PATOKAN
        |--------------------------------------------------------------------------
        */

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 14px;
        }

        .ng-kpi-card {
            position: relative;
            overflow: hidden;
            min-height: 108px;
            display: flex;
            gap: 12px;
            padding: 16px 15px;
            border-radius: 22px;
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

        .ng-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
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

        @media (max-width: 1100px) {
            .ng-kpi-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1100px) {
            .ng-category-form-page {
                padding: 18px 18px 10px !important;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-category-form-hero-actions {
                justify-content: flex-start;
            }

            body:has(.ng-category-form-page) form .fi-section,
            body:has(.ng-category-form-page) .fi-section {
                margin-left: 18px !important;
                margin-right: 18px !important;
                width: calc(100% - 36px) !important;
            }

            body:has(.ng-category-form-page) form .fi-form-actions,
            body:has(.ng-category-form-page) form .fi-ac {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
        }

        @media (max-width: 640px) {
            .ng-category-form-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-category-form-page) form .fi-section,
            body:has(.ng-category-form-page) .fi-section {
                margin-left: 14px !important;
                margin-right: 14px !important;
                width: calc(100% - 28px) !important;
            }

            body:has(.ng-category-form-page) form .fi-form-actions,
            body:has(.ng-category-form-page) form .fi-ac {
                padding-left: 14px !important;
                padding-right: 14px !important;
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/categories/widgets/category-form-hero-widget.blade.php ENDPATH**/ ?>