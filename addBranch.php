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
    <title>Add Branch</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <div class="border rounded-3 p-4 bg-white col-lg-6 mx-auto">
                        <h4 class="pb-3">Add Branch</h4>
                        <form action="">
                            <div class="mb-3">
                                <label for="branchName" class="form-label">Branch name</label>
                                <input type="text" class="form-control" name="branchName" id="branchName">
                            </div>
                            <div class="mb-3">
                                <label for="branchAddress" class="form-label">Address</label>
                                <textarea class="form-control" name="branchAddress" id="branchAddress"></textarea>
                            </div>
                            <div class="mb-5">
                                <label for="branchContact" class="form-label">Contact number</label>
                                <input type="text" class="form-control" name="branchContact" id="branchContact">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100">Create</button>
                                <a href="./branchManagement.php" class="btn btn-outline-dark ms-3 w-100">Back</a>
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
        document.getElementById('branch').classList.add('is-active');
    </script>
</body>

</html>