<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'includes/helpers.php';

$router = new \Bramus\Router\Router();
$router->setBasePath('/index.php');

require_once 'routes.php';
$router->run();
