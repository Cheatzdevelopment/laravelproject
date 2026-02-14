<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // បន្ថែមបន្ទាត់នេះ

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // បន្ថែមបន្ទាត់ខាងក្រោមនេះ
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}