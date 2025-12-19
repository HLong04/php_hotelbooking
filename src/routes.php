<?php

use App\Router;

use App\Controllers\AuthController;  
use App\Controllers\HomeController;   
use App\Controllers\UserController;    
use App\Controllers\RoomController;    
use App\Controllers\OrderController;
use App\Controllers\AdminController;   


$authCtrl = new AuthController();
$homeCtrl = new HomeController();
$userCtrl = new UserController();
$roomCtrl = new RoomController();
$orderCtrl = new OrderController();
$adminCtrl = new AdminController();


$router = new Router();

$router->addRoute('#^/$#', [$homeCtrl, 'index']); // Trang chủ
$router->addRoute('#^/login/?$#', [$authCtrl, 'login']);
$router->addRoute('#^/register/?$#', [$authCtrl, 'register']); // [MỚI] Đăng ký
$router->addRoute('#^/logout/?$#', [$authCtrl, 'logout']);


// USER
// Xem danh sách phòng & Chi tiết
$router->addRoute('#^/rooms/?$#', [$homeCtrl, 'listRoom']);
$router->addRoute('#^/room/detail/(\d+)$#', [$homeCtrl, 'detailRoom']);

// Route này nhận dữ liệu POST từ form đặt phòng để lưu vào DB
$router->addRoute('#^/booking/create/(\d+)$#', [$orderCtrl, 'createBooking']);

// Quản lý cá nhân
$router->addRoute('#^/profile/(\d+)$#', [$userCtrl, 'profile']);
$router->addRoute('#^/profile/update/(\d+)$#', [$userCtrl, 'updateProfile']);

// Lịch sử đặt phòng của tôi
$router->addRoute('#^/myorders/?$#', [$orderCtrl, 'myOrders']);
$router->addRoute('#^/myorders/detail/(\d+)$#', [$orderCtrl, 'myOrderDetail']);


//   ADMIN PORTAL
// 1. Quản lý Phòng (Rooms)

$router->addRoute('#^/adminhome/?$#', [$adminCtrl, 'admin']);


$router->addRoute('#^/admin/rooms/?$#', [$roomCtrl, 'index']);
$router->addRoute('#^/admin/rooms/create/?$#', [$roomCtrl, 'create']);
$router->addRoute('#^/admin/rooms/update/(\d+)$#', [$roomCtrl, 'update']);
$router->addRoute('#^/admin/rooms/delete/(\d+)$#', [$roomCtrl, 'delete']);

// 2. Quản lý Khách hàng (Users)
$router->addRoute('#^/admin/users/?$#', [$userCtrl, 'index']);
$router->addRoute('#^/admin/users/create/?$#', [$userCtrl, 'create']);
$router->addRoute('#^/admin/users/update/(\d+)$#', [$userCtrl, 'update']); // [MỚI] Sửa User
$router->addRoute('#^/admin/users/delete/(\d+)$#', [$userCtrl, 'delete']);

// 3. Quản lý Đơn đặt (Orders)
$router->addRoute('#^/admin/orders/?$#', [$orderCtrl, 'index']);
$router->addRoute('#^/admin/orders/detail/(\d+)$#', [$orderCtrl, 'show']);
// [MỚI] Route để Admin duyệt đơn (đổi status thành Confirmed/Cancelled)
$router->addRoute('#^/admin/orders/status/(\d+)$#', [$orderCtrl, 'updateStatus']);
$router->addRoute('#^/admin/orders/delete/(\d+)$#', [$orderCtrl, 'delete']);
