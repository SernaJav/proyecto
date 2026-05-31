FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    zip \
    libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default

RUN php artisan config:clear || true

EXPOSE 10000

CMD php artisan migrate --force || true && \
    service nginx start && \
    php-fpm -F