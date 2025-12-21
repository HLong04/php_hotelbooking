
<?php
// Kiểm tra: Nếu chưa có DB_HOST thì mới định nghĩa
if (!defined('DB_HOST')) {
    define('DB_HOST', '127.0.0.1'); 
    define('DB_USER', 'root');
    define('DB_PASSWORD', ''); // Điền pass nếu có, không thì để trống
    define('DB_NAME', 'mybhotel_db');
    define('DB_PORT', 3307); // Nhớ giữ port 3307 nhé
}
?>