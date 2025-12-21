<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Booking;
use App\Model\Room;
use App\Model\RoomType;

class OrderController extends Controller
{
    private $bookingModel;
    private $roomModel;
    private $roomTypeModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
    }


    //star admin check
    private function requireAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }

    // 1. Hiển thị danh sách đơn
    public function qlorder()
    {
        $this->requireAdmin();
        $orders = $this->bookingModel->getAllBookings();
        $this->render('admin/orders/qlorder', ['orders' => $orders]);
    }

    // 2. Xem chi tiết đơn (Và form đổi trạng thái nằm ở đây luôn)
    public function show($id)
    {
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
    public function updateStatus($id)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'];
            
            // 1. Lấy thông tin booking hiện tại để biết Room ID là gì
            $booking = $this->bookingModel->getBookingById($id);
            
            if ($booking) {
                $roomId = $booking['room_id'];

                // 2. Cập nhật trạng thái Booking
                $this->bookingModel->updateStatus($id, $newStatus);

                // 3. Xử lý đồng bộ trạng thái Phòng (Room)                
                if ($newStatus == 'confirmed' || $newStatus == 'pending') {
                    $this->roomModel->updateStatus($roomId, 'booked');
                    
                } elseif ($newStatus == 'completed' || $newStatus == 'cancelled') {
                    $this->roomModel->updateStatus($roomId, 'available');
                }
                
                $_SESSION['flash_message'] = "Cập nhật trạng thái Order #$id và trạng thái phòng thành công!";
            } else {
                $_SESSION['flash_message'] = "Không tìm thấy đơn hàng!";
            }

            header("Location: /admin/orders/detail/$id");
            exit();
        }
    }

    public function delete($id)
    {
        $this->requireAdmin();
        $this->bookingModel->deleteBooking($id);
        $_SESSION['flash_message'] = "Đã xóa đơn hàng thành công!";
        header('Location: /admin/orders');
        exit();
    }
    //end admin check

    //user nam dang
}
