<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    header('Location: viewOrder.php');
    exit();
}

// Fetch the order details with package data
$query = "
    SELECT op.Quantity, op.PackageID, p.Name, p.BasePrice, o.* 
    FROM `order` o
    LEFT JOIN `orderprintingpackage` op ON o.OrderID = op.OrderID
    LEFT JOIN `printingpackage` p ON op.PackageID = p.PackageID
    WHERE o.OrderID = :order_id AND o.CustomerID = :customer_id
";
$stmt = $conn->prepare($query);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: viewOrder.php');
    exit();
}

// Fetch available printing packages
$query = "SELECT * FROM printingpackage WHERE Availability = 1";
$packages = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-body-secondary bg-opacity-50">
    <div class="row vh-100">
        <div class="col-lg-2 border-end bg-light">
            <div class="offcanvas-lg offcanvas-start position-fixed" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">RapidPrint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="nav flex-column d-flex justify-content-between" style="height: 87vh;">
                        <div>
                            <li class="nav-item mt-lg-3">
                                <a class="nav-link is-dark" href="customerDashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link is-dark" href="order_management.php">Add Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link is-dark" href="showOrder.php">View Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link is-dark" href="viewOrder.php">Checkout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link is-dark" href="applyMembership.php">Membership Card</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link is-dark" href="CustomerProfile.php">Profile</a>
                            </li>
                        </div>
                        <div>
                            <li class="nav-item">
                                <div class="nav-link">
                                    <button class="btn w-100 btn-outline-dark" onclick="location.href='logout.php'">
                                        Log Out
                                    </button>
                                </div>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5>Edit Your Order #<?= htmlspecialchars($order['OrderID']); ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="updateOrder.php" enctype="multipart/form-data">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['OrderID']); ?>">

                            <div class="mb-3">
                                <label for="package" class="form-label">Select Package</label>
                                <select name="package_id" id="package" class="form-select" required>
                                    <?php foreach ($packages as $package): ?>
                                        <option value="<?= $package['PackageID']; ?>" <?= $order['PackageID'] == $package['PackageID'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($package['Name']); ?> (RM<?= number_format($package['BasePrice'], 2); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($order['Quantity']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>

                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-select" required>
                                    <option value="MembershipCard" <?= $order['PaymentMethod'] == 'MembershipCard' ? 'selected' : ''; ?>>Membership Card</option>
                                    <option value="Cash" <?= $order['PaymentMethod'] == 'Cash' ? 'selected' : ''; ?>>Cash</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="pickup_date" class="form-label">Pick-Up Date</label>
                                <input type="date" name="pickup_date" id="pickup_date" class="form-control" value="<?= htmlspecialchars($order['PickUpDate']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="pickup_time" class="form-label">Pick-Up Time</label>
                                <input type="time" name="pickup_time" id="pickup_time" class="form-control" value="<?= htmlspecialchars($order['PickUpTime']); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>