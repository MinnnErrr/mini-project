<?php
require 'dbconfig.php';

session_start();

// Validate if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    try {
        // Fetch the order details
        $stmt = $conn->prepare("SELECT * FROM `order` WHERE OrderID = :order_id AND CustomerID = :customer_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            throw new Exception("Order not found.");
        }

        $payment_method = $order['PaymentMethod'];
        $total_price = $order['TotalPrice'];
        $points = $order['Points'];

        if ($payment_method === 'MembershipCard') {
            // Check membership balance
            $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE CustomerID = :customer_id");
            $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
            $stmt->execute();
            $membership = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$membership) {
                throw new Exception("Membership card not found.");
            }

            if ($membership['Balance'] < $total_price) {
                throw new Exception("Insufficient balance in Membership Card.");
            }

            // Deduct balance and update membership balance and points
            $new_balance = $membership['Balance'] - $total_price + $points;

            $stmt = $conn->prepare("
                UPDATE membershipcard 
                SET Balance = :new_balance
                WHERE MembershipID = :membership_id
            ");
            $stmt->bindParam(':new_balance', $new_balance, PDO::PARAM_INT);
            $stmt->bindParam(':membership_id', $membership['MembershipID'], PDO::PARAM_INT);
            $stmt->execute();

            // Record points in the points table
            $stmt = $conn->prepare("
                INSERT INTO point (Date, Amount, MembershipID) 
                VALUES (NOW(), :points, :membership_id)
            ");
            $stmt->bindParam(':points', $points, PDO::PARAM_INT);
            $stmt->bindParam(':membership_id', $membership['MembershipID'], PDO::PARAM_INT);
            $stmt->execute();
        }

        // Update order status to 'Completed'
        $stmt = $conn->prepare("UPDATE `order` SET Status = 'Completed' WHERE OrderID = :order_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Display success message and redirect
        echo "<script>alert('Checkout successful!');</script>";
        echo "<script>window.location.href = 'viewOrder.php?status=Completed';</script>";
        exit();
    } catch (Exception $e) {
        // Handle errors
        echo "<script>alert('" . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'viewOrder.php';</script>";
    }
}
?>
