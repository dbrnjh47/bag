<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibrary;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                // 'danger' => Color::Rose,
                // 'gray' => Color::Gray,
                // 'info' => Color::Blue,
                // 'primary' => Color::Indigo,
                // 'success' => Color::Emerald,
                // 'warning' => Color::Orange,
            ])
            ->brandName('Bappler Admin Panel')
            ->maxContentWidth(MaxWidth::Full)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //Pages\Dashboard::class,
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
            ->plugins([FilamentMediaLibrary::make(),
                FilamentFullCalendarPlugin::make()
                ->editable()
                // ->plugins(['scrollGrid', 'adaptive'])
                ->plugins(['interaction'])
                ->config([
                    'locale' => config('app.locale'),
                    'dayMaxEvents'=> true,
                    'droppable' => true,
                ])

            ]);
    }

    public function boot(): void
    {
        // https://filamentphp.com/docs/2.x/admin/navigation#registering-custom-navigation-items
        // Filament::serving(function () {
        //     Filament::registerNavigationGroups([
        //         NavigationGroup::make()
        //              ->label('IT')
        //              ->icon('heroicon-s-shopping-cart'),
        //         NavigationGroup::make()
        //             ->label('Media'),

        //     ]);
        // });
    }
}
