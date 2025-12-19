<?php

namespace App\Controllers;

use App\Controller;
use App\Model\User;

class AdminController extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function admin()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 1) {
            header('Location: /login');
            exit();
        }

        // Gọi view hiển thị Dashboard admin
        // Lưu ý: File view phải nằm ở src/Views/admin/adminhome.php
        $this->render('admin/adminhome');
    }
}
