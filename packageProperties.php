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
    <title>Package Management</title>
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
                <div class="container-fluid min-vh-100 p-4">

                    <div class="bg-white p-5 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between pb-3">
                            <h4>Package A</h4>
                            <button class="btn btn-sm btn-outline-dark" onclick="location.href='./addPackage.php'">
                                ADD PROPERTIES
                            </button>
                        </div>

                        <!--search, filter, sort-->
                        <div class="row d-flex align-items-center pb-2">
                            <div class="col-sm-12 col-lg-6 mb-2">
                                <form action="" class="d-flex col-sm-12">
                                    <input class="form-control rounded-0" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success rounded-0" type="submit">
                                        <span class="bi bi-search"></span>
                                    </button>
                                </form>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-select rounded-0">
                                    <option value="">Sort by Property Name</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-select rounded-0">
                                    <option value="">Filter by Category</option>
                                </select>
                            </div>
                        </div>

                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Property Name</th>
                                    <th width="20%" scope="col">
                                        <div class="d-flex justify-content-center">
                                            Category
                                        </div>
                                    </th>
                                    <th width="20%" scope="col">
                                        <div class="d-flex justify-content-center">
                                            Price (RM)
                                        </div>
                                    </th>
                                    <th width="20%" colspan="3" scope="col">
                                        <div class="d-flex justify-content-center">
                                            Action
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Colour</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            Colour Mode
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            0.50
                                        </div>

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-secondary me-2" onclick="location.href='./viewPackage.php'">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-secondary me-2" onclick="location.href='./updatePackage.php'">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePackage">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center pt-4">
                            <button class="btn btn-dark" onclick="location.href='./packageManagement.php'">
                                Back
                            </button>
                        </div>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <!--modal-->
    <div class="modal fade" id="deletePackage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the package?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('package').classList.add('is-active');
    </script>
</body>

</html>