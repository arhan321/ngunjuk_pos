<div class="ng-profile-card ng-profile-card-password">
    <div class="ng-profile-side">
        <div>
            <div class="ng-profile-badge">
                <span></span>
                Security
            </div>

            <h2 class="ng-profile-title">
                Password
            </h2>

            <p class="ng-profile-desc">
                Perbarui password akun secara berkala agar akses dashboard admin tetap aman.
            </p>
        </div>

        <div class="ng-profile-mini">
            <span>Minimal Password</span>
            <strong>8 Karakter</strong>
            <small>Gunakan kombinasi yang kuat</small>
        </div>
    </div>

    <div class="ng-profile-form">
        <form wire:submit.prevent="submit" class="space-y-5">
            <?php echo e($this->form); ?>


            <div class="ng-profile-action">
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','class' => 'ng-profile-submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'ng-profile-submit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Update Password
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
            </div>
        </form>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-profile-card) {
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

        body:has(.ng-profile-card) .fi-main,
        body:has(.ng-profile-card) .fi-main-ctn,
        body:has(.ng-profile-card) .fi-page,
        body:has(.ng-profile-card) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-profile-card) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-profile-card) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-profile-card) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-profile-card) .fi-page-content {
            gap: 16px !important;
            row-gap: 16px !important;
            padding: 24px !important;
        }

        body:has(.ng-profile-card) .fi-section,
        body:has(.ng-profile-card) .fi-wi-widget,
        body:has(.ng-profile-card) .fi-wi-widget-content {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-profile-card {
            position: relative;
            overflow: hidden;
            width: 100% !important;
            min-height: 190px;
            display: grid;
            grid-template-columns: minmax(320px, .42fr) minmax(0, 1fr);
            gap: 18px;
            padding: 18px;
            border-radius: 26px;
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
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-profile-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(120deg, rgba(255, 255, 255, .34), transparent 28%, transparent 70%, rgba(255, 255, 255, .16));
            opacity: .38;
        }

        .ng-profile-card * {
            box-sizing: border-box;
        }

        .ng-profile-side,
        .ng-profile-form {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-profile-side {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 18px;
            padding: 18px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .38);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .42);
        }

        .ng-profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 12px;
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

        .ng-profile-badge span {
            width: 8px;
            height: 8px;
            flex: 0 0 auto;
            border-radius: 999px;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 0 0 5px rgba(249, 115, 22, .16);
        }

        .ng-profile-title {
            margin: 0;
            color: #21160d;
            font-size: 28px;
            line-height: 1.05;
            font-weight: 950;
            letter-spacing: -.04em;
        }

        .ng-profile-desc {
            max-width: 520px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-profile-mini {
            min-height: 82px;
            display: grid;
            align-content: center;
            gap: 6px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .40);
        }

        .ng-profile-mini span,
        .ng-profile-mini small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
        }

        .ng-profile-mini strong {
            display: block;
            color: #21160d;
            font-size: 19px;
            line-height: 1.15;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-profile-form {
            padding: 18px;
            border-radius: 22px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .30), rgba(255, 246, 231, .16)),
                radial-gradient(circle at 100% 0%, rgba(255, 153, 30, .10), transparent 38%) !important;
            border: 1px solid rgba(255, 255, 255, .46);
            box-shadow:
                0 16px 38px rgba(101, 58, 21, .08),
                inset 0 1px 0 rgba(255, 255, 255, .42);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .ng-profile-form form {
            width: 100% !important;
            max-width: 100% !important;
        }

        .ng-profile-form .fi-fo,
        .ng-profile-form .fi-fo-component-ctn,
        .ng-profile-form .fi-section,
        .ng-profile-form .fi-sc,
        .ng-profile-form .fi-sc-section {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-profile-form .fi-fo-field-wrp-label span,
        .ng-profile-form .fi-fo-field-wrp-label,
        .ng-profile-form label {
            color: #4b3525 !important;
            font-size: 12px !important;
            font-weight: 950 !important;
        }

        .ng-profile-form .fi-input-wrp,
        .ng-profile-form .fi-select-input,
        .ng-profile-form .fi-textarea {
            width: 100% !important;
            min-height: 44px !important;
            border-radius: 16px !important;
            background: rgba(255, 255, 255, .30) !important;
            border-color: rgba(255, 255, 255, .44) !important;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, .40),
                0 10px 26px rgba(101, 58, 21, .05) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }

        .ng-profile-form .fi-input,
        .ng-profile-form .fi-select-input,
        .ng-profile-form textarea {
            color: #24180f !important;
            font-weight: 750 !important;
        }

        .ng-profile-form .fi-input::placeholder,
        .ng-profile-form textarea::placeholder {
            color: rgba(111, 88, 68, .62) !important;
        }

        .ng-profile-form .fi-fo-field-wrp-helper-text {
            color: #8b7057 !important;
            font-size: 12px !important;
            font-weight: 700 !important;
        }

        .ng-profile-form .fi-fo-file-upload {
            border-radius: 18px !important;
            overflow: hidden !important;
        }

        .ng-profile-action {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 16px;
        }

        .ng-profile-submit,
        .ng-profile-form .fi-btn {
            min-height: 42px !important;
            border-radius: 14px !important;
            font-weight: 950 !important;
        }

        .ng-profile-submit,
        .ng-profile-form .fi-btn-color-primary,
        .ng-profile-form .fi-btn-color-warning {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500) !important;
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22) !important;
        }

        .ng-profile-form .fi-btn-color-gray {
            background: rgba(255, 255, 255, .42) !important;
            border: 1px solid rgba(255, 255, 255, .55) !important;
            color: #6f5844 !important;
        }

        .ng-profile-form .fi-btn-color-danger {
            box-shadow: 0 12px 22px rgba(239, 68, 68, .18) !important;
        }

        .ng-profile-form ul,
        .ng-profile-form ol {
            margin: 0 !important;
            padding-left: 0 !important;
            list-style: none !important;
        }

        .ng-profile-form li,
        .ng-profile-form [class*="border"],
        .ng-profile-form [class*="divide"] > * {
            border-color: rgba(114, 74, 41, .08) !important;
        }

        .ng-profile-form [class*="bg-white"],
        .ng-profile-form [class*="dark:bg"] {
            background: rgba(255, 255, 255, .22) !important;
            border-color: rgba(255, 255, 255, .38) !important;
            box-shadow: none !important;
        }

        .ng-profile-form p,
        .ng-profile-form span,
        .ng-profile-form small {
            color: #765d45;
            font-weight: 750;
        }

        .ng-profile-form strong,
        .ng-profile-form h3,
        .ng-profile-form h4 {
            color: #21160d;
            font-weight: 950;
        }

        body:has(.ng-profile-card) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-profile-card) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-profile-card) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-profile-card) .fi-sidebar-item-active a,
        body:has(.ng-profile-card) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-profile-card) .fi-sidebar-item-active svg,
        body:has(.ng-profile-card) .fi-sidebar-item a:hover svg,
        body:has(.ng-profile-card) .fi-sidebar-item-active span,
        body:has(.ng-profile-card) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1200px) {
            .ng-profile-card {
                grid-template-columns: 1fr;
            }

            .ng-profile-side {
                gap: 14px;
            }
        }

        @media (max-width: 700px) {
            body:has(.ng-profile-card) .fi-page-content {
                padding: 14px !important;
            }

            .ng-profile-card {
                padding: 14px;
                border-radius: 22px;
            }

            .ng-profile-side,
            .ng-profile-form {
                padding: 14px;
                border-radius: 18px;
            }

            .ng-profile-title {
                font-size: 24px;
            }
        }
    </style>

</div>
<?php /**PATH /var/www/html/resources/views/vendor/filament-breezy/livewire/update-password.blade.php ENDPATH**/ ?>