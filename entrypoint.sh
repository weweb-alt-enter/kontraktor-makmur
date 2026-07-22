#!/bin/bash

echo "=== ENTRYPOINT START ==="

# Buat .env dari environment variables
echo "APP_ENV=${APP_ENV}" > .env
echo "APP_DEBUG=${APP_DEBUG}" >> .env
echo "APP_KEY=${APP_KEY}" >> .env
echo "APP_URL=${APP_URL}" >> .env
echo "ASSET_URL=${APP_URL}" >> .env
echo "DB_CONNECTION=${DB_CONNECTION}" >> .env
echo "DB_HOST=${DB_HOST}" >> .env
echo "DB_PORT=${DB_PORT}" >> .env
echo "DB_DATABASE=${DB_DATABASE}" >> .env
echo "DB_USERNAME=${DB_USERNAME}" >> .env
echo "DB_PASSWORD=${DB_PASSWORD}" >> .env
echo "DB_SSL_MODE=${DB_SSL_MODE}" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "CACHE_DRIVER=file" >> .env
echo "QUEUE_CONNECTION=sync" >> .env
echo "FILESYSTEM_DISK=${FILESYSTEM_DISK}" >> .env
echo "CLOUDINARY_URL=${CLOUDINARY_URL}" >> .env
echo "CLOUDINARY_KEY=${CLOUDINARY_KEY}" >> .env
echo "CLOUDINARY_SECRET=${CLOUDINARY_SECRET}" >> .env
echo "CLOUDINARY_CLOUD_NAME=${CLOUDINARY_CLOUD_NAME}" >> .env
echo "CLOUDINARY_SECURE=true" >> .env
echo "CLOUDINARY_PREFIX=${CLOUDINARY_PREFIX}" >> .env

echo "=== .env FILE ==="
cat .env
echo "=================="

# Clear dan cache config (dengan HTTPS)
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link

# Start Apache
apache2-foreground