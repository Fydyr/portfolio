#!/bin/bash
set -e

# Note: includes/db.php lit ses settings depuis les env vars (MYSQL_HOST etc.),
# avec fallback sur localhost/root/root pour MAMP local. Pas besoin de le générer ici.

# Assure les permissions sur les dossiers d'upload bind-montés depuis l'hôte
for dir in /var/www/html/assets/img/projects /var/www/html/assets/docs; do
    if [ -d "$dir" ]; then
        chown -R www-data:www-data "$dir" 2>/dev/null || true
        chmod -R u+rwX,g+rwX "$dir" 2>/dev/null || true
    fi
done

# === Auto-migrations SQL (via le script PHP, portable) ===
MIGRATE_SCRIPT="/var/www/html/sql/migrate.php"
if [ -f "$MIGRATE_SCRIPT" ]; then
    : "${MYSQL_HOST:=database}"
    : "${MYSQL_USERNAME:=portfolio}"
    : "${MYSQL_PASSWORD:=portfolio}"

    # Attend que MySQL réponde (jusqu'à 30s)
    echo "[migrations] Attente de MySQL ($MYSQL_HOST)..."
    for i in $(seq 1 30); do
        if php -r "try { new PDO('mysql:host=${MYSQL_HOST}', '${MYSQL_USERNAME}', '${MYSQL_PASSWORD}'); exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; then
            break
        fi
        sleep 1
    done

    echo "[migrations] Lancement de migrate.php"
    php "$MIGRATE_SCRIPT" || echo "[migrations] ECHEC (le serveur démarre quand même)"
fi

exec "$@"
