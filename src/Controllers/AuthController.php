<?php

namespace App\Controllers;

use App\Controller;
use App\Model\User;

class AuthController extends Controller
{
    //login model
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Xử lý Đăng nhập
     */
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) {
                header('Location: /admin');
            } else {
                header('Location: /');
            }
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_phone'] = $user['phone'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['flash_message'] = "Đăng nhập thành công!";

                if ($user['role'] == 1) {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit();
            } else {
                // Đăng nhập thất bại
                $error = "Email hoặc mật khẩu không đúng!";
                $this->render('auth/login', ['error' => $error]);
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $passwordCheck = $_POST['password_check'];

            if ($password !== $passwordCheck) {
                $this->render('auth/register', ['error' => 'Mật khẩu nhập lại không khớp!']);
                return;
            }

            $isCreated = $this->userModel->register($fullName, $email, $password, $phone);

            if ($isCreated) {
                $_SESSION['flash_message'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: /login?msg=registered');
                exit();
            } else {
                $this->render('auth/register', ['error' => 'Email này đã được sử dụng hoặc có lỗi xảy ra!']);
            }
        } else {
            $this->render('auth/register');
        }
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}