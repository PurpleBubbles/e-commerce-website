FROM php:8.5-apache-trixie

WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer:2.11.1 /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions xdebug pdo pdo_mysql
