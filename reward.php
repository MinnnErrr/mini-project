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
     <!-- External CSS -->
     <link rel="stylesheet" type="text/css" href="printing.css">
     
    <!-- Method 2:CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'sidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100">
                    <!-- Your content here... -->
                     <div class="header">
                        <h5>Staff Reward Dashboard</h5>
                        <p>Track your sales performance and earned rewards</p>
                     </div>

                     <div class="row">
                        <div class="col-6">
                            <div class="box">
                                <h6>Staff Information</h6>
                                <p>Staff Name</p>
                                <p>ID</p>
                                <p>Department</p>
                                <p>Join Date</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="box">
                                <p>Your QR Code</p>
                                QR
                                <p>Scan to view detailed performance</p>
                            </div>   
                        </div>
                     </div>

                <div class="row">
                     <div class="col-4">
                        <div class="box3">
                            <p>Monthly Printing Sales</p>
                            <p>RM</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <p>Points Earned</p>
                            <p>RM</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <p>Current Bonus</p>
                            <p>RM</p>
                        </div>
                     </div>
                </div>     

                <div class="box2">
                     <h4>Bonus Structure</h4>
                     <table>
                        <tr>
                            <th>Monthly Printing Sales</th>
                            <th>Bonus Obtained (RM)</th>
                            <th>Points Awarded</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                     </table>
                </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>