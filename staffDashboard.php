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

    <!-- Method 2:CDN Link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .welcome,
        .header {
            background-color: #0d6efd;
            border: 1px solid #0d6efd;
            border-radius: 12px;
            padding: 15px;
            margin: 20px;
            color: white;
            line-height: 0.7;
        }

        .row {
            display: flex;
            margin: 10px;
        }

        .box {
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 10px;
            padding: 10px;
        }

        .box2 {
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 30px;
            padding: 10px;
            padding-right: 3%;
        }

        .box3 {
            border: 1px solid #ddd;
            text-align: center;
            flex: 50%;
            margin: 30px;
            padding: 10px;
            padding-right: 3%;
            background-color: rgb(36, 105, 201);
            color: white;
            border-radius: 12px;
        }

        .tablestyle {
            border: 1px solid #ddd;
            border-collapse: collapse;
            margin: 10px;
            width: 100%;
        }

        .normal {
            margin: 10px;
            width: 100%;
        }

        .normal th {
            padding-bottom: 10px;
        }

        .normal td {
            padding: 0%;
        }

        .tablestyle th,
        .tablestyle td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .tablestyle th {
            background-color: #f9f9f9;
        }

        .customimg {
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
                    <div class="welcome">
                        <h3 style="margin-left: 10px;">RapidPrint Staff Dashboard</h3>
                        <p style="margin-left:10px;">Welcome back</p>
                    </div>
                    <!-- =========================================================================================== -->
                    <!-- Bootstrap - 1 row have 12 col, so 6 6 col => 2 box in one row   -->
                    <!-- =========================================================================================== -->
                    <div class="row">
                        <div class="col-6">
                            <div class="box">
                                <h5><b>Monthly Sales Overview</b></h5>
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                                <script>
                                    const xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                    const yValues = [70, 80, 80, 90, 90, 90, 100, 110, 140, 140, 150, 160];

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
                                                        min: 10,
                                                        max: 300
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
                                <table class="normal">
                                    <tr>
                                        <th>
                                            <h5>Your Reward</h5>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Current Month Sales: RM</td>
                                    </tr>
                                    <tr>
                                        <td>Bonus Earned: RM</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div id="qrcode" style="margin-left:32%"></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- QRCode.js Library -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

                    <script>
                        // Generate the QR Code
                        var qrcode = new QRCode(document.getElementById("qrcode"), {
                            text: "http://localhost/WEBFILE/mini-project/reward.php",
                            width: 170, // Fixed width
                            height: 170, // Fixed height
                            colorDark: "#000000", // QR code color
                            colorLight: "#ffffff" // Background color
                        });
                    </script>

                    <div class="box2">
                        <h4>Pending Orders</h4>
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
        document.getElementById('staffDashboard').classList.add('is-active', 'text-decoration-underline');
    </script>

</body>

</html>