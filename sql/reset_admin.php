<?php
/**
 * Réinitialisation du compte administrateur — CLI uniquement.
 *
 * Filet ultime, utilisable tant que l'accès au serveur est conservé, y compris
 * quand plus aucun code de secours n'est disponible.
 *
 * Usage :
 *   php sql/reset_admin.php --list
 *   php sql/reset_admin.php --email=vous@exemple.fr
 *   php sql/reset_admin.php --email=vous@exemple.fr --password='...'
 *   php sql/reset_admin.php --create --email=vous@exemple.fr
 *
 * Sous Docker :
 *   docker compose exec app php sql/reset_admin.php --list
 *
 * Ce script n'est PAS exposé en HTTP : il modifie les identifiants d'accès de la
 * production. Il est doublement bloqué côté serveur — .htaccess interdit /sql/*
 * par RewriteRule et par RedirectMatch — et refuse de s'exécuter hors CLI.
 */

declare(strict_types=1);

// Refus catégorique hors CLI. 404 pour ne rien révéler de l'existence du script,
// comme le fait déjà sql/migrate.php.
if (php_sapi_name() !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/password.php';
global $pdo;

if (!$pdo instanceof PDO) {
    fwrite(STDERR, "Erreur : PDO non initialisé (vérifie includes/db.php).\n");
    exit(1);
}

function out(string $msg): void
{
    echo $msg . "\n";
}

function fail(string $msg): never
{
    fwrite(STDERR, "Erreur : " . $msg . "\n");
    exit(1);
}

function usage(): never
{
    out("Usage :");
    out("  php sql/reset_admin.php --list");
    out("  php sql/reset_admin.php --email=<adresse> [--password=<mdp>]");
    out("  php sql/reset_admin.php --create --email=<adresse> [--password=<mdp>]");
    out("");
    out("Sans --password, un mot de passe fort est généré et affiché.");
    exit(0);
}

/**
 * Mot de passe aléatoire. random_int() est le générateur cryptographique de PHP ;
 * rand()/mt_rand() produiraient des mots de passe prédictibles.
 */
function generateStrongPassword(int $length = 20): string
{
    $alphabet = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789-_@#%*';
    $max = strlen($alphabet) - 1;
    $out = '';
    for ($i = 0; $i < $length; $i++) {
        $out .= $alphabet[random_int(0, $max)];
    }
    return $out;
}

/**
 * Saisie masquée si le terminal le permet. Retourne null si l'entrée standard
 * n'est pas un terminal — cas d'un `docker compose exec` sans -it, où stty
 * échouerait et où le mot de passe s'afficherait en clair.
 */
function promptHidden(string $label): ?string
{
    if (!function_exists('shell_exec') || !stream_isatty(STDIN)) {
        return null;
    }
    echo $label;
    shell_exec('stty -echo 2>/dev/null');
    $value = fgets(STDIN);
    shell_exec('stty echo 2>/dev/null');
    echo "\n";
    return $value === false ? null : rtrim($value, "\r\n");
}

// === Analyse des arguments ===
$options = getopt('', ['list', 'create', 'email:', 'password:', 'help']);
if ($options === false || isset($options['help']) || $options === []) {
    usage();
}

// === --list ===
if (isset($options['list'])) {
    $rows = $pdo->query('SELECT id, mail, admin FROM user ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) {
        out("Aucun compte dans la table user.");
        out("Créez-en un : php sql/reset_admin.php --create --email=vous@exemple.fr");
        exit(0);
    }
    out(str_pad('ID', 6) . str_pad('ADMIN', 8) . 'EMAIL');
    foreach ($rows as $r) {
        out(str_pad((string)$r['id'], 6) . str_pad(((int)$r['admin'] === 1 ? 'oui' : 'non'), 8) . $r['mail']);
    }
    exit(0);
}

// === Adresse visée ===
$email = isset($options['email']) ? trim((string)$options['email']) : '';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail("--email=<adresse> est requis et doit être une adresse valide.");
}

$stmt = $pdo->prepare('SELECT id FROM user WHERE mail = ?');
$stmt->execute([$email]);
$userId = $stmt->fetchColumn();

$creating = isset($options['create']);

if (!$userId && !$creating) {
    fail("Aucun compte avec l'adresse « $email ». Ajoutez --create pour le créer, ou listez les comptes avec --list.");
}
if ($userId && $creating) {
    fail("Un compte existe déjà avec l'adresse « $email ». Relancez sans --create pour réinitialiser son mot de passe.");
}

// === Nouveau mot de passe ===
$generated = false;
if (isset($options['password'])) {
    $password = (string)$options['password'];
} else {
    $password = promptHidden('Nouveau mot de passe (laisser vide pour en générer un) : ') ?? '';
    if ($password === '') {
        $password = generateStrongPassword();
        $generated = true;
    }
}

if (!$generated) {
    $errors = validateNewPassword($password, $password);
    if ($errors) {
        fail(implode(' ', $errors));
    }
}

$hash = password_hash($password, PASSWORD_DEFAULT);

// === Écriture ===
if ($creating) {
    $pdo->prepare('INSERT INTO user (mail, password, admin) VALUES (?, ?, 1)')
        ->execute([$email, $hash]);
    out("Compte administrateur créé : $email");
} else {
    // admin = 1 forcé : un compte réinitialisé par ce script doit pouvoir
    // reprendre la main sur /admin, or la colonne vaut 0 par défaut.
    $pdo->prepare('UPDATE user SET password = ?, admin = 1 WHERE id = ?')
        ->execute([$hash, (int)$userId]);
    out("Mot de passe réinitialisé pour : $email (admin = 1)");
}

if ($generated) {
    out("");
    out("  Mot de passe généré : $password");
    out("");
    out("Notez-le maintenant, il n'est pas stocké en clair.");
}

out("Connexion : /login — pensez à régénérer vos codes de secours depuis /admin/account.");
exit(0);
