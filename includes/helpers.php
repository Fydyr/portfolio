<?php

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
    $scriptName = $_SERVER['SCRIPT_NAME']; // /dossier/index.php
    $basePath = dirname($scriptName);       // /dossier

    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }

    $url = $basePath . '/index.php';

    if (!empty($path)) {
        $url .= '/' . ltrim($path, '/');
    }

    return $url;
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
