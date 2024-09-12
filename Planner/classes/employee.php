<?php

class Employee{

    public $voornaam;
    public $achternaam;
    public $email;


    function __constructor($voornaam, $achternaam, $email){
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->email = $email;
    }
}


?>