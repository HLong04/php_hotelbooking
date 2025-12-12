<?php

namespace App\Models;

class Booking
{
    private $connection;

    public function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;

        $this->connection = new \mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // Tạo đơn đặt phòng
    public function createBooking($userId, $roomId, $checkIn, $checkOut, $totalPrice)
    {
        $userId = $this->connection->real_escape_string($userId);
        $roomId = $this->connection->real_escape_string($roomId);
        $checkIn = $this->connection->real_escape_string($checkIn);
        $checkOut = $this->connection->real_escape_string($checkOut);
        $totalPrice = $this->connection->real_escape_string($totalPrice);

        // Mặc định status là 'pending'
        $sql = "INSERT INTO bookings (user_id, room_id, check_in, check_out, total_price, status) 
                VALUES ('$userId', '$roomId', '$checkIn', '$checkOut', '$totalPrice', 'pending')";
        
        return $this->connection->query($sql);
    }

    // Lấy danh sách lịch sử đặt phòng của 1 user
    public function getBookingsByUserId($userId)
    {
        $userId = $this->connection->real_escape_string($userId);
        
        // Join bảng để lấy tên loại phòng hiển thị cho đẹp
        $sql = "SELECT bookings.*, room_types.name as room_name, rooms.room_number 
                FROM bookings 
                JOIN rooms ON bookings.room_id = rooms.id 
                JOIN room_types ON rooms.room_type_id = room_types.id
                WHERE bookings.user_id = $userId
                ORDER BY bookings.created_at DESC";

        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Admin lấy tất cả booking
    public function getAllBookings()
    {
        $sql = "SELECT bookings.*, users.full_name, rooms.room_number 
                FROM bookings 
                JOIN users ON bookings.user_id = users.id
                JOIN rooms ON bookings.room_id = rooms.id
                ORDER BY bookings.created_at DESC";
                
        $result = $this->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}