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

    public function showTasks($user_id) {
        try {
            $this->user_id = $user_id;

            $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
            
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("user_id", $this->user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function showTaskperId($id) {
        try {
            $sql = "SELECT * FROM tasks WHERE id = :id";

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
            $this->title = $data["title"];
            $this->description = $data["description"];
            $this->end_datetime = $data["end_datetime"];
            $this->priority = $data["priority"];
            $this->status = $data["status"];
            $this->category = $data["category"];

            $sql = "UPDATE tasks SET title = :title, description = :description, end_datetime = :end_datetime, priority = :priority, status = :status, category = :category WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("title", $this->title);
            $stmt->bindParam("description", $this->description);
            $stmt->bindParam("end_datetime", $this->end_datetime);
            $stmt->bindParam("priority", $this->priority);
            $stmt->bindParam("status", $this->status);
            $stmt->bindParam("category", $this->category);
            $stmt->bindParam("id", $id);

            if (!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het bijwerken van deze task");
            }
            return "Task is bijgewerkt";
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function deleteTask($id) {
        try {
            $sql = "DELETE FROM tasks WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("id", $id);
            return $stmt->execute();
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function getStatuses() {
        try {
            $sql = "SELECT * FROM status";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function updateTaskStatus($task_id, $new_status) {
        try {
            $sql = "UPDATE tasks SET status = :status WHERE id = :task_id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':status', $new_status);
            $stmt->bindParam(':task_id', $task_id);
            if (!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het bijwerken van de status");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPriorities() {
        try {
            $sql = "SELECT * FROM priority";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}