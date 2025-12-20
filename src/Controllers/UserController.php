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
    private function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }


    private function requireAdmin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }
    }


    // Xem profile
    public function Profile($id)
    {
        $this->requireLogin();

        if ($_SESSION['user_id'] != $id) {
            header('Location: /');
            exit();
        }

        $user = $this->userModel->getProfileById($id);

        if (!$user) {
            header('Location: /');
            exit();
        }

        $this->render('user/profile', [
            'user' => $user
        ]);

    }

    // Cập nhật profile (update_profile)
    public function updateprofile($id)
    {
        $this->requireLogin();

        if ($_SESSION['user_id'] != $id) {
            header('Location: /');
            exit();
        }

        $user = $this->userModel->getProfileById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if ($this->userModel->emailExistsExceptUser($email, $id)) {
                return $this->render('profile/update_profile', [
                    'user' => $user,
                    'error' => 'Email đã tồn tại!'
                ]);
            }

            $this->userModel->updateUser($id, $fullName, $email, $phone);

            $_SESSION['flash_message'] = "Cập nhật hồ sơ thành công!";
            header("Location: /profile/$id");
            exit();
        }

        $this->render('user/update_profile', [
            'user' => $user
        ]);
    }
    public function changePassword($id)
{
    $this->requireLogin();

    if ($_SESSION['user_id'] != $id) {
        header('Location: /');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentPassword = $_POST['current_password'];
        $newPassword     = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        $user = $this->userModel->getProfileById($id);

        // 1. Kiểm tra mật khẩu hiện tại
        if (!password_verify($currentPassword, $user['password'])) {
            return $this->render('user/change_password', ['error' => 'Mật khẩu hiện tại không đúng!']);
        }

        // 2. Kiểm tra xác nhận mật khẩu
        if ($newPassword !== $confirmPassword) {
            return $this->render('user/change_password', ['error' => 'Mật khẩu xác nhận không khớp!']);
        }

        // 3. Kiểm tra độ mạnh
        if (strlen($newPassword) < 6) {
            return $this->render('user/change_password', ['error' => 'Mật khẩu phải có ít nhất 6 ký tự!']);
        }

        // 4. Update mật khẩu
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($id, $hashed);

        return $this->render('user/change_password', ['success' => 'Đổi mật khẩu thành công!']);
    }

    // GET request
    $this->render('user/change_password');
}



    //user controller

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