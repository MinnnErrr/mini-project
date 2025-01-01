<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Management</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.8/b-3.2.0/r-3.0.3/rg-1.5.1/sc-2.4.3/sb-1.8.1/sp-2.3.3/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./tablePagination.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container-fluid min-vh-100 p-4">

                    <div class="bg-white p-5 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between pb-3">
                            <h4>Printing Packages</h4>
                            <button class="btn btn-sm btn-secondary" onclick="location.href='./addPackage.php'">
                                <i class="bi bi-plus-circle me-1"></i>
                                ADD PACKAGE
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="packageTable">
                                <thead>
                                    <tr>
                                        <th width="10%" scope="col" class="text-start">No.</th>
                                        <th scope="col">Package Name</th>
                                        <th scope="col">Affiliated Branch</th>
                                        <th scope="col">
                                            Availability
                                        </th>
                                        <th width="20%" scope="col">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM printingpackage 
                                                            JOIN branch ON printingpackage.BranchID = branch.BranchID
                                                            ORDER BY printingpackage.PackageID DESC");
                                    $stmt->execute();

                                    $packages = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    foreach ($packages as $package):
                                    ?>
                                        <tr>
                                            <th scope="row" class="text-start"><?php echo $i ?></th>
                                            <td><?php echo $package->PackageName ?></td>
                                            <td>
                                                <?php echo $package->Name ?>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill text-bg-<?php echo $package->Availability == 'Available' ? 'success' : 'danger' ?>">
                                                    <?php echo $package->Availability ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-secondary me-4" onclick="location.href='./viewPackage.php?id=<?php echo $package->PackageID ?>'">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $package->PackageID ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!--modal-->
                                        <div class="modal fade" id="delete<?php echo $package->PackageID ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete package <?php echo $package->Name ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Back</button>
                                                        <form action="./controller/packageController.php" method="post">
                                                            <input type="hidden" name="packageID" value="<?php echo $package->PackageID ?>">
                                                            <button type="submit" name="deletePackage" class="btn btn-danger">Confirm</button>
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
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.8/b-3.2.0/r-3.0.3/rg-1.5.1/sc-2.4.3/sb-1.8.1/sp-2.3.3/datatables.min.js"></script>

    <script>
        document.getElementById('package').classList.add('is-active');
    </script>
    <script>
        new DataTable('#packageTable');
    </script>
</body>

</html>