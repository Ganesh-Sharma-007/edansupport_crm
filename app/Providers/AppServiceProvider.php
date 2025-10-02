<?php

namespace App\Providers;

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
    }
}