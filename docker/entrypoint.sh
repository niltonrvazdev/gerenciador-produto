#!/bin/sh

echo "🚀 Iniciando Laravel no Docker..."

# Aguarda o banco (se você tiver healthcheck no mysql, isso já resolve)
echo "⏳ Aguardando MySQL..."

# Instala dependências PHP
if [ ! -d "vendor" ]; then
  echo "📦 Rodando composer install..."
  composer install --no-interaction --prefer-dist
fi

# Instala dependências Node
if [ ! -d "node_modules" ]; then
  echo "📦 Rodando npm install..."
  npm install
fi

# Build do Vite
echo "⚡ Rodando build do Vite..."
npm run build

# Gera a key do Laravel
if ! grep -q "APP_KEY=base64" .env; then
  echo "🔑 Gerando APP_KEY..."
  php artisan key:generate
fi

# ===============================
# PERMISSÕES PARA STORAGE
# ===============================
echo "🗄️ Ajustando permissões de pastas..."

mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public

chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Link simbólico para imagens públicas
if [ ! -L "public/storage" ]; then
  echo "🔗 Criando storage:link..."
  php artisan storage:link
fi

# ===============================
# Migrations e Seed
# ===============================
echo "🗄️ Rodando migrations..."
php artisan migrate --force

echo "🌱 Rodando seed..."
php artisan db:seed --force

echo "✅ Laravel pronto!"

exec "$@"
