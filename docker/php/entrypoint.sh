#!/bin/sh
set -e

cd /var/www

CONTAINER_ROLE="${CONTAINER_ROLE:-app}"
WAIT_FOR_DB="${WAIT_FOR_DB:-true}"
AUTO_MIGRATE="${AUTO_MIGRATE:-false}"
AUTO_SEED="${AUTO_SEED:-false}"
AUTO_OPTIMIZE="${AUTO_OPTIMIZE:-true}"
AUTO_STORAGE_LINK="${AUTO_STORAGE_LINK:-true}"

to_lower() {
  echo "$1" | tr '[:upper:]' '[:lower:]'
}

is_true() {
  [ "$(to_lower "$1")" = "true" ]
}

wait_for_db() {
  if ! is_true "$WAIT_FOR_DB"; then
    return
  fi

  if [ -z "${DB_HOST}" ] || [ -z "${DB_PORT}" ]; then
    return
  fi

  echo "Waiting for database ${DB_HOST}:${DB_PORT}..."
  ATTEMPT=0
  MAX_ATTEMPTS=40
  until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'ok'; } catch (Throwable $e) { exit(1); }" >/dev/null 2>&1; do
    ATTEMPT=$((ATTEMPT + 1))
    if [ "$ATTEMPT" -ge "$MAX_ATTEMPTS" ]; then
      echo "Database is not ready after ${MAX_ATTEMPTS} attempts."
      exit 1
    fi
    sleep 3
  done
  echo "Database is ready."
}

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

# Run one-time app init tasks on app container only
if [ "$CONTAINER_ROLE" = "app" ]; then
  wait_for_db

  if is_true "$AUTO_MIGRATE"; then
    php artisan migrate --force || true
  fi

  if is_true "$AUTO_SEED"; then
    php artisan db:seed --force || true
  fi

  if is_true "$AUTO_STORAGE_LINK"; then
    php artisan storage:link || true
  fi

  if is_true "$AUTO_OPTIMIZE"; then
    if [ "${APP_ENV}" = "production" ]; then
      php artisan optimize || true
    else
      php artisan optimize:clear || true
    fi
  fi
fi

# Start PHP-FPM
exec "$@"
