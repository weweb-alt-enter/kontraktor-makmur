<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class StorageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ============================================
        // CUSTOM STORAGE MACRO
        // ============================================
        
        Storage::macro('getFullUrl', function ($path) {
            $disk = $this;
            
            if ($disk->getDriver() instanceof \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary) {
                return $disk->url($path);
            }
            
            return $disk->url($path);
        });
    }
}