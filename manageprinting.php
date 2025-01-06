<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

require 'calcSales.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--your page title-->
    <title>Manage printing</title> 
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
                    <div class="header">
                <h3 style="margin-left: 10px;">Manage Orders</h3>
                <p style="margin-left: 10px;">View and manage all printing orders</p>
            </div>

    <div class="box">
        <input type="text" placeholder="Search by Order ID or Customer name" style="margin: 3px; padding:10px; width:40%; float:left; margin-bottom:20px;">
        <select name="" id="" style="margin: 4px; padding:10px; float:left">
            <option value="">Filter Status</option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <button type="button" class="btn btn-primary" style="float:left; margin-top:8px">Filter</button>

<?php
// Connect to the database server
$link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

// SQL query with JOIN to fetch customer ID & phoneNo from the customer table
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
    $orderID = $row['OrderID'];
    $status = $row['Status'];

    // Colleted will no display
    if ($status !== 'Collected') {
    echo '<tr>';
    echo '<td>' . $orderID . '</td>';
    echo '<td>' . $row['Date'] . '</td>';
    echo '<td>' . $row['TotalPrice'] . '</td>';
    echo '<td>' . $status . '</td>';
    echo '<td>' . $row['Points'] . '</td>';
    echo '<td>' . $row['StudentID'] . '</td>';
    echo '<td>';
    }

    // Add "Accept Order" action
    if ($status == 'Ordered') {
        echo '
        <form method="POST" action="backprinting.php">
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <input type="hidden" name="user_id" value="' . $user_id . '">
        <button type="submit" name="action" value="accept_order" class="btn btn-info"><i class="bi bi-check2-all"></i> Accept Order</button>
        </form>';
    }
    
    // Add "Complete Order" action
    if ($status == 'Accepted') {
        echo '
        <form method="POST" action="backprinting.php">
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <input type="hidden" name="user_id" value="' . $user_id . '">
        <button type="submit" name="action" value="complete_order" class="btn btn-primary"><i class="bi bi-check2-all"></i> Complete Order</button>
   
        <input type="hidden" name="order_id" value="' . $orderID . '">
        <input type="hidden" name="user_id" value="' . $user_id . '">
        <button type="submit" name="action" value="delete" class="btn btn-danger" style="display:inline;"><i class="bi bi-trash3-fill"></i> Delete</button>

        <input type="hidden" name="order_id" value="' . $orderID . '">
        <input type="hidden" name="user_id" value="' . $user_id . '">
        <button type="submit" name="action" value="generate_invoice" class="btn btn-success" style="display:inline;"><i class="bi bi-receipt"></i> Generate Invoice</button>
    </form>';
    }
    
    // Add "Mark Collected" action
    else if ($status == 'Order Complete') {
        echo '
            <form method="POST" action="backprinting.php" style="display:inline;">
                <input type="hidden" name="order_id" value="' . $orderID . '">
                <input type="hidden" name="user_id" value="' . $user_id . '">
                <button type="submit" name="action" value="mark_collected" class="btn btn-secondary">Mark Collected</button>
            </form>';
    } 
        
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

// Close the database connection
mysqli_close($link);
?>
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
        document.getElementById('managePrinting').classList.add('is-active'); 
    </script>
</body>

</html>