<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register helpers
        require_once app_path('Helpers/Helper.php');
    }

    public function boot(): void
    {
        //
            Paginator::useBootstrapFive(); // or useBootstrapFour() if using Bootstrap 4

    }
}