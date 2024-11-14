# Usar la imagen base de PHP
FROM php:8.0-apache

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Instalar dependencias necesarias (MySQL y PDO)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar el código fuente al contenedor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80
