<?php
require 'dbconfig.php';

// Get the package ID from the request
$packageID = intval($_GET['packageID']);

$link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

// Query to fetch properties for the selected package
$query = "
    SELECT 
        p.PropertyID, 
        p.Category, 
        p.Name, 
        p.Price 
    FROM 
        packageproperty p
    WHERE 
        p.PackageID = $packageID";

$result = mysqli_query($link, $query);

$properties = [];
while ($row = mysqli_fetch_assoc($result)) {
    $properties[] = $row;
}

// Return properties as JSON
header('Content-Type: application/json');
echo json_encode($properties);
?>
