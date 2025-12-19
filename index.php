<?php
// SỬA LẠI ĐƯỜNG DẪN: Bỏ dấu ".." đi vì file index.php đang nằm ngang hàng với thư mục vendor và src
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/routes.php'; 

// 1. Khởi động Session và Buffer
session_start();
ob_start();

// 2. Định nghĩa đường dẫn gốc (APPROOT)
if (!defined('APPROOT')) {
    // Vì index.php đang ở root, nên APPROOT chính là __DIR__ luôn
    define('APPROOT', __DIR__); 
}

// Định nghĩa URL gốc (Sửa lại theo port của bạn nếu cần)
if (!defined('URLROOT')) {
    define('URLROOT', 'http://localhost/BOOKHOTEL');
}

// 3. Xử lý URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$projectFolder = '/BOOKHOTEL'; 

// Xử lý cắt bỏ tên thư mục dự án trên URL để Router hiểu
if (strpos($uri, $projectFolder) === 0) {
    $uri = substr($uri, strlen($projectFolder));
}

// Nếu uri rỗng (trang chủ) thì để nguyên là /
if ($uri == '') {
    $uri = '/';
}

// Gọi Router
$router->match($uri);
?>