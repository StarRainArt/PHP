<?php
require_once "../classes/user.class.php";

$user = new User($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="logout.php">Log Out</a>
            <a href="gebruikers.php">Gebruikers</a>
            <a href="profiel.php">Profiel</a>
        </nav>
    </header>
    <main>
    <p><?php echo $_SESSION["id"]?> - <?php echo $_SESSION["username"]?> - <?php echo $_SESSION["loggedin"]?> - <?php echo $_SESSION["isadmin"]?></p>
    </main>
</body>
</html>