FROM dunglas/frankenphp:php8.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN install-php-extensions gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /app

WORKDIR /app

# Install composer dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Build assets (if you have frontend assets)
RUN npm install && npm run build

# Setup Laravel caches
RUN php artisan config:cache && \
    php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache