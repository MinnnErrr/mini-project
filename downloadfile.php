<?php
require 'dbconfig.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID from the POST request
    $orderID = intval($_POST['order_id']);
    
   // Prepare and execute query to fetch file name associated with the order
    $stmt = $conn->prepare("SELECT file FROM `order` WHERE orderID = ?");
    $stmt->execute([$orderID]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the file exists in the database
if ($order) {
    $fileName = $order['file'];
    $filePath = "files/" . $fileName;

    // Check if the file exists in the file system
    if (file_exists($filePath)) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "Error: File not found.";
    }
} else {
    echo "Error: Order not found.";
}
}
?>
