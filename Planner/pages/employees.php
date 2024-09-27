<?php

include '../db_connect/dbconfig.php';
include '../classes/employee.php';

$employee = new Employee($db);
$employees = $employee->get_all_employees();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>All employees</h1>
<?php if (!empty($employees)): ?>
    <?php foreach ($employees as $emp): ?>
        <div>
            <p><strong>First Name:</strong> <?php echo $emp['voornaam']; ?></p>
            <p><strong>Last Name:</strong> <?php echo $emp['achternaam']; ?></p>
            <p><strong>Email:</strong> <?php echo $emp['email']; ?></p>
            <p><strong>Created at: </strong> <?php echo $emp['created_at']; ?></p>
            <p><strong>Updated at: </strong> <?php echo $emp['updated_at']; ?></p>
            <hr>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No employees found.</p>
<?php endif; ?>
</body>
</html>
