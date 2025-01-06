<!--
---------------------------------------------------------------------------------
GROUP_CONCAT() [SQL]:
---------------------------------------------------------------------------------
Combines multiple rows into a single string.
----------------------------------------------------------------------------------

==================================================================================
CONCAT() [SQL]:
==================================================================================
Combines multiple strings into one.
separator , ==> Format: A4 (RM1), Color: black white (RM2)
==================================================================================
-->
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
    o.StaffID AS StaffID,
    GROUP_CONCAT(CONCAT(p.Category, ': ', p.Name, ' (RM', p.Price, ')') SEPARATOR ', ') AS Properties,
    SUM(p.Price) AS TotalPropertyPrice
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
JOIN 
    `orderproperty` opp ON op.OrderPackageID = opp.OrderPackageID 
JOIN 
    `packageproperty` p ON opp.PropertyID = p.PropertyID 
WHERE 
    o.OrderID = $orderID
GROUP BY 
    op.OrderPackageID";


$result = mysqli_query($link, $query);

$i = 0;
$TotalAmount = 0;

// Fetch the rows from the result
while ($row = mysqli_fetch_assoc($result)) {
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
    $Properties = $row["Properties"]; // Aggregated properties
    $TotalPropertyPrice = $row["TotalPropertyPrice"];

    $Amount = ($Qty * $Price) + ($Qty * $TotalPropertyPrice);
    $TotalAmount += $Amount;

    ++$i;
    echo "<tr>
        <td>$i.</td>
        <td>$PackageName</td>
        <td>$Properties</td>
        <td>$Qty</td>
        <td>$Price</td>
        <td>$Amount</td>
    </tr>";
}
?>
