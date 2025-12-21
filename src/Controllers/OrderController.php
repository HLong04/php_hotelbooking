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

    //user đặt thì sẽ lấy check in phòng đang tróng 
    public function confirm()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Vui lòng đăng nhập để đặt phòng!";
            header('Location: /login');
            exit();
        }

        $typeId = $_GET['type_id'] ?? null;
        if (!$typeId) {
            header('Location: /rooms');
            exit();
        }

        $roomType = $this->roomTypeModel->getRoomTypeById($typeId);

        $this->render('user/booking', [
            'roomType' => $roomType
        ]);
    }


    public function store()
    {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $roomTypeId = $_POST['room_type_id'];
        $checkIn = $_POST['check_in'];
        $checkOut = $_POST['check_out'];
        $pricePerNight = $_POST['price_per_night'];

        $diff = strtotime($checkOut) - strtotime($checkIn);
        $days = ceil($diff / (60 * 60 * 24));
        if ($days <= 0) $days = 1;
        $totalPrice = $days * $pricePerNight;

        $roomId = $this->bookingModel->findAvailableRoomId($roomTypeId, $checkIn, $checkOut);

        if ($roomId) {
            // B. TẠO BOOKING
            $data = [
                'user_id' => $userId,
                'room_id' => $roomId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'total_price' => $totalPrice,
                'status' => 'pending' 
            ];

            $this->bookingModel->createBooking($data);

            $this->roomModel->updateStatus($roomId, 'Booked');

            $_SESSION['flash_message'] = "Đặt phòng thành công! Mã phòng của bạn là P." . $roomId;
            header('Location: /myorders');
        } else {
            $_SESSION['flash_message'] = "Rất tiếc, loại phòng này đã hết trong ngày bạn chọn.";
            header("Location: /rooms?type_id=$roomTypeId");
        }
    }

    /**
     * 3. DANH SÁCH ĐƠN HÀNG CỦA TÔI
     * URL: /myorders
     */
    public function index()
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

    /**
     * 4. HỦY PHÒNG / TRẢ PHÒNG (USER ACTION)
     * URL: /booking/cancel/{id}
     */

    public function cancel($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $booking = $this->bookingModel->getBookingById($id);

        if ($booking && $booking['user_id'] == $_SESSION['user_id']) {
            if ($booking['status'] == 'Pending' || $booking['status'] == 'confirmed') {

                $this->bookingModel->updateStatus($id, 'cancelled');
                
                $this->roomModel->updateStatus($booking['room_id'], 'available');

                $_SESSION['flash_message'] = "Đã hủy đơn đặt phòng.";
            }
        }

        header('Location: /myorders');
    }
}
