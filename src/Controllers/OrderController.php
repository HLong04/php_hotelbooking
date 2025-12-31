<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Booking;
use App\Model\Room;
use App\Model\RoomType;
use App\Model\User;

class OrderController extends Controller
{
    private $bookingModel;
    private $roomModel;
    private $roomTypeModel;
    private $userModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->roomModel = new Room();
        $this->userModel = new User();
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

        // $orders = $this->bookingModel->getAllBookings();

        $keyword = $_GET['keyword'] ?? '';
        $room    = $_GET['room'] ?? '';
        $price   = $_GET['price'] ?? '';
        $status  = $_GET['status'] ?? '';

        // Gọi Model
        if ($keyword || $room || $price || $status) {
            $orders = $this->bookingModel->searchBookingsAdvanced($keyword, $room, $price, $status);
        } else {
            $orders = $this->bookingModel->getAllBookings();
        }

        $data = [
            'orders'  => $orders,
            'keyword' => $keyword,
            'room'    => $room,
            'price'   => $price,
            'status'  => $status
        ];
        $this->render('admin/orders/qlorder', $data);
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

            // 1. Lấy thông tin booking hiện tại
            $booking = $this->bookingModel->getBookingById($id);

            if ($booking) {
                $roomId = $booking['room_id'];
                $userId = $booking['user_id']; // Lấy thêm User ID để tính hạng

                // 2. Cập nhật trạng thái Booking
                $this->bookingModel->updateStatus($id, $newStatus);


                // 3. Xử lý đồng bộ trạng thái Phòng (Room)
                if ($newStatus == 'confirmed' || $newStatus == 'pending') {
                    $this->roomModel->updateStatus($roomId, 'booked');
                } elseif ($newStatus == 'completed' || $newStatus == 'cancelled') {
                    $this->roomModel->updateStatus($roomId, 'available');
                }

                // =========================================================
                // 4. [MỚI] TỰ ĐỘNG CẬP NHẬT HẠNG THÀNH VIÊN (VIP LOGIC)
                // =========================================================
                // Chỉ chạy khi Admin bấm "Đã trả phòng" (Completed)

                if ($newStatus == 'completed') {
                    $this->userModel->updateMemberRank($userId);
                }
                // =========================================================

                $_SESSION['flash_message'] = "Cập nhật trạng thái Order #$id thành công!";
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
    public function printInvoice($id)
    {
        $this->requireAdmin();

        // 1. Lấy thông tin đơn hàng từ DB (để in tên khách, phòng...)
        $order = $this->bookingModel->getBookingById($id);

        if (!$order) {
            die("Đơn hàng không tồn tại");
        }

        // 2. TẠO DỮ LIỆU HÓA ĐƠN "ẢO" (Không lưu vào DB)
        // Tự động sinh mã hóa đơn theo quy tắc: INV + NămThángNgày + ID Đơn (Ví dụ: INV-20231225-10)
        $invoiceData = [
            'invoice_code' => 'INV-' . date('Ymd') . '-' . $id,
            'created_at'   => date('Y-m-d H:i:s'), // Lấy thời gian hiện tại
            'total_amount' => $order['total_price']
        ];

        // 3. Truyền dữ liệu sang View để in
        // View vẫn nhận biến $invoice nhưng giờ nó là mảng mình vừa tạo ở trên
        $this->render('admin/orders/invoice', [
            'order' => $order,
            'invoice' => $invoiceData
        ]);
    }
    //end admin check



    public function createBooking($roomId)
    {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Vui lòng đăng nhập để đặt phòng";
            header('Location: /login');
            exit();
        }

        // 2. Lấy thông tin phòng
        $room = $this->roomModel->getRoomById($roomId);

        // Check phòng tồn tại và còn trống
        if (!$room || $room['status'] !== 'available') {
            $_SESSION['flash_message'] = "Phòng này không còn trống!";
            header('Location: /rooms');
            exit();
        }

        // 3. Xử lý hiển thị Form (GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('user/booking', [
                'room' => $room
            ]);
            return;
        }

        // 4. Xử lý Đặt phòng (POST)
        $checkIn  = $_POST['check_in'];
        $checkOut = $_POST['check_out'];

        // Validate ngày
        $days = (strtotime($checkOut) - strtotime($checkIn)) / 86400;
        if ($days <= 0) {
            $this->render('user/booking', [
                'room'  => $room,
                'error' => 'Ngày trả phòng phải sau ngày nhận phòng'
            ]);
            return;
        }

        // --- BẮT ĐẦU TÍNH TOÁN TIỀN & VIP (QUAN TRỌNG) ---

        // A. Tính tổng tiền gốc
        $originalPrice = $days * $room['price'];

        // B. Lấy thông tin User để check hạng VIP
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $rank = $user['rank_level'] ?? 'standard'; // Mặc định là standard nếu lỗi

        // C. Tính % giảm giá
        $discountRate = 0;
        if ($rank == 'vip') {
            $discountRate = 0.05; // 5%
        } elseif ($rank == 'diamond') {
            $discountRate = 0.10; // 10%
        }

        // D. Tính ra con số cuối cùng
        $discountAmount = $originalPrice * $discountRate; // Số tiền được giảm
        $finalPrice     = $originalPrice - $discountAmount; // Giá chốt phải trả
        $depositAmount  = $finalPrice * 0.3; // Tiền cọc (30%)

        // --------------------------------------------------

        // 5. Lưu vào Database
        // Gọi hàm createBooking (Đảm bảo Model Booking của bạn đã nhận đủ 7 tham số này)
        $isCreated = $this->bookingModel->createBooking(
            $_SESSION['user_id'],
            $roomId,
            $checkIn,
            $checkOut,
            $finalPrice,    // Lưu giá sau khi đã giảm
            $depositAmount, // Lưu tiền cọc
            'pending'       // Trạng thái chờ duyệt
        );

        if ($isCreated) {
            // 6. Cập nhật trạng thái phòng thành 'Booked'
            $this->roomModel->updateStatus($roomId, 'booked');

            // 7. Thông báo & Chuyển hướng
            $msg = "🎉 Đặt phòng thành công! Vui lòng chờ xác nhận cọc.";
            if ($discountAmount > 0) {
                $msg .= " (Bạn được giảm " . number_format($discountAmount) . "đ nhờ hạng thành viên $rank)";
            }

            $_SESSION['flash_message'] = $msg;
            $_SESSION['alert_type'] = "success"; // Để hiện popup đẹp (nếu có dùng SweetAlert)

            header('Location: /myorders');
            exit();
        } else {
            // Nếu lỗi Database
            $_SESSION['flash_message'] = "Có lỗi xảy ra, vui lòng thử lại.";
            header("Location: /rooms/detail/$roomId");
            exit();
        }
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

        $userId = $_SESSION['user_id']; // Lưu vào biến cho gọn

        // Lấy thông tin booking
        $booking = $this->bookingModel->getBookingById($bookingId);

        // Kiểm tra booking có tồn tại và thuộc về user hiện tại
        if (!$booking || $booking['user_id'] != $userId) {
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

        // 2. Cập nhật trạng thái phòng thành 'maintenance' (Bảo trì/Dọn dẹp)
        $this->roomModel->updateStatus($booking['room_id'], 'maintenance');

        // =============================================================
        // 3. [MỚI] TÍNH TOÁN LẠI HẠNG THÀNH VIÊN (Database)
        // =============================================================
        // Lúc này đơn đã là completed, hàm này sẽ cộng tiền và đổi rank trong DB
        $this->userModel->updateMemberRank($userId);

        // =============================================================
        // 4. [MỚI] CẬP NHẬT LẠI SESSION (Quan trọng nhất)
        // =============================================================
        // Lấy thông tin mới nhất từ DB (lúc này đã là VIP/Diamond)
        $updatedUser = $this->userModel->getUserById($userId);

        // Cập nhật đè vào Session hiện tại để giao diện đổi ngay lập tức
        // Tùy vào cách bạn lưu session lúc login, thường là 1 trong 2 cách sau:

        // Cách 1: Nếu bạn lưu cả mảng user
        if (isset($_SESSION['user'])) {
            $_SESSION['user'] = $updatedUser;
        }

        // Cách 2: Nếu bạn lưu lẻ từng biến (như rank_level)
        $_SESSION['rank_level'] = $updatedUser['rank_level'];

        // =============================================================

        // 5. Thông báo thành công
        $msg = "✅ Checkout thành công! Cảm ơn quý khách.";

        // Khoe ngay nếu được lên hạng
        if ($updatedUser['rank_level'] != 'standard') {
            $msg .= " Chúc mừng! Bạn hiện là thành viên " . strtoupper($updatedUser['rank_level']);
        }

        $_SESSION['flash_message'] = $msg;
        header('Location: /myorders/detail/' . $bookingId);
        exit();
    }
}
