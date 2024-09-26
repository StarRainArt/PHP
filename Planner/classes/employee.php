<?php

include '../db_connect/dbconfig.php';

class Employee{
    
    public $db;
    public $voornaam;
    public $achternaam;
    public $email;


    function __constructor($db, $voornaam, $achternaam, $email){
        $this->db = $db;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->email = $email;
    }

    function get_customer(){
        return $this->voornaam;
        return $this-> achternaam;
        return $this->email;
    }
}


?>