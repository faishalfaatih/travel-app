<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
        // Aktifkan HTTPS jika menggunakan secure connection
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Atur CORS agar mengizinkan akses frontend
        Route::middleware('cors')->group(function () {
            // Tambahkan rute API di sini jika perlu
        });
    }
}
