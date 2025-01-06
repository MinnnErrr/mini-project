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
    <title>Update Package</title>
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
                <div class="container min-vh-100 p-5">

                    <div class="col-lg-8 mx-auto border rounded-3 p-4 bg-white col-lg-6 mx-auto">
                        <h4 class="pb-3">Update Package</h4>

                        <?php
                        $packageID = $_GET['id'];
                        $stmt = $conn->prepare("SELECT * FROM printingpackage WHERE PackageID = '$packageID'");
                        $stmt->execute();

                        $package = $stmt->fetch(PDO::FETCH_OBJ);
                        ?>

                        <form action="./controller/packageController.php" method="post">
                            <div class="mb-3 visually-hidden">
                                <label for="packageID" class="form-label">Package ID</label>
                                <input type="text" class="form-control" name="packageID" id="packageID" value="<?php echo $package->PackageID ?>">
                            </div>
                            <div class="mb-3">
                                <label for="packageName" class="form-label">Package name</label>
                                <input type="text" class="form-control" name="packageName" id="packageName" value="<?php echo $package->Name ?>">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description"><?php echo $package->Description ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="basePrice" class="form-label">Base Price (RM)</label>
                                <input type="text" class="form-control" name="basePrice" id="basePrice" value="<?php echo $package->BasePrice ?>">
                            </div>
                            <div class="mb-3">
                                <label for="availability" class="form-label">Availability</label>
                                <select id="availability" class="form-select" name="availability">
                                    <option selected value="<?php echo $package->Availability ?>"><?php echo $package->Availability ?></option>
                                    <option value="<?php echo $package->Availability == 'Available' ? 'Unavailable' : 'Available' ?>"><?php echo $package->Availability == 'Available' ? 'Unavailable' : 'Available' ?></option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="branch" class="form-label">Affiliated branch</label>
                                <select id="branch" class="form-select" name="branch">

                                    <?php
                                    $packageBranchID = $package->BranchID;
                                    $stmt = $conn->prepare("SELECT * FROM branch");
                                    $stmt->execute();

                                    $branches = $stmt->fetchAll(PDO::FETCH_OBJ);

                                    foreach ($branches as $branch):
                                    ?>

                                    <option value="<?php echo $branch->BranchID ?>" <?php echo $branch->BranchID == $packageBranchID ? 'selected' : null ?>><?php echo $branch->Name ?></option>

                                    <?php
                                    endforeach
                                    ?>

                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100" name="updatePackage">Save</button>
                                <a href="./viewPackage.php?id=<?php echo $packageID ?>" class="btn btn-outline-dark ms-3 w-100">Cancel</a>
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