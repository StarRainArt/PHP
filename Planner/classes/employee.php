<?php
class Employee{
    
    public $db;
    public $voornaam;
    public $achternaam;
    public $email;
    public $created_at;
    public $updated_at;


    function __construct($db, $employee_id = null){
        $this->db = $db;

        if($employee_id){
            $this->load_employee($employee_id);
        }
    }

    function get_all_employees(){
        try{
            $stmt = $this->db->prepare("SELECT voornaam, achternaam, email, created_at, updated_at FROM medewerkers");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }   catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        }
    

    function load_employee($employee_id){
        try{

            $stmt = $this->db->prepare("SELECT voornaam, achternaam, email, created_at, updated_at FROM medewerkers WHERE employee_id = :employee_id");
            $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
            $stmt->execute();

            $employee = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($employee){
                $this->voornaam = $employee['voornaam'];
                $this->achternaam = $employee['achternaam'];
                $this->email = $employee['email'];
                $this->created_at = $employee['created_at'];
                $this->updated_at = $employee['updated_at'];
            } else {
                echo "Employee not found!";
            }
        }catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function get_employee(){
        return $this->voornaam . " " . $this->achternaam . " (". $this->email . ")" . $this->created_at . $this->updated_at;
    }
}