<?php
namespace App\Model;

class Booking {
    private $mysqli;

    public function __construct() {
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8");
    }

    public function getAllBookings() {
        $sql = "SELECT b.*, u.full_name, u.email, r.room_number 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                ORDER BY b.created_at DESC";
        
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBookingById($id) {
        $id = $this->mysqli->real_escape_string($id);
        $sql = "SELECT b.*, u.full_name, u.email, u.phone, r.room_number, b.total_price 
                FROM bookings b 
                JOIN users u ON b.user_id = u.id 
                JOIN rooms r ON b.room_id = r.id 
                WHERE b.id = $id";
        
        $result = $this->mysqli->query($sql);
        return $result->fetch_assoc();
    }

    // 3. Cập nhật trạng thái đơn (Pending -> Confirmed -> Cancelled)
    public function updateStatus($id, $status) {
        $id = $this->mysqli->real_escape_string($id);
        $status = $this->mysqli->real_escape_string($status);
        
        $sql = "UPDATE bookings SET status = '$status' WHERE id = $id";
        return $this->mysqli->query($sql);
    }

    // 4. Xóa đơn
    public function deleteBooking($id) {
        $id = $this->mysqli->real_escape_string($id);
        $sql = "DELETE FROM bookings WHERE id = $id";
        return $this->mysqli->query($sql);
    }

    // 5. Tính tổng doanh thu (Chỉ tính các đơn đã Hoàn thành hoặc Đã xác nhận)
    // Hàm này dùng cho Dashboard AdminController
    public function getTotalRevenue() {
        $sql = "SELECT SUM(total_price) as revenue FROM bookings 
                WHERE status = 'Confirmed' OR status = 'Completed'";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['revenue'] ?? 0;
    }
}