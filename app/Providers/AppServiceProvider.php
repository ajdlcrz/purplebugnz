<?php

namespace App\Providers;

use App\Service;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['welcome', 'about', 'services', 'service'], function ($view) {
            /* $services = \Cache::rememberForever('services', function () {
                return Service::all();
            }); */

            $services = Service::orderBy('title')->get();

            $view->with('services', $services);
        });
    }
}
