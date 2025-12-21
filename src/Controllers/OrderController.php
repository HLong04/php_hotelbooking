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

    private function requireAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }
    //oder controller

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
            $status = $_POST['status'];
            $this->bookingModel->updateStatus($id, $status);

            $_SESSION['flash_message'] = "Cập nhật trạng thái Order #$id thành công!";
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

       
    public function createBooking($roomId)
    {
        // Chưa login
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Lấy thông tin phòng
        $room = $this->roomModel->getRoomById($roomId);

        // Phòng không tồn tại hoặc đã booked
        if (!$room || $room['status'] !== 'available') {
            header('Location: /rooms');
            exit();
        }

        // =====================
        // GET → HIỂN THỊ FORM
        // =====================
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('user/booking', [
                'room' => $room
            ]);
            return;
        }

        // =====================
        // POST → XỬ LÝ BOOKING
        // =====================
        $checkIn  = $_POST['check_in'];
        $checkOut = $_POST['check_out'];

        // Validate ngày
        $days = (strtotime($checkOut) - strtotime($checkIn)) / 86400;
        if ($days <= 0) {
            $this->render('user/booking', [
                'room'  => $room,
                'error' => 'Ngày check-out phải sau check-in'
            ]);
            return;
        }

        $totalPrice = $days * $room['price'];

        // 1️⃣ Lưu booking
        $this->bookingModel->createBooking(
            $_SESSION['user_id'],
            $roomId,
            $checkIn,
            $checkOut,
            $totalPrice
        );

        // 2️⃣ Update trạng thái phòng
        $this->roomModel->updateRoomStatus($roomId, 'booked');

        // 3️⃣ Thông báo + redirect
        $_SESSION['flash_message'] = "🎉 Đặt phòng thành công!";
        header('Location: /rooms');
        exit();
    }


}
