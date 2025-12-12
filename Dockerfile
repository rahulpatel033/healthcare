FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip curl libzip-dev \
    procps \
    && docker-php-ext-install zip pdo_mysql

COPY --from=composer:2.9.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Add this line to install trusted keys
RUN mkdir -p /root/.composer \
    && curl -sS https://getcomposer.org/keys.dev.pub -o /root/.composer/keys.dev.pub \
    && curl -sS https://getcomposer.org/keys.tags.pub -o /root/.composer/keys.tags.pub

RUN composer install --optimize-autoloader \
    && composer dump-autoload \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && php artisan key:generate \
    && php artisan optimize

