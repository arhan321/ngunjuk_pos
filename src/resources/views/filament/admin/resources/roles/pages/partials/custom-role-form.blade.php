<style>
    /*
    |--------------------------------------------------------------------------
    | ROLE FORM DIRECT STYLE
    |--------------------------------------------------------------------------
    | Style ini dibuat langsung di partial supaya form tidak tampil polos.
    | Widget hero juga dibuat non-lazy lewat RoleFormHeroWidget.php agar
    | kotak putih placeholder di atas tidak muncul saat klik New Role.
    */

    html,
    body {
        overflow-x: hidden !important;
    }

    body:has(.ng-custom-role-form) {
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

    body:has(.ng-custom-role-form) .fi-layout,
    body:has(.ng-custom-role-form) .fi-main,
    body:has(.ng-custom-role-form) .fi-main-ctn,
    body:has(.ng-custom-role-form) .fi-page,
    body:has(.ng-custom-role-form) .fi-page-content,
    body:has(.ng-custom-role-form) main {
        width: 100% !important;
        max-width: 100% !important;
        background: transparent !important;
        overflow-x: hidden !important;
    }

    body:has(.ng-custom-role-form) .fi-main,
    body:has(.ng-custom-role-form) .fi-page {
        padding: 0 !important;
    }

    body:has(.ng-custom-role-form) .fi-page-header {
        display: none !important;
    }

    body:has(.ng-custom-role-form) .fi-page-content {
        gap: 0 !important;
        row-gap: 0 !important;
        padding: 0 !important;
    }

    /*
    | Hilangkan placeholder widget kosong.
    | Jika isi widget belum berisi .ng-role-form-page, berarti itu hanya
    | placeholder/blank card dari Filament.
    */
    body:has(.ng-custom-role-form) .fi-wi:not(:has(.ng-role-form-page)),
    body:has(.ng-custom-role-form) .fi-wi-widget:not(:has(.ng-role-form-page)),
    body:has(.ng-custom-role-form) .fi-wi-widget-content:not(:has(.ng-role-form-page)),
    body:has(.ng-custom-role-form) .fi-wi-widgets > *:not(:has(.ng-role-form-page)) {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        min-height: 0 !important;
        max-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    body:has(.ng-custom-role-form) .fi-wi,
    body:has(.ng-custom-role-form) .fi-wi-widget,
    body:has(.ng-custom-role-form) .fi-wi-widget-content,
    body:has(.ng-custom-role-form) .fi-wi-widgets,
    body:has(.ng-custom-role-form) .fi-wi-widgets > * {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    .ng-custom-role-form {
        width: calc(100% - 48px);
        max-width: calc(100% - 48px);
        margin: 0 24px 28px;
        padding: 0;
        font-family: Inter, Poppins, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color: #24180f;
    }

    .ng-custom-role-form * {
        box-sizing: border-box;
    }

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

    .ng-form-field label span {
        color: #ef4444;
    }

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

    .ng-form-help {
        color: #8b7057;
    }

    .ng-form-error {
        color: #b91c1c;
    }

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

    .ng-toggle-button.is-active::after {
        left: 30px;
    }

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

    .ng-permission-group-card {
        border-radius: 22px;
    }

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

    body:has(.ng-custom-role-form) .fi-sidebar {
        background: rgba(255,250,242,.50) !important;
        border-right: 1px solid rgba(255,255,255,.48) !important;
        box-shadow: 18px 0 55px rgba(137,78,26,.10) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
    }

    body:has(.ng-custom-role-form) .fi-sidebar-nav {
        padding: 18px 14px !important;
    }

    body:has(.ng-custom-role-form) .fi-sidebar-item a,
    body:has(.ng-custom-role-form) .fi-sidebar-item-button {
        border-radius: 14px !important;
        color: #6f5844 !important;
        transition: .2s ease !important;
    }

    body:has(.ng-custom-role-form) .fi-sidebar-item-active a,
    body:has(.ng-custom-role-form) .fi-sidebar-item a:hover,
    body:has(.ng-custom-role-form) .fi-sidebar-item-active .fi-sidebar-item-button,
    body:has(.ng-custom-role-form) .fi-sidebar-item .fi-sidebar-item-button:hover,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active a,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active .fi-sidebar-item-button {
        background: linear-gradient(135deg, #ff9500, #f26a00) !important;
        color: #fff !important;
        box-shadow: 0 14px 24px rgba(242,106,0,.24) !important;
    }

    body:has(.ng-custom-role-form) .fi-sidebar-item-active svg,
    body:has(.ng-custom-role-form) .fi-sidebar-item a:hover svg,
    body:has(.ng-custom-role-form) .fi-sidebar-item-active span,
    body:has(.ng-custom-role-form) .fi-sidebar-item a:hover span,
    body:has(.ng-custom-role-form) .fi-sidebar-item-active .fi-sidebar-item-icon,
    body:has(.ng-custom-role-form) .fi-sidebar-item-active .fi-sidebar-item-label,
    body:has(.ng-custom-role-form) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-icon,
    body:has(.ng-custom-role-form) .fi-sidebar-item .fi-sidebar-item-button:hover .fi-sidebar-item-label,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active svg,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active span,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    body:has(.ng-custom-role-form) .fi-sidebar-item.fi-active .fi-sidebar-item-label {
        color: #fff !important;
    }

    @media (max-width: 1200px) {
        .ng-role-basic-grid,
        .ng-permission-groups-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 1100px) {
        .ng-custom-role-form {
            width: calc(100% - 36px);
            max-width: calc(100% - 36px);
            margin-left: 18px;
            margin-right: 18px;
        }
    }

    @media (max-width: 640px) {
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

        .ng-permission-actions {
            grid-template-columns: 1fr;
        }
    }
</style>


@php
    $tabs = $this->permissionTabs;
    $activeTabKey = $activePermissionTab;
    $activeTab = $tabs[$activeTabKey] ?? ['groups' => [], 'count' => 0];
    $allSelected = $this->totalPermissionCount > 0 && $this->selectedPermissionCount >= $this->totalPermissionCount;
@endphp

<form wire:submit.prevent="saveRole" class="ng-custom-role-form">
    <section class="ng-custom-role-card">
        <div class="ng-custom-card-header">
            <div class="ng-custom-card-title">
                <div class="ng-custom-card-icon">◈</div>

                <div>
                    <h2>Data Role</h2>
                    <p>Isi nama role, guard, dan pengaturan dasar role sistem.</p>
                </div>
            </div>
        </div>

        <div class="ng-custom-card-body">
            <div class="ng-role-basic-grid">
                <div class="ng-form-field">
                    <label for="role_name">Name <span>*</span></label>

                    <input
                        id="role_name"
                        type="text"
                        class="ng-form-input"
                        placeholder="Contoh: super_admin / karyawan"
                        wire:model.blur="name"
                    >

                    @error('name')
                        <span class="ng-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ng-form-field">
                    <label for="role_guard_name">Guard Name</label>

                    <input
                        id="role_guard_name"
                        type="text"
                        class="ng-form-input"
                        placeholder="web"
                        wire:model.blur="guard_name"
                    >

                    <span class="ng-form-help">Default guard biasanya web.</span>

                    @error('guard_name')
                        <span class="ng-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ng-select-all-box">
                    <button
                        type="button"
                        wire:click="toggleSelectAll"
                        class="ng-toggle-button {{ $allSelected ? 'is-active' : '' }}"
                        aria-label="Select all permissions"
                    ></button>

                    <div class="ng-toggle-copy">
                        <strong>Select All</strong>
                        <span>
                            {{ $this->selectedPermissionCount }} / {{ $this->totalPermissionCount }}
                            permission dipilih.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ng-custom-role-card">
        <div class="ng-custom-card-header">
            <div class="ng-custom-card-title">
                <div class="ng-custom-card-icon">⌕</div>

                <div>
                    <h2>Hak Akses Role</h2>
                    <p>Atur permission berdasarkan Resources, Pages, dan Widgets.</p>
                </div>
            </div>
        </div>

        <div class="ng-custom-card-body">
            <div class="ng-permission-tabs-shell">
                <div class="ng-permission-tabs">
                    @foreach ($tabs as $tabKey => $tab)
                        <button
                            type="button"
                            wire:click="$set('activePermissionTab', '{{ $tabKey }}')"
                            class="ng-tab-button {{ $activeTabKey === $tabKey ? 'is-active' : '' }}"
                        >
                            {{ $tab['label'] }}
                            <span class="ng-tab-count">{{ $tab['count'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            @if (empty($activeTab['groups']))
                <div class="ng-empty-permission">
                    Tidak ada permission pada tab ini.
                </div>
            @else
                <div class="ng-permission-groups-grid">
                    @foreach ($activeTab['groups'] as $group)
                        @php
                            $permissionNames = collect($group['permissions'])->pluck('name')->values()->all();
                            $selectedCount = collect($permissionNames)
                                ->filter(fn ($permission) => in_array($permission, $selectedPermissions, true))
                                ->count();
                            $isGroupFull = count($permissionNames) > 0 && $selectedCount === count($permissionNames);
                        @endphp

                        <article class="ng-permission-group-card">
                            <div class="ng-permission-group-head">
                                <div>
                                    <h3>{{ $group['title'] }}</h3>
                                    <p>{{ $group['subtitle'] }}</p>
                                </div>

                                <div class="ng-group-control">
                                    <span class="ng-group-count">
                                        {{ $selectedCount }}/{{ count($permissionNames) }}
                                    </span>

                                    @if ($isGroupFull)
                                        <button
                                            type="button"
                                            class="ng-mini-button"
                                            wire:click="deselectGroupPermissions(@js($permissionNames))"
                                        >
                                            Deselect all
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="ng-mini-button"
                                            wire:click="selectGroupPermissions(@js($permissionNames))"
                                        >
                                            Select all
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="ng-permission-actions">
                                @foreach ($group['permissions'] as $permission)
                                    <label class="ng-permission-option">
                                        <input
                                            type="checkbox"
                                            value="{{ $permission['name'] }}"
                                            wire:model.live="selectedPermissions"
                                        >

                                        <span>{{ $permission['label'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            @error('selectedPermissions')
                <span class="ng-form-error">{{ $message }}</span>
            @enderror

            <div class="ng-form-actions">
                <button type="submit" class="ng-primary-button">
                    {{ $submitLabel ?? 'Simpan Role' }}
                </button>

                <a href="{{ \App\Filament\Admin\Resources\Roles\RoleResource::getUrl('index') }}" class="ng-soft-button">
                    Batal
                </a>
            </div>
        </div>
    </section>
</form>
