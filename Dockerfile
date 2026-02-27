FROM dunglas/frankenphp:php8.2

# Install GD extension
RUN install-php-extensions gd

# Copy application
COPY . /app

WORKDIR /app

# Install composer dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Build assets
RUN npm install && npm run build

# Setup Laravel
RUN php artisan config:cache && \
    php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache