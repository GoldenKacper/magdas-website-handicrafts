# 1. Base image with PHP-FPM
FROM php:8.4.10-fpm-alpine3.22

# 2. Install system dependencies and PHP extensions
# Installing npm, database drivers, and other required tools
RUN apk update && apk add --no-cache \
    oniguruma-dev \
    libzip-dev \
    bash \
    shadow \
    autoconf \
    build-base \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# 3. Set working directory
WORKDIR /var/www/html

# 4. Copy application code (will be overridden by volumes at runtime)
COPY --chown=www-data:www-data src/website-handicrafts/ /var/www/html

# 5. Create necessary directories and set permissions
RUN mkdir -p storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 6. Install JavaScript dependencies
RUN npm install

# 7. Expose port and start PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
