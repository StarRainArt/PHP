<?php
require_once "../db_connect/dbconfig.php";

$db = new DbConfig($host, $user, $pass, $dbname);
$db->connect();

class Task {
    public $title;
    public $description;
    public $end_datetime;
    public $user_id;
    public $priority;
    public $status;
    public $category;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addTask($data) {
        try {
            $this->title = $data["title"];
            $this->description = $data["description"];
            $this->end_datetime = $data["end_datetime"];
            $this->user_id = $data["user_id"];
            $this->priority = $data["priority"];
            $this->status = $data["status"];
            $this->category = $data["category"];

            $sql = "INSERT INTO tasks (title, description, end_datetime, user_id, priority, status, category) VALUES (:title, :description, :end_datetime, :user_id, :priority, :status, :category)";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("title", $this->title);
            $stmt->bindParam("description", $this->description);
            $stmt->bindParam("end_datetime", $this->end_datetime);
            $stmt->bindParam("user_id", $this->user_id);
            $stmt->bindParam("priority", $this->priority);
            $stmt->bindParam("status", $this->status);
            $stmt->bindParam("category", $this->category);

            if(!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het toevoegen van de task");
            }
            return "Task is toegevoegd";
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function showTasks() {
        try {
            $sql = "SELECT * FROM tasks";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }
}