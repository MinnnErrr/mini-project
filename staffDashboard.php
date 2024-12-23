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
    <title>Staff Dashboard</title>
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
            <!--side bar-->
            <?php require 'staffsidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10 p-0">
                <div class="container min-vh-100 p-4">

                    <!-- your content starts here -->
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
                    legend: {display: false},
                    scales: {
                    yAxes: [{ticks: {min: 10, max:300}}],
                    }
                }
                });
                </script>
                <button type="button" class="btn btn-primary" style="float:right">Generate report</button>
        </div>
    </div>
    <div class="col-6">
        <div class="box">
            <?php require 'queryReward.php'; ?>
            <table class="normal">
                <tr>
                    <th><h5>Your Reward</h5></th>
                </tr>
                <tr>
                    <td>Current Month Sales: RM<?php echo $MonthlySales; ?>?</td>
                </tr>
                <tr>
                    <td>Bonus Earned: RM<?php echo $Bonus; ?>?</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>
                    <div id="qrcode-container" style="display: flex; justify-content: center;">
                    <div id="qrcode"></div>
                    </div>
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
        width: 170,  // Fixed width
        height: 170, // Fixed height
        colorDark: "#000000", // QR code color
        colorLight: "#ffffff" // Background color
    });

</script>

<div class="box2">
<h4>Pending Orders</h4>
            
<?php
// Connect to the database server
$link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

// SQL query with JOIN to fetch customer name from the customer table
$strSQL = "
    SELECT `order`.`OrderID`, `order`.`Date`, `order`.`TotalPrice`, `order`.`Status`, `order`.`Points`, 
           `customer`.`StudentID`, `customer`.`PhoneNumber`
    FROM `order`
    JOIN `customer` ON `order`.`CustomerID` = `customer`.`CustomerID`";

// Execute the query
$rs = mysqli_query($link, $strSQL);

if (!$rs) {
    die("Query failed: " . mysqli_error($link));
}

// Display records in a table
echo '<table class="table table-striped table-bordered table-hover">';
echo '<thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Points</th>
            <th>Student ID</th>
            <th>Actions</th>
        </tr>
      </thead>';
echo '<tbody>';

// Loop through the recordset
while ($row = mysqli_fetch_assoc($rs)) {
    $orderID = htmlspecialchars($row['OrderID']);
    $status = htmlspecialchars($row['Status']);

    if ($status !== 'Collected') {
    echo '<tr>';
    echo '<td>' . $orderID . '</td>';
    echo '<td>' . htmlspecialchars($row['Date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['TotalPrice']) . '</td>';
    echo '<td>' . $status . '</td>';
    echo '<td>' . htmlspecialchars($row['Points']) . '</td>';
    echo '<td>' . htmlspecialchars($row['StudentID']) . '</td>';
    echo '<td>';
    }

    // Add "Accept Order" action
    if ($status == 'Ordered') {
        echo '
        <form method="POST" action="backprinting.php">
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <button type="submit" name="action" value="accept_orderD" class="btn btn-info"><i class="bi bi-check2-all"></i> Accept Order</button>
        </form>';
    }

    // Add "Complete Order" action
    if ($status == 'Accepted') {
        echo '
        <form method="POST" action="backprinting.php">
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <button type="submit" name="action" value="complete_orderD" class="btn btn-primary"><i class="bi bi-check2-all"></i> Complete Order</button>
   
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <button type="submit" name="action" value="deleteD" class="btn btn-danger" style="display:inline;"><i class="bi bi-trash3-fill"></i> Delete</button>

        <input type="hidden" name="order_id" value="' . $orderID . '">
        <button type="submit" name="action" value="generate_invoice" class="btn btn-success" style="display:inline;"><i class="bi bi-receipt"></i> Generate Invoice</button>
    </form>';
    }
    
    // Add "Mark Collected" action
    else if ($status == 'Order Complete') {
        echo '
            <form method="POST" action="backprinting.php" style="display:inline;">
                <input type="hidden" name="order_id" value="' . $orderID . '">
                <button type="submit" name="action" value="mark_collectedD" class="btn btn-secondary">Mark Collected</button>
            </form>';
    } 
    
    //Testing
    // else if ($status == 'Collected') {
    //     echo '
    //         <form method="POST" action="" style="display:inline;">
    //             <input type="hidden" name="order_id" value="' . $orderID . '">
    //             <button type="submit" name="action" value="back" class="btn btn-secondary">Back</button>
    //         </form>';
    // }
    
    // Handle the "back" action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'back') {
        $orderID = intval($_POST['order_id']); // Retrieve the OrderID
        $query = "UPDATE `order` SET `Status` = 'Ordered' WHERE `OrderID` = $orderID";
        
        // Execute the query
        if (mysqli_query($link, $query)) {
            echo "Order status reverted to 'Ordered'.";
            
        } else {
            echo "Error updating order status: " . mysqli_error($link);
        }
    }
    
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Close the database connection
mysqli_close($link);
?>

            </tr>
        </table>
</div>

                </div>
                         <div class="row bg-body border-top py-2 m-0">
                            <footer class="col d-flex justify-content-center align-items-center">
                            <a href="#" class="text-decoration-none me-2">
                                <img src="./Images/RapidPrintIcon.png" alt="RapidPrint" width="25">
                            </a>
                            <span>&copy 2024 RapidPrint. All rights reserved.</span>
                            </footer>
                         </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('staffDashboard').classList.add('is-active'); 
    </script>
</body>

</html>