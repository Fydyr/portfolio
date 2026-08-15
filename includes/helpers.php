<?php

require_once __DIR__ . '/session.php';

/**
 * Vrai si la session courante est celle d'un administrateur.
 *
 * Attention à la version précédente de ce test :
 *   !isset($_SESSION['user_id']) && !isset($_SESSION['admin']) == 1
 * `==` étant prioritaire sur `&&`, elle se lisait « aucune des deux clés n'est
 * présente ». Comme le login pose TOUJOURS les deux (y compris admin = 0), tout
 * compte authentifié passait pour administrateur.
 */
function isAdmin(): bool
{
    return !empty($_SESSION['user_id']) && (int)($_SESSION['admin'] ?? 0) === 1;
}

/**
 * Garde d'accès pour toute la zone /admin. Termine la requête si l'appelant
 * n'est pas administrateur — l'`exit` est ce qui manquait au middleware.
 */
function requireAdmin(): void
{
    if (isAdmin()) {
        return;
    }
    header('HTTP/1.1 403 Forbidden');
    echo view('403', ['title' => '403 - Accès interdit']);
    exit;
}

/**
 * Jeton CSRF de la session (généré au premier appel, stable ensuite).
 */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Champ caché à insérer dans chaque formulaire POST.
 */
function csrfField(): string
{
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Vérifie le jeton CSRF d'une requête POST. Termine la requête en 403 si absent
 * ou invalide. hash_equals() pour éviter la comparaison à temps variable.
 */
function requireCsrf(): void
{
    $sent = $_POST['_csrf'] ?? '';
    if (!empty($_SESSION['csrf_token']) && is_string($sent) && hash_equals($_SESSION['csrf_token'], $sent)) {
        return;
    }
    header('HTTP/1.1 403 Forbidden');
    echo view('403', ['title' => '403 - Requête invalide']);
    exit;
}

/**
 * Raccourci pour les actions d'admin en POST : authentification + CSRF.
 */
function requireAdminPost(): void
{
    requireAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        requireCsrf();
    }
}

function view($template, $data = [])
{
    // Gérer les meta tags si fournis
    if (isset($data['page_meta'])) {
        global $page_meta;
        $page_meta = $data['page_meta'];
    }

    extract($data);
    ob_start();
    include "views/$template.php";
    $content = ob_get_clean();
    return $content;
}

/**
 * Inclut un fragment de vue depuis views/partials/.
 *
 * Différence avec view() : partial() écrit directement dans la sortie au lieu de
 * retourner une chaîne, et ne touche pas aux meta tags. Il sert à découper une
 * page, pas à en rendre une.
 *
 * $data est extrait dans la portée du fragment. EXTR_SKIP protège les variables
 * déjà définies : un fragment ne peut pas écraser une variable de la page hôte
 * par accident.
 */
function partial(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    include __DIR__ . "/../views/partials/$name.php";
}

function json($data, $code = 200)
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function redirect($url)
{
    header("Location: " . url($url));
    exit;
}

function url($path = '')
{
    $scriptName = $_SERVER['SCRIPT_NAME']; // ex: /index.php  ou  /sousdossier/index.php
    $basePath = dirname($scriptName);

    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }

    $path = ltrim($path, '/');
    if ($path === '') {
        return $basePath === '' ? '/' : $basePath . '/';
    }

    return $basePath . '/' . $path;
}

function homeUrl()
{
    return url('');
}

function post($key, $default = null)
{
    return $_POST[$key] ?? $default;
}

function clean($string)
{
    return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
}

function flash($type, $message)
{
    $_SESSION['flash'][$type] = $message;
}

function getFlash($type)
{
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}
