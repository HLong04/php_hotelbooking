<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room;
use App\Model\RoomType;

class HomeController extends Controller
{

    private $roomModel;
    private $roomTypeModel;

    public function __construct()
    {
        // Khởi tạo Model 1 lần dùng cho toàn class
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
    }

    public function services()
    {
        $this->render('user/services', []);
    }
    /**
     * TRANG CHỦ
     * Route: /
     */
    public function index()
    {
        $featuredRooms = $this->roomModel->getFeaturedRooms(5);

        $this->render('user/home', ['roomTypes' => $featuredRooms]);
    }

    /**
     * Xem danh sách phòng theo Loại (VD: Bấm vào "Xem danh sách" của loại Deluxe)
     * Route: /rooms/type/{id}
     */
    public function roomsByType($id)
    {
        $typeInfo = $this->roomTypeModel->getRoomTypeById($id);

        if (!$typeInfo) {
            header("Location: /rooms");
            exit;
        }

        $roomList = $this->roomModel->getRoomsByType($id);
        $this->render('user/detail_room', [
            'typeInfo' => $typeInfo,
            'roomList' => $roomList
        ]);
    }

    /**
     * Trang danh sách tất cả phòng (nếu có)
     * Route: /rooms
     */
    public function listRoom()
    {
        $rooms = $this->roomModel->getAllRooms();
        $typeroom = $this->roomTypeModel->getAllRoomTypes();
        $this->render('user/list', ['rooms' => $rooms, 'typeroom' => $typeroom]);
    }

    /**
     * Xem chi tiết 1 phòng cụ thể
     * Route: /room/detail/{id}
     */
    public function detailRoom($id)
    {
        $room = $this->roomModel->getRoomById($id);

        if (!$room) {
            // Xử lý lỗi đẹp hơn echo
            header("Location: /rooms");
            exit;
        }

        $this->render('user/detailroom', ['room' => $room]);
    }
}
