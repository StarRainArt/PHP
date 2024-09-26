<?php


$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = 'root';
$databaseName = 'project';

try {
    
    $db = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    
    echo "Connection failed: " . $e->getMessage();
}

?>
