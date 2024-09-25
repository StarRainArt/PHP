<?php
require_once "../classes/user.class.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $response = $user->loginUser(["username"=>$_POST["username"]], $db);
    echo $response;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>
    <main>
        <form action="inloggen.php" method="POST">
            <label for="username">Gebruikersnaam: </label>
            <input type="text" name="username" required>
            <label for="password">Wachtwoord: </label>
            <input type="password" name="password" required>
            <button type="submit">Inloggen</button>
        </form>
        <p>Heb je nog geen account? <a href="registreren.php">account aanmaken</a></p>
    </main>
</body>
</html>