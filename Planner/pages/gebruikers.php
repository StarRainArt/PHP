<?php
require_once "../classes/user.class.php";

$user = new User($db);

if (!$user->isLoggedIn()) {
    header("Location: inloggen.php");
}

if (!$user->isAdmin()) {
    header("Location: index.php");
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $user->deleteUser($delete_id);
    header('Location: gebruikers.php');
    exit();
}

$users = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers - Plann(t)er</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo $user['admin'] == 1 ? 'Yes' : 'No'; ?></td>
                            <td>
                                <?php if ($user["admin"] == 0): ?>
                                    <a href="gebruikers.php?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?');">Verwijderen</a>
                                <?php  endif ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Geen gebruikers gevonden.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>