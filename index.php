<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use App\UserType;
use App\Router;
use App\Data;
use App\Migration;

session_start();

Migration::run();

$router = new Router();

include_once './routes.php';
include_once './routes_api.php';

$router->checkAuth();
$url = $_SERVER['REQUEST_URI'];

if ($url == '/index.php')
    Router::toMain();

$method = $_SERVER['REQUEST_METHOD'];

$params=Router::getParams($url);

$router->route($url, $method,$params);