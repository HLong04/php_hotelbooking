<?php

namespace App\Controllers;

use App\Controller;
use App\Model\User;
use App\Model\Booking;
use App\Model\Room;
use App\Model\RoomType;

class AdminController extends Controller
{
    private $userModel;
    private $roomModel;
    private $bookingModel;
    private $roomTypeModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->roomModel = new Room();
        $this->roomTypeModel = new RoomType();
        $this->bookingModel = new Booking(); 
    }

    public function admin()
    {
        // 1. Check quyền Admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }

        $countUsers = $this->userModel->countUsers(); // Hàm tự viết trong Model User
        $countRooms = $this->roomModel->countRooms(); // Hàm tự viết trong Model Room
        $countRoomTypes = $this->roomTypeModel->countRoomTypes(); // Hàm tự viết trong Model RoomType
        $revenue    = $this->bookingModel->getTotalRevenue(); // Hàm tự viết trong Model Booking

        $data = [
            'so_user' => $countUsers,
            'so_room' => $countRooms,
            'so_room_type' => $countRoomTypes,
            'tong_tien' => $revenue
        ];

        $this->render('admin/dashboard', $data);
    }
}