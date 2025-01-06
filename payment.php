<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];
$selected_orders = $_POST['selected_orders'] ?? [];

if (empty($selected_orders)) {
    header('location:orderManagement.php');
    exit();
}

// Fetch selected orders
$placeholders = implode(',', array_fill(0, count($selected_orders), '?'));
$query = "SELECT * FROM `order` WHERE OrderID IN ($placeholders) AND CustomerID = ?";
$stmt = $conn->prepare($query);
$params = array_merge($selected_orders, [$customer_id]);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_amount = array_sum(array_column($orders, 'TotalPrice'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="bg-light">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'customerSideBar.php'; ?>
            <div class="col-lg-10">
                <div class="container min-vh-100 mt-5">
                    <h4 class="mb-4">Payment Summary</h4>
                    <div class="card shadow p-4">
                        <h5 class="mb-3">Selected Orders</h5>
                        <ul class="list-group mb-4">
                            <?php foreach ($orders as $order): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Order #<?= htmlspecialchars($order['OrderID']); ?> - RM <?= number_format($order['TotalPrice'], 2); ?></span>
                                    <span><?= htmlspecialchars($order['Date']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <h5>Total Amount: RM <?= number_format($total_amount, 2); ?></h5>
                        <form method="POST" action="showOrder.php">
                            <input type="hidden" name="order_ids" value="<?= htmlspecialchars(json_encode($selected_orders)); ?>">
                            <a href="checkout.php?order_id=<?= htmlspecialchars($order['OrderID']); ?>" class="btn btn-success btn-sm">Checkout</a>
                        </form>
                    </div>
                </div>
                <?php require 'footer.php'; ?>
            </div>
        </div>
    </div>
</body>

</html>
