#!/usr/bin/env bash
set -e

cd /var/www

# Ensure writable dirs (best-effort for bind mounts)
mkdir -p storage bootstrap/cache
chmod -R 777 storage bootstrap/cache || true

# Ensure .env exists
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
  else
    touch .env
  fi
fi

# Install PHP deps if needed
if [ ! -d vendor ]; then
  composer install --no-interaction
fi

# Generate APP_KEY if missing/empty
if ! grep -qE '^APP_KEY=.+$' .env; then
  php artisan key:generate --force || true
fi

# Dev/prod caching behavior
if [ "${APP_ENV}" = "production" ]; then
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
else
  php artisan optimize:clear || true
fi

# Start PHP-FPM
exec "$@"
