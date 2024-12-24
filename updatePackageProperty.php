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
    <title>Update Package Property</title>
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
                        <h4 class="pb-3">Update Package Property</h4>

                        <?php
                        $propertyID = $_GET['id'];
                        $stmt = $conn->prepare("SELECT * FROM packageproperty WHERE PropertyID = '$propertyID'");
                        $stmt->execute();

                        $property = $stmt->fetch(PDO::FETCH_OBJ)
                        ?>

                        <form action="./controller/packagePropertiesController.php" method="post">
                            <div class="mb-3 visually-hidden">
                                <label for="propertyID" class="form-label">Property ID</label>
                                <input type="text" class="form-control" name="propertyID" id="propertyID" value="<?php echo $property->PropertyID ?>">
                            </div>
                            <div class="mb-3 visually-hidden">
                                <label for="packageID" class="form-label">Package ID</label>
                                <input type="text" class="form-control" name="packageID" id="packageID" value="<?php echo $property->PackageID ?>">
                            </div>
                            <div class="mb-3">
                                <label for="propertyName" class="form-label">Property name</label>
                                <input type="text" class="form-control" name="propertyName" id="propertyName" value="<?php echo $property->Name ?>">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" id="category" value="<?php echo $property->Category ?>">
                            </div>
                            <div class="mb-5">
                                <label for="price" class="form-label">Price (RM)</label>
                                <input type="text" class="form-control" name="price" id="price" value="<?php echo $property->Price ?>">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100" name="updatePackageProperty">Save</button>
                                <a href="./viewPackage.php?id=<?php echo $property->PackageID ?>" class="btn btn-outline-dark ms-3 w-100">Back</a>
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