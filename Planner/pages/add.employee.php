<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
</head>
<body>

    <h2>Add New Employee</h2>

    <form action="add_employee.php" method="POST">
        <label for="voornaam">First Name:</label><br>
        <input type="text" id="voornaam" name="voornaam" required><br><br>

        <label for="achternaam">Last Name:</label><br>
        <input type="text" id="achternaam" name="achternaam" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Add Employee">
    </form>

</body>
</html>
