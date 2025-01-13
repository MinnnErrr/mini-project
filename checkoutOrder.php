<?php
require 'dbconfig.php';

session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

// Check if selected orders are passed
if (!isset($_POST['selected_order']) || empty($_POST['selected_order'])) {
    echo "<script>alert('No orders selected for checkout.');</script>";
    echo "<script>window.location.href = 'viewOrder.php';</script>";
    exit();
}

// Fetch selected orders from the form
$selected_orders = $_POST['selected_order'];

// Get payment method
$payment_method = $_POST['paymentMethod'] ?? '';

if (!$payment_method) {
    echo "<script>alert('Please select a payment method.');</script>";
    echo "<script>window.location.href = 'viewOrder.php';</script>";
    exit();
}

try {
    foreach ($selected_orders as $order_id) {
        // Fetch order details
        $stmt = $conn->prepare("SELECT * FROM `order` WHERE OrderID = :order_id AND CustomerID = :customer_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            throw new Exception("Order #$order_id not found.");
        }

        $total_price = $order['TotalPrice'];
        $points = $order['Points'];
        $order_status = $order['Status'];

        if ($order_status === 'Ordered') {
            throw new Exception("Order #$order_id is already ordered.");
        }

        // Calculate points: Amount = total_price / 2
        $amount = $total_price / 2;

        if ($payment_method === 'Membership Card') {
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

            $stmt = $conn->prepare("UPDATE membershipcard SET Balance = :new_balance WHERE MembershipID = :membership_id");
            $stmt->bindParam(':new_balance', $new_balance, PDO::PARAM_INT);
            $stmt->bindParam(':membership_id', $membership['MembershipID'], PDO::PARAM_INT);
            $stmt->execute();

            // Record points in the points table, with the calculated amount
            $stmt = $conn->prepare("INSERT INTO point (Date, Amount, MembershipID) VALUES (NOW(), :amount, :membership_id)");
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->bindParam(':membership_id', $membership['MembershipID'], PDO::PARAM_INT);
            $stmt->execute();

            $membershipID = $membership['MembershipID'];
            $stmt = $conn->prepare("SELECT SUM(Amount) AS total_points FROM point WHERE MembershipID = :membership_id"); // Calculate total points
            $stmt->bindParam(':membership_id', $membershipID );
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_points = $result["total_points"];
            
            $stmt = $conn->prepare("UPDATE membershipcard SET AccumulatedPoints= :accumulatedPoints WHERE MembershipID = :membership_id"); // Update accumulated points
            $stmt->bindParam(':membership_id', $membershipID);
            $stmt->bindParam(':accumulatedPoints', $total_points);
            $stmt->execute();
        

            // Update payment method to Membership Card
            $stmt = $conn->prepare("UPDATE `order` SET PaymentMethod = 'Membership Card' WHERE OrderID = :order_id");
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } elseif ($payment_method === 'Cash') {
            // Cash payment, no balance check needed
            $stmt = $conn->prepare("UPDATE `order` SET PaymentMethod = 'Cash' WHERE OrderID = :order_id");
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new Exception("Invalid payment method selected.");
        }

        // Update order status to 'Completed'
        $stmt = $conn->prepare("UPDATE `order` SET Status = 'Ordered' WHERE OrderID = :order_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Success message and redirect
    echo "<script>alert('Checkout successful!');</script>";
    echo "<script>window.location.href = 'viewOrder.php?status=Ordered';</script>";
    exit();

} catch (Exception $e) {
    // Handle errors and rollback if necessary
    echo "<script>alert('" . $e->getMessage() . "');</script>";
    echo "<script>window.location.href = 'viewOrder.php';</script>";
}
?>
