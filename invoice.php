<!--do not edit this template-->
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
    <!--your page title-->
    <title>Invoice</title> 
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid p-0">
        <div class="row vh-100 m-0">
            <!--change the sidebar file name-->
            <?php require 'staffsidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10 p-0">
                <div class="container min-vh-100 p-4">

                <!-- your content starts here -->
                <img src="./RapidPrintIcon.png" alt="RapidPrint" class="customimg">
                <h2>INVOICE</h2>
                <p>INVOICE ID</p>
                <p>Date</p>
            <br>
                <b>From</b>
                <p></p>
            <br>
                <b>Bill To</b>
                <p>Customer Name</p>
                <p>Customer ID</p>
                <p>Email</p>
                <p>Phone</p>
            <br>
                <table class="tablestyle">
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price (RM)</th>
                        <th>Amount (RM)</th>
                    </tr>
                    <tr>
                        <td>Invoice info</td>
                    </tr>
                </table>
<br>
                <button type="button" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</button>
                <button type="button" class="btn btn-danger"><i class="bi bi-trash3"></i> Delete</button>
                <button type="button" class="btn btn-success"><i class="bi bi-printer"></i> Print Invoice</button>

                </div>

                        <div class="row bg-body border-top py-2 m-0">
                            <footer class="col d-flex justify-content-center align-items-center">
                                <a href="#" class="text-decoration-none me-2">
                                    <img src="./RapidPrintIcon.png" alt="RapidPrint" width="25">
                                </a>
                                <span>&copy 2024 RapidPrint. All rights reserved.</span>
                            </footer>
                        </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>