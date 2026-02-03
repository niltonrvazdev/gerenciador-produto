#!/bin/sh
set -e

cd /var/www/html

# Garante .env
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist
fi

if [ ! -d "node_modules" ]; then
  npm install
fi

npm run build

if ! grep -q "APP_KEY=base64" .env; then
  php artisan key:generate
fi

mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/app/public

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

if [ ! -L "public/storage" ]; then
  php artisan storage:link || true
fi

php artisan migrate --force || true
php artisan db:seed --force || true

echo "✅ PHP-FPM rodando em foreground"
exec php-fpm -F
