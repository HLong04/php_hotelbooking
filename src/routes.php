<?php

use App\Router;
use App\Controllers\UserController;


$controller = new UserController();

$router = new Router();

// Trang chủ: "/"
$router->addRoute('#^/$#', [$controller, 'index']);

// "/post" hoặc "/post/" 
$router->addRoute('#^/user/?$#', [$controller, 'index']);

// "/post/index" hoặc "/post/index/"
$router->addRoute('#^/user/index/?$#', [$controller, 'index']);

// "/post/show/123"
$router->addRoute('#^/user/show/(\d+)$#', [$controller, 'show']);

// "/post/create"
$router->addRoute('#^/user/create/?$#', [$controller, 'create']);

// "/post/update/123"
$router->addRoute('#^/user/update/(\d+)$#', [$controller, 'update']);

// "/post/delete/123"
$router->addRoute('#^/user/delete/(\d+)$#', [$controller, 'delete']);
