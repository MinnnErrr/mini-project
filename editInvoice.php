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
        pp.BasePrice AS Price 
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
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Invoice</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Edit Invoice</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="date" class="form-label">Invoice Date</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo $invoice['InvoiceDate']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $invoice['Quantity']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="unit_price" class="form-label">Unit Price (RM)</label>
            <input type="number" class="form-control" id="unit_price" name="unit_price" value="<?php echo $invoice['UnitPrice']; ?>" step="0.01" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </div>
    </form>
    <button class="btn btn-success mt-3" onclick="window.print()">Print Invoice</button>
</div>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
