<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

require 'queryReward.php';
require 'calcSales.php';

// Fetch sales history for the current staff member
$salesHistoryQuery = "SELECT DATE_FORMAT(Date, '%M %Y') AS Month, MonthlySales, Bonus, Points 
                      FROM `reward` 
                      WHERE StaffID = $StaffID 
                      ORDER BY Date DESC";
$salesHistoryResult = mysqli_query($link, $salesHistoryQuery);

// Delete Order Logic
if (isset($_GET['deleteOrderID'])) {
    $orderID = $_GET['deleteOrderID'];

    // Delete the order from the database
    $deleteQuery = "DELETE FROM `order` WHERE `OrderID` = '$orderID'";
    if (mysqli_query($link, $deleteQuery)) {
        header("Location: reward.php"); // Redirect to the same page after deletion
    } else {
        echo "Error deleting record: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reward</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
</head>

<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid p-0">
        <div class="row vh-100 m-0">
            <?php require 'staffsidebar.php' ?>

            <div class="col-sm-12 col-lg-10 p-0">
                <div class="container min-vh-100 p-4">
                    <div class="header">
                        <h3 style="margin-left: 10px;">Staff Sales History</h3>
                        <p style="margin-left: 10px;">Track your sales performance and earned rewards</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="box">
                                <h5><i class="bi bi-person-circle fs-4"></i> Staff Information</h5>
                                <br>
                                <img src="profile default image.jpg" alt="Card image" style="width:200px;float:right">
                                <table style="text-align:left; margin-left:40px;margin-bottom:60px">
                                    <tr>
                                        <td><p>Staff Name: <?php echo $Name; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Staff ID: <?php echo $StaffID; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Position: <?php echo $Position; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Branch: <?php echo $Branch; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <form method="POST" action="staffProfile.php">
                                            <button type="submit" class="btn btn-dark">View Profile</button>
                                        </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="box3">
                                <h6>Monthly Printing Sales</h6>
                                <p>RM<?php echo $monthlySales; ?></p>
                            </div>
                            <div class="box3">
                                <h6>Points Earned</h6>
                                <p>RM <?php echo $points; ?></p>
                            </div>
                            <div class="box3">
                                <h6>Current Bonus</h6>
                                <p>RM <?php echo $bonus; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="box2">
                        <h4>Monthly Sales History</h4>
                        <table class="table table-bordered" style="text-align:center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Month</th>
                                    <th>Monthly Printing Sales</th>
                                    <th>Bonus Obtained (RM)</th>
                                    <th>Points Awarded</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //number_format => 550.00
                                if (mysqli_num_rows($salesHistoryResult) > 0) {
                                    while ($row = mysqli_fetch_assoc($salesHistoryResult)) {
                                        $month = $row['Month'];
                                        echo "<tr>";
                                        echo "<td>" . $row['Month'] . "</td>";
                                        echo "<td>RM " . number_format($row['MonthlySales'], 2) . "</td>";
                                        echo "<td>RM " . number_format($row['Bonus'], 2) . "</td>";
                                        echo "<td>" . $row['Points'] . "</td>";

                                        // Set a unique ID for each collapse
                                        $collapseId = "collapse" . md5($month); // Unique ID based on month
                                        echo "<td><button class='btn btn-primary' data-bs-toggle='collapse' data-bs-target='#$collapseId'>View Detail</button></td>";
                                        echo "</tr>";

                                        // Display the collapse content for the month
                                        echo "<tr><td colspan='5' class='p-0'>
                                                <div id='$collapseId' class='collapse'>
                                                    <table class='table table-striped'>
                                                        <thead>
                                                            <tr>
                                                                <th>Order ID</th>
                                                                <th>Date</th>
                                                                <th>Total Price</th>
                                                                <th>Status</th>
                                                                <th>Points</th>
                                                                <th>Student ID</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>";

                                        // Fetch and display order details for the specific month
                                        $orderQuery = "
                                            SELECT `order`.`OrderID`, `order`.`Date`, `order`.`TotalPrice`, `order`.`Status`, `order`.`Points`, 
                                                   `customer`.`StudentID`
                                            FROM `order`
                                            JOIN `customer` ON `order`.`CustomerID` = `customer`.`CustomerID`
                                            WHERE DATE_FORMAT(`order`.`Date`, '%M %Y') = '$month' AND `order`.`Status` = 'Collected'";

                                        $orderResult = mysqli_query($link, $orderQuery);

                                        if (mysqli_num_rows($orderResult) > 0) {
                                            while ($order = mysqli_fetch_assoc($orderResult)) {
                                                $orderID = $order['OrderID'];
                                                echo "<tr>";
                                                echo "<td>" . $order['OrderID'] . "</td>";
                                                echo "<td>" . $order['Date'] . "</td>";
                                                echo "<td>RM " . number_format($order['TotalPrice'], 2) . "</td>";
                                                echo "<td>" . $order['Status'] . "</td>";
                                                echo "<td>" . $order['Points'] . "</td>";
                                                echo "<td>" . $order['StudentID'] . "</td>";
                                                
                                                // Add Delete Button 
                                                $modalID = "modal" . $orderID; // Unique modal ID for each order
                                                echo "<td><button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#$modalID'>
                                                        Delete
                                                    </button></td>";
                                                    echo "</tr>";
echo "
<!-- The Modal -->
<div class='modal' id='$modalID'>
  <div class='modal-dialog'>
    <div class='modal-content'>

      <!-- Modal Header -->
      <div class='modal-header'>
        <h4 class='modal-title'>Delete Confirmation</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
      </div>

      <!-- Modal body -->
      <div class='modal-body'>
       <p>Are you sure you want to delete this order?</p>
      </div>

      <!-- Modal footer -->
      <div class='modal-footer'>
        <form method='POST' action='backprinting.php'>";
        $user_id = $_SESSION['user_id'];
            echo '<input type="hidden" name="order_id" value="' . $orderID . '">
            <input type="hidden" name="user_id" value="' . $user_id . '">
            <button type="submit" name="action" value="deleteReward" class="btn btn-danger" style="display:inline;"><i class="bi bi-trash3-fill"></i> Delete</button>
    </form>
      </div>

    </div>
  </div>
</div>';
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No collected orders for this month.</td></tr>";
                                        }

                                        echo "</tbody></table></div></td></tr>";
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td colspan='5'>No sales history found.</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
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
        document.getElementById('reward').classList.add('is-active');
    </script>
</body>

</html>
