<?php
require 'dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = $_SESSION['user_id'];
    $packageID = $_POST['orderPackage'];
    $quantity = $_POST['quantity'];
    $paymentMethod = $_POST['paymentMethod'];
    $pickUpDate = $_POST['pickUpDate'];
    $pickUpTime = $_POST['pickUpTime'];
    $file = $_FILES['file'];

    // File upload logic
    $fileName = time() . "_" . basename($file['name']);
    $filePath = "files/" . $fileName;
    move_uploaded_file($file['tmp_name'], $filePath);

    // Fetch BasePrice for calculation
    $stmt = $conn->prepare("SELECT BasePrice FROM printingpackage WHERE PackageID = ?");
    $stmt->execute([$packageID]);
    $basePrice = $stmt->fetchColumn();

    $totalPrice = $basePrice * $quantity;
    $points = $totalPrice;

    // Insert into order table
    $stmt = $conn->prepare("INSERT INTO `order` (TotalPrice, Status, Points, PaymentMethod, PickUpDate, PickUpTime, CustomerID, File) VALUES (?, 'Pending', ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$totalPrice, $points, $paymentMethod, $pickUpDate, $pickUpTime, $customerID, $fileName]);

    $orderID = $conn->lastInsertId();

    // Insert into orderprintingpackage table
    $stmt = $conn->prepare("INSERT INTO orderprintingpackage (Quantity, OrderID, PackageID) VALUES (?, ?, ?)");
    $stmt->execute([$quantity, $orderID, $packageID]);

    header('Location: viewOrder.php');
}
?>
