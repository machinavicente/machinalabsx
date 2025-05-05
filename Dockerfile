FROM php:8.2-apache

# Instala los drivers de PostgreSQL
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Copia tu aplicación al directorio web
COPY . /var/www/html/

# Establece permisos correctos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
