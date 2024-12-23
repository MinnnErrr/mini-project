<?php
require 'dbconfig.php';
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

// Filter by status if set
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch orders based on filters
$query = "SELECT * FROM `order` WHERE CustomerID = :customer_id";
if (!empty($status_filter)) {
    $query .= " AND Status = :status";
}

// Add order by clause to sort by date in descending order
$query .= " ORDER BY Date DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
if (!empty($status_filter)) {
    $stmt->bindParam(':status', $status_filter, PDO::PARAM_STR);
}
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .order-card {
            margin-bottom: 20px;
        }

        .btn-sm {
            font-size: 0.8rem;
        }

        .modal-content {
            border-radius: 15px;
        }
    </style>
</head>

<body class="bg-body-secondary bg-opacity-50">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
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
                                    <a class="nav-link is-dark is-active" href="viewOrder.php">Checkout</a>
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
                    <h4 class="mb-4">Order Management</h4>

                    <!-- Filter Orders -->
                    <div class="mb-4">
                        <form method="GET" class="d-flex gap-2">
                            <select name="status" class="form-select w-25">
                                <option value="">All</option>
                                <option value="Pending" <?= $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Completed" <?= $status_filter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>

                    <!-- Orders -->
                    <div class="row">
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <div class="col-md-4">
                                    <div class="card shadow order-card">
                                        <div class="card-header bg-primary text-white">
                                            <h5>Order #<?= htmlspecialchars($order['OrderID']); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Order Date:</strong> <?= htmlspecialchars($order['Date']); ?></p>
                                            <p><strong>Status:</strong> <?= htmlspecialchars($order['Status']); ?></p>
                                            <p><strong>Total:</strong> RM<?= number_format($order['TotalPrice'], 2); ?></p>
                                            <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['PaymentMethod']); ?></p>
                                            <p><strong>Pick-Up:</strong> <?= htmlspecialchars($order['PickUpDate']); ?> at <?= htmlspecialchars($order['PickUpTime']); ?></p>
                                        </div>
                                        <div class="card-footer d-flex gap-2">
                                            <?php if ($order['Status'] === 'Completed'): ?>
                                                <p class="text-success mb-1">This order is complete.</p>
                                            <?php else: ?>
                                                <a href="editOrder.php?order_id=<?= htmlspecialchars($order['OrderID']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <form method="POST" action="deleteOrder.php" onsubmit="return confirmDelete();">
                                                    <input type="hidden" name="order_id" value="<?= $order['OrderID']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>

                                                <script>
                                                    function confirmDelete() {
                                                        return confirm('Are you sure you want to cancel this order?');
                                                    }
                                                </script>

                                                <a href="checkout.php?order_id=<?= htmlspecialchars($order['OrderID']); ?>" class="btn btn-success btn-sm">Checkout</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No orders found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>