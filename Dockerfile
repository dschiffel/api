FROM php:7-fpm

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

WORKDIR /app/api
RUN cd /app/api && /usr/local/bin/php ./bin/console doctrine:migrations:migrate --no-interaction