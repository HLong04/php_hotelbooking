<?php

use App\Router;

use App\Controllers\AuthController;  
use App\Controllers\HomeController;   
use App\Controllers\UserController;    
use App\Controllers\RoomController;    
use App\Controllers\OrderController;
use App\Controllers\AdminController;
use App\Controllers\TypeRoomController;

$authCtrl = new AuthController();
$homeCtrl = new HomeController();
$userCtrl = new UserController();
$roomCtrl = new RoomController();
$orderCtrl = new OrderController();
$adminCtrl = new AdminController();
$typeRoomCtrl = new TypeRoomController();




$router = new Router();
// Route cho trang chủ (dấu /)
$router->addRoute('#^/$#', [$homeCtrl, 'index']);
$router->addRoute('#^/login/?$#', [$authCtrl, 'login']);
$router->addRoute('#^/register/?$#', [$authCtrl, 'register']); // [MỚI] Đăng ký
$router->addRoute('#^/logout/?$#', [$authCtrl, 'logout']);


// USER
// Xem danh sách phòng & Chi tiết
$router->addRoute('#^/rooms/?$#', [$homeCtrl, 'listRoom']);
$router->addRoute('#^/room/detail/(\d+)$#', [$homeCtrl, 'detailRoom']);
// Route xem danh sách phòng theo Loại (VD: /rooms/type/1)
$router->addRoute('#^/rooms/type/(\d+)$#', [$homeCtrl, 'roomsByType']);

// Route này nhận dữ liệu POST từ form đặt phòng để lưu vào DB
$router->addRoute('#^/booking/create/(\d+)$#', [$orderCtrl, 'createBooking']);

// Quản lý cá nhân
$router->addRoute('#^/profile/(\d+)$#', [$userCtrl, 'Profile']);
$router->addRoute('#^/profile/update/(\d+)$#', [$userCtrl, 'updateprofile']);
$router->addRoute('#^/profile/change-password/(\d+)$#', [$userCtrl, 'changePassword']);

// Lịch sử đặt phòng của tôi
$router->addRoute('#^/myorders/?$#', [$orderCtrl, 'myOrders']);
$router->addRoute('#^/myorders/detail/(\d+)$#', [$orderCtrl, 'myOrderDetail']);


//   ADMIN PORTAL
$router->addRoute('#^/admin/?$#', [$adminCtrl, 'admin']);

// 1. Quản lý Phòng
$router->addRoute('#^/admin/rooms/?$#', [$roomCtrl, 'qlroom']);
$router->addRoute('#^/admin/rooms/create/?$#', [$roomCtrl, 'create']);
$router->addRoute('#^/admin/rooms/update/(\d+)$#', [$roomCtrl, 'update']);
$router->addRoute('#^/admin/rooms/delete/(\d+)$#', [$roomCtrl, 'delete']);

// 2. Quản lý Loại phòng
$router->addRoute('#^/admin/typeroom/?$#', [$typeRoomCtrl, 'qltyperoom']);
$router->addRoute('#^/admin/typeroom/create/?$#', [$typeRoomCtrl, 'createType']);
$router->addRoute('#^/admin/typeroom/update/(\d+)$#', [$typeRoomCtrl, 'updateType']);
$router->addRoute('#^/admin/typeroom/delete/(\d+)$#', [$typeRoomCtrl, 'deleteType']);
// 3. Quản lý Users
$router->addRoute('#^/admin/users/?$#', [$userCtrl, 'qluser']); 
$router->addRoute('#^/admin/users/create/?$#', [$userCtrl, 'create']); 
$router->addRoute('#^/admin/users/update/(\d+)$#', [$userCtrl, 'update']);
$router->addRoute('#^/admin/users/delete/(\d+)$#', [$userCtrl, 'delete']); 

// 4. Quản lý Đơn đặt (Orders)
$router->addRoute('#^/admin/orders/?$#', [$orderCtrl, 'qlorder']);
$router->addRoute('#^/admin/orders/detail/(\d+)$#', [$orderCtrl, 'show']);
// [MỚI] Route để Admin duyệt đơn (đổi status thành Confirmed/Cancelled)
$router->addRoute('#^/admin/orders/status/(\d+)$#', [$orderCtrl, 'updateStatus']);
$router->addRoute('#^/admin/orders/delete/(\d+)$#', [$orderCtrl, 'delete']);
