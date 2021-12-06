FROM rushlowdev/php-cli:8.0-cli

USER 0:0

RUN pecl install xdebug

RUN find /usr/local/lib/php -name "xdebug.so" -exec echo 'zend_extension="{}"' >> /usr/local/etc/php/php.ini \;

COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

USER 1000:1000
