<?php
namespace App;

class Controller {
    protected function render($view_name, $data = []) {
        extract($data);
        $view_file = __DIR__ . '\Views\\' . $view_name . '.php';
        if (file_exists($view_file)) {
            include $view_file;
        } else {
            echo "Lỗi: Không tìm thấy file view tại đường dẫn: " . $view_file;
            die();
        }
    }
}