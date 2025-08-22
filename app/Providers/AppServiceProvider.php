<?php

namespace App\Providers;

use App\Models\SchoolInformation;
use App\Observers\SchoolInformationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the SchoolInformation observer
        SchoolInformation::observe(SchoolInformationObserver::class);
        
        // Set the default string length for MySQL
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}
