<?php
    $cards = [
        [
            'label' => 'Total Produk',
            'value' => number_format((int) ($stats['total_products'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua data produk',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Produk Aktif',
            'value' => number_format((int) ($stats['active_products'] ?? 0), 0, ',', '.'),
            'caption' => 'Tampil di kasir',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Total Kategori',
            'value' => number_format((int) ($stats['total_categories'] ?? 0), 0, ',', '.'),
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

    <div class="ng-product-form-page">
        <section class="ng-product-form-hero-grid">
            <article class="ng-widget-card ng-product-form-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <h1><?php echo e($title); ?></h1>

                        <p>
                            <?php echo e($description); ?>

                        </p>
                    </div>

                    <div class="ng-product-form-hero-actions">
                        <a href="<?php echo e($backUrl); ?>" class="ng-primary-button">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-product-form-kpi-grid">
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

        body:has(.ng-product-form-page) {
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

        body:has(.ng-product-form-page) .fi-layout,
        body:has(.ng-product-form-page) .fi-main,
        body:has(.ng-product-form-page) .fi-main-ctn,
        body:has(.ng-product-form-page) .fi-page,
        body:has(.ng-product-form-page) .fi-page-content,
        body:has(.ng-product-form-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-product-form-page) .fi-page,
        body:has(.ng-product-form-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-product-form-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-product-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        body:has(.ng-product-form-page) .fi-wi,
        body:has(.ng-product-form-page) .fi-wi-widget,
        body:has(.ng-product-form-page) .fi-wi-widget-content,
        body:has(.ng-product-form-page) .fi-wi-widgets,
        body:has(.ng-product-form-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-product-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-product-form-page * {
            box-sizing: border-box;
        }

        /*
        |--------------------------------------------------------------------------
        | HERO - FULL WIDTH, IKUT CATEGORY
        |--------------------------------------------------------------------------
        */

        .ng-product-form-hero-grid {
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

        .ng-product-form-hero-card {
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

        .ng-product-form-hero-actions {
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

        body:has(.ng-product-form-page) form,
        body:has(.ng-product-form-page) .fi-section,
        body:has(.ng-product-form-page) .fi-fo-component-ctn,
        body:has(.ng-product-form-page) .fi-section-content {
            background: transparent !important;
        }

        body:has(.ng-product-form-page) .fi-page-content > form {
            margin-top: -16px !important;
        }

        body:has(.ng-product-form-page) form .fi-section,
        body:has(.ng-product-form-page) .fi-section {
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

        body:has(.ng-product-form-page) form .fi-section::before,
        body:has(.ng-product-form-page) .fi-section::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            border-radius: inherit;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        body:has(.ng-product-form-page) .fi-section-header,
        body:has(.ng-product-form-page) .fi-section-content {
            position: relative !important;
            z-index: 2 !important;
        }

        body:has(.ng-product-form-page) .fi-section-header {
            background: rgba(255, 247, 235, .10) !important;
            border-bottom: 1px solid rgba(114, 74, 41, .08) !important;
        }

        body:has(.ng-product-form-page) .fi-section-header-heading,
        body:has(.ng-product-form-page) .fi-section-header-description {
            color: #4b3525 !important;
        }

        body:has(.ng-product-form-page) .fi-input-wrp,
        body:has(.ng-product-form-page) .fi-select-input,
        body:has(.ng-product-form-page) .fi-textarea {
            min-height: 40px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .28) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .36) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        body:has(.ng-product-form-page) .fi-input,
        body:has(.ng-product-form-page) .fi-select-input,
        body:has(.ng-product-form-page) textarea {
            color: #2d1f16 !important;
            font-weight: 750 !important;
        }

        body:has(.ng-product-form-page) .fi-input::placeholder,
        body:has(.ng-product-form-page) textarea::placeholder {
            color: rgba(111, 88, 68, .62) !important;
        }

        body:has(.ng-product-form-page) .fi-fo-field-wrp-label span,
        body:has(.ng-product-form-page) label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        body:has(.ng-product-form-page) .fi-fo-field-wrp-helper-text,
        body:has(.ng-product-form-page) .fi-fo-field-wrp-error-message {
            font-size: 11px !important;
            font-weight: 800 !important;
        }

        body:has(.ng-product-form-page) .fi-btn {
            border-radius: 14px !important;
            font-weight: 900 !important;
        }

        body:has(.ng-product-form-page) .fi-btn-color-primary,
        body:has(.ng-product-form-page) .fi-btn-color-warning {
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        body:has(.ng-product-form-page) .fi-btn-color-primary:hover,
        body:has(.ng-product-form-page) .fi-btn-color-warning:hover {
            box-shadow: 0 16px 28px rgba(238, 101, 0, .28) !important;
        }

        body:has(.ng-product-form-page) form .fi-form-actions,
        body:has(.ng-product-form-page) form .fi-ac {
            margin-top: 14px !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUCT FORM CUSTOM UI — SIDE BY SIDE
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-form-page) .ng-product-main-section > .fi-section-content {
            padding: 22px !important;
        }

        body:has(.ng-product-form-page) .ng-product-form-layout {
            align-items: stretch !important;
            gap: 22px !important;
        }

        body:has(.ng-product-form-page) .ng-product-info-panel,
        body:has(.ng-product-form-page) .ng-product-pricing-panel {
            position: relative !important;
            min-width: 0 !important;
            height: 100% !important;
            padding: 20px !important;
            border: 1px solid rgba(255, 255, 255, .64) !important;
            border-radius: 22px !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .42), rgba(255, 247, 235, .22)),
                radial-gradient(circle at 100% 0%, rgba(255, 137, 0, .10), transparent 40%) !important;
            box-shadow:
                0 16px 34px rgba(109, 62, 23, .09),
                inset 0 1px 0 rgba(255, 255, 255, .72) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-product-form-page) .ng-product-info-panel {
            align-content: start !important;
        }

        body:has(.ng-product-form-page) .ng-product-info-panel::before {
            content: "Informasi Utama Produk";
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            min-height: 44px;
            margin: -4px -2px 2px;
            padding: 0 2px 14px;
            border-bottom: 1px solid rgba(116, 72, 36, .10);
            color: #3d291b;
            font-size: 15px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.02em;
        }

        body:has(.ng-product-form-page) .ng-product-info-panel::after {
            content: "Data dasar, gambar, dan status produk";
            position: absolute;
            top: 24px;
            right: 20px;
            color: rgba(104, 76, 52, .66);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel > .fi-fo-field-wrp-label,
        body:has(.ng-product-form-page) .ng-product-pricing-panel > div > .fi-fo-field-wrp-label {
            margin-bottom: 14px !important;
            padding-bottom: 14px !important;
            border-bottom: 1px solid rgba(116, 72, 36, .10) !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-field-wrp-label > span,
        body:has(.ng-product-form-page) .ng-product-pricing-panel > label {
            font-size: 15px !important;
            letter-spacing: -.02em !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-items,
        body:has(.ng-product-form-page) .ng-product-pricing-panel [data-repeater-items] {
            display: grid !important;
            gap: 14px !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-item,
        body:has(.ng-product-form-page) .ng-product-pricing-panel [data-repeater-item] {
            position: relative !important;
            overflow: visible !important;
            border: 1px solid rgba(255, 255, 255, .76) !important;
            border-radius: 20px !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .62), rgba(255, 242, 220, .32)),
                radial-gradient(circle at 100% 0%, rgba(255, 126, 0, .10), transparent 38%) !important;
            box-shadow:
                0 13px 26px rgba(91, 51, 20, .08),
                inset 0 1px 0 rgba(255, 255, 255, .88) !important;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-item:hover,
        body:has(.ng-product-form-page) .ng-product-pricing-panel [data-repeater-item]:hover {
            transform: translateY(-1px) !important;
            border-color: rgba(249, 115, 22, .26) !important;
            box-shadow:
                0 18px 34px rgba(91, 51, 20, .11),
                inset 0 1px 0 rgba(255, 255, 255, .90) !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-item-header {
            min-height: 48px !important;
            padding: 10px 14px !important;
            border-bottom: 1px solid rgba(116, 72, 36, .08) !important;
            background: rgba(255, 255, 255, .13) !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-item-content {
            padding: 16px !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-add,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-add-action,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-btn.fi-color-gray {
            width: 100% !important;
            min-height: 44px !important;
            margin-top: 14px !important;
            border: 1.5px dashed rgba(238, 101, 0, .34) !important;
            border-radius: 16px !important;
            color: #c85400 !important;
            background: rgba(255, 247, 235, .34) !important;
            box-shadow: none !important;
        }

        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-add:hover,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-fo-repeater-add-action:hover,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-btn.fi-color-gray:hover {
            border-color: rgba(238, 101, 0, .56) !important;
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .18) !important;
        }

        body:has(.ng-product-form-page) .ng-product-upload-field .fi-fo-file-upload,
        body:has(.ng-product-form-page) .ng-product-upload-field .filepond--panel-root,
        body:has(.ng-product-form-page) .ng-product-upload-field [data-file-upload] {
            border-radius: 18px !important;
        }

        body:has(.ng-product-form-page) .ng-product-upload-field .filepond--root {
            min-height: 112px !important;
            border: 1.5px dashed rgba(238, 101, 0, .28) !important;
            border-radius: 18px !important;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .44), rgba(255, 242, 220, .22)) !important;
        }

        body:has(.ng-product-form-page) .ng-product-upload-field .filepond--drop-label {
            color: #79583d !important;
            font-weight: 850 !important;
        }

        body:has(.ng-product-form-page) .ng-product-status-field {
            grid-column: 1 / -1 !important;
            display: flex !important;
            align-items: center !important;
            min-height: 64px !important;
            padding: 12px 14px !important;
            border: 1px solid rgba(255, 255, 255, .58) !important;
            border-radius: 17px !important;
            background: rgba(255, 255, 255, .18) !important;
        }

        body:has(.ng-product-form-page) .ng-product-info-panel .fi-input-wrp:focus-within,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-input-wrp:focus-within,
        body:has(.ng-product-form-page) .ng-product-info-panel .fi-select-input:focus-within,
        body:has(.ng-product-form-page) .ng-product-pricing-panel .fi-select-input:focus-within {
            border-color: rgba(249, 115, 22, .50) !important;
            box-shadow:
                0 0 0 3px rgba(249, 115, 22, .10),
                inset 0 1px 0 rgba(255, 255, 255, .46) !important;
        }

        body:has(.ng-product-form-page) form .fi-form-actions,
        body:has(.ng-product-form-page) form .fi-ac {
            position: sticky !important;
            bottom: 10px !important;
            z-index: 70 !important;
            width: fit-content !important;
            margin-left: auto !important;
            margin-right: 24px !important;
            padding: 10px !important;
            border: 1px solid rgba(255, 255, 255, .64) !important;
            border-radius: 18px !important;
            background: rgba(255, 248, 238, .74) !important;
            box-shadow: 0 18px 42px rgba(84, 45, 15, .16) !important;
            backdrop-filter: blur(18px) !important;
            -webkit-backdrop-filter: blur(18px) !important;
        }

        @media (max-width: 1279px) {
            body:has(.ng-product-form-page) .ng-product-form-layout {
                gap: 16px !important;
            }

            body:has(.ng-product-form-page) .ng-product-info-panel,
            body:has(.ng-product-form-page) .ng-product-pricing-panel {
                padding: 16px !important;
            }

            body:has(.ng-product-form-page) .ng-product-info-panel::after {
                display: none;
            }
        }

        @media (max-width: 767px) {
            body:has(.ng-product-form-page) .ng-product-main-section > .fi-section-content {
                padding: 12px !important;
            }

            body:has(.ng-product-form-page) .ng-product-info-panel,
            body:has(.ng-product-form-page) .ng-product-pricing-panel {
                padding: 13px !important;
                border-radius: 18px !important;
            }

            body:has(.ng-product-form-page) form .fi-form-actions,
            body:has(.ng-product-form-page) form .fi-ac {
                position: static !important;
                width: auto !important;
                margin: 14px 12px 0 !important;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DATEPICKER / DROPDOWN FIX
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-form-page),
        body:has(.ng-product-form-page) .fi-main,
        body:has(.ng-product-form-page) .fi-main-ctn,
        body:has(.ng-product-form-page) .fi-page,
        body:has(.ng-product-form-page) .fi-page-content,
        body:has(.ng-product-form-page) form,
        body:has(.ng-product-form-page) form .fi-section,
        body:has(.ng-product-form-page) .fi-section,
        body:has(.ng-product-form-page) .fi-section-content,
        body:has(.ng-product-form-page) .fi-fo-component-ctn,
        body:has(.ng-product-form-page) .fi-fo-field-wrp,
        body:has(.ng-product-form-page) .ng-product-form-page,
        body:has(.ng-product-form-page) .ng-widget-card {
            overflow: visible !important;
        }

        body:has(.ng-product-form-page) form {
            position: relative !important;
            z-index: 20 !important;
        }

        body:has(.ng-product-form-page) .fi-input-wrp,
        body:has(.ng-product-form-page) .fi-select-input,
        body:has(.ng-product-form-page) .fi-textarea,
        body:has(.ng-product-form-page) input,
        body:has(.ng-product-form-page) textarea {
            position: relative !important;
            z-index: 1 !important;
        }

        body:has(.ng-product-form-page) .flatpickr-calendar,
        body:has(.ng-product-form-page) .flatpickr-calendar.open,
        body:has(.ng-product-form-page) .flatpickr-calendar.animate.open,
        body:has(.ng-product-form-page) .fi-date-time-picker-panel,
        body:has(.ng-product-form-page) .fi-dropdown-panel,
        body:has(.ng-product-form-page) .fi-popover,
        body:has(.ng-product-form-page) .fi-popover-panel,
        body:has(.ng-product-form-page) [role="dialog"],
        body:has(.ng-product-form-page) [role="listbox"],
        body:has(.ng-product-form-page) [data-headlessui-state],
        body:has(.ng-product-form-page) [data-floating-ui-portal],
        body:has(.ng-product-form-page) .choices__list--dropdown {
            z-index: 999999 !important;
        }

        body:has(.ng-product-form-page) .flatpickr-calendar {
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

        body:has(.ng-product-form-page) .flatpickr-calendar * {
            z-index: auto !important;
        }

        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-day,
        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-weekday,
        body:has(.ng-product-form-page) .flatpickr-calendar .cur-month,
        body:has(.ng-product-form-page) .flatpickr-calendar .numInputWrapper {
            color: #3b2a1c !important;
        }

        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-day.selected,
        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-day.startRange,
        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-day.endRange {
            color: #fff !important;
            border-color: #f97316 !important;
            background: #f97316 !important;
        }

        body:has(.ng-product-form-page) .flatpickr-calendar .flatpickr-day:hover {
            border-color: rgba(249, 115, 22, .24) !important;
            background: rgba(249, 115, 22, .12) !important;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-form-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-product-form-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-product-form-page) .fi-sidebar-item a,
        body:has(.ng-product-form-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-product-form-page) .fi-sidebar-item-active a,
        body:has(.ng-product-form-page) .fi-sidebar-item a:hover,
        body:has(.ng-product-form-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-product-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-product-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-product-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-product-form-page) .fi-sidebar-item-active span,
        body:has(.ng-product-form-page) .fi-sidebar-item a:hover span,
        body:has(.ng-product-form-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-product-form-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-product-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-product-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-product-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        /*
        |--------------------------------------------------------------------------
        | KPI PRODUCT - IKUT WARNA WIDGET PATOKAN
        |--------------------------------------------------------------------------
        */

        .ng-kpi-grid,
        .ng-product-form-kpi-grid {
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

        /*
        |--------------------------------------------------------------------------
        | PRODUCT FORM EXTRA PANEL - IKUT WARNA PATOKAN
        |--------------------------------------------------------------------------
        */

        body:has(.ng-product-form-page) .fi-section + .fi-section,
        body:has(.ng-product-form-page) .fi-sc-section + .fi-sc-section {
            margin-top: 14px !important;
        }

        body:has(.ng-product-form-page) .fi-fo-repeater,
        body:has(.ng-product-form-page) .fi-fo-repeater-item {
            border-radius: 20px !important;
            background: rgba(255, 255, 255, .20) !important;
            border: 1px solid rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
            overflow: hidden !important;
        }

        body:has(.ng-product-form-page) .fi-fo-file-upload,
        body:has(.ng-product-form-page) .fi-fo-file-upload .filepond--root,
        body:has(.ng-product-form-page) .fi-fo-file-upload .filepond--panel-root,
        body:has(.ng-product-form-page) .filepond--panel-root {
            border-radius: 18px !important;
            background: rgba(255, 255, 255, .24) !important;
            border-color: rgba(255, 255, 255, .42) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .32) !important;
        }

        body:has(.ng-product-form-page) .fi-btn-color-gray {
            background: rgba(255, 255, 255, .42) !important;
            border: 1px solid rgba(255, 255, 255, .55) !important;
            color: #6f5844 !important;
        }

        body:has(.ng-product-form-page) .fi-btn-color-danger {
            box-shadow: 0 12px 22px rgba(239, 68, 68, .18) !important;
        }

        @media (max-width: 1100px) {
            .ng-kpi-grid,
            .ng-product-form-kpi-grid {
                grid-template-columns: 1fr !important;
            }

            .ng-product-form-page {
                padding: 18px 18px 10px !important;
            }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-product-form-hero-actions {
                justify-content: flex-start;
            }

            body:has(.ng-product-form-page) form .fi-section,
            body:has(.ng-product-form-page) .fi-section {
                margin-left: 18px !important;
                margin-right: 18px !important;
                width: calc(100% - 36px) !important;
            }

            body:has(.ng-product-form-page) form .fi-form-actions,
            body:has(.ng-product-form-page) form .fi-ac {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
        }

        @media (max-width: 640px) {
            .ng-product-form-page {
                padding: 14px 14px 8px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            body:has(.ng-product-form-page) form .fi-section,
            body:has(.ng-product-form-page) .fi-section {
                margin-left: 14px !important;
                margin-right: 14px !important;
                width: calc(100% - 28px) !important;
            }

            body:has(.ng-product-form-page) form .fi-form-actions,
            body:has(.ng-product-form-page) form .fi-ac {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | PRODUCT CATEGORY SELECT DROPDOWN STACKING FIX
        |--------------------------------------------------------------------------
        | Fix masalah dropdown kategori tertimpa field/textarea/form lain.
        | Penyebab utamanya adalah stacking context dari section, pseudo ::before,
        | field wrapper, dan dropdown select yang z-index-nya kalah dari field setelahnya.
        */

        body:has(.ng-product-form-page) .fi-section::before,
        body:has(.ng-product-form-page) form .fi-section::before {
            z-index: 0 !important;
        }

        body:has(.ng-product-form-page) .fi-section-header,
        body:has(.ng-product-form-page) .fi-section-content {
            position: relative !important;
            z-index: 2 !important;
            overflow: visible !important;
        }

        body:has(.ng-product-form-page) .fi-fo-component-ctn,
        body:has(.ng-product-form-page) .fi-grid,
        body:has(.ng-product-form-page) .fi-fo-field-wrp,
        body:has(.ng-product-form-page) .fi-fo-field-wrp > div {
            overflow: visible !important;
        }

        body:has(.ng-product-form-page) .fi-fo-field-wrp {
            position: relative !important;
            z-index: 5 !important;
        }

        body:has(.ng-product-form-page) .fi-fo-field-wrp:focus-within,
        body:has(.ng-product-form-page) .fi-fo-field-wrp:has([aria-expanded="true"]),
        body:has(.ng-product-form-page) .fi-fo-field-wrp:has(.choices__list--dropdown.is-active),
        body:has(.ng-product-form-page) .fi-fo-field-wrp:has(.ts-dropdown),
        body:has(.ng-product-form-page) .fi-fo-field-wrp:has([role="listbox"]) {
            z-index: 999999 !important;
        }

        body:has(.ng-product-form-page) .fi-select,
        body:has(.ng-product-form-page) .fi-fo-select,
        body:has(.ng-product-form-page) .fi-input-wrp:focus-within {
            position: relative !important;
            z-index: 999999 !important;
        }

        body:has(.ng-product-form-page) .fi-dropdown-panel,
        body:has(.ng-product-form-page) .fi-select-panel,
        body:has(.ng-product-form-page) .fi-popover,
        body:has(.ng-product-form-page) .fi-popover-panel,
        body:has(.ng-product-form-page) [role="listbox"],
        body:has(.ng-product-form-page) [data-floating-ui-portal],
        body:has(.ng-product-form-page) .choices,
        body:has(.ng-product-form-page) .choices__inner,
        body:has(.ng-product-form-page) .choices__list--dropdown,
        body:has(.ng-product-form-page) .choices__list--dropdown.is-active,
        body:has(.ng-product-form-page) .ts-wrapper,
        body:has(.ng-product-form-page) .ts-control,
        body:has(.ng-product-form-page) .ts-dropdown {
            z-index: 1000000 !important;
        }

        body:has(.ng-product-form-page) .choices__list--dropdown,
        body:has(.ng-product-form-page) .choices__list--dropdown.is-active,
        body:has(.ng-product-form-page) .ts-dropdown,
        body:has(.ng-product-form-page) [role="listbox"] {
            position: absolute !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, .72) !important;
            background: rgba(255, 255, 255, .96) !important;
            box-shadow:
                0 24px 56px rgba(72, 42, 18, .20),
                0 0 0 1px rgba(255, 255, 255, .46) inset !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            overflow: hidden auto !important;
        }

        body:has(.ng-product-form-page) .choices__list--dropdown .choices__item,
        body:has(.ng-product-form-page) .ts-dropdown .option,
        body:has(.ng-product-form-page) [role="option"] {
            position: relative !important;
            z-index: 1000001 !important;
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
<?php endif; ?><?php /**PATH /var/www/html/resources/views/filament/admin/resources/products/widgets/product-form-hero-widget.blade.php ENDPATH**/ ?>