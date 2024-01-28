FROM php:8.2-fpm
EXPOSE 5173
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y --fix-missing \
        zlib1g-dev \
        mariadb-client \
        vim \
        libzip-dev \
    &&  pecl install redis \
    && docker-php-ext-enable redis

RUN docker-php-ext-install \
    zip \
    pdo_mysql 

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require laravel/installer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Nodejs install
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - &&\
    apt-get install -y nodejs

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www