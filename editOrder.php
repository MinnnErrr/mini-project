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

// Fetch the order details with package and property data
$query = "
    SELECT op.Quantity, op.PackageID, op.OrderPackageID, p.Name AS PackageName, p.BasePrice, pp.PropertyID, pp.Name AS PropertyName, pp.Price AS PropertyPrice, o.*, o.descriptionOrder
    FROM `order` o
    LEFT JOIN `orderprintingpackage` op ON o.OrderID = op.OrderID
    LEFT JOIN `printingpackage` p ON op.PackageID = p.PackageID
    LEFT JOIN `orderproperty` opy ON op.OrderPackageID = opy.OrderPackageID
    LEFT JOIN `packageproperty` pp ON opy.PropertyID = pp.PropertyID
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
$query = "SELECT * FROM printingpackage WHERE Availability = 'Available'";
$packages = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

// Determine selected package (use existing order data or submitted form)
$selected_package_id = $_POST['package_id'] ?? $order['PackageID'];

// Fetch categories for the selected package
$categories = [];
if ($selected_package_id) {
    $categoryQuery = "SELECT * FROM packageproperty WHERE PackageID = :package_id";
    $categoryStmt = $conn->prepare($categoryQuery);
    $categoryStmt->bindParam(':package_id', $selected_package_id, PDO::PARAM_INT);
    $categoryStmt->execute();
    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <title>Edit Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Sidebar -->
            <?php require 'customerSidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 py-5">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h5>Edit Your Order #<?= htmlspecialchars($order['OrderID']); ?></h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="updateOrder.php" enctype="multipart/form-data">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['OrderID']); ?>">

                                <div class="mb-3">
                                    <label for="package" class="form-label fw-bold">Select Package</label>
                                    <select name="package_id" id="package" class="form-select" required>
                                        <option value="">-- Select Package --</option>
                                        <?php foreach ($packages as $package): ?>
                                            <option value="<?= $package['PackageID']; ?>" <?= $selected_package_id == $package['PackageID'] ? 'selected' : ''; ?>>
                                                <?= $package['Name'] . " [ " . $package['Description'] . " ] " . " - RM" . number_format($package['BasePrice'], 2); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label fw-bold">Select Category</label>
                                    <select name="category" id="category" class="form-select" required data-selected="<?= $order['PropertyID']; ?>">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['PropertyID']; ?>" <?= isset($order['PropertyID']) && $order['PropertyID'] == $category['PropertyID'] ? 'selected' : ''; ?>>
                                                <?= $category['Name'] . " - RM" . number_format($category['Price'], 2); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea name="description" id="description" class="form-control" required><?= htmlspecialchars($order['descriptionOrder']); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($order['Quantity']); ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label for="file" class="form-label fw-bold">Upload File</label>
                                    <?php if (!empty($order['file'])): ?>
                                        <div class="mb-2">
                                            <label class="d-block fst-italic">Current File:</label>
                                            <a href="files/<?= htmlspecialchars($order['file']); ?>" target="_blank" class="btn btn-link text-decoration-none">
                                                <?= htmlspecialchars(basename($order['file'])); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="file" id="file" class="form-control-file" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg,.txt,.zip,">
                                    <!-- Hidden input to pass the current file name -->
                                    <input type="hidden" name="current_file" value="<?= htmlspecialchars($order['file']); ?>">
                                    <small class="form-text text-muted">You can upload a new file or leave it blank to keep the current one.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label fw-bold">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-select" required>
                                        <option value="MembershipCard" <?= $order['PaymentMethod'] == 'MembershipCard' ? 'selected' : ''; ?>>Membership Card</option>
                                        <option value="Cash" <?= $order['PaymentMethod'] == 'Cash' ? 'selected' : ''; ?>>Cash</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="pickup_date" class="form-label fw-bold">Pick-Up Date</label>
                                    <input type="date" name="pickup_date" id="pickup_date" class="form-control" value="<?= htmlspecialchars($order['PickUpDate']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="pickup_time" class="form-label fw-bold">Pick-Up Time</label>
                                    <input type="time" name="pickup_time" id="pickup_time" class="form-control" value="<?= htmlspecialchars($order['PickUpTime']); ?>" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php require 'footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('package').addEventListener('change', function() {
            const packageId = this.value;
            const categorySelect = document.getElementById('category');
            const oldCategory = categorySelect.dataset.selected;

            fetch(`fetchCategories.php?package_id=${packageId}`)
                .then(response => response.json())
                .then(categories => {
                    categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.PropertyID;
                        option.textContent = `${category.Name} - RM${parseFloat(category.Price).toFixed(2)}`;
                        if (category.PropertyID == oldCategory) {
                            option.selected = true;
                        }
                        categorySelect.appendChild(option);
                    });
                });
        });
    </script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('viewOrder').classList.add('is-active');
    </script>
</body>

</html>