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
        // 1. Kiểm tra đăng nhập & Phòng
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Vui lòng đăng nhập!";
            header('Location: /login');
            exit();
        }

        $room = $this->roomModel->getRoomById($roomId);
        if (!$room || $room['status'] !== 'available') {
            $_SESSION['flash_message'] = "Phòng không khả dụng!";
            header('Location: /rooms');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('user/booking', ['room' => $room]);
            return;
        }

        // 2. Tính toán tiền
        $checkIn  = $_POST['check_in'];
        $checkOut = $_POST['check_out'];
        $days = (strtotime($checkOut) - strtotime($checkIn)) / 86400;

        if ($days <= 0) {
            // Handle error...
        }

        // A. Giá gốc
        $originalPrice = $days * $room['price'];

        // B. Trừ tiền Rank (Đã làm đúng)
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        $rank = $user['rank_level'] ?? 'standard';

        $discountRate = ($rank == 'vip') ? 0.05 : (($rank == 'diamond') ? 0.10 : 0);
        $discountAmount = $originalPrice * $discountRate;

        // $finalPrice: Là GIÁ CHỐT HỢP ĐỒNG (Sau khi trừ Rank)
        // Ví dụ: Gốc 1tr - Giảm 100k = 900k. (Lưu 900k vào DB)
        $finalPrice = $originalPrice - $discountAmount;

        // C. Tính tiền cọc (Chỉ tính ra con số để khách chuyển, KHÔNG trừ vào finalPrice)
        // Ví dụ: Cọc 30% của 900k = 270k.
        $depositAmount = $finalPrice * 0.3; // Bạn nên để 0.3 (30%) cho chuẩn logic cũ

        // 3. Gọi Model
        $newBookingId = $this->bookingModel->createBooking(
            $_SESSION['user_id'],
            $roomId,
            $checkIn,
            $checkOut,
            $finalPrice,
            $depositAmount,
            'deposited'
        );
        // => Lúc này trong DB: Status = 'pending' (do sửa Model ở Bước 1)

        // ... Code lưu booking ở trên ...

        if ($newBookingId) {
            // 1. Update trạng thái phòng
            $this->roomModel->updateStatus($roomId, 'booked');
            // 2. TẠO THÔNG BÁO CHI TIẾT (Logic hiển thị Rank & Tiền giảm)
            $msg = "🎉 Đặt phòng thành công!";

            if ($discountAmount > 0) {
                $rankName = strtoupper($rank); // Chuyển vip -> VIP
                $moneySaved = number_format($discountAmount);

                $msg .= " Chúc mừng! Vì bạn là thành viên <b>$rankName</b>, ";
                $msg .= "bạn đã được giảm trực tiếp <b>$moneySaved VNĐ</b> vào đơn hàng.";
            } else {
                $msg .= " Vui lòng chờ Admin xác nhận khoản cọc.";
            }

            $_SESSION['flash_message'] = $msg;
            $_SESSION['alert_type'] = 'success'; // Để dùng class màu xanh (nếu có)

            // 4. Chuyển hướng
            header('Location: /myorders');
            exit();
        } else {
            $_SESSION['flash_message'] = "Lỗi hệ thống!";
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
        $_SESSION['flash_message'] = "Đã hủy đơn đặt phòng thành công! Tiền cọc của bạn sẽ được hoàn trả trong 24h tới!!! vui kiểm tra tài khoản của mình!!";
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

        // Lúc này đơn đã là completed, hàm này sẽ cộng tiền và đổi rank trong DB
        $this->userModel->updateMemberRank($userId);

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
