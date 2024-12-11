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
                <div class="container min-vh-100">
                    <div class="m-5">
                        <div class="row pb-3 d-flex align-items-center">
                            <div class="col">
                                <h5 class="">Koperasi branches list</h5>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button class="btn" type="button">
                                    <span class="bi bi-filter fs-3"></span>
                                </button>
                                <form action="" class="d-flex p-2">
                                    <input class="form-control rounded-0" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success rounded-0" type="submit">
                                        <span class="bi bi-search"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Branch Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>
                                        <div>
                                            <button class="btn btn-info" type="submit">
                                                UPDATE
                                            </button>
                                            <button class="btn btn-danger" type="submit">
                                                DELETE
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>.
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>