<?php
require_once '../../env.php';

class DbConfig {
    protected $conn;
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;

    public function __construct($host, $user, $pass, $dbname) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    public function connect() {
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}