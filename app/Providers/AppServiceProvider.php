<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Safemood\Discountify\Facades\Condition;

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
    public function boot()
    {
        // Define a placeholder discount condition that always applies
        Condition::define('category_discount', function (array $items) {
            return true;
        }, 0);  // Placeholder discount value
    }
}
