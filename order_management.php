<?php
require 'dbconfig.php';
session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Fetch packages from the database
$packages = $conn->query("SELECT * FROM printingpackage WHERE Availability = 1")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <title>Order Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-body-secondary bg-opacity-50">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Sidebar -->
            <div class="col-lg-2 border-end bg-light">
                <div class="offcanvas-lg offcanvas-start position-fixed" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">RapidPrint</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="nav flex-column d-flex justify-content-between" style="height: 87dvh;">
                            <div>
                                <li class="nav-item mt-lg-3">
                                    <a class="nav-link is-dark" href="customerDashboard.php">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link is-dark is-active" href="order_management.php">Add Order</a>
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

            <!-- Main Content -->
            <div class="col-sm-12 col-lg-10">
                <div class="container py-5">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h2><i class="bi bi-cart-plus"></i> Place Your Order</h2>
                        </div>
                        <div class="card-body p-4">
                            <form action="place_order.php" method="POST" enctype="multipart/form-data">
                                <!-- Package Selection -->
                                <div class="mb-4">
                                    <label for="orderPackage" class="form-label fw-bold">
                                        <i class="bi bi-box"></i> Select Package
                                    </label>
                                    <select class="form-select" id="orderPackage" name="orderPackage" required>
                                        <?php foreach ($packages as $package) : ?>
                                            <option value="<?= $package['PackageID']; ?>">
                                                <?= $package['Name'] . " - RM" . number_format($package['BasePrice'], 2); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Quantity -->
                                <div class="mb-4">
                                    <label for="quantity" class="form-label fw-bold">
                                        <i class="bi bi-list-ol"></i> Quantity
                                    </label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" placeholder="Enter quantity" required>
                                </div>
                                <!-- File Upload -->
                                <div class="mb-4">
                                    <label for="file" class="form-label fw-bold">
                                        <i class="bi bi-cloud-upload"></i> Upload File
                                    </label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                </div>
                                <!-- Payment Method -->
                                <div class="mb-4">
                                    <label for="paymentMethod" class="form-label fw-bold">
                                        <i class="bi bi-credit-card"></i> Payment Method
                                    </label>
                                    <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                        <option value="MembershipCard">Membership Card</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>
                                <!-- Pick-Up Date -->
                                <div class="mb-4">
                                    <label for="pickUpDate" class="form-label fw-bold">
                                        <i class="bi bi-calendar-check"></i> Pick-Up Date
                                    </label>
                                    <input type="date" class="form-control" id="pickUpDate" name="pickUpDate" required>
                                </div>
                                <!-- Pick-Up Time -->
                                <div class="mb-4">
                                    <label for="pickUpTime" class="form-label fw-bold">
                                        <i class="bi bi-clock"></i> Pick-Up Time
                                    </label>
                                    <input type="time" class="form-control" id="pickUpTime" name="pickUpTime" required>
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-check-circle"></i> Submit Order
                                </button>
                            </form>
                        </div>
                        <?php require 'footer.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>