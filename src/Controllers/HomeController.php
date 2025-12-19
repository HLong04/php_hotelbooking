<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room; 

class HomeController extends Controller {
    
    private $roomModel;

    public function __construct() {
        $this->roomModel = new Room();
    }

    public function index() {
        $rooms = $this->roomModel->getAllRooms(); 
        $this->render('user/home', ['rooms' => $rooms]); 
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