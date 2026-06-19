<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';
require_once 'includes/helpers.php';

$router = new \Bramus\Router\Router();

require_once 'routes.php';
$router->run();
