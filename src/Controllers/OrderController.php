<?php
namespace App\Controllers;

use App\Controller;
use App\Model\Booking;

class OrderController extends Controller {
    private $bookingModel;

    public function __construct() {
        $this->bookingModel = new Booking();
    }

    private function requireAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }

    // 1. Hiển thị danh sách đơn
    public function qlorder() {
        $this->requireAdmin();
        $orders = $this->bookingModel->getAllBookings();
        $this->render('admin/orders/qlorder', ['orders' => $orders]);
    }

    // 2. Xem chi tiết đơn (Và form đổi trạng thái nằm ở đây luôn)
    public function show($id) {
        $this->requireAdmin();
        $order = $this->bookingModel->getBookingById($id);

        if (!$order) {
            $_SESSION['flash_message'] = "Đơn đặt phòng không tồn tại!";
            header('Location: /admin/orders');
            exit();
        }

        $this->render('admin/orders/detail', ['order' => $order]);
    }

    // 3. Xử lý cập nhật trạng thái
    public function updateStatus($id) {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $this->bookingModel->updateStatus($id, $status);
            
            $_SESSION['flash_message'] = "Cập nhật trạng thái đơn hàng #$id thành công!";
            header("Location: /admin/orders/detail/$id");
            exit();
        }
    }
    public function delete($id) {
        $this->requireAdmin();
        $this->bookingModel->deleteBooking($id);
        $_SESSION['flash_message'] = "Đã xóa đơn hàng thành công!";
        header('Location: /admin/orders');
        exit();
    }
    
    // ... Các hàm myOrders (cho user) giữ nguyên hoặc làm sau ...




}