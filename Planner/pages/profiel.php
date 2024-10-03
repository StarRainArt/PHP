<?php
require_once '../classes/user.class.php';

$user = new User($db);

if (!$user->isLoggedIn()) {
    header('Location: inloggen.php');
    exit();
}

$profile = $user->readProfile();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <main>
        <p>Username: <?php echo $profile["username"]?></p>
    </main>
</body>
</html>