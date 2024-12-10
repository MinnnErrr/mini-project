<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashbaord</title>
</head>

<body>
    <h1>this is customer dashboard. your username is <?php echo $username ?></h1>
    <a href="logout.php">
        <button>Log Out</button>
    </a>

</html>