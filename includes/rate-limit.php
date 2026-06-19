<?php
/**
 * Rate limiter simple basé sur la table login_attempts.
 *
 * Règle : MAX_ATTEMPTS échecs sur WINDOW_MINUTES déclenche un blocage,
 * appliqué par IP ET par email (le plus restrictif gagne).
 *
 * Pourquoi ne pas hasher l'IP : on en a besoin en clair pour aggréger.
 * Pourquoi loguer l'email : permet de protéger un compte ciblé même
 * si l'attaquant change d'IP.
 */

const RATE_LIMIT_MAX_ATTEMPTS  = 5;
const RATE_LIMIT_WINDOW_MIN    = 15;   // fenêtre de comptage en minutes
const RATE_LIMIT_RETENTION_HRS = 24;   // purge les entrées plus vieilles que ça

/**
 * Récupère l'IP réelle du client, même derrière Traefik / un reverse proxy.
 * On accepte X-Forwarded-For uniquement si le hop précédent est connu (sinon
 * un attaquant pourrait simplement spoofer le header pour bypasser le rate limit).
 */
function clientIp(): string
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    // Liste des IPs/CIDR de confiance (proxy local + sous-réseaux Docker privés)
    $trusted = ['127.0.0.1', '::1'];
    $isTrusted = in_array($remote, $trusted, true)
        || str_starts_with($remote, '172.') // bridge Docker
        || str_starts_with($remote, '10.')
        || str_starts_with($remote, '192.168.');

    if ($isTrusted && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Prend la 1re IP de la chaîne (client d'origine)
        $first = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        if (filter_var($first, FILTER_VALIDATE_IP)) {
            return $first;
        }
    }
    return $remote;
}

/**
 * Vérifie si la combinaison IP/email est actuellement bloquée.
 * Retourne ['blocked' => bool, 'retry_after' => int (secondes), 'attempts' => int].
 */
function checkRateLimit(string $ip, ?string $email = null): array
{
    global $pdo;

    $result = ['blocked' => false, 'retry_after' => 0, 'attempts' => 0];

    try {
        $windowSec = RATE_LIMIT_WINDOW_MIN * 60;

        // Compte les échecs récents par IP
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) AS n, UNIX_TIMESTAMP(MIN(attempted_at)) AS first_ts
             FROM login_attempts
             WHERE ip = :ip AND success = 0
               AND attempted_at >= (NOW() - INTERVAL :win SECOND)"
        );
        $stmt->execute([':ip' => $ip, ':win' => $windowSec]);
        $byIp = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['n' => 0, 'first_ts' => null];

        $byEmail = ['n' => 0, 'first_ts' => null];
        if ($email !== null && $email !== '') {
            $stmt = $pdo->prepare(
                "SELECT COUNT(*) AS n, UNIX_TIMESTAMP(MIN(attempted_at)) AS first_ts
                 FROM login_attempts
                 WHERE email = :em AND success = 0
                   AND attempted_at >= (NOW() - INTERVAL :win SECOND)"
            );
            $stmt->execute([':em' => $email, ':win' => $windowSec]);
            $byEmail = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['n' => 0, 'first_ts' => null];
        }

        $attempts = max((int)$byIp['n'], (int)$byEmail['n']);
        $result['attempts'] = $attempts;

        if ($attempts >= RATE_LIMIT_MAX_ATTEMPTS) {
            // Temps restant = (1re tentative bloquante + fenêtre) - maintenant
            $firstTs = max(
                $byIp['first_ts']   ? (int)$byIp['first_ts']   : 0,
                $byEmail['first_ts'] ? (int)$byEmail['first_ts'] : 0
            );
            $retry = max(0, ($firstTs + $windowSec) - time());
            $result['blocked'] = true;
            $result['retry_after'] = $retry;
        }
    } catch (PDOException $e) {
        // Si la table n'existe pas, on ne bloque pas (fail-open volontaire en dev)
    }

    return $result;
}

/**
 * Enregistre une tentative. Si success=true, vide les échecs précédents
 * pour cette IP et cet email (l'utilisateur reprend un quota frais).
 */
function recordLoginAttempt(string $ip, ?string $email, bool $success): void
{
    global $pdo;

    try {
        $pdo->prepare(
            "INSERT INTO login_attempts (ip, email, success) VALUES (:ip, :em, :s)"
        )->execute([
            ':ip' => $ip,
            ':em' => $email !== '' ? $email : null,
            ':s'  => $success ? 1 : 0,
        ]);

        if ($success) {
            $pdo->prepare(
                "DELETE FROM login_attempts WHERE (ip = :ip OR email = :em) AND success = 0"
            )->execute([':ip' => $ip, ':em' => $email]);
        }

        // Purge opportuniste des très vieilles entrées (~1% des requêtes)
        if (random_int(1, 100) === 1) {
            $pdo->exec(
                "DELETE FROM login_attempts WHERE attempted_at < (NOW() - INTERVAL " . (int)RATE_LIMIT_RETENTION_HRS . " HOUR)"
            );
        }
    } catch (PDOException $e) {
        // Silencieux : on ne veut pas casser le login si la table manque
    }
}

/**
 * Formate un nombre de secondes en "Xm Ys" lisible.
 */
function formatRetryAfter(int $sec): string
{
    if ($sec <= 0) return '0s';
    $min = intdiv($sec, 60);
    $rem = $sec % 60;
    if ($min > 0 && $rem > 0) return "{$min} min {$rem} s";
    if ($min > 0) return "{$min} min";
    return "{$rem} s";
}
