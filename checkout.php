<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-body-secondary bg-opacity-50">

    <nav class="navbar sticky-top shadow-sm bg-white p-2">
    <div class="container-fluid">
        <button class="btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
            <span class="bi bi-list fs-3"></span>
        </button>
        <a class="navbar-brand d-flex align-items-center" aria-current="page" href="#">
            <img class="me-1" src="./RapidPrintIcon.png" alt="RapidPrint" width="30">
            <span class="ms-1">RapidPrint</span>
        </a>

    </div>
</nav>
    <div class="container-fluid">
        <div class="row vh-100">
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
                        <a class="nav-link is-dark is-active" href="customerDashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="order_management.php">Add Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="viewOrder.php">View Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="checkout.php">Checkout</a>
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
<?php
// Simulate database connection and orders
$orders = [
    "001" => ["customer" => "John Doe", "date" => "2024-06-18", "amount" => "50.00", "status" => "Pending"],
    "002" => ["customer" => "Jane Smith", "date" => "2024-06-17", "amount" => "75.00", "status" => "Completed"]
];

// Get order ID from URL
$order_id = $_GET['order_id'] ?? null;

// Find order details
$order = $orders[$order_id] ?? null;

// Redirect if order not found
if (!$order) {
    header("Location: viewOrder.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2>Checkout</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Order Details</h5>
                <p><strong>Order ID:</strong> <?= $order_id ?></p>
                <p><strong>Customer:</strong> <?= $order['customer'] ?></p>
                <p><strong>Date:</strong> <?= $order['date'] ?></p>
                <p><strong>Amount:</strong> $<?= $order['amount'] ?></p>
                <p><strong>Status:</strong> <?= $order['status'] ?></p>
            </div>
        </div>

        <!-- Payment Form -->
        <form class="mt-4" action="process_checkout.php" method="POST">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Payment Method</label>
                <select name="payment_method" id="paymentMethod" class="form-control" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cash">Cash on Delivery</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Shipping Address</label>
                <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Complete Checkout</button> <a href = "viewOrder.php">
        </form>
    </div>
</body>

</html>
