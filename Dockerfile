FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    zip \
    libpq-dev

# Instalar extensiones PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio Laravel
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Configuración nginx
COPY nginx.conf /etc/nginx/sites-available/default

# SOLO limpiar config
RUN php artisan config:clear || true

# Puerto Render
EXPOSE 10000

# Iniciar Laravel + migraciones automáticas
CMD php artisan migrate --force || true && \
    service nginx start && \
    php-fpm -F