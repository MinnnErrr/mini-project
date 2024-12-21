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
        <!-- Main Content -->
        <div class="col-lg-10">
                <div class="mt-3 mb-3">
                    <h4>Order Management</h4>
                    <div class="input-group mb-3 w-50">
                        <input type="text" class="form-control" placeholder="Search Orders..." />
                        <button class="btn btn-outline-secondary" type="button">Search</button>
                    </div>
                </div>

<!-- Order Table -->
<div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                            
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Order Row 1 -->
                            <tr>
                                <td>#001</td>
                                <td>2024-06-18</td>
                                <td>Pending</td>
                                <td>$50.00</td>
                                <td class="action-links">
                                    <a href="editOrder.php?order_id=1" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="viewOrder.php?order_id=1" class="btn btn-info btn-sm">View</a>
                                    <a href="checkout.php?order_id=2" class="btn btn-primary btn-sm">Checkout</a>
                                    <button class="btn btn-danger btn-sm delete-order" data-order-id="1">Delete</button>
                                </td>
                            </tr>
                            <!-- Example Order Row 2 -->
                            <tr>
                                <td>#002</td>
                                <td>2024-06-17</td>
                                <td>Completed</td>
                                <td>$75.00</td>
                                <td class="action-links">
                                    <a href="editOrder.php?order_id=2" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="viewOrder.php?order_id=2" class="btn btn-info btn-sm">View</a>
                                    <a href="checkout.php?order_id=2" class="btn btn-primary btn-sm">Checkout</a>
                                    <button class="btn btn-danger btn-sm delete-order" data-order-id="2">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- JavaScript for Delete Confirmation -->
<script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteButtons = document.querySelectorAll('.delete-order');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const orderId = this.getAttribute('data-order-id');
                    if (confirm(`Are you sure you want to delete order #${orderId}?`)) {
                        // Implement delete logic or redirect to delete script
                        window.location.href = `deleteOrder.php?order_id=${orderId}`;
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
</html>