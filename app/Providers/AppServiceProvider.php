<?php

namespace App\Providers;

use App\Models\Employee;

use App\Observers\EmployeeObserver;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton('valuestore', function () {
        //     return \Spatie\Valuestore\Valuestore::make(storage_path('app/settings.json'));
        // });
        // $values = $this->app->valuestore->all();
        // $this->app->bind('settings', function () use($values) {
        //     return $values;
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //register observers
        Employee::observe(EmployeeObserver::class);
    }
}
