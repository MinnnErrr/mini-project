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
    <title>Manage printing</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>
<body class="bg-body-secondary bg-opacity-50">

<?php require 'navbar.php' ?>

<div class="container-fluid">
    <div class="row vh-100 m-0">
        <?php require 'staffsidebar.php' ?>

        <div class="col-sm-12 col-lg-10">
            <div class="container min-vh-100">
            <!-- Your content here... -->
            <div class="header">
                <h3 style="margin-left: 10px;">Manage Orders</h3>
                <p style="margin-left: 10px;">View and manage all printing orders</p>
            </div>

    <div class="box">
        <input type="text" placeholder="Search by Order ID or Customer name" style="margin: 10px; padding:10px; width:40%; float:left">
        <select name="" id="" style="margin: 10px; padding:10px; float:left">
            <option value="">Filter Status</option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <button type="button" class="btn btn-primary" style="float:left; margin-top:12px">Filter</button>
    
    <table class="tablestyle">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th colspan="2">Action</th>
        </tr>
        <tr>
            <td>Order info</td>
            <td></td>
            <td></td>
            <td><button type="button" class="btn btn-primary">Action</button></td>
            <td><a href="invoice.php" class="btn btn-success">Generate Invoice</a></td>
        </tr>
    </table>
    </div>
            </div>
            <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('manageprinting').classList.add('is-active', 'text-decoration-underline');
    </script>
</body>
</html>