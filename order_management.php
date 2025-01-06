<?php
require 'dbconfig.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['customer_id'])) {
    header('location:login.php');
}

// Fetch available packages from the database
$packages = $conn->query("SELECT * FROM printingpackage WHERE Availability = 'Available'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css"> -->
    <title>Order Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./main.css">
</head>

<body class="bg-light">
    <?php require 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Sidebar -->
            <?php require 'customerSidebar.php' ?>

            <!-- Main Content -->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 py-5">

                    <!-- content starts here -->
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
                                    <select class="form-select" id="orderPackage" name="orderPackage" required onchange="updateCategory(this.value)">
                                        <option value="" selected disabled>Select a package</option>
                                        <?php foreach ($packages as $package) : ?>
                                            <option value="<?= $package['PackageID']; ?>">
                                                <?= $package['Name'] . " [ " . $package['Description'] . " ] " . " - RM" . number_format($package['BasePrice'], 2); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Category Selection -->
                                <div class="mb-4" id="categorySection" style="display: none;">
                                    <label for="category" class="form-label fw-bold">
                                        <i class="bi bi-tags"></i> Select Category
                                    </label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="" selected disabled>Select a category</option>
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div class="mb-4">
                                    <label for="quantity" class="form-label fw-bold">
                                        <i class="bi bi-list-ol"></i> Quantity
                                    </label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" placeholder="Enter quantity" required>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">
                                        <i class="bi bi-card-text"></i> Description Order
                                    </label>
                                    <textarea class="form-control" id="description" name="description" rows="1" placeholder="Enter order description" required></textarea>
                                </div>

                                <!-- File Upload -->
                                <div class="mb-4">
                                    <label for="file" class="form-label fw-bold">
                                        <i class="bi bi-cloud-upload"></i> Upload File
                                    </label>
                                    <input type="file" class="form-control" id="file" name="file" required>
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

                    </div>
                </div>

                <?php require 'footer.php'; ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const packageProperties = <?php
                                    $properties = $conn->query("SELECT * FROM packageproperty")->fetchAll(PDO::FETCH_ASSOC);
                                    echo json_encode($properties);
                                    ?>;

        function updateCategory(packageID) {
            const categorySection = document.getElementById('categorySection');
            const categorySelect = document.getElementById('category');

            // Clear existing categories
            categorySelect.innerHTML = '<option value="" selected disabled>Select a category</option>';

            // Populate categories based on selected packageID
            const filteredProperties = packageProperties.filter(property => property.PackageID == packageID);
            filteredProperties.forEach(property => {
                const option = document.createElement('option');
                option.value = property.PropertyID;
                option.textContent = `${property.Name} - RM${parseFloat(property.Price).toFixed(2)}`;
                categorySelect.appendChild(option);
            });

            categorySection.style.display = 'block';
        }
    </script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('orderManagement').classList.add('is-active');
    </script>
</body>

</html>