FROM php:8.2.14-fpm

RUN apt-get update && apt-get install -y \
        cron \
        git \
        libzip-dev \
        zip \
        unzip \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libfreetype6-dev \
        libicu-dev \
    && docker-php-ext-configure gd \
            --with-webp \
            --with-jpeg \
            --with-freetype \
    && docker-php-ext-configure intl \
	&& docker-php-ext-install \
	     zip \
	     bcmath \
	     gd \
	     mysqli \
	     pdo_mysql \
	     intl \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Установка Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html

COPY run-deamons.sh /run-deamons.sh

ENTRYPOINT /bin/bash /run-deamons.sh
