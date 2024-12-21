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
    <title>Branch Management</title>
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
                            <h4>Koperasi Branches</h4>
                            <button class="btn btn-sm btn-outline-dark" onclick="location.href='./addBranch.php'">
                                ADD BRANCH
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
                                    <option value="">Sort by Branch Name</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-select rounded-0">
                                    <option value="">Filter by Location</option>
                                </select>
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Branch Name</th>
                                    <th width="20%" colspan="3" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Branch A</td>
                                    <td>
                                        <button class="btn btn-secondary me-2" onclick="location.href='./viewBranch.php'">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary me-2" onclick="location.href='./updateBranch.php'">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <!--modal-->
    <div class="modal fade" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the branch?
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
        document.getElementById('branch').classList.add('is-active');
    </script>
</body>

</html>