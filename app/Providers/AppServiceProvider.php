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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // HAPUS ATAU KOMENTAR baris ini:
        // \Illuminate\Support\Facades\DB::statement('PRAGMA journal_mode=WAL;');
        // \Illuminate\Support\Facades\DB::statement('PRAGMA synchronous=NORMAL;');
        
        // Atau ganti dengan ini (hanya jalan di SQLite):
        // if (config('database.default') === 'sqlite') {
        //     \Illuminate\Support\Facades\DB::statement('PRAGMA journal_mode=WAL;');
        //     \Illuminate\Support\Facades\DB::statement('PRAGMA synchronous=NORMAL;');
        // }
    }
}