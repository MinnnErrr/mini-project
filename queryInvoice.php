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