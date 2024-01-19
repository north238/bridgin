FROM php:8.2-fpm
EXPOSE 5173
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y --fix-missing \
        npm \
        nodejs \
        zlib1g-dev \
        mariadb-client \
        vim \
        libzip-dev \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install \
    zip \
    pdo_mysql

#Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www/html

RUN composer global require laravel/installer