<!--do not edit this file-->
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'sidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-5">
                    <h4 class="pb-3">Add Branches</h4>
                    <form action="" class="border rounded-3 p-3 bg-white">
                        <div class="mb-3">
                            <label for="branchName" class="form-label">Branch name</label>
                            <input type="text" class="form-control" name="branchName" id="branchName">
                        </div>
                        <div class="mb-3">
                            <label for="branchAddress" class="form-label">Address</label>
                            <textarea class="form-control" name="branchAddress" id="branchAddress"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="branchContact" class="form-label">Contact number</label>
                            <input type="text" class="form-control" name="branchContact" id="branchContact">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-dark me-3">Create</button>
                            <button type="button" class="btn btn-outline-dark ms-3" onclick="history.back()">Back</button>
                        </div>
                    </form>
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>