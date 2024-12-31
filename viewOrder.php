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

// Fetch membership balance for the logged-in customer
$balanceQuery = "SELECT Balance FROM membershipcard WHERE CustomerID = :customer_id LIMIT 1";
$stmt = $conn->prepare($balanceQuery);
$stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
$stmt->execute();
$balanceResult = $stmt->fetch(PDO::FETCH_ASSOC);
$membership_balance = $balanceResult ? $balanceResult['Balance'] : 0;

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
    <script src="https://cdn.tailwindcss.com"></script>
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

        .balance-card {
            background-color: #f1f1f1;
            padding: 10px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .balance-card i {
            font-size: 2rem;
            color: #4CAF50;
        }

        .balance-card .balance-info {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .balance-card .balance-info span {
            font-size: 1.5rem;
            color: #4CAF50;
        }

        /* Ensures balance card stays left aligned */
        .balance-card-container {
            display: flex;
            justify-content: flex-start;
        }
    </style>
</head>

<body class="bg-light">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'customerSideBar.php' ?>
            <div class="col-lg-10">
                <div class="container min-vh-100 mt-5">  
                    <!-- content starts here -->
                    <h4 class="mb-4">Order Cart</h4>

                    <!-- Display Membership Balance (Aligned Left) -->
                    <div class="balance-card-container">
                        <div class="balance-card">
                            <i class="bi bi-wallet2"></i>
                            <div class="balance-info">
                                <p><strong>Current Membership Balance:</strong></p>
                                <p><span>RM <?= number_format($membership_balance, 2); ?></span></p>
                            </div>
                        </div>
                    </div>

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
                                <div class="col-md-6">
                                    <div class="card shadow order-card">
                                        <div class="card-header bg-primary text-white">
                                            <h5>Order #<?= htmlspecialchars($order['OrderID']); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Order Date:</strong> <?= htmlspecialchars($order['Date']); ?></p>
                                            <p><strong>Status:</strong> <?= htmlspecialchars($order['Status']); ?></p>
                                            <p><strong>Total:</strong> RM <?= number_format($order['TotalPrice'], 2); ?></p>
                                            <p><strong>Earn:</strong> <?= htmlspecialchars($order['Points']); ?> Point</p>
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

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('viewOrder').classList.add('is-active'); 
    </script>
</body>

</html>
