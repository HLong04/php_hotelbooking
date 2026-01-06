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

    public function getFeaturedRooms($limit = 10)
    {
        $sql = "SELECT * FROM room_types ORDER BY price ASC LIMIT ?";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // 1. Đếm tổng số bản ghi (Phục vụ phân trang)
    public function countsRooms($keyword = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as total FROM rooms r WHERE 1=1";
        $types = "";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (r.id LIKE ? OR r.room_number LIKE ?)";
            $keywordParam = "%$keyword%";
            $types .= "ss";
            $params[] = $keywordParam;
            $params[] = $keywordParam;
        }

        if (!empty($status)) {
            $sql .= " AND r.status = ?";
            $types .= "s";
            $params[] = $status;
        }

        $stmt = $this->mysqli->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    // 2. Lấy danh sách phòng có Phân trang & Tìm kiếm
    public function getRoomsPagination($keyword = '', $status = '', $limit = 10, $offset = 0)
    {
        // Có JOIN để lấy tên loại phòng
        $sql = "SELECT r.*, rt.name as room_type_name 
                FROM rooms r
                LEFT JOIN room_types rt ON r.room_type_id = rt.id
                WHERE 1=1";

        $types = "";
        $params = [];

        // Lọc theo từ khóa
        if (!empty($keyword)) {
            $sql .= " AND (r.id LIKE ? OR r.room_number LIKE ?)";
            $keywordParam = "%$keyword%";
            $types .= "ss";
            $params[] = $keywordParam;
            $params[] = $keywordParam;
        }

        // Lọc theo trạng thái
        if (!empty($status)) {
            $sql .= " AND r.status = ?";
            $types .= "s";
            $params[] = $status;
        }

        // Thêm sắp xếp và giới hạn
        $sql .= " ORDER BY r.id DESC LIMIT ? OFFSET ?";
        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ================================================================
    // 2. HÀM DÙNG CHO TRANG TÌM KIẾM (SEARCH PAGE)
    // Mục đích: Lấy danh sách PHÒNG CỤ THỂ (101, 102...) còn trống
    // ================================================================

    public function searchAvailableRoomTypes($checkIn, $checkOut, $maxGuests)
    {
        $sql = "SELECT r.*, 
                       rt.name as room_type_name, 
                       rt.price, 
                       rt.image, 
                       rt.description, rt.max_adults
                FROM rooms r
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.status = 'available' AND rt.max_adults >= ? 
                AND r.id NOT IN (
                    SELECT b.room_id 
                    FROM bookings b 
                    WHERE (
                        (b.check_in <= ? AND b.check_out >= ?) 
                        AND b.status != 'cancelled' AND b.status != 'completed'
                    )
                )
                ORDER BY r.room_number ASC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iss", $maxGuests, $checkOut, $checkIn);

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

    public function countStatusRooms()
    {
        $sql = "SELECT Count(*) as total FROM rooms WHERE status = 'available'";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }

    public function getRoomById($id)
    {
        $sql = "SELECT r.*, 
                   rt.name AS room_type_name,
                   rt.price,
                   rt.image
            FROM rooms r
            JOIN room_types rt ON r.room_type_id = rt.id
            WHERE r.id = ?";

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

    public function countRooms()
    {
        $sql = "SELECT COUNT(*) as total FROM rooms";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function updateStatus($roomId, $status)
    {
        $sql = "UPDATE rooms SET status = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $status, $roomId);
        return $stmt->execute();
    }

    public function updateRoomStatus($roomId, $status)
    {
        $sql = "UPDATE rooms SET status = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("si", $status, $roomId);
        return $stmt->execute();
    }
}
