#!/bin/bash
set -e

DB_FILE="/var/www/html/includes/db.php"

if [ ! -f "$DB_FILE" ] || [ "${DB_REGENERATE:-false}" = "true" ]; then
    : "${MYSQL_HOST:=database}"
    : "${MYSQL_DATABASE:=portfolio}"
    : "${MYSQL_USERNAME:=portfolio}"
    : "${MYSQL_PASSWORD:=portfolio}"

    cat > "$DB_FILE" <<PHP
<?php
global \$pdo;
\$host = '${MYSQL_HOST}';
\$db = '${MYSQL_DATABASE}';
\$user = '${MYSQL_USERNAME}';
\$pass = '${MYSQL_PASSWORD}';
\$charset = 'utf8mb4';

\$dsn = "mysql:host=\$host;dbname=\$db;charset=\$charset";
\$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    \$pdo = new PDO(\$dsn, \$user, \$pass, \$options);
} catch (\PDOException \$e) {
    throw new \PDOException(\$e->getMessage(), (int)\$e->getCode());
}
PHP
    chown www-data:www-data "$DB_FILE"
fi

exec "$@"
