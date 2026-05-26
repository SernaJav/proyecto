FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Variables de entorno
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Variables específicas para Laravel en producción
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Permitimos que Composer se ejecute como root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Instalar dependencias de PHP y PostgreSQL
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql pgsql

# Instalar dependencias de Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Optimizar Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Comando para iniciar el servidor
CMD ["/start.sh"]