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
        <div class="row">
            <?php require 'sidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="row">
                    <div class="col-12">
                        <div class="row m-4 rounded-3 p-4 bg-gradient shadow" style="color: #0f524f; background-color: #08c4b3;">
                            <div class="col-md-6 col-sm-12">
                                <h4>Admin Dashboard</h4>
                                <p>Welcome back, <?php echo $username?> !</p>
                            </div>
                            <div class="col-md-6 col-sm-12 d-flex justify-content-end">
                                <img style="max-width: 250px;" src="./undraw_hello_re_3evm.svg" alt="">
                            </div>
                        </div>
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            graph
                        </div>
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            graph
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-5">
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            <h5>Total Number of Staff</h5>
                            <p>Number</p>
                        </div>
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            <h5>Total Number of Customer</h5>
                            <p>Number</p>
                        </div>
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            <h5>Total Number of Registered Customer</h5>
                            <p>Number</p>
                        </div>
                        <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                            <h5>Total Number of Verified Customer</h5>
                            <p>Number</p>
                        </div>
                    </div>
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>