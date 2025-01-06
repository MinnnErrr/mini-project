<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $OrderID = intval($_POST['order_id']);

// Connect to the database
$link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

// Fetch the file path from the database
$query = "SELECT file FROM `order` WHERE OrderID = $OrderID";
$result = mysqli_query($link, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $filePath = $row['file'];

    // Check if the file exists on the server
    if (file_exists($filePath)) {
        // Get the file name
        $fileName = basename($filePath);

        // Set headers to force download
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Length: " . filesize($filePath));

        // Read the file and send it to the output buffer
        readfile($filePath);
        exit;
    } else {
        echo "Error: File does not exist.";
    }
} else {
    echo "Error: Order not found.";
}

// Close the database connection
mysqli_close($link);
}


?>
