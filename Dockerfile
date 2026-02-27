FROM dunglas/frankenphp:php8.2

# Install system dependencies including Node.js
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
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

# Install npm dependencies
RUN npm ci

# Build assets
RUN npm run build

# Setup Laravel caches
RUN php artisan config:cache && \
    php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 8080
EXPOSE 8080

# Start the application on port 8080
CMD php artisan serve --host=0.0.0.0 --port=8080