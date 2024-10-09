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

$tasks = $task->showTasks($_SESSION["id"]);
$statuses = $task->getStatuses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="tasks.php">Tasks</a>
            <a href="events.php">Events</a>
            <a href="categories.php">Categories</a>
        </nav>
    </header>
    <main>
        <h1>Tasks</h1>
        <a href="taskAdd.php">Task Toevoegen</a>
        <section id="tasks">
            <?php if (count($tasks) > 0): ?>
                <?php foreach ($tasks as $task): ?>
                    <article class="task">
                        <h3><?php echo htmlspecialchars($task["title"]); ?></h3>
                        <form action="tasks.php" method="POST">
                            <?php $selected = $task["status"];?>
                            <select name="status" id="status<?php echo $task["id"]; ?>" onchange="this.form.submit()">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?php echo $status["id"]; ?>" <?php if($selected == $status["id"]){echo "selected";}?>>
                                        <?php echo htmlspecialchars($status['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        </form>
                    </article>
                <?php endforeach ?>
            <?php else: ?>
                <p>Begin met Tasks toevoegen!</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>