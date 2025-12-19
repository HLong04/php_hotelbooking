<?php

namespace App\Controllers;

use App\Controller;
use App\Model\User;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    private function requireAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }

    public function qluser()
    {
        $this->requireAdmin();
        $users = $this->userModel->getAllUsers();
        $this->render('admin/users/qluser', ['users' => $users]);
    }

    public function create()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];

            $isCreated = $this->userModel->createUser($fullName, $email, $password, $phone, $role);

            if ($isCreated) {
                $_SESSION['flash_message'] = "Thêm người dùng thành công!";
                header('Location: /admin/users');
                exit();
            } else {
                $this->render('admin/users/create', ['error' => 'Lỗi: Email có thể đã tồn tại!']);
            }
        } else {
            $this->render('admin/users/create');
        }
    }

    public function update($id)
    {
        $this->requireAdmin();
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            header('Location: /admin/users');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            $newPassword = $_POST['password']; 

            $this->userModel->updateUserWithRole($id, $fullName, $email, $phone, $role);

            if (!empty($newPassword)) {
                $this->userModel->adminResetPassword($id, $newPassword);
            }

            $_SESSION['flash_message'] = "Cập nhật thành công!";
            header('Location: /admin/users');
            exit();
        } else {
            $this->render('admin/users/update', ['user' => $user]);
        }
    }

    public function delete($id)
    {
        $this->requireAdmin();
        if ($id == $_SESSION['user_id']) {
            $_SESSION['flash_message'] = "Không thể xóa tài khoản đang đăng nhập!";
        } else {
            $this->userModel->deleteUser($id);
            $_SESSION['flash_message'] = "Xóa người dùng thành công!";
        }
        header('Location: /admin/users');
        exit();
    }
}