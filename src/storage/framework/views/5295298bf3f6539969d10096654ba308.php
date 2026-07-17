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
        $user = $record;
        $user->loadMissing('roles');

        $backUrl = \App\Filament\Admin\Resources\Users\UserResource::getUrl('index');
        $editUrl = \App\Filament\Admin\Resources\Users\UserResource::getUrl('edit', ['record' => $user]);

        $roles = $user->roles
            ->pluck('name')
            ->map(fn ($role) => str($role)->replace('_', ' ')->title()->toString())
            ->values();

        $roleText = $roles->isNotEmpty() ? $roles->implode(', ') : '-';

        $avatarPath = $user->avatar_url;

        if ($avatarPath && str_starts_with($avatarPath, 'http')) {
            $avatarUrl = $avatarPath;
        } elseif ($avatarPath) {
            $avatarUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($avatarPath);
        } else {
            $hash = md5(mb_strtolower(mb_trim((string) $user->email)));
            $avatarUrl = 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
        }

        $cards = [
            [
                'label' => 'Nama User',
                'value' => $user->name ?? '-',
                'caption' => 'Akun pengguna',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Role',
                'value' => $roleText,
                'caption' => 'Hak akses sistem',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Dibuat',
                'value' => $user->created_at?->translatedFormat('d M Y') ?? '-',
                'caption' => 'Tanggal akun dibuat',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Update',
                'value' => $user->updated_at?->diffForHumans() ?? '-',
                'caption' => 'Terakhir diperbarui',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    ?>

    <div class="ng-user-detail-page">
        <section class="ng-user-detail-hero-grid">
            <article class="ng-widget-card ng-user-detail-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <span class="ng-kicker">
                            POS Ngunjuk
                        </span>

                        <h1>Detail User</h1>

                        <p>
                            Informasi lengkap akun pengguna, role akses, email, avatar,
                            waktu pembuatan akun, dan waktu terakhir data diperbarui.
                        </p>
                    </div>
                </div>

                <div class="ng-hero-actions">
                    <a href="<?php echo e($backUrl); ?>" class="ng-soft-button">
                        ← Kembali
                    </a>

                    <a href="<?php echo e($editUrl); ?>" class="ng-primary-button">
                        Edit User
                    </a>
                </div>
            </article>

            <article class="ng-widget-card ng-user-profile-card">
                <img src="<?php echo e($avatarUrl); ?>" alt="<?php echo e($user->name); ?>" class="ng-profile-avatar">

                <div class="ng-profile-info">
                    <span>User Terpilih</span>
                    <strong><?php echo e($user->name); ?></strong>
                    <small><?php echo e($user->email); ?></small>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-user-detail-kpi-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
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

        <section class="ng-user-detail-main-grid">
            <article class="ng-widget-card ng-user-info-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Informasi Akun</h2>
                        <p>Ringkasan profil pengguna sistem POS.</p>
                    </div>

                    <span class="ng-role-pill">
                        <?php echo e($roleText); ?>

                    </span>
                </div>

                <div class="ng-info-list">
                    <div>
                        <span>Nama User</span>
                        <strong><?php echo e($user->name ?? '-'); ?></strong>
                    </div>

                    <div>
                        <span>Email</span>
                        <strong><?php echo e($user->email ?? '-'); ?></strong>
                    </div>

                    <div>
                        <span>Role Akses</span>
                        <strong><?php echo e($roleText); ?></strong>
                    </div>

                    <div>
                        <span>ID User</span>
                        <strong>#<?php echo e($user->id); ?></strong>
                    </div>

                    <div>
                        <span>Dibuat</span>
                        <strong><?php echo e($user->created_at?->translatedFormat('d F Y H:i') ?? '-'); ?></strong>
                    </div>

                    <div>
                        <span>Terakhir Update</span>
                        <strong><?php echo e($user->updated_at?->translatedFormat('d F Y H:i') ?? '-'); ?></strong>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-user-avatar-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Avatar User</h2>
                        <p>Foto profil akun pengguna.</p>
                    </div>
                </div>

                <div class="ng-avatar-preview">
                    <img src="<?php echo e($avatarUrl); ?>" alt="<?php echo e($user->name); ?>">

                    <strong><?php echo e($user->name); ?></strong>
                    <span><?php echo e($user->email); ?></span>
                </div>
            </article>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-user-detail-page) {
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

        body:has(.ng-user-detail-page) .fi-main,
        body:has(.ng-user-detail-page) .fi-main-ctn,
        body:has(.ng-user-detail-page) .fi-page,
        body:has(.ng-user-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-user-detail-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-user-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-user-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-user-detail-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-user-detail-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-user-detail-page * {
            box-sizing: border-box;
        }

        .ng-user-detail-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(360px, .55fr);
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

        .ng-user-detail-hero-card,
        .ng-user-profile-card {
            min-height: 126px;
        }

        .ng-user-detail-hero-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .ng-user-profile-card {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .ng-widget-head {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-kicker {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 10px;
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

        .ng-hero-actions {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
            flex: 0 0 auto;
        }

        .ng-soft-button,
        .ng-primary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 950;
            text-decoration: none !important;
            white-space: nowrap;
            transition: .2s ease;
        }

        .ng-soft-button {
            color: #d95d00 !important;
            background: rgba(255, 255, 255, .36);
            border: 1px solid rgba(255, 255, 255, .50);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .44);
        }

        .ng-soft-button:hover {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 12px 22px rgba(238, 101, 0, .22);
        }

        .ng-primary-button {
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .26);
        }

        .ng-primary-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238, 101, 0, .30);
        }

        .ng-profile-avatar {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            width: 66px;
            height: 66px;
            border-radius: 20px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 14px 26px rgba(101, 58, 21, .14);
        }

        .ng-profile-info {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .ng-profile-info span,
        .ng-profile-info small {
            display: block;
            color: #765d45;
            font-size: 11px;
            font-weight: 850;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-profile-info strong {
            display: block;
            max-width: 280px;
            margin: 7px 0;
            color: #21160d;
            font-size: 22px;
            line-height: 1.1;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 16px;
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

        .ng-user-detail-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 16px;
        }

        .ng-user-info-card,
        .ng-user-avatar-card {
            padding: 0;
        }

        .ng-card-head {
            position: relative;
            z-index: 2;
            min-height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 20px;
            background: rgba(255, 247, 235, .10);
            border-bottom: 1px solid rgba(114, 74, 41, .07);
        }

        .ng-card-head h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-card-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            font-weight: 750;
        }

        .ng-role-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #078657;
            background: rgba(16, 185, 129, .12);
            border: 1px solid rgba(16, 185, 129, .22);
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .ng-info-list {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 18px 20px 20px;
        }

        .ng-info-list div {
            min-height: 74px;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-info-list span {
            display: block;
            color: #6f5946;
            font-size: 11px;
            font-weight: 900;
        }

        .ng-info-list strong {
            display: block;
            margin-top: 7px;
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
            word-break: break-word;
        }

        .ng-avatar-preview {
            position: relative;
            z-index: 2;
            padding: 24px;
            text-align: center;
        }

        .ng-avatar-preview img {
            width: 140px;
            height: 140px;
            border-radius: 34px;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, .58);
            box-shadow: 0 18px 36px rgba(101, 58, 21, .14);
        }

        .ng-avatar-preview strong,
        .ng-avatar-preview span {
            display: block;
        }

        .ng-avatar-preview strong {
            margin-top: 14px;
            color: #21160d;
            font-size: 18px;
            font-weight: 950;
        }

        .ng-avatar-preview span {
            margin-top: 6px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-user-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-user-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-user-detail-page) .fi-sidebar-item-active svg,
        body:has(.ng-user-detail-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-user-detail-page) .fi-sidebar-item-active span,
        body:has(.ng-user-detail-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-user-detail-hero-grid,
            .ng-user-detail-main-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-user-detail-page {
                padding: 18px 18px 28px !important;
            }

            .ng-user-detail-hero-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-hero-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid,
            .ng-info-list {
                grid-template-columns: 1fr;
            }

            .ng-user-detail-page {
                padding: 14px 14px 24px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-user-profile-card {
                align-items: flex-start;
                flex-direction: column;
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
<?php /**PATH /var/www/html/resources/views/filament/admin/resources/users/pages/view-user.blade.php ENDPATH**/ ?>