<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

include '../db_connect/dbconfig.php';
include '../classes/employee.php';

$employee = new Employee($db, 1);
echo $employee->get_employee();
?>

</body>
</html>
