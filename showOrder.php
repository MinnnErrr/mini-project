<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
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

        .file-icon {
            font-size: 1.0rem;
            /* Icon size */
            margin-right: 5px;
            /* Space between icon and text */
            color: #007bff;
            /* Icon color */
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #777;
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

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('showOrder').classList.add('is-active'); 
    </script>
</body>

</html>