<?php
require_once '../../env.php';


class dbconfig {
    private $pdo;
    public function __construct($dsn, $user, $pass) {
        $this->conn($dsn, $user, $pass);
    }
    private function conn() {
        $dsn = "mysql:host=localhost:3036;dbname=project;charset=utf8mb4";
        $user = "root";
        $pass = "password";
        $this->pdo = null;
        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function getConnection() {
        return $this->pdo;
    }
}
