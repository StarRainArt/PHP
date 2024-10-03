<?php
require_once "../classes/user.class.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["password"] !== $_POST["password2"]) {
        // Passwords don't match, show an error
        echo "<p>De wachtwoorden zijn niet hetzelfde, probeer opnieuw.</p>";
    }
    else {
        $user = new User($db);
        $response = $user->addUser(["username"=>$_POST["username"], "password" => $_POST["password"]]);
        header ("Location: inloggen.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <form action="registreren.php" method="POST">
        <label for="username">Gebruikersnaam: </label>
        <input type="text" name="username" required>
        <label for="password">Wachtwoord: </label>
        <input type="password" name="password" required>
        <label for="password2">Herhaal Wachtwoord: </label>
        <input type="password" name="password2" required>
        <button type="submit">Toevoegen</button>
    </form>
</body>
</html>