<?php

namespace App\Providers\Filament;

use App\Models\TenantOrganization;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\Platform;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class OrganizationPanelProvider extends PanelProvider
{
    /**
     * @throws \Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->spa()
            ->id('organization')
            ->path('')
            ->login()
//            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->defaultThemeMode(ThemeMode::Light)
            ->brandLogoHeight('4rem')
            ->favicon(asset('images/logo-default.svg'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->font('Ubuntu')
            ->viteTheme('resources/css/filament/theme.css')
            ->discoverResources(in: app_path('Filament/Organization/Resources'), for: 'App\\Filament\\Organization\\Resources')
            ->discoverPages(in: app_path('Filament/Organization/Pages'), for: 'App\\Filament\\Organization\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Organization/Widgets'), for: 'App\\Filament\\Organization\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //                Widgets\FilamentInfoWidget::class,
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
            ->tenant(TenantOrganization::class, slugAttribute: 'slug')
            ->renderHook(
                PanelsRenderHook::TOPBAR_START,
                fn () => view('tenant-menu'),
            )
            ->tenantMenu(false)
            ->unsavedChangesAlerts()
            ->databaseTransactions()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->sidebarCollapsibleOnDesktop()
            ->globalSearch()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldSuffix(fn (): ?string => match (Platform::detect()) {
                Platform::Windows, Platform::Linux => 'CTRL+K',
                Platform::Mac => '⌘K',
                default => null,
            })
            ->plugins([
                GlobalSearchModalPlugin::make(),
                BreezyCore::make()
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
                        requiresCurrentPassword: true, // when false, the user can update their password without entering their current password. (default = true)
                    )
                    ->avatarUploadComponent(fn ($fileUpload) => $fileUpload->disableLabel())
                    ->enableSanctumTokens()
                    ->enableTwoFactorAuthentication(
                        force: false,
                    )
                    ->myProfile(
                        hasAvatars: true,
                        navigationGroup: 'Settings',
                    ),
            ]);
    }
}
