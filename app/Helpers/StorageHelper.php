<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageHelper
{
    /**
     * Upload file ke storage (local atau cloud)
     */
    public static function upload($file, $path = '', $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        
        // Generate unique filename
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        
        // Upload ke disk yang dipilih
        $storedPath = Storage::disk($disk)->putFileAs($path, $file, $filename);
        
        // Get URL
        $url = self::getFullUrl($storedPath, $disk);
        
        return [
            'disk' => $disk,
            'path' => $storedPath,
            'filename' => $filename,
            'url' => $url,
        ];
    }

    /**
     * Upload multiple files
     */
    public static function uploadMultiple($files, $path = '', $disk = null)
    {
        $results = [];
        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $results[] = self::upload($file, $path, $disk);
            }
        }
        return $results;
    }

    /**
     * Get full URL dari file (support Cloudinary)
     */
    public static function getFullUrl($path, $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        
        if (empty($path)) {
            return null;
        }
        
        try {
            if ($disk === 'cloudinary') {
                $cloudName = config('filesystems.disks.cloudinary.cloud');
                return "https://res.cloudinary.com/{$cloudName}/image/upload/" . $path;
            }
            return Storage::disk($disk)->url($path);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get URL dari file dengan transformasi Cloudinary
     */
    public static function getOptimizedUrl($path, $width = 800, $height = 600, $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        
        if (empty($path)) {
            return null;
        }
        
        if ($disk === 'cloudinary') {
            $cloudName = config('filesystems.disks.cloudinary.cloud');
            return "https://res.cloudinary.com/{$cloudName}/image/upload/c_fill,w_{$width},h_{$height}/" . $path;
        }
        
        return Storage::disk($disk)->url($path);
    }

    /**
     * Delete file dari storage
     */
    public static function delete($path, $disk = null)
    {
        if (empty($path)) {
            return false;
        }
        
        $disk = $disk ?? config('filesystems.default');
        
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        
        return false;
    }

    /**
     * Delete multiple files
     */
    public static function deleteMultiple($paths, $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        $deleted = [];
        
        foreach ($paths as $path) {
            if (self::delete($path, $disk)) {
                $deleted[] = $path;
            }
        }
        
        return $deleted;
    }

    /**
     * Get all files dari folder
     */
    public static function getFiles($directory, $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        return Storage::disk($disk)->files($directory);
    }

    /**
     * Check apakah file exists
     */
    public static function exists($path, $disk = null)
    {
        $disk = $disk ?? config('filesystems.default');
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Check apakah menggunakan Cloudinary
     */
    public static function isCloudinary()
    {
        return config('filesystems.default') === 'cloudinary';
    }

    /**
     * Check apakah menggunakan Local
     */
    public static function isLocal()
    {
        return config('filesystems.default') === 'public' || config('filesystems.default') === 'local';
    }

    /**
     * Get disk name berdasarkan config
     */
    public static function getCurrentDisk()
    {
        return config('filesystems.default');
    }
}