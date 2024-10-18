<?php
require_once "../classes/user.class.php";
require_once "../classes/categ.class.php";

$user = new User($db);
$category = new Category($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

$categories = $category->showCategories($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://kit.fontawesome.com/9ce9532b81.js" crossorigin="anonymous"></script>
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
        <h1>Categories</h1>
        <a href="categoryAdd.php">Category Toevoegen</a>
        <section id="categories">
            <?php if (count($categories) > 0): ?>
                <?php foreach ($categories as $category): ?>
                    <article class="category">
                        <h3><?php echo htmlspecialchars($category["name"]) ?></h3>
                        <a href="categoryUpdate.php?id=<?php echo $category["id"] ?>"><i class="fa-solid fa-pencil"></i></a>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Begin met Categories toevoegen!</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>