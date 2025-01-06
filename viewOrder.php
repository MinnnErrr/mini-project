<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
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
$query .= " ORDER BY Date DESC"; // Order by date in descending order
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
            <?php require 'customerSideBar.php'; ?>
            <div class="col-lg-10">
                <div class="container min-vh-100 mt-5">
                    <h4 class="mb-4">Order Cart</h4>

                    <!-- Display Membership Balance -->
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
                    <form id="orderForm" method="post" action="checkoutOrder.php">
                        <div class="row">
                            <?php if (count($orders) > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <div class="col-md-6">
                                        <div class="card shadow order-card">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                <h5>Order #<?= htmlspecialchars($order['OrderID']); ?></h5>
                                                <?php if ($order['Status'] === 'Pending'): ?>
                                                    <input type="checkbox" name="selected_order[]" value="<?= htmlspecialchars($order['OrderID']); ?>" onclick="selectOrder(this)">
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>Order Date:</strong> <?= htmlspecialchars($order['Date']); ?></p>
                                                <p><strong>Status:</strong> <?= htmlspecialchars($order['Status']); ?></p>
                                                <p><strong>Total:</strong> RM <?= number_format($order['TotalPrice'], 2); ?></p>
                                                <p><strong>Earn:</strong> <?= htmlspecialchars($order['Points']); ?> Point</p>
                                                <p><strong>Pick-Up:</strong> <?= htmlspecialchars($order['PickUpDate']); ?> at <?= htmlspecialchars($order['PickUpTime']); ?></p>
                                            </div>
                                            <div class="card-footer d-flex gap-2">
                                                <?php if ($order['Status'] === 'Completed'): ?>
                                                    <p class="text-success mb-1">This order is complete.</p>
                                                <?php else: ?>
                                                    <a href="editOrder.php?order_id=<?= htmlspecialchars($order['OrderID']); ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <!-- Delete button triggering JavaScript to delete the order -->
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= htmlspecialchars($order['OrderID']); ?>)">Delete</button>
                                                    <script>
                                                        function confirmDelete(orderId) {
                                                            const confirmation = confirm('Are you sure you want to cancel this order?');
                                                            if (confirmation) {
                                                                // Create a form dynamically
                                                                const form = document.createElement('form');
                                                                form.method = 'POST';
                                                                form.action = 'deleteOrder.php';

                                                                // Create a hidden input for the order_id
                                                                const input = document.createElement('input');
                                                                input.type = 'hidden';
                                                                input.name = 'order_id';
                                                                input.value = orderId;

                                                                // Append the hidden input to the form
                                                                form.appendChild(input);

                                                                // Append the form to the body
                                                                document.body.appendChild(form);

                                                                // Submit the form
                                                                form.submit();
                                                            }
                                                        }
                                                    </script>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No orders found.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Total and Payment -->
                        <div id="orderDetails" style="display:none;">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Order Summary</h4>
                                </div>
                                <div class="card-body">
                                    <p style="font-size:15px; margin-bottom:10px;"><strong>Total Price:</strong> RM <span id="totalPrice">0.00</span></p>
                                    <label for="paymentMethod" class="form-label">Select Payment Method:</label>
                                    <select name="paymentMethod" id="paymentMethod" class="form-select w-100 mb-3">
                                        <option value="">--Choose--</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Membership Card">Membership Card</option>
                                    </select>
                                </div>
                                <div class="card-footer text-end">
                                    <button type="submit" id="checkoutButton" class="btn btn-success" disabled>Checkout</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php require 'footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectOrder(checkbox) {
            const orderDetails = document.getElementById('orderDetails');
            const checkoutButton = document.getElementById('checkoutButton');
            const totalPriceElement = document.getElementById('totalPrice');

            let selectedTotal = 0;

            // Get all selected orders
            const checkboxes = document.querySelectorAll('input[name="selected_order[]"]:checked');

            checkboxes.forEach((cb) => {
                const card = cb.closest('.card');
                const priceText = card.querySelector('p:nth-child(3)').innerText; // Assuming total price is in the 3rd <p>
                const price = parseFloat(priceText.replace(/[^0-9.-]+/g, ''));
                selectedTotal += price;
            });

            totalPriceElement.innerText = selectedTotal.toFixed(2);

            if (checkboxes.length > 0) {
                orderDetails.style.display = 'block';
                checkoutButton.disabled = false;
            } else {
                orderDetails.style.display = 'none';
                checkoutButton.disabled = true;
            }
        }
    </script>
</body>

</html>