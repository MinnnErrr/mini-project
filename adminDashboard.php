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


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <!--side bar-->
            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container-fluid min-vh-100 p-4">

                    <!--first row-->
                    <div class="row align-items-center mb-4">
                        <!--admin dashboard-->
                        <div>
                            <div class="rounded-3 p-4 bg-gradient shadow-sm d-flex justify-content-between" style="color: #0f524f; background-color: #08c4b3;">
                                <div class="">
                                    <h4>Admin Dashboard</h4>
                                    <p>Welcome back, <?php echo $username ?> !</p>
                                </div>
                                <div class="d-flex">
                                    <img style="max-width: 160px;" src="./images/undraw_admin.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--second row-->
                    <div class="row">
                        <div class="col-lg-3 col-sm-12 mb-4">
                            <div class="rounded-3 p-4 bg-white shadow-sm">
                                <h6>Total Number of Staff</h6>
                                <p>Number</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12 mb-4">
                            <div class="rounded-3 p-4 bg-white shadow-sm">
                                <h6>Total Number of Customer</h6>
                                <p>Number</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12 mb-4">
                            <div class="rounded-3 p-4 bg-white shadow-sm">
                                <h6>Total Number of Registered Customer</h6>
                                <p>Number</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-12 mb-4">
                            <div class="rounded-3 p-4 bg-white shadow-sm">
                                <h6>Total Number of Verified Customer</h6>
                                <p>Number</p>
                            </div>
                        </div>
                    </div>

                    <!--graph 1-->
                    <div class="row-lg-12 mb-4">
                        <div class="rounded-3 p-4 bg-white shadow-sm">
                            <h6>Total Sales based on package</h6>
                            <div class="d-flex justify-content-center">
                                <canvas id="chart1" style="width:100%;max-width:800px"></canvas>
                            </div>
                        </div>
                    </div>

                    <!--graph 2-->
                    <div class="row-lg-12">
                        <div class="rounded-3 p-4 bg-white shadow-sm">
                        <h6>Total Sales based on branch</h6>
                            <div class="d-flex justify-content-center">
                                <canvas id="chart2" style="width:100%;max-width:800px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- for active nav item -->
    <script>
        document.getElementById('dashboard').classList.add('is-active');
    </script>

    <!-- for charts -->
    <script>
        const xValues = [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150];
        const yValues = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

        new Chart("chart1", {
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

        new Chart("chart2", {
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
</body>

</html>