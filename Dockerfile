# Usamos la imagen oficial de Render para PHP y Laravel
FROM richarvey/nginx-php-fpm:3.1.6

# Copiamos todo nuestro proyecto al contenedor
COPY . .

# Configuramos las variables de entorno para el contenedor
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

# Comando para iniciar el servidor
CMD ["/start.sh"]