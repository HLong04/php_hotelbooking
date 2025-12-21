<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room;
use App\Model\RoomType;

class HomeController extends Controller {
    
    private $roomModel;
    private $roomTypeModel;

    public function __construct() {
        // Khởi tạo Model 1 lần dùng cho toàn class
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();  
    }

    /**
     * TRANG CHỦ
     * Route: /
     */
    public function index() {
        // [CẬP NHẬT] Dùng hàm getFeaturedRooms từ Room.php (vừa thêm ở bước trước)
        // Để lấy đúng 4 loại phòng hiển thị ra trang chủ
        $featuredRooms = $this->roomModel->getFeaturedRooms(4); 
        
        // Truyền biến 'roomTypes' để khớp với view home của bạn
        $this->render('user/home', ['roomTypes' => $featuredRooms]); 
    }

    /**
     * Xem danh sách phòng theo Loại (VD: Bấm vào "Xem danh sách" của loại Deluxe)
     * Route: /rooms/type/{id}
     */
    public function roomsByType($id) {
        // 1. Lấy thông tin loại phòng (Tên, giá...)
        // Dùng $this->roomTypeModel thay vì new RoomType()
        $typeInfo = $this->roomTypeModel->getRoomTypeById($id);

        if (!$typeInfo) {
            // Nếu khách nhập ID linh tinh -> về trang chủ hoặc trang danh sách
            header("Location: /rooms"); 
            exit;
        }

        // 2. Lấy danh sách các phòng cụ thể (101, 102...) thuộc loại này
        $roomList = $this->roomModel->getRoomsByType($id);
        
        // 3. Render view
        // Bạn kiểm tra lại tên file view là 'detail_room' hay 'rooms_by_type' nhé
        // Theo code cũ của bạn là 'user/detail_room'
        $this->render('user/detail_room', [
            'typeInfo' => $typeInfo,
            'roomList' => $roomList
        ]);
    }
    
    /**
     * Trang danh sách tất cả phòng (nếu có)
     * Route: /rooms
     */
    public function listRoom() {
      // [QUAN TRỌNG] Đổi sang dùng Model Room (thay vì RoomType)
        $roomModel = new \App\Model\Room();
        
        // Gọi hàm vừa viết để lấy danh sách chi tiết (101, 102...)
        $rooms = $roomModel->getAllRoomsWithDetails(); 

        // Render ra view
        $this->render('user/list', ['rooms' => $rooms]);
    }

    /**
     * Xem chi tiết 1 phòng cụ thể
     * Route: /room/detail/{id}
     */
    public function detailRoom($id) {
        $room = $this->roomModel->getRoomById($id);
        
        if (!$room) {
            // Xử lý lỗi đẹp hơn echo
            header("Location: /rooms");
            exit;
        }
        
        $this->render('user/detailroom', ['room' => $room]);
    }
}