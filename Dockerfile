FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    zip \
    libpq-dev

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Carpeta app
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos Laravel
RUN chmod -R 777 storage bootstrap/cache

# Config nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Limpiar cache
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Migraciones automáticas
RUN php artisan migrate --force || true

# Cache producción
RUN php artisan config:cache

# Puerto render
EXPOSE 10000

# Inicio
CMD service nginx start && php-fpm -F