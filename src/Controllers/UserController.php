<?php

namespace App\Controllers;

use App\Controller;
use App\Model\Booking;
use App\Model\User;

class UserController extends Controller
{
    private $userModel;
    private $bookingModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->bookingModel = new Booking();
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
        // ==================================================================
        // BẮT ĐẦU ĐOẠN CODE CẦN THÊM (LOGIC TÍNH RANK)
        // ==================================================================
        
        $totalSpent = (float)($user['total_spent'] ?? 0);
        
        // Cấu hình mốc tiền (Bạn có thể đổi số ở đây)
        $milestones = [
            'vip' => 10000000,      // 10 triệu lên VIP
            'diamond' => 50000000  // 50 triệu lên Diamond
        ];

        // Mặc định
        $currentRank = 'standard'; 
        $nextRank = 'VIP';
        $moneyNeeded = 0;
        $percent = 0;

        if ($totalSpent < $milestones['vip']) {
            // Đang là Standard
            $currentRank = 'standard';
            $nextRank = 'VIP';
            $moneyNeeded = $milestones['vip'] - $totalSpent;
            $percent = ($totalSpent / $milestones['vip']) * 100;

        } elseif ($totalSpent < $milestones['diamond']) {
            // Đang là VIP
            $currentRank = 'vip';
            $nextRank = 'Diamond';
            $moneyNeeded = $milestones['diamond'] - $totalSpent;
            
            // Tính % trong khoảng từ VIP đến Diamond
            $range = $milestones['diamond'] - $milestones['vip'];
            $progress = $totalSpent - $milestones['vip'];
            $percent = ($progress / $range) * 100;

        } else {
            // Đã là Diamond
            $currentRank = 'diamond';
            $nextRank = 'Max Level';
            $moneyNeeded = 0;
            $percent = 100;
        }

        // Đóng gói dữ liệu để gửi sang View
        $rankInfo = [
            'current_rank' => ucfirst($currentRank), // Viết hoa chữ cái đầu
            'next_rank'    => $nextRank,
            'needed'       => number_format($moneyNeeded, 0, ',', '.'),
            'total_spent'  => number_format($totalSpent, 0, ',', '.'),
            'percent'      => round($percent)
        ];

        // ==================================================================
        // KẾT THÚC ĐOẠN CODE CẦN THÊM
        // ==================================================================

        $this->render('user/profile', [
            'user' => $user,
            'rankInfo' => $rankInfo
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


    //admin
    public function qluser()
    {
        $this->requireAdmin();

        $users = $this->userModel->getAllUsers();

        foreach ($users as &$user) {
            $user['total_spent'] = $this->bookingModel->getTotalMoneyByUserId($user['id']);
        }
        unset($user);

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
            $totalspent = $_POST['total_spent'];
            $ranklevel = $_POST['rank_level'];

            $isCreated = $this->userModel->createUser($fullName, $email, $password, $phone, $role, $totalspent, $ranklevel);

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
            $totalspent = $_POST['total_spent'];
            $ranklevel = $_POST['rank_level'];

            $this->userModel->updateUserWithRole($id, $fullName, $email, $phone, $role, $totalspent, $ranklevel);

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
