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
    <title>Invoice</title>
    <!-- Method 1:Node=>Bootstrap -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- Method 2:CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .welcome,.header{
            background-color: #0d6efd;
            border: 1px solid #0d6efd;
            border-radius: 12px;
            padding: 15px;
            margin: 20px;
            color: white;
            line-height: 0.7;
        }

        .row{
            display: flex;
            margin: 10px;
        }

        .box{
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 10px;
            padding: 10px;   
        }

        .box2{
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 30px;
            padding: 10px;
            padding-right: 3%;
        }

        .box3{
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 30px;
            padding: 10px;
            padding-right: 3%;
            background-color:rgb(36, 105, 201);
            color: white;
            border-radius: 12px;
        }

        .tablestyle{
            border: 1px solid #ddd;
            border-collapse: collapse;
            margin: 10px;
            width: 100%;
        }

        .normal{
            margin: 10px;
            width: 100%;
        }

        .normal th{
            padding-bottom: 10px;
        }

        .normal td{
            padding: 0%;
        }

        .tablestyle th, .tablestyle td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        
        .tablestyle th {
            background-color: #f9f9f9;
        }

        .customimg{
            float: right;
            width: 10%;
        }

    </style>
    
</head>
<body class="bg-body-secondary bg-opacity-50">

<?php require 'navbar.php' ?>

<div class="container-fluid">
    <div class="row vh-100">
        <?php require 'staffsidebar.php' ?>

        <div class="col-sm-12 col-lg-10">
            <div class="container min-vh-100">
                <!-- Your content here... -->
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
                <button type="button" class="btn btn-success">Print Invoice</button>
                <button type="button" class="btn btn-warning">Download Invoice</button>
            </div>
            <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>