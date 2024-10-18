<?php
require_once "../classes/user.class.php";
require_once "../classes/task.class.php";

$user = new User($db);
$task = new Task($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"])) {
    $task_id = $_POST["task_id"];
    $new_status = $_POST["status"];

    $task->updateTaskStatus($task_id, $new_status);
}

$task_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$task_info = $task->showTaskperId($task_id);
$statuses = $task->getStatuses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - Plann(t)er</title>
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
        <section>
            <h1><?php echo htmlspecialchars($task_info["title"]) ?></h1>
            <h3><?php echo htmlspecialchars($task_info["description"]) ?></h3>
            <p><?php echo htmlspecialchars($task_info["end_datetime"]) ?></p>
            <p><?php echo htmlspecialchars($task_info["priority"]) ?></p>
            <p><?php echo htmlspecialchars($task_info["category"]) ?></p>
            <form action="taskById.php?id=<?php echo $task_info["id"] ?>" method="POST">
                <?php $selected = $task_info["status"];?>
                <select name="status" id="status<?php echo $task_info["id"]; ?>" onchange="this.form.submit()">
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?php echo $status["id"]; ?>" <?php if($selected == $status["id"]){echo "selected";}?>>
                            <?php echo htmlspecialchars($status['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="task_id" value="<?php echo $task_info['id']; ?>">
            </form>
        </section>
        <a href="taskUpdate.php?id=<?php echo $task_info["id"] ?>"><i class="fa-solid fa-pencil"></i></a>
    </main>
</body>
</html>