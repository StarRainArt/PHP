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

$employee1 = new Employee($db, 1);
$employee2 = new Employee($db, 2);
echo $employee1->get_employee();
echo $employee2->get_employee();
?>

</body>
</html>
