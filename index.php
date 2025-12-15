<?php

require_once __DIR__ . '/vendor/autoload.php';


require __DIR__ . '/src/routes.php';

// $msg = $_SESSION['flash_message'];
// echo $msg;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '') {
    $uri = '/login';
}
$router->match($uri);
?>