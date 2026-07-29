<?php
/**
 * Démarrage de session durci, centralisé.
 *
 * Doit être appelé AVANT toute écriture de sortie. Idempotent : les appels
 * suivants (header.php, contrôleurs) sont des no-op.
 */

/**
 * Vrai si la requête est arrivée en HTTPS, y compris derrière Traefik / un
 * reverse proxy qui termine le TLS (PHP ne voit alors que du http en interne).
 */
function requestIsHttps(): bool
{
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }
    // Header posé par Traefik. On ne s'y fie que pour ACTIVER le flag Secure :
    // un spoof ne peut donc que renforcer la sécurité du cookie, jamais l'affaiblir.
    return ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
}

function startSecureSession(): void
{
    if (session_status() !== PHP_SESSION_NONE) {
        return;
    }

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,               // inaccessible au JS -> pas de vol via XSS
        'secure'   => requestIsHttps(),   // false en dev http, sinon le login local casse
        'samesite' => 'Strict',           // le cookie ne part pas sur une requête cross-site (anti-CSRF)
    ]);

    session_start();
}
