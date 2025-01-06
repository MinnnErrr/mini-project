<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
    exit();
}

// Initialize variables
$orders = [];
$customer_id = $_SESSION['user_id'];

try {
    // Fetch orders for the logged-in user, sorted by date in descending order
    $query = "SELECT * FROM `order` WHERE CustomerID = :customer_id AND Status = 'Completed' ORDER BY Date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and initialize $orders as an empty array
    $orders = [];
    error_log("Error fetching orders: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <style>
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

        .file-icon,
        .action-icon {
            font-size: 1.2rem;
            color: #007bff;
            cursor: pointer;
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        .modal-card {
            padding: 20px;
            width: fit-content;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-card-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #007bff
        }

        .modal-card-content table {
            width: fit-content;
        }

        .modal-card-content th {
            text-align: left;
            padding-right: 80px;
            font-weight: bold;
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
                    <h4 class="mb-4">List of Orders</h4>
                    <div class="order-card">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders) && count($orders) > 0): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($order['OrderID']); ?></td>
                                            <td><?= htmlspecialchars($order['Date']); ?></td>
                                            <td>
                                                <?php if (!empty($order['file'])): ?>
                                                    <a href="files/<?= htmlspecialchars($order['file']); ?>" target="_blank">
                                                        <i class="bi bi-file-earmark-text file-icon" title="Download File"></i>
                                                    </a>
                                                <?php else: ?>
                                                    No File Available
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="bi bi-eye action-icon"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderDetailsModal"
                                                    data-order='<?= json_encode($order); ?>'></i>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="no-orders">No orders found for this account.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php require 'footer.php'; ?>
            </div>
        </div>
    </div>

    <!-- Modal for Order Details -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-card">
                <div class="modal-card-header">Order Details</div>
                <div class="modal-card-content">
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <td id="modalOrderID"></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="modalDate"></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>RM <span id="modalTotalPrice"></span></td>
                        </tr>
                        <tr>
                            <th>Points Earned</th>
                            <td id="modalPoints"></td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td id="modalPaymentMethod"></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td id="modalDescriptionOrder"></td>
                        </tr>
                        <tr>
                            <th>Pick-Up Date</th>
                            <td id="modalPickUpDate"></td>
                        </tr>
                        <tr>
                            <th>Pick-Up Time</th>
                            <td id="modalPickUpTime"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('showOrder').classList.add('is-active');
    </script>

    <script>
        // Populate modal with order details
        document.querySelectorAll('.action-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const order = JSON.parse(this.getAttribute('data-order'));

                // Populate modal fields
                document.getElementById('modalOrderID').textContent = order.OrderID || 'N/A';
                document.getElementById('modalDate').textContent = order.Date || 'N/A';
                document.getElementById('modalTotalPrice').textContent = parseFloat(order.TotalPrice || 0).toFixed(2);
                document.getElementById('modalPoints').textContent = order.Points || 'N/A';
                document.getElementById('modalPaymentMethod').textContent = order.PaymentMethod || 'N/A';
                document.getElementById('modalDescriptionOrder').textContent = order.descriptionOrder || 'N/A';
                document.getElementById('modalPickUpDate').textContent = order.PickUpDate || 'N/A';
                document.getElementById('modalPickUpTime').textContent = order.PickUpTime || 'N/A';
            });
        });
    </script>
</body>

</html>