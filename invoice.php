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
    <title>Document</title>
    <!-- Method 1:Node=>Bootstrap -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- Method 2:CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- External CSS -->
    <link rel="stylesheet" type="text/css" href="printing.css">
    
</head>
<body class="bg-body-secondary bg-opacity-50">

<?php require 'navbar.php' ?>

<div class="container-fluid">
    <div class="row vh-100">
        <?php require 'sidebar.php' ?>

        <div class="col-sm-12 col-lg-10">
            <div class="container min-vh-100">
                <!-- Your content here... -->
                <img src="./RapidPrintIcon.png" alt="RapidPrint">
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
                <table>
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

                <button>Print Invoice</button>
                <button>Download Invoice</button>
            </div>
            <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>