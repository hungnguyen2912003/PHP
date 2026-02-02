FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    linux-headers \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl opcache zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install dependencies (no scripts yet because code isn't copied)
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy application code
COPY . .

# Generate autoload files and run scripts
RUN composer dump-autoload --optimize && php artisan package:discover

# Set permissions
RUN chown -R www-data:www-data /var/www
