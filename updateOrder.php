<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $package_id = $_POST['package_id'];
    $quantity = $_POST['quantity'];
    $payment_method = $_POST['payment_method'];
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];

    // File upload handling
    $file_upload = $_FILES['file'];
    $file_path = null;
    if ($file_upload['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($file_upload['name']);
        $upload_dir = 'uploads/';
        $file_path = $upload_dir . time() . '_' . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!move_uploaded_file($file_upload['tmp_name'], $file_path)) {
            $_SESSION['error'] = "Failed to upload file.";
            header("Location: editOrder.php?order_id=$order_id");
            exit();
        }
    }

    // Start a transaction
    $conn->beginTransaction();

    try {
        // Fetch the BasePrice of the selected package
        $query = "SELECT BasePrice FROM printingpackage WHERE PackageID = :package_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
        $stmt->execute();
        $package = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$package) {
            throw new Exception("Invalid package selected.");
        }

        $base_price = $package['BasePrice'];
        $total_price = $quantity * $base_price;

        // Update the order details in the `order` table
        $query = "
            UPDATE `order`
            SET PaymentMethod = :payment_method,
                PickUpDate = :pickup_date,
                PickUpTime = :pickup_time,
                TotalPrice = :total_price
            WHERE OrderID = :order_id AND CustomerID = :customer_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
        $stmt->bindParam(':pickup_date', $pickup_date, PDO::PARAM_STR);
        $stmt->bindParam(':pickup_time', $pickup_time, PDO::PARAM_STR);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update the package and quantity in the `orderprintingpackage` table
        $query = "
            UPDATE `orderprintingpackage`
            SET PackageID = :package_id,
                Quantity = :quantity
            WHERE OrderID = :order_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Optionally update the file path in the `order` table
        if ($file_path) {
            $query = "UPDATE `order` SET file = :file_path WHERE OrderID = :order_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        $_SESSION['success'] = "Order updated successfully.";
    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['error'] = "Failed to update order: " . $e->getMessage();
    }

    header('Location: viewOrder.php');
    exit();
}
