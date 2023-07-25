<?php

namespace Vextor\VextorNovaTheme;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Nova::theme(asset('/vextor/vextor-nova-theme/theme.css'));

        Nova::style('custom', public_path('vextor/vextor-nova-theme/theme.css'));

        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vextor/vextor-nova-theme'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
