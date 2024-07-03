#!/bin/bash

# install高速化
composer global require hirak/prestissimo
composer install --optimize-autoloader --no-dev
cp .env.example .env

# APP_KEY生成
php artisan key:generate

# キャッシュクリア
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# マイグレーション（リセットしてから）
php artisan migrate:refresh

# nodejsをセットアップ
npm cache clear --force
npm install