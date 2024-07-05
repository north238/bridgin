#!/bin/bash

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
php artisan migrate:refresh --seed

# nodejsをセットアップ
npm cache clear --force
npm install