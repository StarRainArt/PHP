<?php
require_once "../classes/user.class.php";

$user = new User($db);

$user->logoutUser();
