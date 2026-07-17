<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Dashboard;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Filament\Admin\Widgets\LatestAccessLogs;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color as FilamentColor;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Event;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Openplain\FilamentShadcnTheme\Color;
use App\Filament\Admin\Resources\ActivityLogs\ActivityLogResource as CustomActivityLogResource;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $this->registerLogoutActivityLogger();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->spa()
            ->spaUrlExceptions([
                Dashboard::class,
            ])
            ->login(\App\Filament\Admin\Pages\Auth\Login::class)
            ->topbar(false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->maxContentWidth(Width::Full)
            ->databaseTransactions()
            ->defaultThemeMode(ThemeMode::Light)
            ->darkMode(false)
            ->colors([
                'primary' => Color::adaptive(
                    lightColor: FilamentColor::Orange,
                    darkColor: FilamentColor::Amber
                ),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->resources([
                CustomActivityLogResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                OverlookWidget::class,
                LatestAccessLogs::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->collapsed(true)
                    ->label('General'),
                NavigationGroup::make()
                    ->collapsed(true)
                    ->label('Administration'),
            ])
            ->plugins([
                BreezyCore::make()
                    ->myProfile(
                        hasAvatars: true,
                        slug: 'profile',
                        userMenuLabel: 'Profile',
                    )
                    ->enableBrowserSessions(),

                GlobalSearchModalPlugin::make(),

                OverlookPlugin::make()
                    ->sort(2)
                    ->columns([
                        'default' => 4,
                        'sm' => 2,
                        'lg' => 4,
                        'xl' => 6,
                    ])
                    ->includes([
                        UserResource::class,
                    ]),

                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 2,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 2,
                    ])
                    ->navigationLabel('Roles & Permissions')
                    ->navigationGroup('Administration')
                    ->navigationSort(2)
                    ->navigationIcon(Heroicon::ShieldCheck),
/*
                |--------------------------------------------------------------------------
                | Developer Login
                |--------------------------------------------------------------------------
                | Plugin tetap didaftarkan supaya struktur halaman login tetap stabil,
                | tetapi daftar user dikosongkan agar bagian "Login as" tidak muncul.
                */
                FilamentDeveloperLoginsPlugin::make()
                    ->enabled(false)
                    ->switchable(false)
                    ->users(fn (): array => []),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | CSS LOGIN ADMIN LANGSUNG DARI PROVIDER
            |--------------------------------------------------------------------------
            | Ini sengaja ditaruh di renderHook supaya tidak perlu npm run build.
            */
            ->renderHook('panels::head.end', fn (): string => <<<'HTML'
<style>

    /*
    |--------------------------------------------------------------------------
    | HIDE FILAMENT THEME SWITCHER
    |--------------------------------------------------------------------------
    | Menghilangkan pilihan Light / Dark / System pada user menu profile.
    */
    .fi-theme-switcher,
    .fi-user-menu .fi-theme-switcher,
    .fi-dropdown-panel .fi-theme-switcher,
    .fi-dropdown-list .fi-theme-switcher {
        display: none !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    body:has(form[action*="login"]) {
        min-height: 100vh !important;
        overflow-x: hidden !important;
        background:
            radial-gradient(circle at 13% 15%, rgba(255, 255, 255, .96) 0 118px, transparent 121px),
            radial-gradient(circle at 89% 12%, rgba(255, 139, 89, .18) 0 270px, transparent 276px),
            radial-gradient(circle at 83% 89%, rgba(235, 168, 88, .20) 0 310px, transparent 318px),
            radial-gradient(circle at 6% 88%, rgba(255, 190, 145, .16) 0 190px, transparent 198px),
            linear-gradient(135deg, #fffaf6 0%, #fff2ea 48%, #ffe5d6 100%) !important;
    }

    body:has(form[action*="login"])::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        opacity: .22;
        background-image: radial-gradient(rgba(207, 124, 71, .34) 1px, transparent 1px);
        background-size: 18px 18px;
    }

    body:has(form[action*="login"])::after {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            linear-gradient(115deg, transparent 0 22%, rgba(255,255,255,.32) 22.2% 22.5%, transparent 23% 100%),
            radial-gradient(circle at 50% 91%, rgba(255, 255, 255, .54), transparent 28%);
    }

    body:has(form[action*="login"]) .fi-simple-layout {
        position: relative !important;
        z-index: 1 !important;
        min-height: 100vh !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 28px !important;
        background: transparent !important;
    }

    body:has(form[action*="login"]) .fi-simple-main {
        width: min(450px, calc(100vw - 38px)) !important;
        max-width: 450px !important;
        margin: 0 auto !important;
        padding: 0 !important;
        border-radius: 32px !important;
        background:
            radial-gradient(circle at 92% 3%, rgba(255, 139, 89, .11), transparent 34%),
            linear-gradient(180deg, rgba(255,255,255,.97), rgba(255,250,246,.94)) !important;
        border: 1px solid rgba(235, 177, 106, .45) !important;
        box-shadow:
            0 28px 70px rgba(82, 49, 33, .16),
            0 0 0 8px rgba(255,255,255,.28),
            inset 0 1px 0 rgba(255,255,255,.96) !important;
        backdrop-filter: blur(16px) !important;
        overflow: hidden !important;
    }

    body:has(form[action*="login"]) .fi-simple-page {
        width: 100% !important;
        max-width: none !important;
        padding: 32px 34px 30px !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    body:has(form[action*="login"]) .fi-simple-header {
        margin-bottom: 20px !important;
        text-align: center !important;
        align-items: center !important;
    }

    body:has(form[action*="login"]) .fi-simple-header::before {
        content: "ADMIN DASHBOARD";
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        margin: 0 auto 12px;
        padding: 8px 16px;
        border-radius: 999px;
        color: #b46718;
        background: rgba(255, 246, 238, .94);
        border: 1px solid rgba(220, 162, 90, .42);
        box-shadow: 0 8px 18px rgba(141, 88, 45, .08);
        font-size: 11px;
        font-weight: 900;
        line-height: 1;
        letter-spacing: .08em;
    }

    body:has(form[action*="login"]) .fi-logo {
        display: block !important;
        margin: 0 auto 4px !important;
        color: #f47a45 !important;
        font-size: 17px !important;
        font-weight: 900 !important;
        letter-spacing: .18em !important;
        text-align: center !important;
        text-transform: uppercase !important;
    }

    body:has(form[action*="login"]) .fi-simple-header-heading,
    body:has(form[action*="login"]) h1 {
        color: #26272d !important;
        font-family: Georgia, 'Times New Roman', serif !important;
        font-size: 44px !important;
        font-weight: 700 !important;
        line-height: 1.02 !important;
        letter-spacing: -1px !important;
        text-align: center !important;
        text-shadow: 0 10px 24px rgba(47, 48, 55, .08) !important;
    }

    body:has(form[action*="login"]) form {
        width: 100% !important;
    }

    body:has(form[action*="login"]) .fi-fo-field-wrp {
        margin-bottom: 14px !important;
    }

    body:has(form[action*="login"]) .fi-fo-field-wrp-label span,
    body:has(form[action*="login"]) label,
    body:has(form[action*="login"]) .fi-checkbox-list-option-label {
        color: #3a332e !important;
        font-size: 13px !important;
        font-weight: 750 !important;
        opacity: 1 !important;
    }

    body:has(form[action*="login"]) .fi-input-wrp {
        min-height: 50px !important;
        border-radius: 15px !important;
        background: rgba(255,255,255,.92) !important;
        border: 1px solid rgba(218, 170, 126, .56) !important;
        box-shadow:
            0 10px 22px rgba(82, 49, 33, .05),
            inset 0 1px 0 rgba(255,255,255,.95) !important;
        overflow: hidden !important;
        transition: .2s ease !important;
    }

    body:has(form[action*="login"]) .fi-input-wrp:focus-within {
        border-color: rgba(255, 139, 89, .78) !important;
        box-shadow:
            0 0 0 5px rgba(255, 139, 89, .13),
            0 15px 30px rgba(82, 49, 33, .08) !important;
        background: #ffffff !important;
    }

    body:has(form[action*="login"]) .fi-input {
        color: #26272d !important;
        background: transparent !important;
        font-weight: 650 !important;
    }

    body:has(form[action*="login"]) .fi-input::placeholder {
        color: #a99b91 !important;
    }

    body:has(form[action*="login"]) input:-webkit-autofill,
    body:has(form[action*="login"]) input:-webkit-autofill:hover,
    body:has(form[action*="login"]) input:-webkit-autofill:focus {
        -webkit-text-fill-color: #26272d !important;
        box-shadow: 0 0 0 1000px #ffffff inset !important;
        transition: background-color 9999s ease-in-out 0s !important;
    }

    body:has(form[action*="login"]) .fi-icon-btn {
        color: #95633f !important;
    }

    body:has(form[action*="login"]) .fi-icon-btn:hover {
        color: #d9612f !important;
        background: #fff0e8 !important;
    }

    body:has(form[action*="login"]) input[type="checkbox"] {
        width: 20px !important;
        height: 20px !important;
        border-radius: 7px !important;
        border-color: rgba(218, 170, 126, .75) !important;
        color: #ff8b59 !important;
        box-shadow: 0 8px 18px rgba(82, 49, 33, .06) !important;
    }

    body:has(form[action*="login"]) input[type="checkbox"]:checked {
        background-color: #ff8b59 !important;
        border-color: #ff8b59 !important;
    }

    body:has(form[action*="login"]) button[type="submit"],
    body:has(form[action*="login"]) .fi-btn-color-primary {
        min-height: 50px !important;
        border-radius: 15px !important;
        border: 0 !important;
        color: #ffffff !important;
        background:
            linear-gradient(135deg, #ffb35c 0%, #ff8b2d 42%, #ed5f16 100%) !important;
        box-shadow:
            0 16px 30px rgba(255, 139, 45, .28),
            inset 0 1px 0 rgba(255,255,255,.30) !important;
        font-size: 15px !important;
        font-weight: 900 !important;
        transition: .2s ease !important;
    }

    body:has(form[action*="login"]) button[type="submit"]:hover,
    body:has(form[action*="login"]) .fi-btn-color-primary:hover {
        transform: translateY(-1px) !important;
        box-shadow:
            0 21px 40px rgba(255, 139, 45, .35),
            inset 0 1px 0 rgba(255,255,255,.34) !important;
    }

    body:has(form[action*="login"]) .fi-alert,
    body:has(form[action*="login"]) .fi-fo-field-wrp-error-message {
        border-radius: 16px !important;
    }

    @media (max-width: 560px) {
        body:has(form[action*="login"]) .fi-simple-layout {
            padding: 14px !important;
        }

        body:has(form[action*="login"]) .fi-simple-main {
            width: calc(100vw - 24px) !important;
            border-radius: 24px !important;
        }

        body:has(form[action*="login"]) .fi-simple-page {
            padding: 28px 20px 24px !important;
        }

        body:has(form[action*="login"]) .fi-simple-header-heading,
        body:has(form[action*="login"]) h1 {
            font-size: 36px !important;
        }

        body:has(form[action*="login"]) .fi-logo {
            font-size: 15px !important;
            letter-spacing: .14em !important;
        }
    }
</style>
HTML);
    }

    private function registerLogoutActivityLogger(): void
    {
        static $registered = false;

        if ($registered) {
            return;
        }

        $registered = true;

        Event::listen(Logout::class, function (Logout $event): void {
            if (! $event->user instanceof Authenticatable) {
                return;
            }

            activity('access')
                ->causedBy($event->user)
                ->event('logout')
                ->withProperties([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Logout');
        });
    }

}