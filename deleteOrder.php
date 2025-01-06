<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    try {
        $conn->beginTransaction();

        // Delete from orderprintingpackage to get all related OrderPackageIDs
        $stmt1 = $conn->prepare("SELECT OrderPackageID FROM orderprintingpackage WHERE OrderID = :order_id");
        $stmt1->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt1->execute();
        
        $orderPackageIds = $stmt1->fetchAll(PDO::FETCH_COLUMN);

        // Delete from orderproperty using the OrderPackageIDs
        if ($orderPackageIds) {
            $placeholders = implode(',', array_fill(0, count($orderPackageIds), '?'));
            $stmt2 = $conn->prepare("DELETE FROM orderproperty WHERE OrderPackageID IN ($placeholders)");
            $stmt2->execute($orderPackageIds);
        }

        // Delete from orderprintingpackage
        $stmt3 = $conn->prepare("DELETE FROM orderprintingpackage WHERE OrderID = :order_id");
        $stmt3->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt3->execute();

        // Delete from order
        $stmt4 = $conn->prepare("DELETE FROM `order` WHERE OrderID = :order_id");
        $stmt4->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt4->execute();

        $conn->commit();
        header('Location: viewOrder.php?status=All');
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Failed to delete order: " . $e->getMessage();
    }
}
?>
