<?php

namespace App\Model;

class Booking
{
    private $mysqli;

    public function __construct()
    {
        // Kết nối CSDL
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8");

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }
    public function countBookingByPending()
    {
        $sql = "SELECT COUNT(*) as total FROM bookings WHERE status = 'pending'";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    // Trong BookingModel

    public function getTotalMoneyByUserId($userId)
    {
        // Dùng hàm SUM để cộng tổng tiền (total_price)
        // IFNULL(..., 0) để nếu không có đơn nào thì trả về 0 thay vì null
        // Bạn có thể chọn status là 'confirmed' hoặc 'completed' tùy nhu cầu
        $sql = "SELECT IFNULL(SUM(total_price), 0) as total_money 
            FROM bookings 
            WHERE user_id = ? AND (status = 'completed')";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total_money'];
    }

    // 1. Lấy tất cả đơn hàng (Đã thêm JOIN room_types)
    public function getAllBookings()
    {
        // Thêm JOIN room_types để lấy tên loại phòng (rt.name)
        $sql = "SELECT b.*, 
                       u.full_name, u.email, 
                       r.room_number, 
                       rt.name as room_type_name 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                JOIN room_types rt ON r.room_type_id = rt.id
                ORDER BY b.created_at DESC";

        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 2. Lấy đơn hàng gần đây (Dashboard)
    public function getRecentOrders($limit = 5)
    {
        $sql = "SELECT b.*, u.full_name, r.room_number, b.status, b.total_price 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                ORDER BY b.created_at DESC 
                LIMIT ?"; // Dùng dấu ?

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $limit); // "i" nghĩa là integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // 3. Xem chi tiết đơn hàng
    public function getBookingById($id)
    {
        $sql = "SELECT b.*, 
                       u.full_name, u.email, u.phone, 
                       r.room_number, 
                       rt.name as room_type_name, rt.price as price_per_night
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE b.id = ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // 4. Tạo đơn đặt phòng mới (Dùng cho User khi đặt phòng) -> QUAN TRỌNG
    // Trong Booking.php
    // File: src/Model/Booking.php

    public function createBooking($userId, $roomId, $checkIn, $checkOut, $totalPrice, $depositAmount, $paymentStatus)
    {

        $sql = "INSERT INTO bookings 
            (user_id, room_id, check_in, check_out, total_price, deposit_amount, status, payment_status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, NOW())";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iissdds", $userId, $roomId, $checkIn, $checkOut, $totalPrice, $depositAmount, $paymentStatus);

        if ($stmt->execute()) {
            return $this->mysqli->insert_id;
        }
        return false;
    }
    // 5. Cập nhật trạng thái
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // 6. Xóa đơn
    public function deleteBooking($id)
    {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // 7. Tổng doanh thu (Chỉ tính Confirmed hoặc Completed)
    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(total_price) as revenue FROM bookings 
                WHERE status IN ('Confirmed', 'Completed')";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['revenue'] ?? 0;
    }

    public function getBookingWithDetails($id)
    {
        $id = (int)$id;

        $sql = "SELECT 
                    b.*,
                    u.full_name as guest_name,
                    u.email as guest_email,
                    u.phone as guest_phone,
                    r.room_number,
                    rt.name as room_type_name,
                    rt.max_adults as guests
                FROM bookings b
                LEFT JOIN users u ON b.user_id = u.id
                LEFT JOIN rooms r ON b.room_id = r.id
                LEFT JOIN room_types rt ON r.room_type_id = rt.id
                WHERE b.id = $id";

        $result = $this->mysqli->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    // Tìm kiếm Booking nâng cao
    public function searchBookings($keyword, $roomNumber, $price, $status)
    {
        $sql = "SELECT b.*, 
                       u.full_name, u.email, 
                       r.room_number 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                WHERE 1=1";

        $types = "";
        $params = [];
        // 1. Tìm theo Từ khóa (Mã đơn hoặc Tên khách)
        if (!empty($keyword)) {
            $sql .= " AND (b.id LIKE ? OR u.full_name LIKE ? OR u.email like ?)";
            $keywordParam = "%$keyword%";
            $types .= "sss";
            $params[] = $keywordParam;
            $params[] = $keywordParam;
            $params[] = $keywordParam;
        }
        // 2. Tìm theo Số phòng
        if (!empty($roomNumber)) {
            $sql .= " AND r.room_number LIKE ?";
            $types .= "s";
            $params[] = "%$roomNumber%";
        }
        // 3. Tìm theo Giá tiền (Tìm chính xác hoặc gần đúng)
        if (!empty($price)) {
            $sql .= " AND b.total_price >= ?";
            $types .= "d";
            $params[] = $price;
        }
        // 4. Tìm theo Trạng thái
        if (!empty($status)) {
            $sql .= " AND b.status = ?";
            $types .= "s";
            $params[] = $status;
        }
        $sql .= " ORDER BY b.created_at DESC";
        $stmt = $this->mysqli->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
