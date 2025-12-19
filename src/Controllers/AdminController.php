<?php

namespace App\Controllers;

use App\Controller;
use App\Model\User;
use App\Model\Room;     // Import Model Phòng
use App\Model\Booking;  // Import Model Đặt phòng (Hoặc Order tùy tên bạn đặt)
use App\Model\RoomType;

class AdminController extends Controller
{
    private $userModel;
    private $roomModel;
    private $bookingModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->roomModel = new RoomType();
        $this->bookingModel = new Booking(); 
    }

    public function admin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }

        $countUsers = $this->userModel->countUsers();
        $countRooms = $this->roomModel->countRooms();
        $revenue    = $this->bookingModel->getTotalRevenue();

        // 3. Đóng gói dữ liệu để gửi sang View
        $data = [
            'so_user' => $countUsers,
            'so_room' => $countRooms,
            'tong_tien' => $revenue
        ];
        // Lưu ý: Đường dẫn 'admin/adminhome' phải khớp với file src/Views/admin/adminhome.php
        $this->render('admin/adminhome', $data);
    }
}