<?php

use App\Helpers\StorageHelper;

if (!function_exists('storage_url')) {
    /**
     * Get storage URL (support Cloudinary)
     */
    function storage_url($path, $disk = null)
    {
        if (empty($path)) {
            return null;
        }
        
        try {
            return StorageHelper::getFullUrl($path, $disk);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('cloudinary_url')) {
    /**
     * Get Cloudinary URL dengan transformasi
     */
    function cloudinary_url($path, $width = null, $height = null)
    {
        if (empty($path)) {
            return null;
        }
        
        if ($width && $height) {
            return StorageHelper::getOptimizedUrl($path, $width, $height);
        }
        
        return StorageHelper::getFullUrl($path);
    }
}