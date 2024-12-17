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
    <title>Staff Dashboard</title>
    <!-- Method 1:Node=>Bootstrap -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- Method 2:CDN Link
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

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
                    <div class="welcome">
                        <h5>RapidPrint Staff Dashboard</h5>
                        <p style="font-size: smaller;">Welcome back</p>
                    </div>
                    <!-- =========================================================================================== -->
                    <!-- Bootstrap - 1 row have 12 col, so 6 6 col => 2 box in one row   -->
                    <!-- =========================================================================================== -->
                    <div class="row">
                        <div class="col-6">
                            <div class="box">
                                <p>Monthly Sales Overview</p>
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                                <script>
                                    const xValues = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
                                    const yValues = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

                                    new Chart("myChart", {
                                        type: "line",
                                        data: {
                                            labels: xValues,
                                            datasets: [{
                                                fill: false,
                                                lineTension: 0,
                                                backgroundColor: "rgba(0,0,255,1.0)",
                                                borderColor: "rgba(0,0,255,0.1)",
                                                data: yValues
                                            }]
                                        },
                                        options: {
                                            legend: {
                                                display: false
                                            },
                                            scales: {
                                                yAxes: [{
                                                    ticks: {
                                                        min: 6,
                                                        max: 16
                                                    }
                                                }],
                                            }
                                        }
                                    });
                                </script>
                                <button type="button" class="btn btn-primary" style="float:right">Generate report</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="box">
                                <p>Your Rewards</p>
                                <p>Current Month Sales</p>
                                <p>Bonus Earned</p>
                                QR
                            </div>
                        </div>
                    </div>

                    <div class="box2">
                        <h4>Pending Orders</h4>
                        <table>
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
                                <td><button type="button" class="btn btn-primary">Generate Invoice</button></td>

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