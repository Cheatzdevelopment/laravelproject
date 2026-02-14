<?php

namespace App\Providers;

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
// កែប្រែពី /home ទៅកាន់ Route ចម្បងរបស់អ្នក
public const HOME = '/cashier/dashboard';
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
