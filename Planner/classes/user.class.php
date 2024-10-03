<?php
session_start();
require_once "../db_connect/dbconfig.php";

$db = new DbConfig($host, $user, $pass, $dbname);
$db->connect();

class User {
    public $username;
    public $password;
    protected $db;  // Make $db a class property

    // Constructor to inject the $db object
    public function __construct($db) {
        $this->db = $db;
    }

    public function addUser($data) {
        try {
            $this->username = $data["username"];
            $this->password = password_hash($data["password"], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

            $stmt = $this->db->getConnection()->prepare($sql);  // Use $this->db->getConnection()
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);

            if (!$stmt->execute()) {
                throw new Exception("Er ging iets mis met het toevoegen van de user");
            }
            return "{$this->username} is toegevoegd";
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function loginUser($data) {
        try {
            $this->username = $data["username"];
            $this->password = $data["password"];

            $sql = "SELECT * FROM users WHERE username = :username";

            $stmt = $this->db->getConnection()->prepare($sql);  // Use $this->db->getConnection()
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($this->password, $user["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $this->username;
                $_SESSION["id"] = $user["id"];
                $_SESSION["isadmin"] = $user["admin"] == 1;
                header("Location: ../pages/index.php");
                exit();
            }
            else {
                throw new Exception("Ongeldige gebruikersnaam of wachtwoord");
            }
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
    }

    public function isAdmin() {
        return isset($_SESSION["isadmin"]) && $_SESSION["isadmin"] === true;
    }

    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $this->db->getConnection()->prepare($sql);  // Use $this->db->getConnection()
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return [];
        }
    }

    public function readProfile() {
        try {
            if (!isset($_SESSION["loggedin"])) {
                throw new Exception("You are not logged in");
            }

            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);  // Use $this->db->getConnection()
            $stmt->bindParam(":id", $_SESSION["id"]);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);  // Use $this->db->getConnection()
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function logoutUser() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Unset all session variables
            $_SESSION = [];
    
            // Destroy the session
            session_destroy();
    
            // Optionally redirect the user to the login page or another page
            header("Location: ../pages/inloggen.php");
            exit();
        }
    }
}