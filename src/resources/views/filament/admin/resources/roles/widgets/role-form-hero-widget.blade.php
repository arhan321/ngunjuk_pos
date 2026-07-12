@php
    $cards = [
        [
            'label' => 'Total Roles',
            'value' => number_format((int) ($stats['total_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Semua role sistem',
            'icon' => '▣',
            'color' => '#f97316',
        ],
        [
            'label' => 'Total Permissions',
            'value' => number_format((int) ($stats['total_permissions'] ?? 0), 0, ',', '.'),
            'caption' => 'Hak akses tersedia',
            'icon' => '✓',
            'color' => '#10b981',
        ],
        [
            'label' => 'Guard Web',
            'value' => number_format((int) ($stats['web_roles'] ?? 0), 0, ',', '.'),
            'caption' => 'Role guard web',
            'icon' => '◇',
            'color' => '#3b82f6',
        ],
    ];
@endphp

<x-filament-widgets::widget>
<style>
        html, body { overflow-x: hidden !important; }

        body:has(.ng-role-form-page) {
            background:
                linear-gradient(120deg, rgba(255,248,237,.18), rgba(255,224,185,.05)),
                url('/images/pos-orange-bg.png'),
                radial-gradient(circle at 15% 8%, rgba(255,255,255,.48) 0 130px, transparent 280px),
                radial-gradient(circle at 88% 78%, rgba(255,118,0,.42) 0 250px, transparent 520px),
                radial-gradient(circle at 20% 96%, rgba(255,181,83,.30) 0 220px, transparent 500px),
                linear-gradient(135deg, #fff3df 0%, #ffd394 48%, #ff9c45 100%) !important;
            background-size: cover !important;
            background-position: center !important;
            background-attachment: fixed !important;
        }

        body:has(.ng-role-form-page) .fi-layout,
        body:has(.ng-role-form-page) .fi-main,
        body:has(.ng-role-form-page) .fi-main-ctn,
        body:has(.ng-role-form-page) .fi-page,
        body:has(.ng-role-form-page) .fi-page-content,
        body:has(.ng-role-form-page) main {
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            overflow-x: hidden !important;
        }

        body:has(.ng-role-form-page) .fi-main,
        body:has(.ng-role-form-page) .fi-page { padding: 0 !important; }

        body:has(.ng-role-form-page) .fi-page-header { display: none !important; }

        body:has(.ng-role-form-page) .fi-page-content {
            gap: 0 !important;
            row-gap: 0 !important;
            padding: 0 !important;
        }

        body:has(.ng-role-form-page) .fi-wi,
        body:has(.ng-role-form-page) .fi-wi-widget,
        body:has(.ng-role-form-page) .fi-wi-widget-content,
        body:has(.ng-role-form-page) .fi-wi-widgets,
        body:has(.ng-role-form-page) .fi-wi-widgets > * {
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .ng-role-form-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 24px 10px !important;
            overflow: visible !important;
            font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #24180f;
        }

        .ng-role-form-page *,
        .ng-custom-role-form * { box-sizing: border-box; }

        .ng-role-form-hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            margin-bottom: 14px;
        }

        .ng-widget-card,
        .ng-kpi-card,
        .ng-custom-role-card,
        .ng-permission-tabs-shell,
        .ng-permission-group-card {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.58);
            background:
                linear-gradient(145deg, rgba(255,255,255,.46), rgba(255,246,231,.22)),
                radial-gradient(circle at 100% 0%, rgba(255,153,30,.16), transparent 38%) !important;
            box-shadow:
                0 22px 54px rgba(101,58,21,.12),
                0 0 0 1px rgba(255,255,255,.12) inset,
                inset 0 1px 0 rgba(255,255,255,.62);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .ng-widget-card::before,
        .ng-kpi-card::before,
        .ng-custom-role-card::before,
        .ng-permission-tabs-shell::before,
        .ng-permission-group-card::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(120deg, rgba(255,255,255,.34), transparent 28%, transparent 70%, rgba(255,255,255,.16));
            opacity: .38;
        }

        .ng-widget-card {
            min-width: 0;
            padding: 18px;
            border-radius: 24px;
        }

        .ng-role-form-hero-card {
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

        .ng-kicker {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 12px;
            margin-bottom: 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.50);
            border: 1px solid rgba(255,255,255,.58);
            color: #d95d00;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.70);
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
            max-width: 900px;
            margin: 8px 0 0;
            color: #765d45;
            font-size: 13px;
            line-height: 1.55;
            font-weight: 700;
        }

        .ng-role-form-hero-actions {
            position: relative;
            z-index: 2;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .ng-primary-button,
        .ng-soft-button,
        .ng-mini-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            text-decoration: none !important;
            white-space: nowrap;
            cursor: pointer;
            transition: .2s ease;
        }

        .ng-primary-button {
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            color: #fff !important;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            box-shadow: 0 14px 26px rgba(238,101,0,.26);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-primary-button:hover {
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(238,101,0,.30);
        }

        .ng-soft-button {
            min-height: 42px;
            padding: 0 16px;
            border-radius: 15px;
            color: #c25500 !important;
            background: rgba(255,255,255,.38);
            border: 1px solid rgba(255,255,255,.56);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.48);
            font-size: 12px;
            font-weight: 950;
        }

        .ng-mini-button {
            min-height: 30px;
            padding: 0 10px;
            border-radius: 12px;
            color: #c25500 !important;
            background: rgba(255,255,255,.34);
            border: 1px solid rgba(255,255,255,.46);
            font-size: 11px;
            font-weight: 950;
        }

        .ng-kpi-grid,
        .ng-role-form-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
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
            box-shadow: 0 15px 28px rgba(249,115,22,.22);
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

        .ng-custom-role-form {
            width: calc(100% - 48px);
            max-width: calc(100% - 48px);
            margin: 0 24px 28px;
            padding: 0;
        }

        .ng-custom-role-card {
            border-radius: 24px;
            margin-bottom: 16px;
        }

        .ng-custom-card-header {
            position: relative;
            z-index: 2;
            min-height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 24px;
            background: rgba(255,247,235,.10);
            border-bottom: 1px solid rgba(114,74,41,.08);
        }

        .ng-custom-card-title {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 0;
        }

        .ng-custom-card-icon {
            flex: 0 0 auto;
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            color: #d95d00;
            background: rgba(255,255,255,.36);
            border: 1px solid rgba(255,255,255,.48);
            font-size: 16px;
            font-weight: 950;
        }

        .ng-custom-card-title h2 {
            margin: 0;
            color: #25170d;
            font-size: 17px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-custom-card-title p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 12px;
            line-height: 1.4;
            font-weight: 750;
        }

        .ng-custom-card-body {
            position: relative;
            z-index: 2;
            padding: 22px 24px 24px;
        }

        .ng-role-basic-grid {
            display: grid;
            grid-template-columns: minmax(0,1fr) minmax(260px,.72fr) minmax(260px,.82fr);
            gap: 18px;
            align-items: start;
        }

        .ng-form-field label {
            display: block;
            color: #4b3525;
            font-size: 12px;
            font-weight: 950;
            margin-bottom: 8px;
        }

        .ng-form-field label span { color: #ef4444; }

        .ng-form-input {
            width: 100%;
            min-height: 46px;
            padding: 0 16px;
            border-radius: 16px;
            color: #24180f;
            background: rgba(255,255,255,.30);
            border: 1px solid rgba(255,255,255,.44);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.40), 0 10px 26px rgba(101,58,21,.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            font-size: 13px;
            font-weight: 850;
            outline: none;
        }

        .ng-form-input:focus {
            border-color: rgba(249,115,22,.52);
            box-shadow: 0 0 0 4px rgba(249,115,22,.10), inset 0 1px 0 rgba(255,255,255,.48);
        }

        .ng-form-help,
        .ng-form-error {
            display: block;
            margin-top: 8px;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 750;
        }

        .ng-form-help { color: #8b7057; }
        .ng-form-error { color: #b91c1c; }

        .ng-select-all-box {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 46px;
            padding-top: 21px;
        }

        .ng-toggle-button {
            position: relative;
            width: 54px;
            height: 28px;
            flex: 0 0 auto;
            border: 0;
            border-radius: 999px;
            background: rgba(148,163,184,.32);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.52);
            cursor: pointer;
        }

        .ng-toggle-button::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 6px;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(101,58,21,.16);
            transition: .2s ease;
        }

        .ng-toggle-button.is-active {
            background: linear-gradient(135deg, #ff9d18, #ee6500);
        }

        .ng-toggle-button.is-active::after { left: 30px; }

        .ng-toggle-copy strong {
            display: block;
            color: #25170d;
            font-size: 13px;
            font-weight: 950;
        }

        .ng-toggle-copy span {
            display: block;
            margin-top: 4px;
            color: #7b624c;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 700;
        }

        .ng-permission-tabs-shell {
            position: relative;
            z-index: 2;
            margin-bottom: 18px;
            padding: 12px 16px;
            border-radius: 24px;
        }

        .ng-permission-tabs {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ng-tab-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 0 14px;
            border: 0;
            border-radius: 14px;
            color: #6f5844;
            background: transparent;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
            transition: .18s ease;
        }

        .ng-tab-button.is-active {
            color: #d95d00;
            background: rgba(255,255,255,.36);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.52);
        }

        .ng-tab-count,
        .ng-group-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 24px;
            padding: 0 8px;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(135deg, #ff9d18, #ee6500);
            font-size: 11px;
            font-weight: 950;
        }

        .ng-permission-groups-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .ng-permission-group-card { border-radius: 22px; }

        .ng-permission-group-head {
            position: relative;
            z-index: 2;
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(114,74,41,.08);
            background: rgba(255,247,235,.08);
        }

        .ng-permission-group-head h3 {
            margin: 0;
            color: #25170d;
            font-size: 16px;
            line-height: 1.2;
            font-weight: 950;
            letter-spacing: -.03em;
        }

        .ng-permission-group-head p {
            margin: 5px 0 0;
            color: #7b624c;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 750;
            word-break: break-word;
        }

        .ng-group-control {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .ng-permission-actions {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 18px;
            padding: 18px 20px 20px;
        }

        .ng-permission-option {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            color: #342417;
            font-size: 13px;
            font-weight: 850;
            cursor: pointer;
        }

        .ng-permission-option input {
            appearance: none;
            -webkit-appearance: none;
            flex: 0 0 auto;
            width: 18px;
            height: 18px;
            border-radius: 7px;
            border: 1px solid rgba(249,115,22,.42);
            background: rgba(255,255,255,.42);
            box-shadow: 0 6px 14px rgba(101,58,21,.08);
            cursor: pointer;
        }

        .ng-permission-option input:checked {
            background:
                radial-gradient(circle at 50% 50%, #fff 0 24%, transparent 26%),
                linear-gradient(135deg, #ff9d18, #ee6500);
            border-color: #f97316;
        }

        .ng-empty-permission {
            position: relative;
            z-index: 2;
            padding: 24px;
            border-radius: 20px;
            color: #7b624c;
            background: rgba(255,255,255,.24);
            border: 1px solid rgba(255,255,255,.42);
            font-size: 13px;
            font-weight: 800;
            text-align: center;
        }

        .ng-form-actions {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
        }

        body:has(.ng-role-form-page) .fi-sidebar {
            background: rgba(255,250,242,.50) !important;
            border-right: 1px solid rgba(255,255,255,.48) !important;
            box-shadow: 18px 0 55px rgba(137,78,26,.10) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-nav { padding: 18px 14px !important; }

        body:has(.ng-role-form-page) .fi-sidebar-item a,
        body:has(.ng-role-form-page) .fi-sidebar-item-button {
            border-radius: 14px !important;
            color: #6f5844 !important;
            transition: .2s ease !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-item-active a,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover,
        body:has(.ng-role-form-page) .fi-sidebar-item-active .fi-sidebar-item-button,
        body:has(.ng-role-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active a,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
            background: linear-gradient(135deg, #ff9500, #f26a00) !important;
            color: #fff !important;
            box-shadow: 0 14px 24px rgba(242,106,0,.24) !important;
        }

        body:has(.ng-role-form-page) .fi-sidebar-item-active svg,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover svg,
        body:has(.ng-role-form-page) .fi-sidebar-item-active span,
        body:has(.ng-role-form-page) .fi-sidebar-item a:hover span,
        body:has(.ng-role-form-page) .fi-sidebar-item-active .fi-sidebar-item-icon,
        body:has(.ng-role-form-page) .fi-sidebar-item-active .fi-sidebar-item-label,
        body:has(.ng-role-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
        body:has(.ng-role-form-page) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active svg,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active span,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
        body:has(.ng-role-form-page) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
            color: #fff !important;
        }

        @media (max-width: 1200px) {
            .ng-role-basic-grid,
            .ng-permission-groups-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 1100px) {
            .ng-role-form-page { padding: 18px 18px 10px !important; }

            .ng-widget-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .ng-role-form-hero-actions { justify-content: flex-start; }

            .ng-kpi-grid,
            .ng-role-form-kpi-grid { grid-template-columns: 1fr !important; }

            .ng-custom-role-form {
                width: calc(100% - 36px);
                max-width: calc(100% - 36px);
                margin-left: 18px;
                margin-right: 18px;
            }
        }

        @media (max-width: 640px) {
            .ng-role-form-page { padding: 14px 14px 8px !important; }

            .ng-widget-head h1 { font-size: 26px; }

            .ng-widget-card {
                padding: 16px;
                border-radius: 22px;
            }

            .ng-custom-role-form {
                width: calc(100% - 28px);
                max-width: calc(100% - 28px);
                margin-left: 14px;
                margin-right: 14px;
            }

            .ng-custom-card-header,
            .ng-custom-card-body,
            .ng-permission-group-head,
            .ng-permission-actions {
                padding-left: 16px;
                padding-right: 16px;
            }

            .ng-permission-actions { grid-template-columns: 1fr; }
        }
    </style>
    <div class="ng-role-form-page">
        <section class="ng-role-form-hero-grid">
            <article class="ng-widget-card ng-role-form-hero-card">
                <div class="ng-widget-head">
                    <div>

                        <h1>{{ $title }}</h1>

                        <p>
                            {{ $description }}
                        </p>
                    </div>

                    <div class="ng-role-form-hero-actions">
                        <a href="{{ $backUrl }}" class="ng-primary-button">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </article>
        </section>

        <section class="ng-kpi-grid ng-role-form-kpi-grid">
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
    </div>
</x-filament-widgets::widget>
