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

                    <div class="border rounded-3 p-4 bg-white col-lg-8 mx-auto">
                        <h4 class="pb-3">Package Details</h4>

                        <?php
                        $packageID = $_GET['id'];
                        $stmt = $conn->prepare("SELECT * FROM printingpackage WHERE PackageID = '$packageID'");
                        $stmt->execute();

                        $package = $stmt->fetch(PDO::FETCH_OBJ);
                        ?>

                        <form action="">
                            <div class="mb-3">
                                <label for="packageName" class="form-label fw-bold">Package name</label>
                                <input type="text" value="<?php echo $package->Name ?>" readonly class="form-control-plaintext" name="packageName" id="packageName">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control-plaintext" readonly name="description" id="description"><?php echo $package->Description ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Base Price (RM)</label>
                                <input type="text" value="<?php echo $package->BasePrice ?>" readonly class="form-control-plaintext" name="price" id="price">
                            </div>
                            <div class="mb-3">
                                <label for="availability" class="form-label fw-bold">Availability</label>
                                <input type="text" value="<?php echo $package->Availability ?>" readonly class="form-control-plaintext" name="branchContact" id="branchContact">
                            </div>
                            <div class="mb-5">
                                <label for="branch" class="form-label fw-bold">Affiliated branch</label>
                                <?php
                                $branchID = $package->BranchID;
                                $stmt = $conn->prepare("SELECT * FROM branch where BranchID = '$branchID'");
                                $stmt->execute();

                                $branch = $stmt->fetch(PDO::FETCH_OBJ);
                                ?>
                                <input type="text" value="<?php echo $branch->Name ?>" readonly class="form-control-plaintext" name="branch" id="branch">
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="./updatePackage.php?id=<?php echo $package->PackageID ?>" class="btn btn-outline-dark me-3 w-100">Edit</a>
                                <a href="./packageManagement.php" class="btn btn-outline-dark ms-3 w-100">Back</a>
                            </div>
                        </form>
                    </div>

                    <div class="border bg-white p-4 rounded-3 col-lg-8 mx-auto mt-4">
                        <div class="d-flex justify-content-between pb-3">
                            <h4>Package Properties</h4>
                            <button class="btn btn-sm btn-outline-dark" onclick="location.href='./addPackageProperty.php?id=<?php echo $packageID ?>'">
                                ADD PROPERTY
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th width="20%" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM packageproperty WHERE PackageID = $packageID ORDER BY PropertyID DESC");
                                    $stmt->execute();

                                    $properties = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    foreach ($properties as $property):
                                    ?>

                                        <tr>
                                            <th scope="row"><?php echo $i ?></th>
                                            <td><?php echo $property->Name ?></td>
                                            <td><?php echo $property->Category ?></td>
                                            <td><?php echo $property->Price ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-secondary me-4" onclick="location.href='./updatePackageProperty.php?id=<?php echo $property->PropertyID ?>'">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $property->PropertyID ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!--modal-->
                                        <div class="modal fade" id="delete<?php echo $property->PropertyID ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete property <?php echo $property->Name ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Back</button>
                                                        <form action="./controller/packagePropertiesController.php" method="post">
                                                            <input type="hidden" name="propertyID" value="<?php echo $property->PropertyID ?>">
                                                            <input type="hidden" name="packageID" value="<?php echo $property->PackageID ?>">
                                                            <button type="submit" class="btn btn-danger" name="deletePackageProperty">Confirm</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                        $i++;
                                    endforeach
                                    ?>
                                </tbody>
                            </table>
                        </div>
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