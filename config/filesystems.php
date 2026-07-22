<?php

return [

    // ============================================
    // PAKSA KE CLOUDINARY
    // ============================================
    'default' => 'cloudinary',

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        // ============================================
        // CLOUDINARY DISK
        // ============================================
        'cloudinary' => [
            'driver' => 'cloudinary',
            'key' => '194547237432569',
            'secret' => 'PyKCPlj3IYyleaEJah8OLZVkbTk',
            'cloud' => 'dnmuqclt',
            'url' => 'cloudinary://194547237432569:PyKCPlj3IYyleaEJah8OLZVkbTk@dnmuqclt',
            'secure' => true,
            'prefix' => 'sekawanmakmur',
            'api_base_uri' => 'https://api.cloudinary.com/v1_1/',
            'api_upload_uri' => 'https://api.cloudinary.com/v1_1/',
            'cdn_uri' => 'https://res.cloudinary.com/',
        ],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];