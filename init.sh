#!/bin/bash

composer update
composer install
cp .env.example .env
php artisan key:generate