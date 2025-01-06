<?php
require 'dbconfig.php';

session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('location: adminDashboard.php');
        exit;
    } elseif ($_SESSION['role'] == 'staff') {
        header('location: staffDashboard.php');
        exit;
    } elseif ($_SESSION['role'] == 'customer') {
        header('location: customerDashboard.php');
        exit;
    }
}

if (isset($_SESSION['customer_id'])) {
    header('location: order_management.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Login</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row vh-100">
            <!--left-->
            <div class="col justify-content-center align-items-center d-flex">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="./images/RapidPrintSquare.png" alt="RapidPrint Logo" class="img-fluid"
                            style="max-width: 20vw;">
                    </div>
                    <div class="col-12">
                        <p class="fs-5 text-center">Fast, Convenient, Affordable</p>
                    </div>
                </div>
            </div>
            <!--right-->
            <div class="col-12 col-lg-6 bg-body-tertiary justify-content-center align-items-center d-flex flex-column">
                <form action="./controller/loginController.php" method="post" class="w-75">
                    <h2>WELCOME</h2>
                    <p class="mb-4">Please enter your details to proceed to order</p>
                    <?php if (isset($_SESSION['loginError'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['loginError']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['loginError']);
                    endif;
                    ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" placeholder="">
                        <label for="floatingInput">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" placeholder="">
                        <label for="floatingInput">Email Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" name="phone" placeholder="">
                        <label for="floatingInput">Phone Number</label>
                    </div>
                    <button class="btn btn-dark w-100 py-2 mb-3" type="submit" name="guestSignIn">Continue</button>
                    <button class="btn btn-light w-100 py-2" type="button" onclick="location.href='./login.php'">Back</button>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>