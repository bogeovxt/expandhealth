<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use App\Nova\User;
use App\Nova\Brand;
use App\Nova\Device;
use App\Nova\Devicetype;
use App\Nova\Employee;
use App\Nova\Subscription;
use App\Nova\Inventory;
use App\Nova\Subscriptiontype;

use App\Nova\Phone;
use App\Nova\Laptop;
use App\Nova\Desktop;
use App\Nova\Tablet;

use App\Nova\Usbstick;
use App\Nova\Projector;
use App\Nova\Monitor;

use App\Nova\Division;

use App\Nova\BankTransaction;

use Laravel\Nova\Dashboards\Main;

// use Laravel\Nova\Menu\Menu;
// use Laravel\Nova\Menu\MenuItem;
// use Laravel\Nova\Menu\MenuSection;

use NormanHuth\NovaMenu\MenuSection;
use NormanHuth\NovaMenu\MenuGroup;
use NormanHuth\NovaMenu\MenuItem;

use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

use Visanduma\NovaBackNavigation\NovaBackNavigation;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;

// use Acme\PriceTracker\PriceTracker;
use Anaseqal\NovaImport\NovaImport;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Nova::withoutThemeSwitcher();
        // Nova::withBreadcrumbs();


        Nova::mainMenu(function (Request $request) {
            return [

                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::resource(Inventory::class)->faIcon('fa-solid fa-table-list'),

                MenuSection::make('Echipamente', [
                    MenuItem::resource(Subscription::class)->faIcon('fa-solid fa-sim-card')->asLabel(),
                    MenuItem::resource(Phone::class)->faIcon('fa-solid fa-mobile-screen')->asLabel(),
                    MenuItem::resource(Laptop::class)->faIcon('fa-solid fa-laptop')->asLabel(),
                    MenuItem::resource(Desktop::class)->faIcon('fa-solid fa-computer')->asLabel(),
                    MenuItem::resource(Tablet::class)->faIcon('fa-solid fa-tablet-screen-button')->asLabel(),
                    MenuItem::resource(Usbstick::class)->faIcon('fa-solid fa-signal')->asLabel(),
                    MenuItem::resource(Projector::class)->faIcon('fa-solid fa-diagram-project')->asLabel(),
                    MenuItem::resource(Monitor::class)->faIcon('fa-solid fa-tv')->asLabel(),
                ])->faIcon('fa-solid fa-list-ol')->collapsable(),

                MenuSection::make('Nomenclatoare', [
                    MenuItem::resource(Brand::class),
                    MenuItem::resource(Device::class),
                    MenuItem::resource(Devicetype::class),
                    MenuItem::resource(Subscriptiontype::class),
                    MenuItem::resource(Division::class),
                ])->faIcon('fa-solid fa-gears')->collapsable(),

                MenuSection::make('Utilizatori', [
                    MenuItem::resource(User::class),
                ])->faIcon('fa-solid fa-users')->collapsable(),

                MenuSection::make('Deconturi', [
                    MenuItem::resource(Employee::class),
                    MenuItem::resource(BankTransaction::class),
                ])->faIcon('fa-solid fa-file-import')->collapsable(),

                // MenuSection::make('CSV Import')
                //     ->path('/csv-import')
                //     ->icon('upload'),

                // MenuSection::make('Logs')
                //     ->path('/logs')
                //     ->icon('sparkles'),
            ];
        });

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'bogdanchelaru@gmail.com',
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Stepanenko3\NovaMenuCollapsed\MenuCollapsed,
            \Laravel\Nova\LogViewer\LogViewer::make(),

            new NovaBackNavigation(),
            // new LaravelNovaCsvImport,


            // new NovaImport,

            // new PriceTracker,
        ];
    }

    public function card()
    {
        return [
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::initialPath('/resources/users');
    }
}
