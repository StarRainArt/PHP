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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_data = [
        "title" => $_POST["title"],
        "description" => $_POST["description"],
        "end_datetime" => $_POST["end_datetime"],
        "priority" => $_POST["priority"],
        "status" => $_POST["status"],
        "category" => $_POST["category"],
        "user_id" => $_SESSION["id"]
    ];

    $response = $task->addTask($task_data);
    header("Location: tasks.php");
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
        <nav></nav>
    </header>
    <main>
        <h1>Add a New Task</h1>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="taskAdd.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <label for="end_datetime">End Date/Time:</label>
            <input type="datetime-local" name="end_datetime" id="end_datetime" required>

            <label for="priority">Priority:</label>
            <select name="priority" id="priority" required>
                <?php foreach ($priorities as $priority): ?>
                    <option value="<?php echo $priority['id']; ?>"><?php echo htmlspecialchars($priority['title']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?php echo $status['id']; ?>"><?php echo htmlspecialchars($status['title']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="category">Category:</label>
            <select name="category" id="category">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Add Task</button>
        </form>
    </main>
</body>
</html>