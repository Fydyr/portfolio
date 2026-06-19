<?php
/**
 * Migrations SQL portables.
 *
 * Usage :
 *   - CLI    : php sql/migrate.php  (depuis la racine du projet)
 *   - Docker : appelé automatiquement par docker/entrypoint.sh
 *   - MAMP   : ouvrir http://localhost:8888/mon_portfolio/sql/migrate.php?token=portfolio-migrate
 *              (token = sécurité minimale pour éviter qu'un visiteur trigger une migration)
 *
 * Parcourt les fichiers .sql de sql/migrations/ dans l'ordre lexicographique,
 * applique ceux qui ne sont pas encore dans la table schema_migrations.
 */

declare(strict_types=1);

$isCli = (php_sapi_name() === 'cli');

// En mode HTTP, exige un token de protection minimale (configurable via env)
if (!$isCli) {
    $expectedToken = getenv('MIGRATE_TOKEN') ?: 'portfolio-migrate';
    if (($_GET['token'] ?? '') !== $expectedToken) {
        http_response_code(403);
        echo "Forbidden. Add ?token=$expectedToken or run from CLI.";
        exit;
    }
    header('Content-Type: text/plain; charset=utf-8');
}

require_once __DIR__ . '/../includes/db.php';
global $pdo;

if (!$pdo instanceof PDO) {
    fwrite(STDERR, "Erreur : PDO non initialisé (vérifie includes/db.php).\n");
    exit(1);
}

function out(string $msg): void
{
    echo $msg . "\n";
}

$migrationsDir = __DIR__ . '/migrations';
if (!is_dir($migrationsDir)) {
    out("Aucun dossier sql/migrations/ trouvé. Rien à faire.");
    exit(0);
}

try {
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS schema_migrations (
            filename VARCHAR(255) PRIMARY KEY,
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );
} catch (PDOException $e) {
    out("Erreur création schema_migrations : " . $e->getMessage());
    exit(1);
}

$applied = [];
foreach ($pdo->query("SELECT filename FROM schema_migrations") as $row) {
    $applied[$row['filename']] = true;
}

$files = glob($migrationsDir . '/*.sql');
sort($files);

$applyCount = 0;
foreach ($files as $file) {
    $name = basename($file);
    if (isset($applied[$name])) {
        continue;
    }

    out("-> $name");
    $sql = file_get_contents($file);
    if ($sql === false || trim($sql) === '') {
        out("   (vide, ignoré)");
        continue;
    }

    try {
        // Pas de transaction : MySQL auto-commit les DDL (CREATE/ALTER), donc inutile.
        // On split sur ; en fin de ligne (suffisant pour des migrations simples).
        $statements = array_filter(
            array_map('trim', preg_split('/;\s*(\r?\n|$)/', $sql)),
            fn($s) => $s !== ''
        );

        foreach ($statements as $stmt) {
            $pdo->exec($stmt);
        }
        $pdo->prepare("INSERT IGNORE INTO schema_migrations (filename) VALUES (?)")
            ->execute([$name]);
        $applyCount++;
    } catch (PDOException $e) {
        out("   ECHEC : " . $e->getMessage());
        exit(1);
    }
}

if ($applyCount === 0) {
    out("Base à jour, rien à appliquer.");
} else {
    out("OK, $applyCount migration(s) appliquée(s).");
}

// === Seed admin user si la table user est vide ET les env vars sont définies ===
$adminEmail = getenv('ADMIN_EMAIL') ?: '';
$adminPass  = getenv('ADMIN_PASSWORD') ?: '';

if ($adminEmail !== '' && $adminPass !== '') {
    try {
        $count = (int)$pdo->query("SELECT COUNT(*) FROM user")->fetchColumn();
        if ($count === 0) {
            $hash = password_hash($adminPass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (mail, password, admin) VALUES (?, ?, 1)");
            $stmt->execute([$adminEmail, $hash]);
            out("Admin user créé : $adminEmail");
        }
    } catch (PDOException $e) {
        out("Seed admin ECHEC : " . $e->getMessage());
    }
}
