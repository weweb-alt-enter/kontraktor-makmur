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
    public function boot()
    {
        // Cache query untuk menghindari query berat di cold start
        \Illuminate\Support\Facades\DB::statement('PRAGMA journal_mode=WAL;');
        \Illuminate\Support\Facades\DB::statement('PRAGMA synchronous=NORMAL;');
    }
}
