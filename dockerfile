FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Permissions (optionnel)
RUN chown -R www-data:www-data /var/www/html
