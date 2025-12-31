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

        $countUsers = $this->userModel->countUsers();
        $countRooms = $this->roomModel->countRooms(); 
        $countRoomTypes = $this->roomTypeModel->countRoomTypes(); 
        $revenue    = $this->bookingModel->getTotalRevenue();
        $recent_orders = $this->bookingModel->getRecentOrders(5);
        $countPendingBookings = $this->bookingModel->countBookingByPending();

        // 2. Truyền dữ liệu sang View
        $data = [
            'so_user' => $countUsers,
            'so_room' => $countRooms,
            'so_room_type' => $countRoomTypes,
            'tong_tien' => $revenue,
            'recent_orders' => $recent_orders,
            'pending_bookings' => $countPendingBookings
        ];

        $this->render('admin/dashboard', $data);
    }

}