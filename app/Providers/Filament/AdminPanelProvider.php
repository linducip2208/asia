<?php

namespace App\Providers\Filament;

use App\Models\Tenant;
use App\Services\FeatureToggleService;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(function () {
                $tenant = $this->getTenant();
                return $tenant ? $tenant->name : config('app.name', 'ERPAsia');
            })
            ->brandLogo(function () {
                $tenant = $this->getTenant();
                if ($tenant && $tenant->logo_url) {
                    return new HtmlString('<img src="' . $tenant->logo_url . '" alt="Logo" style="height:2rem">');
                }
                return null;
            })
            ->favicon(function () {
                $tenant = $this->getTenant();
                return $tenant && $tenant->favicon_url ? $tenant->favicon_url : '/favicon.svg';
            })
            ->colors([
                'primary' => function () {
                    $tenant = $this->getTenant();
                    $hex = $tenant->primary_color ?? '#3B82F6';
                    return Color::hex($hex);
                },
            ])
            ->darkMode(true)
            ->sidebarCollapsibleOnDesktop(true)
            ->sidebarWidth('16rem')
            ->collapsedSidebarWidth('4.5rem')
            ->databaseNotifications(true)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->navigationGroups([
                NavigationGroup::make('💰 Penjualan')->collapsed(false),
                NavigationGroup::make('🛒 Pembelian')->collapsed(true),
                NavigationGroup::make('📦 Inventory')->collapsed(false),
                NavigationGroup::make('🏭 Produksi')->collapsed(true),
                NavigationGroup::make('👥 Customer')->collapsed(true),
                NavigationGroup::make('🚚 Supplier')->collapsed(true),
                NavigationGroup::make('🏪 Outlet')->collapsed(true),
                NavigationGroup::make('💳 Keuangan')->collapsed(false),
                NavigationGroup::make('🎁 Promo')->collapsed(true),
                NavigationGroup::make('📈 Laporan')->collapsed(false),
                NavigationGroup::make('👨‍💼 Pegawai')->collapsed(true),
                NavigationGroup::make('🔔 Notifikasi')->collapsed(true),
                NavigationGroup::make('🔗 Integrasi')->collapsed(true),
                NavigationGroup::make('⚙️ Pengaturan')->collapsed(true),
                NavigationGroup::make('📰 Website')->collapsed(true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('POS Kasir')
                    ->url('/pos')
                    ->icon('heroicon-o-shopping-cart')
                    ->openUrlInNewTab()
                    ->sort(100)
                    ->visible(fn (): bool => auth()->check() && auth()->user()?->hasPermission('pos-access')),
            ]);
    }

    protected function getTenant(): ?Tenant
    {
        if (auth()->check() && auth()->user()?->tenant_id) {
            return \App\Models\Tenant::find(auth()->user()->tenant_id);
        }
        return null;
    }
}
