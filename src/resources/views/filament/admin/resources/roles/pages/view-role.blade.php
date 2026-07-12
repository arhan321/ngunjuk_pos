<x-filament-panels::page>
    @php
        $role = $record;
        $role->loadMissing('permissions');

        $backUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('index');
        $editUrl = \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('edit', ['record' => $role]);

        $roleName = str($role->name ?? '-')->replace('_', ' ')->title()->toString();
        $guardName = $role->guard_name ?? 'web';
        $permissions = $role->permissions ?? collect();

        $cards = [
            [
                'label' => 'Nama Role',
                'value' => $roleName,
                'caption' => 'Role akses sistem',
                'icon' => '▣',
                'color' => '#f97316',
            ],
            [
                'label' => 'Guard Name',
                'value' => $guardName,
                'caption' => 'Guard role',
                'icon' => '◇',
                'color' => '#3b82f6',
            ],
            [
                'label' => 'Total Permission',
                'value' => number_format($permissions->count(), 0, ',', '.'),
                'caption' => 'Hak akses aktif',
                'icon' => '✓',
                'color' => '#10b981',
            ],
            [
                'label' => 'Update',
                'value' => $role->updated_at?->diffForHumans() ?? '-',
                'caption' => 'Terakhir diperbarui',
                'icon' => '↗',
                'color' => '#8b5cf6',
            ],
        ];
    @endphp

    <div class="ng-role-detail-page">
        <section class="ng-role-detail-hero-grid">
            <article class="ng-widget-card ng-role-detail-hero-card">
                <div class="ng-widget-head">
                    <div>
                        <span class="ng-kicker">
                            POS Ngunjuk
                        </span>

                        <h1>Detail Role</h1>

                        <p>
                            Informasi lengkap role pengguna, guard, jumlah permission, dan daftar hak akses
                            yang dimiliki role ini pada sistem POS.
                        </p>
                    </div>
                </div>

                <div class="ng-hero-actions">
                    <a href="{{ $backUrl }}" class="ng-soft-button">
                        ← Kembali
                    </a>

                    <a href="{{ $editUrl }}" class="ng-primary-button">
                        Edit Role
                    </a>
                </div>
            </article>

            <article class="ng-widget-card ng-role-profile-card">
                <div class="ng-role-avatar">
                    {{ mb_strtoupper(mb_substr($roleName, 0, 1)) }}
                </div>

                <div class="ng-profile-info">
                    <span>Role Terpilih</span>
                    <strong>{{ $roleName }}</strong>
                    <small>{{ number_format($permissions->count(), 0, ',', '.') }} permission</small>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-role-detail-kpi-grid">
            @foreach ($cards as $card)
                <article class="ng-kpi-card" style="--accent: {{ $card['color'] ?? '#f97316' }};">
                    <div class="ng-kpi-icon">
                        {{ $card['icon'] ?? '▣' }}
                    </div>

                    <div class="ng-kpi-content">
                        <div class="ng-kpi-label">
                            {{ $card['label'] ?? '-' }}
                            <span>⋮</span>
                        </div>

                        <strong>
                            {{ $card['value'] ?? '-' }}
                        </strong>

                        <p class="neutral">
                            {{ $card['caption'] ?? '-' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="ng-role-detail-main-grid">
            <article class="ng-widget-card ng-role-info-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Informasi Role</h2>
                        <p>Ringkasan role dan konfigurasi guard.</p>
                    </div>

                    <span class="ng-guard-pill">
                        {{ $guardName }}
                    </span>
                </div>

                <div class="ng-info-list">
                    <div>
                        <span>Nama Role</span>
                        <strong>{{ $roleName }}</strong>
                    </div>

                    <div>
                        <span>Guard Name</span>
                        <strong>{{ $guardName }}</strong>
                    </div>

                    <div>
                        <span>Total Permission</span>
                        <strong>{{ number_format($permissions->count(), 0, ',', '.') }}</strong>
                    </div>

                    <div>
                        <span>ID Role</span>
                        <strong>#{{ $role->id }}</strong>
                    </div>

                    <div>
                        <span>Dibuat</span>
                        <strong>{{ $role->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>

                    <div>
                        <span>Terakhir Update</span>
                        <strong>{{ $role->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}</strong>
                    </div>
                </div>
            </article>

            <article class="ng-widget-card ng-role-summary-card">
                <div class="ng-card-head">
                    <div>
                        <h2>Access Summary</h2>
                        <p>Status kelengkapan permission role.</p>
                    </div>
                </div>

                <div class="ng-access-summary">
                    <div class="ng-big-number">
                        {{ number_format($permissions->count(), 0, ',', '.') }}
                    </div>

                    <strong>Permission Aktif</strong>

                    <span>
                        Role {{ $roleName }} memiliki {{ number_format($permissions->count(), 0, ',', '.') }}
                        hak akses yang terhubung.
                    </span>
                </div>
            </article>
        </section>

        <section class="ng-widget-card ng-role-permission-card">
            <div class="ng-card-head">
                <div>
                    <h2>Daftar Permission</h2>
                    <p>Semua permission yang terhubung dengan role ini.</p>
                </div>

                <span class="ng-permission-count-pill">
                    {{ number_format($permissions->count(), 0, ',', '.') }} Permission
                </span>
            </div>

            <div class="ng-permission-list">
                @forelse ($permissions as $permission)
                    <div class="ng-permission-item">
                        <span>{{ $loop->iteration }}</span>

                        <strong>
                            {{ str($permission->name)->replace('_', ' ')->replace('.', ' ')->title() }}
                        </strong>

                        <small>
                            {{ $permission->name }}
                        </small>
                    </div>
                @empty
                    <div class="ng-empty-state">
                        <strong>Belum ada permission</strong>
                        <span>Role ini belum memiliki hak akses yang terhubung.</span>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <style>
        html,
        body {
            overflow-x: hidden !important;
        }

        body:has(.ng-role-detail-page) {
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

        body:has(.ng-role-detail-page) .fi-main,
        body:has(.ng-role-detail-page) .fi-main-ctn,
        body:has(.ng-role-detail-page) .fi-page,
        body:has(.ng-role-detail-page) .fi-page-content {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-detail-page) .fi-page {
            padding: 0 !important;
        }

        body:has(.ng-role-detail-page) .fi-page-header {
            display: none !important;
        }

        body:has(.ng-role-detail-page) .fi-main {
            padding: 0 !important;
        }

        body:has(.ng-role-detail-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
        }

        .ng-role-detail-page {
            width: 100% !important;
            max-width: 100% !important;
            min-height: 100vh;
            padding: 24px 24px 32px !important;
            overflow: hidden !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-detail-page * {
            box-sizing: border-box;
        }

        .ng-role-detail-hero-grid {
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

        .ng-role-detail-hero-card,
        .ng-role-profile-card {
            min-height: 126px;
        }

        .ng-role-detail-hero-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .ng-role-profile-card {
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

        .ng-role-avatar {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            width: 66px;
            height: 66px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238, 101, 0, .24);
            font-size: 22px;
            font-weight: 950;
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

        .ng-role-detail-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .65fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .ng-role-info-card,
        .ng-role-summary-card,
        .ng-role-permission-card {
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

        .ng-guard-pill,
        .ng-permission-count-pill {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: #c25500;
            background: rgba(249, 115, 22, .12);
            border: 1px solid rgba(249, 115, 22, .22);
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

        .ng-access-summary {
            position: relative;
            z-index: 2;
            padding: 24px;
            text-align: center;
        }

        .ng-big-number {
            width: 120px;
            height: 120px;
            display: grid;
            place-items: center;
            margin: 0 auto 14px;
            border-radius: 34px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 18px 36px rgba(238, 101, 0, .22);
            font-size: 34px;
            font-weight: 950;
        }

        .ng-access-summary strong,
        .ng-access-summary span {
            display: block;
        }

        .ng-access-summary strong {
            color: #21160d;
            font-size: 18px;
            font-weight: 950;
        }

        .ng-access-summary span {
            max-width: 280px;
            margin: 6px auto 0;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.5;
        }

        .ng-permission-list {
            position: relative;
            z-index: 2;
            padding: 14px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .ng-permission-item {
            min-height: 74px;
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            column-gap: 10px;
            align-items: center;
            padding: 12px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-permission-item > span {
            grid-row: span 2;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 12px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-permission-item strong {
            color: #23160d;
            font-size: 12px;
            font-weight: 950;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-permission-item small {
            color: #8b7057;
            font-size: 10px;
            font-weight: 750;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .ng-empty-state {
            grid-column: 1 / -1;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .24);
            border: 1px solid rgba(255, 255, 255, .38);
        }

        .ng-empty-state strong,
        .ng-empty-state span {
            display: block;
        }

        .ng-empty-state strong {
            color: #23160d;
            font-size: 14px;
            font-weight: 950;
        }

        .ng-empty-state span {
            margin-top: 5px;
            color: #765d45;
            font-size: 12px;
            font-weight: 750;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR EFFECT SYNC
        |--------------------------------------------------------------------------
        */

        body:has(.ng-role-detail-page) .fi-sidebar {
            background: rgba(255, 250, 242, .50) !important;
            border-right: 1px solid rgba(255, 255, 255, .48) !important;
            box-shadow: 18px 0 55px rgba(137, 78, 26, .10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-nav {
            padding: 18px 14px !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-item a {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-item-active a,
        body:has(.ng-role-detail-page) .fi-sidebar-item a:hover {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242, 106, 0, .24) !important;
        }

        body:has(.ng-role-detail-page) .fi-sidebar-item-active svg,
        body:has(.ng-role-detail-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-role-detail-page) .fi-sidebar-item-active span,
        body:has(.ng-role-detail-page) .fi-sidebar-item a:hover span {
            color: #fff !important;
        }

        @media (max-width: 1500px) {
            .ng-role-detail-hero-grid,
            .ng-role-detail-main-grid {
                grid-template-columns: 1fr;
            }

            .ng-kpi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ng-permission-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .ng-role-detail-page {
                padding: 18px 18px 28px !important;
            }

            .ng-role-detail-hero-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-hero-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 700px) {
            .ng-kpi-grid,
            .ng-info-list,
            .ng-permission-list {
                grid-template-columns: 1fr;
            }

            .ng-role-detail-page {
                padding: 14px 14px 24px !important;
            }

            .ng-widget-head h1 {
                font-size: 26px;
            }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-role-profile-card {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</x-filament-panels::page>
