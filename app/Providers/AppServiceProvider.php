<?php

namespace App\Providers;

use App\Models\EventType;
use App\Models\Location;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $view->with('globalLocations', Location::all());
            $view->with('globalEventTypes', EventType::all());
        });
        Paginator::useBootstrap();
    }
}
