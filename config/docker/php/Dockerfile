FROM php:fpm-alpine

RUN apk update \
    && apk add --no-cache git mysql-client postgresql-dev curl openssh-client icu libpng libjpeg-turbo libzip-dev \
    && apk add --no-cache --virtual build-dependencies icu-dev libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .phpize-deps-configure \
    && docker-php-source delete \
    && docker-php-ext-install opcache mysqli pdo pdo_mysql pgsql pdo_pgsql soap intl zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apk del build-dependencies \
    && rm -rf /tmp/*