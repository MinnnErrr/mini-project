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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'sidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100">
                    Admin profile
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('profile').classList.add('is-active', 'text-decoration-underline');
    </script>
</body>

</html>