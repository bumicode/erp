<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Accounting\PaymentTermTemplatesResource;
use App\Filament\Resources\Accounting\SalesInvoiceResource;
use App\Filament\Resources\Common\CountryResource;
use App\Filament\Resources\Common\CurrencyResource;
use App\Filament\Resources\Common\TimezoneResource;
use App\Filament\Resources\CRM\AddressResource;
use App\Filament\Resources\CRM\ContactResource;
use App\Filament\Resources\Selling\CustomerGroupResource;
use App\Filament\Resources\Selling\CustomerResource;
use App\Filament\Resources\Selling\QuotationResource;
use App\Filament\Resources\Selling\SalesOrderResource;
use App\Filament\Resources\Selling\SalesPersonResource;
use App\Filament\Resources\Selling\TargetResource;
use App\Filament\Resources\Selling\TerritoryResource;
use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\Stock\ItemGroupResource;
use App\Filament\Resources\Stock\ItemResource;
use App\Filament\Resources\Stock\PriceListResource;
use App\Filament\Resources\Stock\UomResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
//            ->authGuard('customers')
            ->plugins([
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 2,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: false,
                        navigationGroup: 'Settings'
                    )
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)],
                        requiresCurrentPassword: true,
                    )
                    ->enableTwoFactorAuthentication(
                        force: false, // force the user to enable 2FA before they can use the application (default = false)
                    )
                    ->customMyProfilePage(MyProfilePage::class),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Dashboard::getUrl()),
                ])
                    ->groups([
                        NavigationGroup::make('Accounting')
                            ->items([
                                ...SalesInvoiceResource::getNavigationItems(),
                                ...PaymentTermTemplatesResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('CRM')
                            ->items([
                                ...AddressResource::getNavigationItems(),
                                ...ContactResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Selling')
                            ->items([
                                ...CustomerResource::getNavigationItems(),
                                ...CustomerGroupResource::getNavigationItems(),
                                ...QuotationResource::getNavigationItems(),
                                ...SalesOrderResource::getNavigationItems(),
                                ...SalesPersonResource::getNavigationItems(),
                                ...TargetResource::getNavigationItems(),
                                ...TerritoryResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Stock')
                            ->items([
                                ...ItemResource::getNavigationItems(),
                                ...ItemGroupResource::getNavigationItems(),
                                ...PriceListResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Master Data')
                            ->icon('heroicon-o-circle-stack')
                            ->items([
                                ...CountryResource::getNavigationItems(),
                                ...CurrencyResource::getNavigationItems(),
                                ...TimezoneResource::getNavigationItems(),
                                ...UomResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('User Management')
                            ->items([
                                ...UserResource::getNavigationItems(),
                                ...RoleResource::getNavigationItems(),
                            ]),
                    ]);
            })
            ->userMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->url(fn (): string => MyProfilePage::getUrl())
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->databaseNotifications();
    }
}
