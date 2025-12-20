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
//rome controller
    /**
     * Hiển thị danh sách phòng
     * Route: /admin/rooms
     */
    public function qlroom()
    {
        $this->requireAdmin();

        $rooms = $this->roomModel->getAllRooms();
        
        $this->render('admin/rooms/qlroom', ['rooms' => $rooms]);
    }

    /**
     * Thêm mới phòng (Hiển thị Form & Xử lý Lưu)
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

 
    // Route: /admin/rooms/update/{id}

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