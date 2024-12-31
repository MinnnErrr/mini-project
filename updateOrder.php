<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $package_id = $_POST['package_id'] ?? null;
    $property_id = $_POST['category'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $description = $_POST['description'] ?? null;
    $payment_method = $_POST['payment_method'] ?? null;
    $pickup_date = $_POST['pickup_date'] ?? null;
    $pickup_time = $_POST['pickup_time'] ?? null;
    $file = $_FILES['file'] ?? null;

    if (!$order_id || !$package_id || !$property_id || !$quantity || !$pickup_date || !$pickup_time) {
        header('Location: editOrder.php?order_id=' . $order_id);
        exit();
    }

    try {
        $conn->beginTransaction();

        // Fetch package base price and property price
        $query = "SELECT p.BasePrice, pp.Price FROM printingpackage p 
                  INNER JOIN packageproperty pp ON pp.PackageID = p.PackageID
                  WHERE p.PackageID = :package_id AND pp.PropertyID = :property_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception('Invalid package or property selection.');
        }

        $base_price = $result['BasePrice'];
        $property_price = $result['Price'];

        // Calculate total price
        $total_price = ($base_price + $property_price) * $quantity;

        // Calculate points
        $points = round($total_price / 2);

        // Handle file upload with timestamp renaming (no directory in the path)
        $uploaded_file = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . "_" . basename($file['name']);
            // The file path is just the file name (without the directory)
            $uploaded_file = $fileName;

            // Move the uploaded file to the desired directory
            $filePath = "files/" . $uploaded_file;
            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                throw new Exception('Failed to upload the file.');
            }
        }

        // Update the `order` table
        $updateOrderQuery = "
            UPDATE `order` 
            SET TotalPrice = :total_price, 
                Points = :points,
                PaymentMethod = :payment_method, 
                PickUpDate = :pickup_date, 
                PickUpTime = :pickup_time, 
                file = :file, 
                descriptionOrder = :description 
            WHERE OrderID = :order_id
        ";
        $stmt = $conn->prepare($updateOrderQuery);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
        $stmt->bindParam(':points', $points, PDO::PARAM_INT);
        $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
        $stmt->bindParam(':pickup_date', $pickup_date, PDO::PARAM_STR);
        $stmt->bindParam(':pickup_time', $pickup_time, PDO::PARAM_STR);
        $stmt->bindParam(':file', $uploaded_file, PDO::PARAM_STR); // Only save the file name, not the full path
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update the `orderprintingpackage` table
        $updateOrderPackageQuery = "
            UPDATE `orderprintingpackage` 
            SET Quantity = :quantity, PackageID = :package_id
            WHERE OrderID = :order_id
        ";
        $stmt = $conn->prepare($updateOrderPackageQuery);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update the `orderproperty` table
        $updateOrderPropertyQuery = "
            DELETE FROM `orderproperty` WHERE OrderPackageID = 
            (SELECT OrderPackageID FROM `orderprintingpackage` WHERE OrderID = :order_id)
        ";
        $stmt = $conn->prepare($updateOrderPropertyQuery);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        $insertOrderPropertyQuery = "
            INSERT INTO `orderproperty` (OrderPackageID, PropertyID)
            VALUES (
                (SELECT OrderPackageID FROM `orderprintingpackage` WHERE OrderID = :order_id), 
                :property_id
            )
        ";
        $stmt = $conn->prepare($insertOrderPropertyQuery);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $property_id, PDO::PARAM_INT);
        $stmt->execute();

        // Update the `point` table
        $insertPointQuery = "
            INSERT INTO `point` (Date, Amount, MembershipID) 
            VALUES (NOW(), :amount, 
                (SELECT MembershipID FROM membershipcard WHERE CustomerID = 
                    (SELECT CustomerID FROM `order` WHERE OrderID = :order_id))
            )
        ";
        $stmt = $conn->prepare($insertPointQuery);
        $stmt->bindParam(':amount', $points, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        $conn->commit();

        header('Location: viewOrder.php?success=Order updated successfully.');
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error updating order: " . $e->getMessage());
        header('Location: editOrder.php?order_id=' . $order_id . '&error=Error updating order.');
        exit();
    }
} else {
    header('Location: viewOrder.php');
    exit();
}
?>
