#!/bin/sh
set -eu

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY non defini : generation d'une cle temporaire (definissez APP_KEY dans .env pour la conserver)." >&2
    APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
    export APP_KEY
fi

php artisan config:clear >/dev/null 2>&1 || true
php artisan route:clear >/dev/null 2>&1 || true
php artisan view:clear >/dev/null 2>&1 || true
php artisan package:discover --ansi

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    # La base peut accepter les connexions quelques secondes apres le healthcheck :
    # on retente les migrations au lieu d'arreter le conteneur a la premiere erreur.
    attempts=0
    max_attempts="${DB_WAIT_ATTEMPTS:-30}"
    until php artisan migrate --force; do
        attempts=$((attempts + 1))
        if [ "$attempts" -ge "$max_attempts" ]; then
            echo "Base de donnees injoignable (${DB_CONNECTION:-?} sur ${DB_HOST:-?}:${DB_PORT:-?}) apres $attempts tentatives." >&2
            exit 1
        fi
        echo "Base de donnees pas encore prete (${DB_HOST:-?}:${DB_PORT:-?}), nouvelle tentative $attempts/$max_attempts dans 2s..." >&2
        sleep 2
    done
fi

exec "$@"
