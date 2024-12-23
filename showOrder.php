<?php
require 'dbconfig.php';
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user, sorted by date in descending order
$query = "SELECT * FROM `order` WHERE CustomerID = :customer_id AND Status = 'Completed' ORDER BY Date DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .order-card {
            margin-top: 20px;
            padding: 20px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .file-icon {
            font-size: 1.0rem; /* Icon size */
            margin-right: 5px; /* Space between icon and text */
            color: #007bff; /* Icon color */
        }
        .no-orders {
            text-align: center;
            padding: 20px;
            color: #777;
        }
    </style>
</head>

<body>
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
                <h4 class="mb-4">List of Orders</h4>

                <div class="order-card">
                    <!-- Orders Table -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total Price (RM)</th>
                                <th>Points Earned</th>
                                <th>Payment Method</th>
                                <th>Pick-Up Date</th>
                                <th>Pick-Up Time</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($orders) > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['OrderID']); ?></td>
                                        <td><?= htmlspecialchars($order['Date']); ?></td>
                                        <td><?= number_format($order['TotalPrice'], 2); ?></td>
                                        <td><?= htmlspecialchars($order['Points']); ?></td>
                                        <td><?= htmlspecialchars($order['PaymentMethod']); ?></td>
                                        <td><?= htmlspecialchars($order['PickUpDate']); ?></td>
                                        <td><?= htmlspecialchars($order['PickUpTime']); ?></td>
                                        <td>
                                            <?php if (!empty($order['file'])): ?>
                                                <a href="files/<?= htmlspecialchars($order['file']); ?>" target="_blank">
                                                    <i class="bi bi-file-earmark-text file-icon" title="Download Order File"></i>
                                                    
                                                </a>
                                            <?php else: ?>
                                                No File Available
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="no-orders">No orders found for this account.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>