#!/bin/bash

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# DEBUGBAR_DIR="storage/debugbar"
# VIEWS_DIR="storage/framework/views"

# find $DEBUGBAR_DIR -type f ! -name '.gitignore' -exec rm -f {} +
# find $VIEWS_DIR -type f ! -name '.gitignore' -exec rm -f {} +