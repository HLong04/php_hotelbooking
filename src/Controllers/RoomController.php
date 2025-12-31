<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room;
use App\Model\RoomType;

class RoomController extends Controller
{
    private $roomModel;
    private $roomTypeModel;

    public function __construct()
    {
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

    // ==========================================
    // PHẦN NGƯỜI DÙNG (USER)
    // ==========================================

    /**
     * [QUAN TRỌNG] Tìm kiếm phòng trống theo ngày
     * Route: /search?checkin=...&checkout=...
     */
    public function search()
    {
        // 1. Lấy dữ liệu từ URL
        $checkIn = $_GET['checkin'] ?? null;
        $checkOut = $_GET['checkout'] ?? null;
        $maxAdults = $_GET['guests'] ?? null;

        // 2. Kiểm tra nếu thiếu ngày thì về trang chủ
        if (!$checkIn || !$checkOut) {
            header('Location: /');
            exit();
        }
        $typeroom = $this->roomTypeModel->getAllRoomTypes();
        // 3. Gọi Model để tìm các LOẠI PHÒNG còn trống
        // Hàm searchAvailableRoomTypes phải được khai báo trong Model/Room.php
        $availableRooms = $this->roomModel->searchAvailableRoomTypes($checkIn, $checkOut, $maxAdults);

        // 4. Render view kết quả
        $this->render('user/search_results', [
            'rooms' => $availableRooms,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'maxAdults' => $maxAdults,
            'typeroom' => $typeroom
        ]);
    }

    // ==========================================
    // PHẦN QUẢN TRỊ (ADMIN) - Code của bạn giữ nguyên
    // ==========================================

    /**
     * Hiển thị danh sách phòng
     * Route: /admin/rooms
     */
    public function qlroom()
    {
        $this->requireAdmin();

        $keyword = $_GET['keyword'] ?? '';
        $status = $_GET['status'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $limit = 10;
        $offset = ($page - 1) * $limit;

        // 3. Gọi Model
        $totalRecords = $this->roomModel->countsRooms($keyword, $status);
        $totalPages = ceil($totalRecords / $limit);
        $rooms = $this->roomModel->getRoomsPagination($keyword, $status, $limit, $offset);

        $data = [
            'rooms' => $rooms,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'keyword' => $keyword,
            'status' => $status
        ];
        $this->render('admin/rooms/qlroom', $data);
    }

    /**
     * Thêm mới phòng
     * Route: /admin/rooms/create
     */
    public function create()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roomNumber = $_POST['room_number'];
            $roomTypeId = $_POST['room_type_id'];
            $status     = $_POST['status'];

            $isCreated = $this->roomModel->createRoom($roomTypeId, $roomNumber, $status);

            if ($isCreated) {
                $_SESSION['flash_message'] = "Thêm phòng thành công!";
                header('Location: /admin/rooms');
                exit();
            } else {
                $error = "Lỗi: Không thể tạo phòng (Có thể số phòng bị trùng).";
                $roomTypes = $this->roomTypeModel->getAllRoomTypes();
                $this->render('admin/rooms/create', ['error' => $error, 'roomTypes' => $roomTypes]);
            }
        } else {
            $roomTypes = $this->roomTypeModel->getAllRoomTypes();
            $this->render('admin/rooms/create', ['roomTypes' => $roomTypes]);
        }
    }

    /**
     * Cập nhật phòng
     * Route: /admin/rooms/update/{id}
     */
    public function update($id)
    {
        $this->requireAdmin();
        $room = $this->roomModel->getRoomById($id);

        if (!$room) {
            $_SESSION['flash_message'] = "Phòng không tồn tại!";
            header('Location: /admin/rooms');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roomNumber = $_POST['room_number'];
            $roomTypeId = $_POST['room_type_id'];
            $status     = $_POST['status'];

            $isUpdated = $this->roomModel->updateRoom($id, $roomTypeId, $roomNumber, $status);

            if ($isUpdated) {
                $_SESSION['flash_message'] = "Cập nhật phòng thành công!";
                header('Location: /admin/rooms');
                exit();
            } else {
                $error = "Lỗi cập nhật phòng!";
                $roomTypes = $this->roomTypeModel->getAllRoomTypes();
                $this->render('admin/rooms/update', [
                    'error' => $error,
                    'room' => $room,
                    'roomTypes' => $roomTypes
                ]);
            }
        } else {
            $roomTypes = $this->roomTypeModel->getAllRoomTypes();
            $this->render('admin/rooms/update', [
                'room' => $room,
                'roomTypes' => $roomTypes
            ]);
        }
    }

    /**
     * Xóa phòng
     * Route: /admin/rooms/delete/{id}
     */
    public function delete($id)
    {
        $this->requireAdmin();
        $this->roomModel->deleteRoom($id);
        $_SESSION['flash_message'] = "Đã xóa phòng thành công!";
        header('Location: /admin/rooms');
        exit();
    }
}
