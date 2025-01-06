<?php
require 'dbconfig.php';
require_once 'vendor/autoload.php';
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body  class="d-flex justify-content-center align-items-center container-xxl">
    <div>
    <h1>Successfully added money to membership</h1>
    <button class="btn btn-primary btn-lg" style="width:100%"><a href="membership.php" style="color:black">Back</a></button>
    </div>
    
</body>
</html>