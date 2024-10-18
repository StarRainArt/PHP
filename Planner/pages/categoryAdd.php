<?php
require_once "../classes/user.class.php";
require_once "../classes/categ.class.php";

$user = new User($db);
$category = new Category($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_data = [
        "name" => $_POST["name"],
        "user_id" => $_SESSION["id"]
    ];

    $response = $category->addCategory($category_data);
    header("Location: categories.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="tasks.php">Tasks</a>
            <a href="events.php">Events</a>
            <a href="categories.php">Categories</a>
            <?php if (session_status() === PHP_SESSION_ACTIVE): ?>
                <a href="logout.php">Log Out</a>
            <?php endif; ?>
            <?php if ($user->isAdmin()): ?>
                <a href="gebruikers.php">Gebruikers</a>
            <?php endif; ?>
            <a href="profiel.php">Profiel</a>
        </nav>
    </header>
    <main>
        <h1>Add a New Category</h1>
        <form action="categoryAdd.php" method="POST">
            <label for="name">Category:</label>
            <input type="text" name="name" id="name" required>

            <button type="submit">Add Category</button>
        </form>
    </main>
</body>
</html>