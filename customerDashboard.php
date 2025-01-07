<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
require './controllerModule2/dashboardControler.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .seach{
    display: flex;
    margin-top: 20px;

}
.seach > input{
    display: block;
    width: 200px;
    
    
}
.seach > button{
    display: block;
    border-radius: 5px;
    width: 20%;
    background-color: blue;
    color: white;
    padding: 10px;
}
</style>
<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require 'customerSidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <!-- content starts here -->
                    <div class="row">
                        <div class="col-12">
                            <div class="row m-4 rounded-3 p-4 bg-gradient shadow"
                                style="color: #0f524f; background-color: #08c4b3;">
                                <div class="col-md-6 col-sm-12">
                                    <h4>Customer Dashboard</h4>
                                    <p>Welcome back, <?php echo $username ?> !</p>
                                </div>

                            </div>
                            <div>
                            <div>
                                <div class="col-sm-12 col-lg-5">
                                    
                                    <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                                    <h5>Enter Membership ID To Search Total Point  </h5>
                                        <form class="seach" action="totalPoints.php" method="post">
                                            <input type="text" placeholder="Enter Membership ID"
                                                name="membershipID"></input>
                                            <button name="searchTotalPoints">Search</button>
                                        </form>
                                    </div>
                                  
                                </div>
                                <div class="col-sm-12 col-lg-5" >
                                   
                                    <div class=" m-4 rounded-3 p-4 bg-white shadow-sm">
                                        <h5>Total Earned Points</h5>
                                        <p><?php echo $totalAmountPoint ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                                <div id="chart_div" style="width: 900px; height: 500px"></div>
                            </div>
                            <div class="m-4 rounded-3 p-4 bg-white shadow-sm">
                                <div id="OrderChart_div" style="width: 900px; height: 500px"></div>


                            </div>
                        </div>
                        
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="customerDashboard.js"></script>
    <script>
    document.getElementById('customerDashboard').classList.add('is-active');
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        let pointCollection = [];
        for (const data of pointData) {
            pointCollection.push([new Date(data.Date), parseInt(data.Amount, 10)])
        }
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', 'Points');

        data.addRows(pointCollection);
        console.log(Date(2015, 0, 16));

        var options = {
            title: 'Points Accumulation Over Time',
            width: 600,
            height: 500,
            hAxis: {
                format: 'M/d/yyyy',
                gridlines: {
                    count: 15
                }
            },
            vAxis: {
                gridlines: {
                    color: 'none'
                },
                minValue: 0
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);

        var button = document.getElementById('change');

        button.onclick = function() {

            // If the format option matches, change it to the new option,
            // if not, reset it to the original format.
            options.hAxis.format === 'M/d/yy' ?
                options.hAxis.format = 'MMM dd, yyyy' :
                options.hAxis.format = 'M/d/yy';

            chart.draw(data, options);
        };
    }
    </script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        let OrderCollection = [];
        for (const data of orderSpending) {
            OrderCollection.push([new Date(data.Date), parseInt(data.TotalPrice, 10)])
        }
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Time of Day');
        data.addColumn('number', 'Spending Order (RM)');

        data.addRows(OrderCollection);
        console.log(Date(2015, 0, 16));

        var options = {
            title: 'Order Spending Over Time',
            width: 600,
            height: 500,
            hAxis: {
                format: 'M/d/yyyy',
                gridlines: {
                    count: 15
                }
            },
            vAxis: {
                gridlines: {
                    color: 'none'
                },
                minValue: 0
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('OrderChart_div'));

        chart.draw(data, options);

        var button = document.getElementById('change');

        button.onclick = function() {

            // If the format option matches, change it to the new option,
            // if not, reset it to the original format.
            options.hAxis.format === 'M/d/yy' ?
                options.hAxis.format = 'MMM dd, yyyy' :
                options.hAxis.format = 'M/d/yy';

            chart.draw(data, options);
        };
    }
    </script>
</body>

</html>