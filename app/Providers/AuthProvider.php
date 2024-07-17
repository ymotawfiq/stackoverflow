<?php

namespace App\Providers;

use App\Services\auth_service\auth_service;
use App\Services\auth_service\auth_service_interface;
use Illuminate\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
