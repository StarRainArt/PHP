<?php
require_once '../../env.php';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
class dbconfig {
    public $pdo;
    public function __construct($dsn, $user, $pass) {
        $this->conn($dsn, $user, $pass);
    }
    private function conn($dsn, $user, $pass) {
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
