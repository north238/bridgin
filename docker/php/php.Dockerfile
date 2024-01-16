FROM composer:latest AS composer
WORKDIR /app
COPY composer.json composer.lock /app/
RUN composer install --no-scripts --no-autoloader

FROM php:8-fpm-alpine
ENV PHPGROUP=laravel
ENV PHPUSER=laravel
RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
RUN sed -i "s/user = www-data = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf
RUN mkdir -p /var/www/html/public
COPY --from=composer /app/vendor /var/www/html/vendor
RUN apk add --no-cache zlib-dev mariadb-client vim \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
COPY ./app /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && npm install

RUN chmod -R 777 /var/www/html/storage

# シンボリックリンク
RUN php artisan storage:link

CMD ["php-fpm", "-F", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
