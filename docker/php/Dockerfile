FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
zlib1g-dev git libzip-dev unzip

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install zip

WORKDIR /app

COPY ./ /app