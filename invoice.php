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

<?php
    // Get the id from the URL
    $orderID = intval($_GET['orderID']); // Convert to integer

    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

    // Query to fetch order, customer, and package details
    $query = "
    SELECT 
        o.OrderID AS OrderID, 
        i.InvoiceID AS InvoiceID,
        o.Date AS Date, 
        i.InvoiceDate AS InvoiceDate,
        o.TotalPrice AS Total, 
        u.Username AS Name, 
        c.StudentID AS sID, 
        u.Email AS Email, 
        c.PhoneNumber AS PhoneNo, 
        op.Quantity AS qty, 
        pp.Name AS PackageName, 
        pp.BasePrice AS Price,
        o.StaffID AS StaffID
    FROM 
        `order` o 
    JOIN 
        `invoice` i ON o.OrderID = i.OrderID 
    JOIN 
        `customer` c ON o.CustomerID = c.CustomerID 
    JOIN 
        `user` u ON c.UserID = u.UserID 
    JOIN 
        `orderprintingpackage` op ON o.OrderID = op.OrderID 
    JOIN 
        `printingpackage` pp ON op.PackageID = pp.PackageID 
    WHERE 
        o.OrderID = $orderID";

    $result = mysqli_query($link, $query);

    $i = 0;
    // Fetch the row from the result
    while ($row = mysqli_fetch_assoc($result)){
        $InvoiceID = $row["InvoiceID"];
        $Date = $row["Date"];
        $InvoiceDate = $row["InvoiceDate"];
        $Total = $row["Total"];
        $Name = $row["Name"];
        $sID = $row["sID"];
        $Email = $row["Email"];
        $PhoneNo = $row["PhoneNo"];
        $Qty = $row["qty"];
        $PackageName = $row["PackageName"];
        $Price = $row["Price"];
        $StaffID = $row["StaffID"];
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
                <img src="./Images/RapidPrintIcon.png" alt="RapidPrint" class="customimg">
                <h2>INVOICE <i class="bi bi-receipt"></i></h2>
                <div style="line-height: 0.7;">
                    <p style="padding-top:30px">Invoice ID: <?php echo $InvoiceID; ?></p>
                    <p>Order ID: <?php echo $orderID; ?></p>
                    <p>Order Date: <?php echo $Date; ?></p>
                    <p>Date: <?php echo $InvoiceDate; ?></p>
                </div>
                
                    <br>
            <br>
            <div style="line-height: 0.7;">
                <?php
                    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

                    // REPLACE , to \n
                    $query = "
                    SELECT 
                    b.BranchID AS BranchID,
                    b.Name AS BranchName,
                    REPLACE(b.Address, ',', '\n') AS Address,
                    b.ContactNumber,s.StaffID
                    FROM 
                            `branch` b
                        JOIN 
                            `staff` s ON b.BranchID = s.BranchID 
                            WHERE 
                            s.StaffID = $StaffID";

                            $result = mysqli_query($link, $query);

                        // Fetch the row from the result
                        while ($row = mysqli_fetch_assoc($result)){
                            $BranchID = $row["BranchID"];
                            $BranchName = $row["BranchName"];
                            $Address = $row["Address"];
                            $ContactNumber = $row["ContactNumber"];
                        }

                ?>
                <p><b>From:</b></p>
                <p>Branch ID: <?php echo $BranchID; ?></p>
                <p><?php echo $BranchName; ?></p>
                <!-- PHP n12br - insert line break when \n in string (php) -->
                <p style="line-height: 1.5;"><?php echo nl2br($Address); ?></p>
                <p>Phone: <?php echo $ContactNumber; ?></p>
            </div>
              
            <br>
            <div style="line-height: 0.7;">
                <p><b>Bill To:</b></p>
                <p>Customer Name: <?php echo $Name; ?></p>
                <p>Customer ID: <?php echo $sID; ?></p>
                <p>Email: <?php echo $Email; ?></p>
                <p>Phone: <?php echo $PhoneNo; ?></p>
            </div>
                
            <br>
            <table class="table table-bordered" style="text-align: center;">
                <thead class="table-primary">
                        <th>No</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit Price (RM)</th>
                        <th>Amount (RM)</th>
                    </tr>
                </thead>
                        <?php
                            require 'queryInvoice.php';    
                        ?>
                            <tr>
                                <td colspan="5" style="text-align: right;"><strong>Total (RM):</strong></td>
                                <td><?php echo $TotalAmount;?></td>
                            </tr>
                            
                </table>
<br>
            <form action="manageInvoice.php" method="POST" style="display: inline;">
                <input type="hidden" name="action" value="editLocation">
                <input type="hidden" name="order_id" value="<?php echo $orderID; ?>">
                <input type="hidden" name="user_id" value="<?php echo $$user_id; ?>">
                <button type="submit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</button>
            </form>

            <form action="manageInvoice.php" method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="invoice_id" value="<?php echo $InvoiceID; ?>">
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3"></i> Delete</button>
            </form>

                <button type="button" class="btn btn-success" onclick="window.print()"><i class="bi bi-printer"></i> Print Invoice</button>

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
</body>

</html>