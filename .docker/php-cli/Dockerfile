ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-cli-alpine

RUN apk update && \
    apk add --no-cache bash && \
    apk add --no-cache $PHPIZE_DEPS

RUN pecl install xdebug

RUN docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql

RUN cp $(find /usr/local/etc/php -name "php.ini-development") /usr/local/etc/php/php.ini

RUN find /usr/local/lib/php -name "xdebug.so" -exec echo 'zend_extension="{}"' >> /usr/local/etc/php/php.ini \;

COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ARG XDEBUG_ENABLE
ARG XDEBUG_HOST
ARG XDEBUG_PORT
ARG XDEBUG_IDEKEY

RUN sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN sed -i "s/xdebug.remote_host=0.0.0.0/xdebug.remote_host=${XDEBUG_HOST}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN sed -i "s/xdebug.remote_port=9000/xdebug.remote_port=${XDEBUG_PORT}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN sed -i "s/xdebug.idekey=docker/xdebug.idekey=${XDEBUG_IDEKEY}/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

USER 1000:1000

WORKDIR /var/htdocs