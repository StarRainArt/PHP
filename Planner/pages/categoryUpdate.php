<?php
require_once "../classes/user.class.php";
require_once "../classes/categ.class.php";

$user = new User($db);
$category = new Category($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

$category_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$category_info = $category->showCategory($category_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = ["name" => $_POST["name"]];
    $response = $category->editCategory($category_id, $data);
    header("Location: categories.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Plann(t)er</title>
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
        <h1>Edit Category</h1>
        <form action="categoryUpdate.php?id=<?php echo $category_id ?>" method="POST">
            <label for="name">Category:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($category_info["name"]) ?>">

            <button type="submit">Edit Category</button>
        </form>
    </main>
</body>
</html>