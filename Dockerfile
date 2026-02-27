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
RUN install-php-extensions gd zip pdo_mysql

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

# Create storage directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Setup Laravel caches (without config:cache to avoid env issues)
RUN php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 8080
EXPOSE 8080

# Create a startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'php artisan config:clear' >> /start.sh && \
    echo 'php artisan cache:clear' >> /start.sh && \
    echo 'php artisan serve --host=0.0.0.0 --port=8080' >> /start.sh && \
    chmod +x /start.sh

# Start the application
CMD ["/start.sh"]