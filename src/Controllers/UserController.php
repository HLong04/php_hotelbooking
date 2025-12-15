<?php

namespace App\Controllers;

use App\Model\User;
use App\Controller;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function showAll()
    {
        $users = $this->userModel->getAllUsers();

        $this->render('users\user-list', ['users' => $users]);
    }

    public function show($userId)
    {
        $user = $this->userModel->getUserById($userId);
        $this->render('users\user-detail', ['user' => $user]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $fullName = $_POST['full_name']; 
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $passwordCheck = $_POST['password_check'];
            
            if ($password !== $passwordCheck) {
                echo "<script>alert('Mật khẩu nhập lại không khớp!');</script>";
            } else {
                $isCreated = $this->userModel->register($fullName, $email, $password, $phone);

                if ($isCreated) {
                    header('Location: /users'); 
                    exit();
                } else {
                    echo "<script>alert('Lỗi: Email có thể đã tồn tại!');</script>";
                }
            }
        }

        $this->render('users\user-form', ['user' => []]);
    }

    public function update($userId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fullName = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];


            $this->userModel->updateUser($userId, $fullName, $email, $phone);
            
            header('Location: /users');
            exit();
        }

        $user = $this->userModel->getUserById($userId);
        
        $this->render('users\user-form', ['user' => $user]);
    }

    public function delete($userId)
    {
        $this->userModel->deleteUser($userId);

        header('Location: /users');
        exit();
    }
}