<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

include '../db_connect/dbconfig.php';

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
$newEmployee = new Employee($db, 1); // Example: Employee with ID 1
echo $newEmployee->get_employee();
?>
</body>
</html>
