<?php
require_once "../classes/user.class.php";
require_once "../classes/task.class.php";
require_once "../classes/categ.class.php";

$user = new User($db);
$task = new Task($db);
$category = new Category($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

$priorities = $task->getPriorities();
$statuses = $task->getStatuses();
$categories = $category->showCategories($_SESSION["id"]);
$task_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$task_info = $task->showTaskperId($task_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "title" => $_POST["title"],
        "description" => $_POST["description"],
        "end_datetime" => $_POST["end_datetime"],
        "priority" => $_POST["priority"],
        "status" => $_POST["status"],
        "category" => $_POST["category"],
        "user_id" => $_SESSION["id"]
    ];
    $response = $task->editTask($task_id, $data);
    header("Location: taskById.php?id=" . $task_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - Plann(t)er</title>
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
        <h1>Edit Task</h1>
        <form action="taskUpdate.php?id=<?php echo $task_id; ?>" method="POST">
            <?php $selectPri = $task_info["priority"];?>
            <?php $selectCat = $task_info["category"];?>
            <?php $selectSta = $task_info["status"];?>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($task_info["title"]) ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($task_info["description"]) ?></textarea>

            <label for="end_datetime">End Date/Time:</label>
            <input type="datetime-local" name="end_datetime" id="end_datetime" value="<?php echo htmlspecialchars($task_info["end_datetime"]) ?>" required>

            <label for="priority">Priority:</label>
            <select name="priority" id="priority" required>
                <?php foreach ($priorities as $priority): ?>
                    <option value="<?php echo $priority['id']; ?>" <?php if($selectPri == $priority["id"]){echo "selected";}?>><?php echo htmlspecialchars($priority['title']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?php echo $status['id']; ?>" <?php if($selectSta == $status["id"]){echo "selected";}?>><?php echo htmlspecialchars($status['title']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="category">Category:</label>
            <select name="category" id="category">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php if($selectCat == $category["id"]){echo "selected";}?>><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Edit Task</button>
        </form>
    </main>
</body>
</html>