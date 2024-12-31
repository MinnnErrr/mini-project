<?php
require 'dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerID = $_SESSION['user_id'];
    $packageID = $_POST['orderPackage'];
    $propertyID = $_POST['category'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $paymentMethod = $_POST['paymentMethod'];
    $pickUpDate = $_POST['pickUpDate'];
    $pickUpTime = $_POST['pickUpTime'];
    $file = $_FILES['file'];

    // File upload logic
    $fileName = time() . "_" . basename($file['name']);
    $filePath = "files/" . $fileName;
    move_uploaded_file($file['tmp_name'], $filePath);

    // Fetch BasePrice and Property Price for calculation
    $stmt = $conn->prepare("SELECT p.BasePrice, pp.Price FROM printingpackage p JOIN packageproperty pp ON p.PackageID = pp.PackageID WHERE p.PackageID = ? AND pp.PropertyID = ?");
    $stmt->execute([$packageID, $propertyID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die("Invalid package or category selection.");
    }

    $basePrice = $result['BasePrice'];
    $propertyPrice = $result['Price'] ?? 0;

    $totalPrice = ($basePrice + $propertyPrice) * $quantity;

    $points = round($totalPrice / 2);

    // Insert into order table
    $stmt = $conn->prepare("INSERT INTO `order` (TotalPrice, Status, Points, PaymentMethod, PickUpDate, PickUpTime, CustomerID, file, descriptionOrder) VALUES (?, 'Pending', ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$totalPrice, $points, $paymentMethod, $pickUpDate, $pickUpTime, $customerID, $fileName, $description]);

    $orderID = $conn->lastInsertId();

    // Insert into orderprintingpackage table
    $stmt = $conn->prepare("INSERT INTO orderprintingpackage (Quantity, OrderID, PackageID) VALUES (?, ?, ?)");
    $stmt->execute([$quantity, $orderID, $packageID]);

    $orderPackageID = $conn->lastInsertId();

    // Insert into orderproperty table
    $stmt = $conn->prepare("INSERT INTO orderproperty (OrderPackageID, PropertyID) VALUES (?, ?)");
    $stmt->execute([$orderPackageID, $propertyID]);

    header('Location: viewOrder.php');
    exit;
}
?>
