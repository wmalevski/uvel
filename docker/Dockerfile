# FROM php:7.3-apache-buster AS base
FROM php:8.3-rc-apache-buster AS base

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC
ENV npm_config_cache=/tmp/.npm

ARG WWWUSER
ARG NODE_VERSION=20

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libtiff-dev \
    libonig-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) \
    opcache \
    mysqli \
    pdo_mysql \
    gd \
    bcmath \
    zip \
    intl \
    && curl -sL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Modify the default VirtualHost configuration
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Adding php ini configuration after composer because we've blocked url_fopen in php.ini
COPY ./docker/php.ini /usr/local/etc/php/

# Adding opcache configuration
COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/20-opcache.ini

# Enable mod_rewrite
RUN a2enmod rewrite

FROM base AS builder

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html

RUN usermod -u ${WWWUSER} www-data \
    && groupmod -g ${WWWUSER} www-data;

COPY --chown=www-data:www-data . .

USER www-data
