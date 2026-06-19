<?php
/**
 * Connexion DB portable :
 *  - en Docker, les variables d'env (MYSQL_HOST, MYSQL_DATABASE, MYSQL_USERNAME, MYSQL_PASSWORD)
 *    sont définies dans docker-compose -> on les utilise.
 *  - en MAMP local, aucune env définie -> on retombe sur les defaults MAMP (localhost/root/root)
 *    et un nom de base local par défaut.
 *
 * Tu peux surcharger via .env si tu utilises phpdotenv (déjà dispo dans vendor).
 */

global $pdo;

$host    = getenv('MYSQL_HOST')     ?: 'localhost';
$db      = getenv('MYSQL_DATABASE') ?: 'enzo_fournier_bdd';
$user    = getenv('MYSQL_USERNAME') ?: 'root';
$pass    = getenv('MYSQL_PASSWORD') ?: 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
