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
    <title>Add Package Property</title>
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
                        <h4 class="pb-3">Add Package Property</h4>

                        <?php
                        $packageID = $_GET['id'];
                        ?>

                        <form action="./controller/packagePropertiesController.php" method="post">
                            <div class="mb-3 visually-hidden">
                                <label for="packageID" class="form-label">Package ID</label>
                                <input type="text" class="form-control" name="packageID" id="packageID" value="<?php echo $packageID ?>">
                            </div>
                            <div class="mb-3">
                                <label for="propertyName" class="form-label">Property name</label>
                                <input type="text" class="form-control" name="propertyName" id="propertyName">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" id="category">
                            </div>
                            <div class="mb-5">
                                <label for="price" class="form-label">Price (RM)</label>
                                <input type="text" class="form-control" name="price" id="price">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100" name="createPackageProperty">Create</button>
                                <a href="./viewPackage.php?id=<?php echo $packageID ?>" class="btn btn-outline-dark ms-3 w-100">Back</a>
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