<?php
require 'dbconfig.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve user inputs
        $customerID = $_SESSION['user_id'];
        $packageID = $_POST['orderPackage'];
        $propertyID = $_POST['category'];
        $quantity = (int)$_POST['quantity'];
        $description = $_POST['description'];
        $pickUpDate = $_POST['pickUpDate'];
        $pickUpTime = $_POST['pickUpTime'];
        $file = $_FILES['file'];

        // Validate inputs
        if (empty($packageID) || empty($propertyID) || $quantity <= 0 || empty($pickUpDate) || empty($pickUpTime)) {
            throw new Exception("Invalid input data. Please ensure all fields are filled correctly.");
        }

        // File upload logic
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . "_" . basename($file['name']);
            $filePath = "files/" . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload file.");
            }
        } else {
            throw new Exception("Error uploading file: " . $file['error']);
        }

        // Fetch BasePrice and Property Price for calculation
        $stmt = $conn->prepare("SELECT p.BasePrice, pp.Price FROM printingpackage p JOIN packageproperty pp ON p.PackageID = pp.PackageID WHERE p.PackageID = ? AND pp.PropertyID = ?");
        $stmt->execute([$packageID, $propertyID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("Invalid package or category selection.");
        }

        $basePrice = $result['BasePrice'];
        $propertyPrice = $result['Price'] ?? 0;

        // Calculate total price and points
        $totalPrice = ($basePrice + $propertyPrice) * $quantity;
        $points = round($totalPrice / 2);

        // Insert into `order` table
        $stmt = $conn->prepare("INSERT INTO `order` (TotalPrice, Status, Points, PickUpDate, PickUpTime, CustomerID, file, descriptionOrder) VALUES (?, 'Pending', ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$totalPrice, $points, $pickUpDate, $pickUpTime, $customerID, $fileName, $description]);
        $orderID = $conn->lastInsertId();

        // Insert into `orderprintingpackage` table
        $stmt = $conn->prepare("INSERT INTO orderprintingpackage (Quantity, OrderID, PackageID) VALUES (?, ?, ?)");
        $stmt->execute([$quantity, $orderID, $packageID]);
        $orderPackageID = $conn->lastInsertId();

        // Insert into `orderproperty` table
        $stmt = $conn->prepare("INSERT INTO orderproperty (OrderPackageID, PropertyID) VALUES (?, ?)");
        $stmt->execute([$orderPackageID, $propertyID]);

        // Redirect to viewOrder.php
        header('Location: viewOrder.php');
        exit;

    } catch (Exception $e) {
        // Handle exceptions
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
