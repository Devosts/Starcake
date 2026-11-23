<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share cart count and site-wide settings with every view
        View::composer('*', function ($view) {
            $cartCount = collect(session('cart', []))
                ->sum(fn ($item) => $item['quantity'] ?? 0);

            $settings = Cache::remember('settings_all', 3600, function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            $view->with(compact('cartCount', 'settings'));
        });

    }
}
