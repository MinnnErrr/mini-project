<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Package</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSideBar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <div class="border rounded-3 p-4 bg-white col-lg-6 mx-auto">
                        <h4 class="pb-3">Package A</h4>
                        <form action="">
                            <div class="mb-3">
                                <label for="packageName" class="form-label">Package name</label>
                                <input type="text" value="Package A" readonly class="form-control-plaintext" name="packageName" id="packageName">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control-plaintext" readonly name="description" id="description">Des....</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Base Price (RM)</label>
                                <input type="text" value="1.00" readonly class="form-control-plaintext" name="price" id="price">
                            </div>
                            <div class="mb-5">
                                <label for="availability" class="form-label">Availability</label>
                                <input type="text" value="Available" readonly class="form-control-plaintext" name="branchContact" id="branchContact">
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="./updatePackage.php" class="btn btn-outline-dark me-3 w-100">Edit</a>
                                <a href="./packageManagement.php" class="btn btn-outline-dark ms-3 w-100">Back</a>
                            </div>
                        </form>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('package').classList.add('is-active');
    </script>
</body>

</html>