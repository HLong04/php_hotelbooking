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
        $typeInfo = $roomTypeModel->getRoomTypeById($id);

        $roomList = $roomModel->getRoomsByType($id);

        if (!$typeInfo) {
            header("Location: /rooms"); 
            exit;
        }
        $this->render('user/detail_room', [
            'typeInfo' => $typeInfo,
            'roomList' => $roomList
        ]);
    }
    
    public function listRoom() {
        $rooms = $this->roomModel->getAllRooms();
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