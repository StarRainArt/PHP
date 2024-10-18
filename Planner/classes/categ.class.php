<?php
require_once "../db_connect/dbconfig.php";

$db = new DbConfig($host, $user, $pass, $dbname);
$db->connect();

class Category {
    public $name;
    public $user_id;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCategory($data) {
        try {
            $this->name = $data["name"];
            $this->user_id = $data["user_id"];

            $sql = "INSERT INTO categories (name, user_id) VALUES (:name, :user_id)";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("name", $this->name);
            $stmt->bindParam("user_id", $this->user_id);

            if(!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het toevoegen van de category");
            }
            return "Category is toegevoegd";
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function showCategories($user_id) {
        try {
            $this->user_id = $user_id;

            $sql = "SELECT * FROM categories WHERE user_id = :user_id";
            
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("user_id", $this->user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function showCategory($id) {
        try {
            $sql = "SELECT * FROM categories WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function editCategory($id, $data) {
        try {
            $this->name = $data["name"];

            $sql = "UPDATE categories SET name = :name WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("name", $this->name);
            $stmt->bindParam("id", $id);

            if (!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het bijwerken van deze category");
            }
            return "Category is bijgewerkt";
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function deleteCategory($id) {
        try {
            $sql = "DELETE FROM categories WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam("id", $id);
            return $stmt->execute();
        }
        catch (Exception $e) {
            return false;
        }
    }
}