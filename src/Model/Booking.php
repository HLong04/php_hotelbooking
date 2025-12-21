<?php
namespace App\Model;

class Booking {
    private $mysqli;

    public function __construct() {
        // Kết nối CSDL
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8");

        // Kiểm tra lỗi kết nối
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    // 1. Lấy tất cả đơn hàng (Đã thêm JOIN room_types)
    public function getAllBookings() {
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
    public function getRecentOrders($limit = 5) {
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
    public function getBookingById($id) {
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
    public function createBooking($userId, $roomId, $checkIn, $checkOut, $totalPrice)
    {
        $sql = "INSERT INTO bookings 
                (user_id, room_id, check_in, check_out, total_price, status) 
                VALUES (?, ?, ?, ?, ?, 'pending')";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iissd", $userId, $roomId, $checkIn, $checkOut, $totalPrice);
        return $stmt->execute();
    }

    // 5. Cập nhật trạng thái
    public function updateStatus($id, $status) {
        $sql = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // 6. Xóa đơn
    public function deleteBooking($id) {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // 7. Tổng doanh thu (Chỉ tính Confirmed hoặc Completed)
    public function getTotalRevenue() {
        $sql = "SELECT SUM(total_price) as revenue FROM bookings 
                WHERE status IN ('Confirmed', 'Completed')";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['revenue'] ?? 0;
    }

    // 8. (Bổ sung) Tìm phòng trống theo loại phòng và ngày
    // Hàm này giúp Controller kiểm tra xem còn phòng để đặt không
    public function findAvailableRoomId($roomTypeId, $checkIn, $checkOut) {
        // Logic: Lấy 1 phòng thuộc loại này mà ID của nó KHÔNG nằm trong danh sách các booking trùng ngày
        $sql = "SELECT r.id FROM rooms r
                WHERE r.room_type_id = ? 
                AND r.status = 'available'
                AND r.id NOT IN (
                    SELECT b.room_id FROM bookings b
                    WHERE (
                        (b.check_in <= ? AND b.check_out >= ?)
                        AND b.status != 'cancelled'
                    )
                )
                LIMIT 1";
        
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iss", $roomTypeId, $checkOut, $checkIn);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        return null; // Hết phòng
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
                    rt.name as room_type_name
                FROM bookings b
                LEFT JOIN users u ON b.user_id = u.id
                LEFT JOIN rooms r ON b.room_id = r.id
                LEFT JOIN room_types rt ON r.room_type_id = rt.id
                WHERE b.id = $id";
        
        $result = $this->mysqli->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
}