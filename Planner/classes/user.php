<?php
class User{
    private int $id;
    private string $username;
    private string $email;
    private PDO $db;
    private string $password;
    private bool $beheerder;

    public function __construct(PDO $conn)
    {
       $this->db = $conn;
    }
    // om te controleren of een gebruiker bepaalde acties mag uitvoeren
    public function checkBeheerder()
    {
        return $this->beheerder;
    }

    // Id is de primary key en willen we niet aanpassen. Vandaar alleen een getter.
    public function getId()
    {
       return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($name)
    {
        
      

    }
    // checken of er een user bestaat met een username
    private function checkUsername($name) {
        try {
            $sql = "SELECT * FROM users WHERE username = :name";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam("name", $name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            else {
                return false;
            }
        } catch (\Throwable $th) {
            var_dump($th);// nooit te beroerd om gebruikers te laten debuggen XD
        }
    }
       
}