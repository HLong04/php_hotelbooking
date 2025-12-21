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
    // 1. Xem đơn hàng (tất cả, có tìm kiếm)
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
        $this->roomModel->updateRoomStatus($id, 'available');
        $_SESSION['flash_message'] = "Đã xóa đơn hàng thành công!";
        header('Location: /admin/orders');
        exit();
    }
    //end admin check



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

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('user/booking', [
                'room' => $room
            ]);
            return;
        }

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

        $this->roomModel->updateRoomStatus($roomId, 'booked');

        // 3️⃣ Thông báo + redirect
        $_SESSION['flash_message'] = "🎉 Đặt phòng thành công!";
        header('Location: /rooms');
        exit();
    }


    public function myorders()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        $allBookings = $this->bookingModel->getAllBookings();
        $myBookings = array_filter($allBookings, function ($b) {
            return $b['user_id'] == $_SESSION['user_id'];
        });

        $this->render('user/my-order', ['bookings' => $myBookings]);
    }

    public function myOrderDetail($id)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Lấy thông tin booking với JOIN để lấy đầy đủ thông tin
        $booking = $this->bookingModel->getBookingWithDetails($id);

        // Kiểm tra booking có tồn tại và thuộc về user hiện tại
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_message'] = "Đơn đặt phòng không tồn tại!";
            header('Location: /myorders');
            exit();
        }

        // Render view chi tiết
        $this->render('user/order-detail', ['booking' => $booking]);
    }

    public function cancel($bookingId)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Lấy thông tin booking
        $booking = $this->bookingModel->getBookingById($bookingId);

        // Kiểm tra booking có tồn tại và thuộc về user hiện tại
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_message'] = "Đơn đặt phòng không tồn tại!";
            header('Location: /myorders');
            exit();
        }

        // Kiểm tra trạng thái phải là 'pending' mới được hủy
        if ($booking['status'] != 'pending') {
            $_SESSION['flash_message'] = "Chỉ có thể hủy đơn hàng đang chờ duyệt!";
            header('Location: /myorders');
            exit();
        }

        // 1. Cập nhật trạng thái booking thành 'cancelled'
        $this->bookingModel->updateStatus($bookingId, 'cancelled');

        // 2. Cập nhật trạng thái phòng về 'available'
        $this->roomModel->updateStatus($booking['room_id'], 'available');

        // 3. Thông báo thành công
        $_SESSION['flash_message'] = "✅ Đã hủy đơn đặt phòng thành công!";
        header('Location: /myorders');
        exit();
    }

    public function checkout($bookingId)
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Lấy thông tin booking
        $booking = $this->bookingModel->getBookingById($bookingId);

        // Kiểm tra booking có tồn tại và thuộc về user hiện tại
        if (!$booking || $booking['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash_message'] = "Đơn đặt phòng không tồn tại!";
            header('Location: /myorders');
            exit();
        }

        // Kiểm tra trạng thái phải là 'confirmed' mới được checkout
        if ($booking['status'] != 'confirmed') {
            $_SESSION['flash_message'] = "Chỉ có thể checkout đơn hàng đã xác nhận!";
            header('Location: /myorders/detail/' . $bookingId);
            exit();
        }

        // 1. Cập nhật trạng thái booking thành 'completed'
        $this->bookingModel->updateStatus($bookingId, 'completed');

        // 2. Cập nhật trạng thái phòng thành 'maintenance'
        $this->roomModel->updateStatus($booking['room_id'], 'maintenance');

        // 3. Thông báo thành công
        $_SESSION['flash_message'] = "✅ Checkout thành công! Phòng đang được bảo trì.";
        header('Location: /myorders/detail/' . $bookingId);
        exit();
    }
}
