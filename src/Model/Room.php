<?php

namespace App\Model;

class Room
{
    private $mysqli;

    public function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;
        $this->mysqli = new \mysqli($host, $username, $password, $database);

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
        
        $this->mysqli->set_charset("utf8");
    }


    public function getAllRooms()
    {        
        $sql = "SELECT * FROM rooms ORDER BY room_number ASC";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getRoomById($id)
    {
        $id = $this->mysqli->real_escape_string($id);
        $sql = "SELECT * FROM rooms WHERE id = $id";
        $result = $this->mysqli->query($sql);

        return $result->fetch_assoc();
    }

    public function getRoomsByType($roomTypeId)
    {
        $roomTypeId = $this->mysqli->real_escape_string($roomTypeId);
        $sql = "SELECT * FROM rooms WHERE room_type_id = $roomTypeId";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countRooms()
    {
        $sql = "SELECT COUNT(*) as total FROM rooms";
        $result = $this->mysqli->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function createRoom($roomTypeId, $roomNumber, $status = 'Available')
    {
        $roomTypeId = $this->mysqli->real_escape_string($roomTypeId);
        $roomNumber = $this->mysqli->real_escape_string($roomNumber);
        $status = $this->mysqli->real_escape_string($status);

        $sql = "INSERT INTO rooms (room_type_id, room_number, status) 
                VALUES ('$roomTypeId', '$roomNumber', '$status')";
        
        return $this->mysqli->query($sql);
    }

    public function updateRoom($id, $roomTypeId, $roomNumber, $status)
    {
        $id = $this->mysqli->real_escape_string($id);
        $roomTypeId = $this->mysqli->real_escape_string($roomTypeId);
        $roomNumber = $this->mysqli->real_escape_string($roomNumber);
        $status = $this->mysqli->real_escape_string($status);

        $sql = "UPDATE rooms 
                SET room_type_id = '$roomTypeId', 
                    room_number = '$roomNumber', 
                    status = '$status' 
                WHERE id = $id";

        return $this->mysqli->query($sql);
    }


    public function deleteRoom($id)
    {
        $id = $this->mysqli->real_escape_string($id);
        $sql = "DELETE FROM rooms WHERE id = $id";
        return $this->mysqli->query($sql);
    }


    public function search($key)
    {
        $key = $this->mysqli->real_escape_string($key);
        $sql = "SELECT * FROM rooms WHERE room_number LIKE '%$key%'";
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}