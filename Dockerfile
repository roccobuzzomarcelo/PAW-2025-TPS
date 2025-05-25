# Imagen base con PHP
FROM php:8.4-cli

WORKDIR /var/www/html

# Instalar dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql

# Copiamos el código al contenedor
COPY . .

# Instalar Composer (desde imagen oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias del proyecto
RUN composer install

# Exponer el puerto que usará el servidor embebido
EXPOSE 8888

# Comando para correr el servidor PHP embebido
CMD ["php", "-S", "0.0.0.0:8888", "-t", "public"]
