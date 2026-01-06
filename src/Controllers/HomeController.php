<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Room;
use App\Model\RoomType;
use App\Model\User;

class HomeController extends Controller
{

    private $roomModel;
    private $roomTypeModel;
    private $userModel;

    public function __construct()
    {
        // Khởi tạo Model 1 lần dùng cho toàn class
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
        $this->userModel = new User();
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
        $featuredRooms = $this->roomModel->getFeaturedRooms(10);
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
        header("Location: /");
        exit;
    }

    $roomList = $this->roomModel->getRoomsByType($id);

    $reviewModel = new \App\Model\Review();
    $reviews     = $reviewModel->getByRoomTypeId($id);
    $ratingInfo  = $reviewModel->getRatingSummary($id);

    $this->render('user/detail_room', [
        'typeInfo' => $typeInfo,
        'roomList' => $roomList ,
        'reviews'  => $reviews,
        'rating'   => $ratingInfo
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
        $coutstausrooms = $this->roomModel->countStatusRooms();
        $this->render('user/list', ['rooms' => $rooms, 'typeroom' => $typeroom, 'coutstatusrooms' => $coutstausrooms]);
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