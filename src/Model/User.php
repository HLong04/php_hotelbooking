<?php

namespace App\Model;

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
        $this->connection->set_charset("utf8");
    }

    public function getAllUsers()
    {
        $result = $this->connection->query("SELECT * FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProfileById($id)
    {
        $id = (int)$id;

        $sql = "SELECT 
                id, 
                full_name, 
                email, 
                phone, 
                role, 
                password,       -- <--- Thêm password
                created_at,
                total_spent,
                rank_level
            FROM users 
            WHERE id = $id";

        $result = $this->connection->query($sql);
        return $result->fetch_assoc();
    }

    public function emailExistsExceptUser($email, $id)
    {
        $email = $this->connection->real_escape_string($email);
        $id = (int)$id;

        $sql = "SELECT id FROM users 
            WHERE email = '$email' AND id != $id";

        $result = $this->connection->query($sql);
        return $result->num_rows > 0;
    }

    public function updatePassword($id, $password)
    {
        $stmt = $this->connection->prepare(
            "UPDATE users SET password = ? WHERE id = ?"
        );
        $stmt->bind_param("si", $password, $id);
        return $stmt->execute();
    }



    public function getUserById($id)
    {
        $id = $this->connection->real_escape_string($id);
        $result = $this->connection->query("SELECT * FROM users WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function countUsers()
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE role = 0";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }


    public function login($email, $password)
    {
        $email = $this->connection->real_escape_string($email);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password']) || $password == $user['password']) {
                return $user;
            }
        }
        return null;
    }

    public function register($fullName, $email, $password, $phone)
    {
        $fullName = $this->connection->real_escape_string($fullName);
        $email = $this->connection->real_escape_string($email);
        $phone = $this->connection->real_escape_string($phone);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, email, password, phone, role) 
                VALUES ('$fullName', '$email', '$hashedPassword', '$phone', 0)";

        return $this->connection->query($sql);
    }


    public function createUser($fullName, $email, $password, $phone, $role, $totalspent, $ranklevel)
    {
        $fullName = $this->connection->real_escape_string($fullName);
        $email = $this->connection->real_escape_string($email);
        $phone = $this->connection->real_escape_string($phone);
        $role = (int)$role;
        $totalspent = (float)$totalspent;
        $ranklevel = (int)$ranklevel;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, email, password, phone, role, total_spent, rank_level) 
                VALUES ('$fullName', '$email', '$hashedPassword', '$phone', '$role', '$totalspent', '$ranklevel')";

        return $this->connection->query($sql);
    }

    public function updateUserWithRole($id, $fullName, $email, $phone, $role, $totalspent, $ranklevel)
    {
        $id = $this->connection->real_escape_string($id);
        $fullName = $this->connection->real_escape_string($fullName);
        $email = $this->connection->real_escape_string($email);
        $phone = $this->connection->real_escape_string($phone);
        $role = (int)$role;
        $totalspent = (float)$totalspent;
        
        $ranklevel = $this->connection->real_escape_string($ranklevel);

        $sql = "UPDATE users 
                SET full_name='$fullName', email='$email', phone='$phone', role='$role', total_spent='$totalspent', rank_level='$ranklevel'
                WHERE id=$id";

        return $this->connection->query($sql);
    }

    public function adminResetPassword($id, $newPassword)
    {
        return $this->changePassword($id, $newPassword);
    }

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

    public function deleteUser($id)
    {
        $id = $this->connection->real_escape_string($id);
        $sql = "DELETE FROM users WHERE id=$id";
        return $this->connection->query($sql);
    }

    public function changePassword($id, $newPassword)
    {
        $id = $this->connection->real_escape_string($id);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$hashedPassword' WHERE id=$id";
        return $this->connection->query($sql);
    }


    public function checkEmailExists($email)
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";


        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function updateMemberRank($userId)
    {
        $sql = "SELECT SUM(total_price) as total_spent 
                FROM bookings 
                WHERE user_id = ? AND status = 'completed'";
                
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        $totalSpent = (float)($result['total_spent'] ?? 0);

        $rank = 'standard';         
        if ($totalSpent >= 50000000) { 
            $rank = 'diamond';
        } elseif ($totalSpent >= 10000000) { 
            $rank = 'vip';  
        }
        $updateSql = "UPDATE users SET total_spent = ?, rank_level = ? WHERE id = ?";
        $updateStmt = $this->connection->prepare($updateSql);
        $updateStmt->bind_param("dsi", $totalSpent, $rank, $userId);
        
        return $updateStmt->execute();
    }
}
