<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
ob_start();

// --- SỬA Ở ĐÂY: Thêm dòng này vào ---
// Phải gọi file cấu hình database trước khi chạy bất kỳ cái gì khác
require_once __DIR__ . '/config/credentials.php'; 
// ------------------------------------

require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/index.php', '', $uri);

// Lưu ý: Nếu bạn chạy php -S localhost:3000 thì để trống là đúng.
// Nếu chạy XAMPP (localhost/php_hotelbooking) thì điền tên thư mục vào đây.
$projectFolder = ''; 

if ($projectFolder != '' && strpos($uri, $projectFolder) === 0) {
    $uri = substr($uri, strlen($projectFolder));
}

if ($uri == '') {
    $uri = '/';
}

// 7. Chạy Router
if (isset($router)) {
    $router->match($uri);
}
?>