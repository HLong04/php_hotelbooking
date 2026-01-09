<?php

namespace App\Controllers;

use App\Controller;
use App\Model\RoomType;

class TypeRoomController extends Controller
{
    private $roomTypeModel;

    public function __construct()
    {
        $this->roomTypeModel = new RoomType();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }

    /**
     * 1. DANH SÁCH LOẠI PHÒNG
     * Route: /admin/typeroom
     */

    public function qltyperoom()
    {
        $this->requireAdmin();

        $keyword  = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $capacity = isset($_GET['capacity']) ? $_GET['capacity'] : '';
        $maxPrice = isset($_GET['price']) ? $_GET['price'] : '';

        if ($keyword != '' || $capacity != '' || $maxPrice != '') {
            $types = $this->roomTypeModel->searchRoomTypes($keyword, $capacity, $maxPrice);
        } else {
            $types = $this->roomTypeModel->getAllRoomTypes();
        }

        $data = [
            'types' => $types,
            'keyword' => $keyword,
            'capacity' => $capacity,
            'maxPrice' => $maxPrice
        ];
        $this->render('admin/room_types/qltyperoom', $data);
    }

    /**
     * 2. TẠO LOẠI PHÒNG MỚI
     * Route: /admin/typeroom/create
     */

    public function createType()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $price = trim($_POST['price']);
            $max_adults = trim($_POST['max_adults']);
            $description = trim($_POST['description']);

            $imageName = 'default.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageName = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $imageName);
            }
            $result = $this->roomTypeModel->createRoomType($name, $price, $max_adults, $description, $imageName);

            if ($result) {
                $_SESSION['flash_message'] = "Thêm loại phòng thành công!";
                header('Location: /admin/typeroom');
                exit();
            } else {
                $data = ['error' => 'Lỗi hệ thống, vui lòng thử lại!'];
                $this->render('admin/room_types/create', $data);
            }
        } else {
            $this->render('admin/room_types/create');
        }
    }

    /**
     * 3. CẬP NHẬT LOẠI PHÒNG
     * Route: /admin/typeroom/update/{id}
     */

    public function updateType($id)
    {
        $type = $this->roomTypeModel->getRoomTypeById($id);
        if (!$type) {
            $_SESSION['flash_message'] = "Không tìm thấy loại phòng!";
            header('Location: /admin/typeroom');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $max_adults = trim($_POST['max_adults']);
            $price = trim($_POST['price']);
            $description = trim($_POST['description']);
            $imageName = $type['image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $imageName = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $imageName);
            }
            $this->roomTypeModel->updateRoomType($id, $name, $price, $max_adults, $description, $imageName);

            $_SESSION['flash_message'] = "Cập nhật thành công!";
            header('Location: /admin/typeroom');
            exit();
        } else {
            $this->render('admin/room_types/update', ['type' => $type]);
        }
    }

    /**
     * 4. XÓA LOẠI PHÒNG
     * Route: /admin/typeroom/delete/{id}
     */
    
    public function deleteType($id)
    {
        $this->roomTypeModel->deleteRoomType($id);

        $_SESSION['flash_message'] = "Đã xóa loại phòng!";
        header('Location: /admin/typeroom');
        exit();
    }
}
