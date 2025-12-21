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
        $this->connection = new \mysqli($host, $username, $password, $database);

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
       $sql = "SELECT * FROM room_types WHERE id = ?";
    $stmt = $this->connection->prepare($sql); // Nhớ kết nối db trong construct giống Room
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
    }

    public function createRoomType($name, $price,$max_adults, $description, $image)
    {
        $name = $this->connection->real_escape_string($name);
        $price = $this->connection->real_escape_string($price);
        $max_adults = $this->connection->real_escape_string($max_adults);
        $description = $this->connection->real_escape_string($description);
        $image = $this->connection->real_escape_string($image);

        $sql = "INSERT INTO room_types (name, price, max_adults, description, image) 
            VALUES ('$name', '$price', '$max_adults', '$description', '$image')";

        return $this->connection->query($sql);
    }
    public function updateRoomType($id, $name, $price, $max_adults, $description, $image)
    {
        $id = $this->connection->real_escape_string($id);
        $name = $this->connection->real_escape_string($name);
        $price = $this->connection->real_escape_string($price);
        $max_adults = $this->connection->real_escape_string($max_adults);
        $description = $this->connection->real_escape_string($description);
        $image = $this->connection->real_escape_string($image);

        $sql = "UPDATE room_types 
            SET name='$name', price='$price', max_adults='$max_adults', description='$description', image='$image' 
            WHERE id=$id";

        return $this->connection->query($sql);
    }

    public function deleteRoomType($id)
    {
        $id = $this->connection->real_escape_string($id);
        return $this->connection->query("DELETE FROM room_types WHERE id=$id");
    }

    public function countRoomTypes()
    {
        $sql = "SELECT COUNT(*) as total FROM room_types";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
