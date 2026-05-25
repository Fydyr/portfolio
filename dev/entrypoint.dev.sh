#!/bin/bash
set -e

# Installe les dépendances composer (avec dev) si vendor est vide
if [ ! -f "/var/www/html/vendor/autoload.php" ]; then
    echo "[dev] vendor/ vide -> composer install"
    composer install --no-interaction --no-progress --working-dir=/var/www/html
    chown -R www-data:www-data /var/www/html/vendor
fi

# Réutilise la logique de génération de includes/db.php
exec /usr/local/bin/entrypoint.sh "$@"
