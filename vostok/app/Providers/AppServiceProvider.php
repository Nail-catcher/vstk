<?php

namespace App\Providers;

use App\Models\LogMagazine;
use App\Observers\LogObserver;
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
        LogMagazine::observe(LogObserver::class);
    }
}
