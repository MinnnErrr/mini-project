<?php

$db_name = "mysql:host=localhost;dbname=mini_project";
$username = "root";
$password = "";

$conn = new PDO($db_name, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>