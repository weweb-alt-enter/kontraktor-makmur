<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ============================================
        // FORCE HTTPS UNTUK PRODUCTION
        // ============================================
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Hanya jalankan jika menggunakan SQLite
        if (config('database.default') === 'sqlite') {
            try {
                DB::statement('PRAGMA journal_mode=WAL;');
                DB::statement('PRAGMA synchronous=NORMAL;');
            } catch (\Exception $e) {
                // Ignore
            }
        }

        date_default_timezone_set('Asia/Jakarta');
    }
}