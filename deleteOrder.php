<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    try {
        $conn->beginTransaction();

        // Delete from orderprintingpackage
        $stmt1 = $conn->prepare("DELETE FROM orderprintingpackage WHERE OrderID = :order_id");
        $stmt1->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt1->execute();

        // Delete from order (escaped using backticks)
        $stmt2 = $conn->prepare("DELETE FROM `order` WHERE OrderID = :order_id");
        $stmt2->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt2->execute();

        $conn->commit();
        header('Location: viewOrder.php?status=Deleted');
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Failed to delete order: " . $e->getMessage();
    }
}
?>
