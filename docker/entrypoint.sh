#!/bin/sh
set -e

# Install PHP dependencies
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist
fi

# Install Node dependencies
if [ ! -d "node_modules" ]; then
  npm install
fi

# Build frontend assets
npm run build

# Ensure env exists
if [ ! -f ".env" ]; then
  exit 1
fi

# Generate app key if missing
if ! grep -q "APP_KEY=base64" .env; then
  php artisan key:generate
fi

# Prepare storage
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/app/public

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Storage link
if [ ! -L "public/storage" ]; then
  php artisan storage:link
fi

# Database
php artisan migrate --force
php artisan db:seed --force

exec "$@"
