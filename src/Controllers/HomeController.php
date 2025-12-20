<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room;
use App\Model\RoomType;

class HomeController extends Controller {
    
    private $roomModel;
    private $roomTypeModel;
//home controller
    public function __construct() {
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();  
    }

    public function index() {
        $roomTypes = $this->roomTypeModel->getAllRoomTypes(); 
        $this->render('user/home', ['roomTypes' => $roomTypes]); 
    }

    // Hàm mới: Hiển thị danh sách phòng thuộc một loại cụ thể
    public function listRoomsByType($id) {
        // Lấy thông tin loại phòng để hiển thị tiêu đề
        $typeInfo = $this->roomTypeModel->getRoomTypeById($id);

        if (!$typeInfo) {
            echo "Loại phòng không tồn tại";
            return;
        }
        $rooms = $this->roomModel->getRoomsByType($id);

        $this->render('user/rooms_by_type', [
            'rooms' => $rooms, 
            'typeInfo' => $typeInfo
        ]);
    }

    public function roomsByType($id) {
        $roomModel = new Room();
        $roomTypeModel = new RoomType();

        // 1. Lấy thông tin chi tiết của Loại phòng (Tên, giá, mô tả...)
        $typeInfo = $roomTypeModel->getRoomTypeById($id);

        // 2. Lấy danh sách các phòng cụ thể thuộc loại này (P101, P102...)
        // Hàm getRoomsByType đã có sẵn trong Room.php của bạn rồi
        $roomList = $roomModel->getRoomsByType($id);

        if (!$typeInfo) {
            // Xử lý nếu ID không tồn tại (có thể chuyển về trang chủ hoặc báo lỗi)
            header("Location: /rooms"); 
            exit;
        }

        // 3. Render ra view 'detail_room.php' và truyền dữ liệu
        $this->render('user/detail_room', [
            'typeInfo' => $typeInfo,
            'roomList' => $roomList
        ]);
    }
    
    public function listRoom() {
        $rooms = $this->roomModel->getAllRooms();
        // Bạn cần tạo file src/Views/user/list.php (hoặc dùng lại layout danh sách)
        $this->render('user/list', ['rooms' => $rooms]); 
    }

    public function detailRoom($id) {
        $room = $this->roomModel->getRoomById($id);
        if (!$room) {
            echo "Phòng không tồn tại";
            return;
        }
        $this->render('user/detailroom', ['room' => $room]);
    }
}