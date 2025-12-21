<?php

namespace App\Model;

class RoomType
{
    private $connection;

    public function __construct()
    {
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $database = DB_NAME;
         $port = DB_PORT;
        $this->connection = new \mysqli($host, $username, $password, $database, $port);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getAllRoomTypes()
    {
        $result = $this->connection->query("SELECT * FROM room_types");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRoomTypeById($id)
    {
        $id = $this->connection->real_escape_string($id);
        $result = $this->connection->query("SELECT * FROM room_types WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function createRoomType($name, $price, $description, $image)
    {
        $name = $this->connection->real_escape_string($name);
        $price = $this->connection->real_escape_string($price);
        $description = $this->connection->real_escape_string($description);
        $image = $this->connection->real_escape_string($image);

        $sql = "INSERT INTO room_types (name, price, description, image) 
                VALUES ('$name', '$price', '$description', '$image')";

        return $this->connection->query($sql);
    }

    public function updateRoomType($id, $name, $price, $description)
    {
        $id = $this->connection->real_escape_string($id);
        $name = $this->connection->real_escape_string($name);
        $price = $this->connection->real_escape_string($price);
        $description = $this->connection->real_escape_string($description);

        $sql = "UPDATE room_types SET name='$name', price='$price', description='$description' WHERE id=$id";

        return $this->connection->query($sql);
    }

    public function deleteRoomType($id)
    {
        $id = $this->connection->real_escape_string($id);
        return $this->connection->query("DELETE FROM room_types WHERE id=$id");
    }
    // Thêm vào trong class Room
    public function countRoomTypes()
    {
        $sql = "SELECT COUNT(*) as total FROM room_types";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
