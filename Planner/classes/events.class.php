<?php
require_once "../db_connect/dbconfig.php";

$db = new DbConfig($host, $user, $pass, $dbname);
$db->connect();

class Event {
    public $name;
    public $description;
    public $date;
    public $start_time;
    public $end_time;
    public $location;
    public $user_id;
    public $category;

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addEvent($data) {
        try {
            $this->name = $data["name"];
            $this->description = $data["description"];
            $this->date = $data["date"];
            $this->start_time = $data["start_time"];
            $this->end_time = $data["end_time"];
            $this->location = $data["location"];
            $this->user_id = $data["user_id"];
            $this->category = $data["category"];

            $sql = "INSERT INTO events (name, description, date, start_time, end_time, location, user_id, category) VALUES (:name, :description, :date, :start_time, :end_time, :location, :user_id, :category)";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("name",$this->name);
            $stmt->bindParam("description",$this->description);
            $stmt->bindParam("date",$this->date);
            $stmt->bindParam("start_time",$this->start_time);
            $stmt->bindParam("end_time",$this->end_time);
            $stmt->bindParam("location",$this->location);
            $stmt->bindParam("user_id",$this->user_id);
            $stmt->bindParam("category",$this->category);

            if (!$stmt->execute()) {
                throw new Exception("Er ging iet smis met het toevoegen van het event");
            }
            return "Event is toegevoegd";
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showEvents($user_id) {
        try {
            $this->user_id = $user_id;

            $sql = "SELECT * FROM events WHERE user_id = :user_id";
            
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("user_id", $this->user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function showEventperId($id) {
        try {
            $sql = "SELECT * FROM events WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function editTask($id, $data) {
        try {
            $this->name = $data["name"];
            $this->description = $data["description"];
            $this->date = $data["date"];
            $this->start_time = $data["start_time"];
            $this->end_time = $data["end_time"];
            $this->location = $data["location"];
            $this->category = $data["category"];

            $sql = "UPDATE events SET name = :name, description = :description, date = :date, start_time = :start_time, end_time = :end_time, location = :location category = :category WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("name", $this->name);
            $stmt->bindParam("description", $this->description);
            $stmt->bindParam("date", $this->date);
            $stmt->bindParam("start_time", $this->start_time);
            $stmt->bindParam("end_time", $this->end_time);
            $stmt->bindParam("location", $this->location);
            $stmt->bindParam("category", $this->category);
            $stmt->bindParam("id", $id);

            if (!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het bijwerken van dit event");
            }
            return "Event is bijgewerkt";
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function deleteEvent($id) {
        try {
            $sql = "DELETE FROM events WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("id", $id);
            return $stmt->execute();
        }
        catch (Exception $e) {
            return false;
        }
    }
}