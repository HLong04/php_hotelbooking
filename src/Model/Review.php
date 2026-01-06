<?php
namespace App\Model;

class Review
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->mysqli->set_charset("utf8mb4");
    }

    // Lấy review theo room_type_id
   public function getByRoomTypeId($roomTypeId)
    {
        // Sử dụng JOIN để lấy tên từ bảng users và số phòng từ bảng rooms
        // Lưu ý: Kiểm tra lại tên cột 'full_name' trong bảng users và 'room_number' trong bảng rooms của bạn xem có đúng không
        $sql = "SELECT 
                    r.rating, 
                    r.comment, 
                    r.created_at,
                    u.full_name,     /* Lấy tên khách */
                    rm.room_number   /* Lấy số phòng */
                FROM reviews r
                JOIN bookings b ON r.booking_id = b.id
                JOIN users u ON b.user_id = u.id
                JOIN rooms rm ON b.room_id = rm.id
                WHERE r.room_type_id = ?
                ORDER BY r.created_at DESC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $roomTypeId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Lấy điểm trung bình + tổng review
    public function getRatingSummary($roomTypeId)
    {
        $sql = "SELECT 
                    AVG(rating) AS avg_rating,
                    COUNT(id) AS total_reviews
                FROM reviews
                WHERE room_type_id = ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $roomTypeId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Lưu review
    public function create($bookingId, $roomTypeId, $rating, $comment)
    {
        $sql = "INSERT INTO reviews (booking_id, room_type_id, rating, comment, created_at)
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iiis", $bookingId, $roomTypeId, $rating, $comment);

        return $stmt->execute();
    }

    public function hasReviewed($bookingId)
    {
        $sql = "SELECT id FROM reviews WHERE booking_id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }
}
