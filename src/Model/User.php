<?php

namespace App\Models;

class User
{
    private $connection;

    public function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;

        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    //all user
    public function getAllUsers()
    {
        $result = $this->connection->query("SELECT * FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //insert user
    public function register($fullName, $email, $password, $phone)
    {
        $fullName = $this->connection->real_escape_string($fullName);
        $email = $this->connection->real_escape_string($email);
        $phone = $this->connection->real_escape_string($phone);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, email, password, phone) 
                VALUES ('$fullName', '$email', '$hashedPassword', '$phone')";

        return $this->connection->query($sql);
    }

    //login
    public function login($email, $password)
    {
        $email = $this->connection->real_escape_string($email);
        $result = $this->connection->query("SELECT * FROM users WHERE email = '$email'");

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    //lấy thông tin user
    public function getUserById($id)
    {
        $id = $this->connection->real_escape_string($id);
        $result = $this->connection->query("SELECT * FROM users WHERE id = $id");
        return $result->fetch_assoc();
    }

    //update user
    public function updateUser($id, $fullName, $email, $phone)
    {
        $id = $this->connection->real_escape_string($id);
        $fullName = $this->connection->real_escape_string($fullName);
        $email = $this->connection->real_escape_string($email);
        $phone = $this->connection->real_escape_string($phone);

        $sql = "UPDATE users 
                SET full_name='$fullName', email='$email', phone='$phone' 
                WHERE id=$id";

        return $this->connection->query($sql);
    }

    //delete
    public function deleteUser($id)
    {
        $id = $this->connection->real_escape_string($id);
        $sql = "DELETE FROM users WHERE id=$id";

        return $this->connection->query($sql);
    }

    //đôi mật khẩu riêng
    public function changePassword($id, $newPassword)
    {
        $id = $this->connection->real_escape_string($id);
        // Mã hóa mật khẩu mới
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password='$hashedPassword' WHERE id=$id";

        return $this->connection->query($sql);
    }
}
