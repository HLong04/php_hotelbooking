<?php

namespace App\Model;

class Room
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset("utf8");
    }

    // ================================================================
    // 1. HÀM DÙNG CHO TRANG CHỦ (HOME PAGE)
    // Mục đích: Chỉ lấy danh sách LOẠI PHÒNG (Standard, VIP...)
    // ================================================================
    public function getFeaturedRooms($limit = 4)
    {
        // Query này lấy từ bảng room_types (Loại phòng) chứ không phải bảng rooms (Phòng lẻ)
        // Đảm bảo trang chủ luôn hiện 4 ô gọn gàng
        $sql = "SELECT * FROM room_types ORDER BY price ASC LIMIT ?";
        
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ================================================================
    // 2. HÀM DÙNG CHO TRANG TÌM KIẾM (SEARCH PAGE)
    // Mục đích: Lấy danh sách PHÒNG CỤ THỂ (101, 102...) còn trống
    // ================================================================
    public function searchAvailableRoomTypes($checkIn, $checkOut) {
        // Query này lấy từ bảng rooms (Phòng lẻ)
        $sql = "SELECT r.*, 
                       rt.name as room_type_name, 
                       rt.price, 
                       rt.image, 
                       rt.description
                FROM rooms r
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.status = 'available'
                AND r.id NOT IN (
                    SELECT b.room_id 
                    FROM bookings b 
                    WHERE (
                        (b.check_in <= ? AND b.check_out >= ?) 
                        AND b.status != 'cancelled'
                    )
                )
                ORDER BY r.room_number ASC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("ss", $checkOut, $checkIn);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ================================================================
    // 3. CÁC HÀM CRUD CHO ADMIN (GIỮ NGUYÊN)
    // ================================================================

    public function getAllRooms()
    {
        $sql = "SELECT r.*, rt.name as room_type_name, rt.price, rt.image 
                FROM rooms r 
                JOIN room_types rt ON r.room_type_id = rt.id 
                ORDER BY room_number ASC";
        return $this->mysqli->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getRoomById($id)
    {
        $sql = "SELECT * FROM rooms WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Lấy danh sách các phòng theo ID loại phòng
     */
    public function getRoomsByType($roomTypeId)
    {
        
        $roomTypeId = $this->mysqli->real_escape_string($roomTypeId);

        $sql = "SELECT * FROM rooms WHERE room_type_id = '$roomTypeId' ORDER BY room_number ASC";
        
        $result = $this->mysqli->query($sql);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createRoom($typeId, $number, $status)
    {
        $sql = "INSERT INTO rooms (room_type_id, room_number, status) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iss", $typeId, $number, $status);
        return $stmt->execute();
    }

    public function updateRoom($id, $typeId, $number, $status)
    {
        $sql = "UPDATE rooms SET room_type_id=?, room_number=?, status=? WHERE id=?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("issi", $typeId, $number, $status, $id);
        return $stmt->execute();
    }

    public function deleteRoom($id)
    {
        $sql = "DELETE FROM rooms WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}