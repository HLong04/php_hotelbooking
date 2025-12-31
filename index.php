<?php

session_start();
ob_start();

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/index.php', '', $uri);

if ($uri == '') {
    $uri = '/';
}

// 7. Chạy Router
if (isset($router)) {
    $router->match($uri);
}
?>