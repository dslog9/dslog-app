#!/bin/bash
set -e

cd /var/www

echo "=== DEPLOY START $(date) ==="

git pull origin main
composer install --no-dev --optimize-autoloader

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan migrate --force

echo "=== DEPLOY DONE $(date) ==="
