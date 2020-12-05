<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Carbon;

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
        setlocale(LC_TIME, config('app.locale'));
        Carbon::setLocale(config('app.locale'));
        Blade::component('textarea', \App\View\Components\Forms\Textarea::class);
        Blade::component('select', \App\View\Components\Forms\Select::class);
    }
}
