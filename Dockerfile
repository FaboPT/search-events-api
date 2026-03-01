FROM php:8.5-fpm
RUN apt update -y && apt install -y libzip-dev libpng-dev
RUN docker-php-ext-install pdo_mysql gd zip opcache
