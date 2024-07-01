FROM php:8.2-fpm

# 開発環境でViteに接続するため
EXPOSE 5173

RUN apt-get update \
    && apt-get install -y --fix-missing \
        zlib1g-dev \
        mariadb-client \
        vim \
        git \
        libzip-dev \
    &&  pecl install redis \
    && docker-php-ext-enable redis

# xdebag install
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install \
    zip \
    pdo_mysql

# Composer install 2.7.2
COPY --from=composer:2.7.2 /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Nodejs install 18.19
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - &&\
    apt-get install -y nodejs

# Clear cache
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Wsl上で動かすためにユーザー名を追加
RUN useradd -m f-kitayama

WORKDIR /var/www/html

COPY . ./
COPY php.ini /usr/local/etc/php/

RUN chown -R www-data:www-data /var/www \
    chomd 777 -R /var/www