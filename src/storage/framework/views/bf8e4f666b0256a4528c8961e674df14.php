<?php if (isset($component)) { $__componentOriginalf45da69382bf4ac45a50b496dc82aa9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf45da69382bf4ac45a50b496dc82aa9a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.simple','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page.simple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

    <style>
        :root {
            --ng-orange: #ff7a3d;
            --ng-orange-dark: #e85a1a;
            --ng-orange-soft: #ffb46f;
            --ng-gold: #d8a24d;
            --ng-text: #22252f;
            --ng-muted: #8f8176;
            --ng-border: rgba(222, 181, 130, 0.55);
        }

        body {
            min-height: 100vh !important;
            overflow-x: hidden !important;
            background:
                radial-gradient(circle at 12% 14%, rgba(255,255,255,.96) 0 120px, transparent 124px),
                radial-gradient(circle at 88% 12%, rgba(255,122,61,.18) 0 280px, transparent 286px),
                radial-gradient(circle at 82% 90%, rgba(216,162,77,.18) 0 320px, transparent 328px),
                linear-gradient(135deg, #fffaf6 0%, #fff1e8 48%, #ffe3d1 100%) !important;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: .22;
            background-image: radial-gradient(rgba(207,124,71,.34) 1px, transparent 1px);
            background-size: 18px 18px;
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(115deg, transparent 0 22%, rgba(255,255,255,.36) 22.2% 22.5%, transparent 23% 100%),
                radial-gradient(circle at 50% 92%, rgba(255,255,255,.52), transparent 30%);
            z-index: 0;
        }

        .fi-simple-header {
            display: none !important;
        }

        .fi-simple-layout {
            position: relative !important;
            z-index: 1 !important;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 28px !important;
            background: transparent !important;
        }

        .fi-simple-main {
            position: relative !important;
            width: min(470px, calc(100vw - 38px)) !important;
            max-width: 470px !important;
            min-height: auto !important;
            margin: 0 auto !important;
            border-radius: 34px !important;
            background:
                radial-gradient(circle at 92% 4%, rgba(255,122,61,.10), transparent 34%),
                linear-gradient(180deg, rgba(255,255,255,.98), rgba(255,250,246,.96)) !important;
            border: 1px solid rgba(216,162,77,.44) !important;
            box-shadow:
                0 30px 80px rgba(82,49,33,.17),
                0 0 0 10px rgba(255,255,255,.28),
                inset 0 1px 0 rgba(255,255,255,.96) !important;
            backdrop-filter: blur(18px) !important;
            overflow: hidden !important;
        }

        .fi-simple-main::before {
            content: "";
            position: absolute;
            top: 0;
            left: 34px;
            right: 34px;
            height: 4px;
            border-radius: 0 0 999px 999px;
            background: linear-gradient(90deg, var(--ng-orange-soft), var(--ng-orange), var(--ng-gold));
            opacity: .95;
        }

        .fi-simple-page {
            padding: 30px 36px 30px !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .ng-login-head {
            text-align: center;
            margin-bottom: 20px;
        }

        .ng-login-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 12px;
            padding: 8px 16px;
            border-radius: 999px;
            color: #aa641d;
            background: rgba(255,246,238,.95);
            border: 1px solid rgba(216,162,77,.42);
            box-shadow: 0 8px 20px rgba(141,88,45,.08);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .ng-login-badge::before {
            content: "•";
            font-size: 14px;
            line-height: 1;
            color: var(--ng-gold);
        }

        .ng-login-brand {
            color: var(--ng-orange);
            font-size: 16px;
            font-weight: 900;
            letter-spacing: .22em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .ng-login-title {
            color: var(--ng-text);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 46px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -1.2px;
            margin: 0;
            text-shadow: 0 10px 24px rgba(47,48,55,.08);
        }

        .ng-login-divider {
            width: 110px;
            height: 14px;
            margin: 12px auto 0;
            position: relative;
        }

        .ng-login-divider::before,
        .ng-login-divider::after {
            content: "";
            position: absolute;
            top: 6px;
            width: 42px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(216,162,77,.18), rgba(216,162,77,.95), rgba(216,162,77,.18));
        }

        .ng-login-divider::before {
            left: 0;
        }

        .ng-login-divider::after {
            right: 0;
        }

        .ng-login-divider span {
            position: absolute;
            left: 50%;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 999px;
            transform: translateX(-50%);
            background: linear-gradient(180deg, #f2c87d, #d59a3a);
            box-shadow: 0 0 0 4px rgba(255,249,243,.92);
        }

        .ng-login-note {
            margin-top: 10px;
            color: var(--ng-muted);
            font-size: 12px;
            font-weight: 600;
            line-height: 1.6;
        }

        .fi-fo-field-wrp {
            margin-bottom: 13px !important;
        }

        .fi-fo-field-wrp-label span,
        label,
        .fi-checkbox-list-option-label {
            color: #342f2c !important;
            font-size: 13px !important;
            font-weight: 800 !important;
        }

        .fi-input-wrp {
            min-height: 49px !important;
            border-radius: 16px !important;
            background: rgba(255,255,255,.94) !important;
            border: 1px solid var(--ng-border) !important;
            box-shadow:
                0 10px 22px rgba(82,49,33,.05),
                inset 0 1px 0 rgba(255,255,255,.95) !important;
            overflow: hidden !important;
            transition: .22s ease !important;
        }

        .fi-input-wrp:focus-within {
            border-color: rgba(255,122,61,.78) !important;
            background: #ffffff !important;
            box-shadow:
                0 0 0 5px rgba(255,122,61,.13),
                0 14px 30px rgba(82,49,33,.08) !important;
        }

        .fi-input {
            color: var(--ng-text) !important;
            background: transparent !important;
            font-weight: 650 !important;
        }

        .fi-input::placeholder {
            color: #a99b91 !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--ng-text) !important;
            box-shadow: 0 0 0 1000px #ffffff inset !important;
            transition: background-color 9999s ease-in-out 0s !important;
        }

        .fi-icon-btn {
            color: #95633f !important;
        }

        .fi-icon-btn:hover {
            color: var(--ng-orange-dark) !important;
            background: #fff0e8 !important;
        }

        input[type="checkbox"] {
            width: 19px !important;
            height: 19px !important;
            border-radius: 7px !important;
            color: var(--ng-orange) !important;
            border-color: rgba(218,170,126,.75) !important;
            box-shadow: 0 7px 16px rgba(82,49,33,.055) !important;
        }

        input[type="checkbox"]:checked {
            background-color: var(--ng-orange) !important;
            border-color: var(--ng-orange) !important;
        }

        .ng-login-submit {
            margin-top: 14px;
        }

        .ng-login-submit button {
            width: 100% !important;
            min-height: 50px !important;
            border-radius: 16px !important;
            border: 0 !important;
            color: #ffffff !important;
            background:
                linear-gradient(135deg, #ffb35c 0%, #ff8b2d 42%, #ed5f16 100%) !important;
            box-shadow:
                0 16px 34px rgba(255,139,45,.30),
                inset 0 1px 0 rgba(255,255,255,.30) !important;
            font-size: 15px !important;
            font-weight: 900 !important;
            cursor: pointer;
            transition: .22s ease;
        }

        .ng-login-submit button:hover {
            transform: translateY(-2px);
            box-shadow:
                0 22px 42px rgba(255,139,45,.38),
                inset 0 1px 0 rgba(255,255,255,.34) !important;
        }

        .ng-login-footer {
            margin-top: 14px;
            text-align: center;
            color: #a8876a;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .10em;
            text-transform: uppercase;
        }

        .fi-alert,
        .fi-fo-field-wrp-error-message {
            border-radius: 16px !important;
        }

        @media (max-width: 560px) {
            .fi-simple-layout {
                padding: 14px !important;
            }

            .fi-simple-main {
                width: calc(100vw - 24px) !important;
                border-radius: 26px !important;
            }

            .fi-simple-page {
                padding: 24px 22px 24px !important;
            }

            .ng-login-title {
                font-size: 38px;
            }

            .ng-login-brand {
                font-size: 15px;
                letter-spacing: .16em;
            }
        }
    </style>

    <div class="ng-login-head">
        <div class="ng-login-badge">Dashboard Admin</div>
        <div class="ng-login-brand">NGUNJUK</div>
        <h1 class="ng-login-title">Sign in</h1>

        <div class="ng-login-divider">
            <span></span>
        </div>

        <div class="ng-login-note">
            Akses panel admin untuk mengelola produk, stok dan laporan penjualan.
        </div>
    </div>

    <form wire:submit="authenticate">
        <?php echo e($this->form); ?>


        <div class="ng-login-submit">
            <button type="submit">
                Masuk Dashboard
            </button>
        </div>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf45da69382bf4ac45a50b496dc82aa9a)): ?>
<?php $attributes = $__attributesOriginalf45da69382bf4ac45a50b496dc82aa9a; ?>
<?php unset($__attributesOriginalf45da69382bf4ac45a50b496dc82aa9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf45da69382bf4ac45a50b496dc82aa9a)): ?>
<?php $component = $__componentOriginalf45da69382bf4ac45a50b496dc82aa9a; ?>
<?php unset($__componentOriginalf45da69382bf4ac45a50b496dc82aa9a); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/filament/admin/auth/login.blade.php ENDPATH**/ ?>