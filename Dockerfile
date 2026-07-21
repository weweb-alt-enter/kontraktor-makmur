FROM php:8.4-apache

# ============================================
# 1. INSTALL SYSTEM DEPENDENCIES
# ============================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libssl-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ============================================
# 2. INSTALL PHP EXTENSIONS
# ============================================
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# ============================================
# 3. INSTALL COMPOSER
# ============================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ============================================
# 4. INSTALL NODE.JS 18
# ============================================
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10.8.2 \
    && node --version \
    && npm --version

# ============================================
# 5. ENABLE APACHE MOD_REWRITE
# ============================================
RUN a2enmod rewrite

# ============================================
# 6. SET WORKING DIRECTORY
# ============================================
WORKDIR /var/www/html

# ============================================
# 7. COPY SEMUA FILE
# ============================================
COPY . .

# ============================================
# 8. REMOVE LOCAL VENDOR & NODE_MODULES
# ============================================
RUN rm -rf vendor node_modules

# ============================================
# 9. INSTALL COMPOSER (TANPA SCRIPTS)
# ============================================
RUN composer config --no-plugins allow-plugins true \
    && composer install --no-interaction --optimize-autoloader --no-dev --no-scripts \
    --ignore-platform-req=php --ignore-platform-req=ext-* \
    && composer dump-autoload --optimize

# ============================================
# 10. INSTALL NPM & BUILD ASSETS
# ============================================
RUN echo "=== INSTALLING NPM PACKAGES ===" \
    && npm install \
    && echo "=== BUILDING ASSETS WITH VITE ===" \
    && npm run build \
    && echo "=== BUILD COMPLETE ===" \
    && rm -rf node_modules

# ============================================
# 11. BUAT .env SEMENTARA (PAKAI ENVIRONMENT VARIABLES)
# ============================================
RUN echo "APP_ENV=production" > .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_KEY=base64:$(openssl rand -base64 32)" >> .env && \
    echo "DB_CONNECTION=${DB_CONNECTION}" >> .env && \
    echo "DB_HOST=${DB_HOST}" >> .env && \
    echo "DB_PORT=${DB_PORT}" >> .env && \
    echo "DB_DATABASE=${DB_DATABASE}" >> .env && \
    echo "DB_USERNAME=${DB_USERNAME}" >> .env && \
    echo "DB_PASSWORD=${DB_PASSWORD}" >> .env && \
    echo "DB_SSL_MODE=${DB_SSL_MODE}" >> .env && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "CACHE_DRIVER=file" >> .env && \
    echo "QUEUE_CONNECTION=sync" >> .env

# ============================================
# 12. RUN POST-AUTOLOAD-DUMP SCRIPTS
# ============================================
RUN composer run-script post-autoload-dump

# ============================================
# 13. SETUP STORAGE
# ============================================
RUN mkdir -p storage/app/public \
    storage/app/private \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/framework/testing \
    storage/logs \
    bootstrap/cache \
    public/storage \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# ============================================
# 14. STORAGE LINK
# ============================================
RUN rm -rf public/storage \
    && php artisan storage:link

# ============================================
# 15. GENERATE APP_KEY
# ============================================
RUN php artisan key:generate --force

# ============================================
# 16. OPTIMASI LARAVEL
# ============================================
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# ============================================
# 17. HAPUS .env (AMAN)
# ============================================
RUN rm -f .env

# ============================================
# 18. CONFIGURE APACHE
# ============================================
RUN echo '<VirtualHost *:8080>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options -Indexes +FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

# ============================================
# 19. HEALTH CHECK
# ============================================
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD curl -f http://localhost:8080/health || exit 1

# ============================================
# 20. EXPOSE PORT
# ============================================
EXPOSE 8080

# ============================================
# 21. START APACHE
# ============================================
CMD ["apache2-foreground"]